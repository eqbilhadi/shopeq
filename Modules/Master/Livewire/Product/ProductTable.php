<?php

namespace Modules\Master\Livewire\Product;

use Livewire\Component;
use Modules\Master\Services\CategoryService;
use Modules\Master\Services\ProductService;

class ProductTable extends Component
{
    protected $categoryService;
    protected $productService;

    public function boot(
        CategoryService $categoryService,
        ProductService $productService
    ) {
        $this->categoryService = $categoryService;
        $this->productService = $productService;
    }

    public function delete($id)
    {
        $this->productService->deleteProduct($id);
        flash()
            ->options([
                'timeout' => 1800
            ])
            ->addSuccess('Data successfully deleted');
        $this->dispatch("close-modal");
    }

    public function render()
    {
        return view('master::livewire.product.product-table', [
            "categoryOptions" => $this->categoryService->getCategory(),
            "results" => $this->productService->getPageDataProduct()
        ]);
    }
}
