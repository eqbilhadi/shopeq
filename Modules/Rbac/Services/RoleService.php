<?php

namespace Modules\Rbac\Services;

use Modules\Rbac\Repositories\RoleRepository;

class RoleService
{
    public function __construct(
        protected RoleRepository $roleRepository,
    ) {
    }

    public function getRole()
    {
        return $this->roleRepository->getRole()->get();
    }

    public function getPageDataRole($filter = [])
    {
        $query = $this->roleRepository->getRole()->orderBy('created_at', 'asc');

        if (isset($filter['search']) && $filter['search'] != null) {
            $query->where('name', 'like', '%' . $filter['search'] . '%');
        }

        return $query->paginate(10)->setPath(route('rbac.role.index'));
    }

    public function changeActiveStatus($id, $status)
    {
        $params = [
            'is_active' => $status
        ];

        $this->roleRepository->updateRole($params, $id);
    }

    public function store($form)
    {
        $params = [
            'code' => $form['code'] ?? null,
            'name' => $form['name'] ?? null,
            'description' => $form['description'] ?? null,
            'is_active' => $form['is_active'] ?? null,
        ];
        $role = $this->roleRepository->insert($params);

        $this->roleRepository->updateMenuByRole($form['menu_id'], $role->id);
    }

    public function update($form)
    {
        $params = [
            'code' => $form['code'] ?? null,
            'name' => $form['name'] ?? null,
            'description' => $form['description'] ?? null,
            'is_active' => $form['is_active'] ?? null,
        ];

        $this->roleRepository->updateRole($params, $form['id']);
        $this->roleRepository->updateMenuByRole($form['menu_id'], $form['id']);
    }

    public function deleteRole($id)
    {
        $this->roleRepository->delete($id);
    }
}