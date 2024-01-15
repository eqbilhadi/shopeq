<?php

namespace Modules\Rbac\Repositories;

use App\Repositories\BaseRepository;
use Modules\Rbac\app\Models\Menu;

class MenuRepository extends BaseRepository
{
    public function __construct(Menu $model)
    {
        parent::__construct($model);
    }

    public function getMenu()
    {
        return $this->model;
    }

    public function getMenuWithChildren()
    {
        return $this->model->with('children');
    }

    public function getParentMenuWithChildren()
    {
        return $this->model->whereNull('parent_id')->with('children');
    }

    public function getParentMenu()
    {
        return $this->model->whereNull('parent_id');
    }

    public function getChildMenuWithId($id)
    {
        return $this->model->whereParentId($id);
    }

    public function updateMenu($params, $id)
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

    public function updateMenuOrder($order, $id)
    {
        // get row from id variable
        $currentID = $this->getModel()->find($id);

        switch ($order) {
            case 'up':
                // get id from row above $id
                $upID = $this->getModel()->query()->orderBy('sort_num', 'desc')
                    ->when($currentID->parent_id, function ($query) use ($currentID) {
                        $query->where('parent_id', $currentID->parent_id);
                    })
                    ->when(!$currentID->parent_id, function ($query) {
                        $query->whereNull('parent_id');
                    })
                    ->where('sort_num', '<', $currentID->sort_num)
                    ->first();

                // update up to current
                $this->getModel()->find($upID->id)->update(['sort_num' => $currentID->sort_num]);

                // update current to down
                $this->getModel()->find($currentID->id)->update(['sort_num' => $upID->sort_num]);
                break;
            case 'down':
                // get id from row under $id
                $downID = $this->getModel()->orderBy('sort_num', 'asc')
                    ->when($currentID->parent_id, function ($query) use ($currentID) {
                        $query->where('parent_id', $currentID->parent_id);
                    })
                    ->when(!$currentID->parent_id, function ($query) {
                        $query->whereNull('parent_id');
                    })
                    ->where('sort_num', '>', $currentID->sort_num)
                    ->first();

                // update down to current
                $this->getModel()->find($downID->id)->update(['sort_num' => $currentID->sort_num]);

                // update current to down
                $this->getModel()->find($currentID->id)->update(['sort_num' => $downID->sort_num]);
                break;
        }
    }

    public function insert($form)
    {
        $this->model->create($form);
    }

    public function update($form, $id)
    {
        $this->model->whereId($id)->update($form);
    }
}
