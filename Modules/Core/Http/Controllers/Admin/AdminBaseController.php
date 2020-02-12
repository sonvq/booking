<?php

namespace Modules\Core\Http\Controllers\Admin;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Routing\Controller;
use Modules\Core\Entities\BaseModel;
use Modules\Core\Foundation\Asset\Manager\AssetManager;
use Modules\Core\Foundation\Asset\Pipeline\AssetPipeline;
use Modules\Core\Foundation\Asset\Types\AssetTypeFactory;

class AdminBaseController extends Controller
{
    /**
     * @var AssetManager
     */
    protected $assetManager;

    /**
     * @var AssetPipeline
     */
    protected $assetPipeline;

    /**
     * @var AssetTypeFactory
     */
    protected $assetFactory;

    /**
     * AdminBaseController constructor.
     */
    public function __construct()
    {
        $this->assetManager = app(AssetManager::class);
        $this->assetPipeline = app(AssetPipeline::class);
        $this->assetFactory = app(AssetTypeFactory::class);

        $this->addAssets();
        $this->requireDefaultAssets();
    }

    /**
     * Add the assets from the config file on the asset manager.
     */
    private function addAssets()
    {
        foreach (config('asgard.core.core.admin-assets') as $assetName => $path) {
            $path = $this->assetFactory->make($path)->url();
            $this->assetManager->addAsset($assetName, $path);
        }
    }

    /**
     * Require the default assets from config file on the asset pipeline.
     */
    private function requireDefaultAssets()
    {
        $this->assetPipeline->requireCss(config('asgard.core.core.admin-required-assets.css'));
        $this->assetPipeline->requireJs(config('asgard.core.core.admin-required-assets.js'));
    }

    /**
     * @param Collection $items
     * @param $emptyOption
     * @return array
     */
    protected function prepareDropdownData(Collection $items, $emptyOption)
    {
        $result[''] = $emptyOption;
        foreach ($items as $item) {
            $result[$item->id] = $item->name;
        }
        return $result;
    }

    /**
     * @param Collection $items
     * @return array
     */
    protected function prepareAjaxResult(Collection $items)
    {
        $result = [];
        foreach ($items as $item) {
            $temp['id'] = $item->id;
            $temp['name'] = $item->name;
            $result[] = $temp;
        }
        return $result;
    }

    /**
     * @param $object
     * @param $originAmount
     * @return float|int|mixed
     */
    protected function calculateAmountByObject($object, $originAmount)
    {
        /** @var BaseModel $object */
        if ($object->amount > 0 && !empty($object->type) && !empty($object->change)) {
            if ($object->type === BaseModel::TYPE_NUMBER) {
                if ($object->change === BaseModel::CHANGE_DECREASE) {
                    $originAmount -= $object->amount;
                } else {
                    $originAmount += $object->amount;
                }
            } else {
                if ($object->change === BaseModel::CHANGE_DECREASE) {
                    $originAmount -= ($originAmount * $object->amount) / 100;
                } else {
                    $originAmount += ($originAmount * $object->amount) / 100;
                }
            }
        } else {
            return null;
        }

        return $originAmount;
    }

    /**
     * @param $object
     * @param $originAmount
     * @param $sale
     * @return float|int|mixed|null
     */
    protected function calculateAmountBySaleType($object, $originAmount, $sale)
    {
        $keyAmount = 'amount_' . $sale;
        $keyChange = 'change_' . $sale;
        $keyType = 'type_' . $sale;

        /** @var BaseModel $object */
        if ($object->$keyAmount > 0 && !empty($object->$keyChange) && !empty($object->$keyType)) {
            if ($object->$keyType === BaseModel::TYPE_NUMBER) {
                if ($object->$keyChange === BaseModel::CHANGE_DECREASE) {
                    $originAmount -= $object->$keyAmount;
                } else {
                    $originAmount += $object->$keyAmount;
                }
            } else {
                if ($object->$keyChange === BaseModel::CHANGE_DECREASE) {
                    $originAmount -= ($originAmount * $object->$keyAmount) / 100;
                } else {
                    $originAmount += ($originAmount * $object->$keyAmount) / 100;
                }
            }
        } else {
            return null;
        }

        return $originAmount;
    }
}
