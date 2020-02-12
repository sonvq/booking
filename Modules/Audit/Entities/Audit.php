<?php

namespace Modules\Audit\Entities;

use Illuminate\Database\Eloquent\Model;

class Audit extends Model
{
    protected $table = 'audits';
    protected $fillable = [

    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function author()
    {
        return $this->belongsTo(\Modules\User\Entities\Sentinel\User::class, 'user_id');
    }
}
