<?php

namespace Modules\Master\Repositories;

use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\DB;
use Modules\Master\app\Models\MstProduct;

class ProductRepository extends BaseRepository
{
    public function __construct(MstProduct $model)
    {
        parent::__construct($model);
    }

    public function getProduct()
    {
        return $this->model;
    }

    public function getProductById($id)
    {
        return $this->model->find($id);
    }

    public function insertNewProduct($paramsProducts, $paramsImages, $paramsUnit)
    {
        return DB::transaction(function () use ($paramsProducts, $paramsImages, $paramsUnit) {
            $product = $this->model->create($paramsProducts);

            foreach ($paramsImages as $value) {
                $product->images()->create($value);
            }

            foreach ($paramsUnit as $value) {
                $product->units()->create($value);
            }
        });
    }

    public function updateProduct($paramsProducts, $paramsImages, $paramsUnit, $paramsEditUnit, $form)
    {
        return DB::transaction(function () use ($paramsProducts, $paramsImages, $paramsUnit, $paramsEditUnit, $form) {
            $product = $this->model->find($form['products']->id);

            $product->update($paramsProducts);

            if(!empty($paramsImages)){
                foreach ($paramsImages as $value) {
                    $product->images()->create($value);
                }
            }

            if(!empty($paramsUnit)) {
                foreach ($paramsUnit as $value) {
                    $product->units()->create($value);
                }
            }

            foreach ($paramsEditUnit as $key => $value) {
                $subUnit = $product->units()->find($value['id']);

                $subUnit->update($value);
            }

            if($form['mainUnitId'] != $form['compareMainUnitId']) {
                $mainUnit = $product->units()->find($form['compareMainUnitId']);

                $mainUnit->delete();
            }
        });
    }

    public function delete($id)
    {
        $product = $this->model->find($id);
        return DB::transaction(function () use ($product, $id) {
            $product->delete();
            $product->images()->where('imageable_id', $id)->delete();
            $product->units()->where('unitable_id', $id)->delete();
        });
    }
}
