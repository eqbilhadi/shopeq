<?php

namespace Modules\Rbac\Services;

use Modules\Rbac\Repositories\MenuRepository;

class MenuService
{
    public function __construct(
        protected MenuRepository $menuRepository,
    ) {
    }

    public function getPageDataNavigation($filter = [])
    {
        $query = $this->menuRepository->getParentMenuWithChildren()->orderBy('sort_num', 'asc')->with('children');

        if (isset($filter['search']) && $filter['search'] != null) {
            // $query->where('label_name', 'like', '%' . $filter['search'] . '%')
            $query->with([
                'children' => function ($query) use ($filter) {
                    $query->where('label_name', 'like', '%' . $filter['search'] . '%');
                }
            ]);
        }

        if (isset($filter['status']) && $filter['status'] != null) {
            $query->whereIsActive($filter['status'])
                ->whereHas('children', function ($child) use ($filter) {
                    $child->whereIsActive($filter['status']);
                });
        }

        return $query->get();
    }


    public function getParentMenu()
    {
        return $this->menuRepository->getParentMenu()->get();
    }

    public function getChildMenuWithId($id)
    {
        return $this->menuRepository->getChildMenuWithId($id)->get();
    }

    public function changeActiveStatus($id, $status)
    {
        $params = [
            'is_active' => $status
        ];

        $this->menuRepository->updateMenu($params, $id);
    }

    public function store($form)
    {
        $this->menuRepository->insert($form);
    }

    public function update($form)
    {
        $form['parent_id'] = ($form['parent_id'] == "") ? null : $form['parent_id'];
        $params = [
            "icon" => $form["icon"] ?? null,
            "label_name" => $form["label_name"] ?? null,
            "controller_name" => $form["controller_name"] ?? null,
            "route_name" => $form["route_name"] ?? null,
            "url" => $form["url"] ?? null,
            "parent_id" => $form["parent_id"] ?? null,
            "is_active" => $form["is_active"] ?? null,
        ];
        if ($form['parent_id'] == null) {
            $sortNum = $this->menuRepository->getMenu()->whereNull('parent_id')->max('sort_num');
            $params['sort_num'] = $sortNum !== null ? $sortNum + 1 : 1;
        }
        $this->menuRepository->update($params, $form['id']);
    }

    public function deleteMenu($id)
    {
        $this->menuRepository->delete($id);
    }

    public function deleteBatchMenu($dataId)
    {
        $this->menuRepository->deleteBatch($dataId);
    }

    public function changeMenuOrder($order, $id)
    {
        $this->menuRepository->updateMenuOrder($order, $id);
    }
}
