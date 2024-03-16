<?php

namespace Modules\Master\Services\Supplier\Registration;

use Modules\Master\app\Models\MstSupplier;

class SupplierRegistration extends RegistrationService
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
     * @var MstSupplier|null
     */
    protected ?MstSupplier $supplier = null;

    /**
     * @param MstSupplier|null $supplier
     * @param array $data
     */
    public function __construct(?MstSupplier $supplier = null, array $data = [])
    {
        $this->supplier = $supplier;

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
        (new ActionSupplier($this->supplier, $this->data))->handle();
    }
}
