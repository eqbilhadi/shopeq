<?php

namespace Modules\Master\Services;

use Illuminate\Support\Str;
use Modules\Master\Repositories\ProductRepository;

class ProductService
{
    public function __construct(
        protected ProductRepository $productRepository,
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

    public function deleteProduct($id)
    {
        $productImages = $this->getImagesProduct($id);

        foreach ($productImages as $img) {
            if($img->filename != null) {
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
        $products = $this->productRepository->getProductById($id)->first();

        return $products->images()->get() ?? array();
    }
}