<?php

namespace Modules\Master\Services\Supplier\Registration;

use Illuminate\Support\Arr;
use Modules\Master\app\Models\MstSupplier;

class ActionSupplier
{

    protected array $data = [];

    protected ?MstSupplier $supplier = null;

    /**
     * Method __construct
     *
     * @param array $data [explicite description]
     *
     * @return void
     */
    public function __construct(?MstSupplier $supplier = null, array $data = [])
    {
        $this->data = $data;

        $this->supplier = $supplier;
    }

    /**
     * Method handle
     *
     * @return void
     */
    public function handle(): void
    {
        if (is_null($this->supplier)) {
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
        $this->supplier = MstSupplier::create($this->getRegistrationDataSupplier());

        return $this;
    }

    /**
     * Method create
     *
     * @return static
     */
    protected function update(): static
    {
        $this->supplier->update($this->getRegistrationDataSupplier());

        return $this;
    }

    /**
     * Get register data
     *
     * @return array
     */
    protected function getRegistrationDataSupplier(): array
    {
        // set data
        $data = [
            'name' => Arr::get($this->data, 'name'),
            'phone' => Arr::get($this->data, 'phone'),
            'address' => Arr::get($this->data, 'address'),
        ];

        return $data;
    }

}
