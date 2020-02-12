<?php

namespace Modules\Customer\Http\Controllers\Admin;

use Illuminate\Http\Response;
use Modules\Booking\Entities\Booking;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;
use Modules\Country\Repositories\CountryRepository;
use Modules\Customer\Entities\Customer;
use Modules\Customer\Http\Requests\CreateCustomerRequest;
use Modules\Customer\Http\Requests\UpdateCustomerRequest;
use Modules\Customer\Repositories\CustomerRepository;
use Modules\User\Contracts\Authentication;

class CustomerController extends AdminBaseController
{
    /**
     * @var CustomerRepository
     */
    private $customer;

    /**
     * @var CountryRepository
     */
    private $country;

    /**
     * @var Authentication
     */
    private $auth;

    /**
     * CustomerController constructor.
     * @param CustomerRepository $customer
     * @param CountryRepository $country
     * @param Authentication $auth
     */
    public function __construct(CustomerRepository $customer, CountryRepository $country, Authentication $auth)
    {
        parent::__construct();

        $this->customer = $customer;
        $this->country = $country;
        $this->auth = $auth;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $user = auth()->user();
        // Check if current login user is sale or operator role
        $canOnlySeeCreated = ($user->hasRoleSlug(config('asgard.user.config.role-list.sale', ''))
            || $user->hasRoleSlug(config('asgard.user.config.role-list.operator', '')));
        $customerQuery = Customer::with('country');
        if ($canOnlySeeCreated) {
            $customerQuery = $customerQuery->where('author_id', $user->id);
        }
        $customers = $customerQuery->get();

        return view('customer::admin.customers.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $countryList = $this->country->all();
        $countries = $this->prepareDropdownData($countryList, trans('customer::customers.form.country_id_empty_option'));
        $genders = [
            0 => trans('customer::customers.form.gender_option.female'),
            1 => trans('customer::customers.form.gender_option.male')
        ];

        return view('customer::admin.customers.create', compact('countries', 'genders'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateCustomerRequest $request
     * @return Response
     */
    public function store(CreateCustomerRequest $request)
    {
        $data = $request->all();
        $userId = $this->auth->id();
        $data['author_id'] = $userId;

        if (!empty($data['birthday'])) {
            $data['birthday'] = \DateTime::createFromFormat('d/m/Y', $data['birthday'])->format('Y-m-d');
        }

        if (!empty($data['appointment'])) {
            $data['appointment'] = \DateTime::createFromFormat('d/m/Y', $data['appointment'])->format('Y-m-d');
        }

        $this->customer->create($data);

        return redirect()->route('admin.customer.customer.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('customer::customers.title.customers')]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Customer $customer
     * @return Response
     */
    public function edit(Customer $customer)
    {
        $countryList = $this->country->all();
        $countries = $this->prepareDropdownData($countryList, trans('customer::customers.form.country_id_empty_option'));
        $genders = [
            0 => trans('customer::customers.form.gender_option.female'),
            1 => trans('customer::customers.form.gender_option.male')
        ];

        $bookings = $customer->booking;
        $bookingStatuses = Booking::bookingStatus();
        $paymentStatuses = Booking::paymentStatus();
        $vendorPurchaseStatuses = Booking::vendorPurchaseStatus();

        return view('customer::admin.customers.edit', compact('customer', 'countries', 'genders',
            'bookings', 'bookingStatuses', 'paymentStatuses', 'vendorPurchaseStatuses'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Customer $customer
     * @param  UpdateCustomerRequest $request
     * @return Response
     */
    public function update(Customer $customer, UpdateCustomerRequest $request)
    {
        $data = $request->all();
        if (!empty($data['birthday'])) {
            $data['birthday'] = \DateTime::createFromFormat('d/m/Y', $data['birthday'])->format('Y-m-d');
        }
        if (!empty($data['appointment'])) {
            $data['appointment'] = \DateTime::createFromFormat('d/m/Y', $data['appointment'])->format('Y-m-d');
        }
        $this->customer->update($customer, $data);

        return redirect()->route('admin.customer.customer.index')
            ->withSuccess(trans('core::core.messages.resource updated', ['name' => trans('customer::customers.title.customers')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Customer $customer
     * @return Response
     */
    public function destroy(Customer $customer)
    {
        $this->customer->destroy($customer);

        return redirect()->route('admin.customer.customer.index')
            ->withSuccess(trans('core::core.messages.resource deleted', ['name' => trans('customer::customers.title.customers')]));
    }
}
