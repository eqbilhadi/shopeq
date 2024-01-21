<?php

namespace Modules\Master\Repositories;

use App\Repositories\BaseRepository;
use Modules\Master\app\Models\MstUnit;

class UnitRepository extends BaseRepository
{
    public function __construct(MstUnit $model)
    {
        parent::__construct($model);
    }

    public function getUnit()
    {
        return $this->model;
    }

    public function insert($params)
    {
        $this->model->create($params);
    }

    public function update($params, $id)
    {
        $this->model->whereId($id)->update($params);
    }

    public function delete($id)
    {
        $this->model->whereId($id)->delete();
    }

    public function deleteBatch($dataId)
    {
        foreach ($dataId as $key => $id) {
            $this->model->whereId($id)->delete();
        }
    }
}