<?php

namespace Modules\Rbac\Repositories;

use App\Repositories\BaseRepository;
use App\Models\User;

class UserRepository extends BaseRepository
{
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function getUser()
    {
        return $this->model;
    }

    public function getUserById($id)
    {
        return $this->model->whereId($id);
    }

    public function getUserWithRole()
    {
        return $this->model->with('roles');
    }
    
    public function getUserWithAuthLog()
    {
        return $this->model->with('authentications');
    }

    public function update($params, $id)
    {
        $this->model->whereId($id)->update($params);
    }

    public function updateRoleByUser($role_id = [], $id)
    {
        $user = $this->model->whereId($id)->first();

        $user->roles()->sync($role_id);
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