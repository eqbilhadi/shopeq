<?php

namespace Modules\Master\Services;

use Illuminate\Support\Str;
use Modules\Master\Repositories\ProductRepository;
use Modules\Master\Repositories\ImageRepository;
use Modules\Master\Repositories\UnitProductRepository;

class ProductService
{
    public function __construct(
        protected ProductRepository $productRepository,
        protected ImageRepository $imageRepository,
        protected UnitProductRepository $unitProductRepository
    ) {
    }

    public function getProduct()
    {
        return $this->productRepository->getProduct()->get();
    }

    public function getPageDataProduct($filter = [])
    {
        $query = $this->productRepository->getProduct()->with('category')->orderBy('created_at', 'desc');

        if (isset($filter['search']) && $filter['search'] != null) {
            $query->where('name', 'like', '%' . $filter['search'] . '%');
        }

        if (isset($filter['category']) && $filter['category'] != null) {
            $query->where('category_id', $filter['category']);
        }

        if (isset($filter['status']) && $filter['status'] != null) {
            $query->where('status', $filter['status']);
        }

        if (isset($filter['visibility']) && $filter['visibility'] != null) {
            $query->where('visibility', $filter['visibility']);
        }

        return $query->paginate(10)->setPath(route('master.product.index'));
    }

    public function store($form)
    {
        $paramsProducts = [
            'category_id' => $form['categoryId'],
            'name' => $form['name'],
            'description' => $form['description'],
            'barcode' => ($form['isAutoBarcode']) ? null : $form['barcode'],
            'selling_price' => preg_replace("/[^0-9]/", "", $form['sellingPrice']),
            'purchase_price' => preg_replace("/[^0-9]/", "", $form['purchasePrice']),
            'minimal_stok' => $form['minimalStok'],
            'status' => $form['status'],
            'visibility' => $form['visibility']
        ];

        $this->productRepository->insertNewProduct($paramsProducts, $form['paramsImages'], $form['paramsUnit']);
    }
    
    public function update($form)
    {
        $paramsProducts = [
            'category_id' => $form['categoryId'],
            'name' => $form['name'],
            'description' => $form['description'],
            'barcode' => ($form['isAutoBarcode']) ? null : $form['barcode'],
            'selling_price' => preg_replace("/[^0-9]/", "", $form['sellingPrice']),
            'purchase_price' => preg_replace("/[^0-9]/", "", $form['purchasePrice']),
            'minimal_stok' => $form['minimalStok'],
            'status' => $form['status'],
            'visibility' => $form['visibility']
        ];

        $this->productRepository->updateProduct($paramsProducts, $form['paramsImages'], $form['paramsUnit'], $form['paramsEditUnit'], $form);
    }

    public function deleteProduct($id)
    {
        $productImages = $this->getImagesProduct($id);

        foreach ($productImages as $img) {
            if ($img->filename != null) {
                $deletePath = public_path($img->filename);
                if (file_exists($deletePath)) {
                    unlink($deletePath);
                }
            }
        }

        $this->productRepository->delete($id);
    }

    public function getImagesProduct($id)
    {
        $products = $this->productRepository->getProductById($id);

        return $products->images()->get() ?? array();
    }

    public function deleteUnitProduct($id)
    {
        $unitProduct = $this->unitProductRepository->getUnitProducts()->find($id);

        $unitProduct->delete();
    }

    public function deleteImageProduct($id)
    {
        $image = $this->deleteFileImageProduct($id);

        $image?->delete();
    }

    public function deleteFileImageProduct($id)
    {
        $image = $this->imageRepository->getImage()->find($id);
        
        if ($image?->filename != null) {
            $deletePath = public_path($image->filename);
            if (file_exists($deletePath)) {
                unlink($deletePath);
            }
        }

        return $image;
    }
}
