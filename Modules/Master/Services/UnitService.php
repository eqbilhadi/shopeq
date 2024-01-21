<?php

namespace Modules\Master\Services;

use Illuminate\Support\Str;
use Modules\Master\Repositories\UnitRepository;

class UnitService
{
    public function __construct(
        protected UnitRepository $unitRepository,
    ) {
    }

    public function getUnit()
    {
        return $this->unitRepository->getUnit()->get();
    }

    public function getPageDataUnit($filter = [])
    {
        $query = $this->unitRepository->getUnit()->orderBy('created_at', 'desc');

        if (isset($filter['search']) && $filter['search'] != null) {
            $query->where('name', 'like', '%' . $filter['search'] . '%');
        }

        return $query->paginate(10)->setPath(route('master.unit.index'));
    }

    public function getUnitById($id)
    {
        return $this->unitRepository->getUnit()->whereId($id)->first();
    }

    public function changeActiveStatus($id, $status)
    {
        $params = [
            'is_active' => $status
        ];

        $this->unitRepository->update($params, $id);
    }

    public function store($form)
    {
        $params = [
            'name' => $form['name'],
            'is_active' => $form['status'],
        ];

        $this->unitRepository->insert($params);
    }

    public function update($form, $id)
    {
        $params = [
            'name' => $form['name'],
        ];

        $this->unitRepository->update($params, $id);
    }

    public function deleteUnit($id)
    {
        $this->unitRepository->delete($id);
    }
    
    public function deleteBatchUnit($id)
    {
        $this->unitRepository->deleteBatch($id);
    }
}
