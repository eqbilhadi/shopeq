<?php

namespace Modules\Master\Services\Customer\Registration;

use Illuminate\Support\Arr;
use Modules\Master\app\Models\MstCustomer;

class ActionCustomer
{

    protected array $data = [];

    protected ?MstCustomer $customer = null;

    /**
     * Method __construct
     *
     * @param array $data [explicite description]
     *
     * @return void
     */
    public function __construct(?MstCustomer $customer = null, array $data = [])
    {
        $this->data = $data;

        $this->customer = $customer;
    }

    /**
     * Method handle
     *
     * @return void
     */
    public function handle(): void
    {
        if (is_null($this->customer)) {
            $this->create();
        } else {
            $this->update();
        }
    }

    /**
     * Method create
     *
     * @return static
     */
    protected function create(): static
    {
        $this->customer = MstCustomer::create($this->getRegistrationDataCustomer());

        return $this;
    }

    /**
     * Method create
     *
     * @return static
     */
    protected function update(): static
    {
        $this->customer->update($this->getRegistrationDataCustomer());

        return $this;
    }

    /**
     * Get register data
     *
     * @return array
     */
    protected function getRegistrationDataCustomer(): array
    {
        // set data
        $data = [
            'name' => Arr::get($this->data, 'name'),
            'gender' => Arr::get($this->data, 'gender'),
            'phone' => Arr::get($this->data, 'phone'),
            'address' => Arr::get($this->data, 'address'),
            'user_id' => Arr::get($this->data, 'user_id'),
        ];

        return $data;
    }

}
