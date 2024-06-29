<?php

namespace Modules\Master\Services\Product\Destroy;

use Modules\Master\app\Models\MstProduct;
use Modules\Master\Services\Product\DestroyFileProduct;
use Modules\Master\Services\Product\Registration\RegistrationService;

class ProductDestroy extends RegistrationService
{
    protected $id;

    public function __construct($id = null)
    {
        $this->id = $id;
    }

    /**
     * Delete action
     *
     * @return void
     */
    public function save(): void
    {
        if (is_array($this->id)) {
            foreach ($this->id as $id) {
                $this->deleteProductRelatedData($id);
            }
        } else {
            $this->deleteProductRelatedData($this->id);
        }
    }

    /**
     * Helper method to delete product related data
     *
     * @param string $productId
     * @return void
     */
    private function deleteProductRelatedData(string $productId): void
    {
        $product = MstProduct::find($productId);
        
        if ($product) {
            // deleting image on file
            DestroyFileProduct::destroyByImageableId($productId);
            // deleting image on database
            $product->images()->delete();
            
            $product->units()->delete();
            $product->delete();
        }
    }
}
