<?php

namespace Modules\Master\Services\Product\Registration;

use Modules\Master\app\Models\MstProduct;
use Modules\Master\Services\Product\Action\InsertProduct;
use Modules\Master\Services\Product\Action\UpdateProduct;

class ProductRegistration extends RegistrationService
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
     * @var MstProduct|null
     */
    protected ?MstProduct $product = null;

    /**
     * @param MstProduct|null $product
     * @param array $data
     */
    public function __construct(?MstProduct $product = null, array $data = [])
    {
        $this->product = $product;

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
        if (is_null($this->product)) {
            (new InsertProduct($this->data))->handle();
        } else {
            (new UpdateProduct($this->product, $this->data))->handle();
        }
    }
}
