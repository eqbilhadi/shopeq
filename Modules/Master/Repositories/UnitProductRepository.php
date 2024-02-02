<?php

namespace Modules\Master\Repositories;

use App\Repositories\BaseRepository;
use Modules\Master\app\Models\MstUnitProducts;

class UnitProductRepository extends BaseRepository
{
    public function __construct(MstUnitProducts $model)
    {
        parent::__construct($model);
    }

    public function getUnitProducts()
    {
        return $this->model;
    }
}