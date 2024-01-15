<?php

namespace Modules\Rbac\Repositories;

use App\Repositories\BaseRepository;
use Modules\Rbac\app\Models\Role;

class RoleRepository extends BaseRepository
{
    public function __construct(Role $model)
    {
        parent::__construct($model);
    }

    public function getRole()
    {
        return $this->model;
    }

    public function updateRole($params, $id)
    {
        $this->model->whereId($id)->update($params);
    }

    public function updateMenuByRole($menu_id = [], $id)
    {
        $role = $this->model->whereId($id)->first();

        $role->menus()->sync($menu_id);
    }
    
    public function insert($form)
    {
        return $this->model->create($form);
    }
    
    public function delete($id)
    {
        $this->model->whereId($id)->delete();
    }

}