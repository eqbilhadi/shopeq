<?php

namespace Modules\Master\Services\Customer\Registration;

use Modules\Master\app\Models\MstCustomer;

class CustomerRegistration extends RegistrationService
{
    /**
     * Data
     *
     * @var array
     */
    protected array $data = [];

    /**
     * Land Area
     *
     * @var MstCustomer|null
     */
    protected ?MstCustomer $customer = null;

    /**
     * @param MstCustomer|null $customer
     * @param array $data
     */
    public function __construct(?MstCustomer $customer = null, array $data = [])
    {
        $this->customer = $customer;

        $this->data = $data;
    }

    /**
     * Get data
     *
     * @return array
     */
    public function data(): array
    {
        return $this->data;
    }

    /**
     * Save action
     *
     * @return void
     */
    public function save(): void
    {
        (new ActionCustomer($this->customer, $this->data))->handle();
    }
}
