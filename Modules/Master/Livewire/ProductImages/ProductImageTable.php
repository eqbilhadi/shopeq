<?php

namespace Modules\Master\Livewire\ProductImages;

use Exception;
use Livewire\Component;
use Modules\Master\app\Models\MstProduct;
use Modules\Master\app\Models\MstImage;
use Modules\Master\Services\CategoryService;
use Modules\Master\Services\ProductService;

class ProductImageTable extends Component
{
    public $image;

    public ?string $title;
    public ?string $source;
    public ?string $description;

    public array $filter = [
        'category' => '',
        'paginate' => 8
    ];

    protected $categoryService;
    protected $productService;

    public function boot(CategoryService $categoryService, ProductService $productService)
    {
        $this->categoryService = $categoryService;
        $this->productService = $productService;
    }

    public function setFilter($id)
    {
        $this->filter['category'] = $id;
    }

    public function edit($id)
    {
        $image = MstImage::with('imageable')->find($id);
        $this->image = $image;

        $this->title = $image->title;
        $this->source = $image->source;
        $this->description = $image->description;

        $this->dispatch("open-modal");
    }

    public function update($id)
    {
        $form = [
            'title' => $this->title,
            'source' => $this->source,
            'description' => $this->description,
        ];

        try {
            MstImage::find($id)->update($form);
            $this->reset();
            flash()
                ->options([
                    'timeout' => 1800
                ])
                ->addSuccess('Data updated successfully');
        } catch (Exception $e) {
            flash()
                ->options([
                    'timeout' => 1800
                ])
                ->addError('Data failed to update');
        }

        $this->dispatch("close-modal");
    }

    public function delete($id)
    {
        try {
            $this->productService->deleteFileImageProduct($id);
            MstImage::find($id)->delete();
            $this->reset();
            flash()
                ->options([
                    'timeout' => 1800
                ])
                ->addSuccess('Data deleted successfully');
        } catch (Exception $e) {
            flash()
                ->options([
                    'timeout' => 1800
                ])
                ->addError('Data failed to delete');
        }

        $this->dispatch("close-modal");
    }

    public function render()
    {
        return view('master::livewire.product-images.product-image-table', [
            'images' => $this->getPageDataImage($this->filter),
            'category' => $this->categoryService->getCategory()
        ]);
    }

    public function getPageDataImage($filter)
    {
        $query = MstImage::byType(MstProduct::class)->with('imageable');

        if (isset($filter['category']) && $filter['category'] != null) {
            $query->whereHas('imageable', function ($imageable) use ($filter) {
                $imageable->whereCategoryId($filter['category']);
            });
        }

        return $query->paginate($filter['paginate'])->setPath(route('master.image.index'));
    }

    public function loadMore()
    {
        $this->filter['paginate'] += 8;
    }
}
