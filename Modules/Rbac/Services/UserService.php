<?php

namespace Modules\Rbac\Services;

use Illuminate\Support\Facades\Hash;
use Modules\Rbac\Repositories\UserRepository;

class UserService
{
    public function __construct(
        protected UserRepository $userRepository,
    ) {
    }

    public function getPageDataUser($filter = [])
    {
        // $query = $this->userRepository->getUserWithRole()->orderBy('created_at', 'desc');
        $query = $this->userRepository->getUserWithRole()->oldest('created_at');

        if (isset($filter['search']) && $filter['search'] != null) {
            $query->where('first_name', 'like', '%' . $filter['search'] . '%');
            $query->orWhere('last_name', 'like', '%' . $filter['search'] . '%');
            $query->orWhere('username', 'like', '%' . $filter['search'] . '%');
        }

        if (isset($filter['gender']) && $filter['gender'] != null) {
            $query->whereGender($filter['gender']);
        }

        if (isset($filter['role']) && $filter['role'] != null) {
            $query->whereHas('roles', fn ($query) => $query->where('role_id', $filter['role']));
        }

        return $query->paginate(10)->setPath(route('rbac.user.index'))->onEachSide(1);
    }

    public function getUserWithAuthLog()
    {
        return $this->userRepository->getUserWithAuthLog();
    }

    public function changeActiveStatus($id, $status)
    {
        $params = [
            'is_active' => $status
        ];

        $this->userRepository->update($params, $id);
    }

    public function store($form)
    {
        $params = [
            "username" => $form["username"],
            "email" => $form["email"],
            "password" => Hash::make($form['password']),
            "first_name" => $form["first_name"],
            "last_name" => $form["last_name"],
            "birthplace" => $form["birthplace"],
            "birthdate" => $form["birthdate"],
            "gender" => $form["gender"],
            "phone" => $form["phone"],
            "address" => $form["address"],
            "avatar" => $form["avatar"],
        ];
        $user = $this->userRepository->insert($params);

        $this->userRepository->updateRoleByUser($form['role'], $user->id);
    }

    public function update($form, $id)
    {
        $params = [
            "username" => $form["username"],
            "email" => $form["email"],
            "first_name" => $form["first_name"],
            "last_name" => $form["last_name"],
            "birthplace" => $form["birthplace"],
            "birthdate" => $form["birthdate"],
            "gender" => $form["gender"],
            "phone" => $form["phone"],
            "address" => $form["address"],
        ];

        if($form['password'] != null) {
            $params['password'] = Hash::make($form['password']);
        }
        if($form['avatar'] != null) {
            $params['avatar'] = $form['avatar'];
        }

        $this->userRepository->update($params, $id);

        $this->userRepository->updateRoleByUser($form['role'], $id);
    }

    public function delete($id)
    {
        $avatar = $this->getAvatarUser($id);
        if($avatar != null) {
            $deletePath = public_path($avatar);
            if (file_exists($deletePath)) {
                unlink($deletePath);
            }
        }
        $this->userRepository->delete($id);
    }

    public function getAvatarUser($id)
    {
        $user = $this->userRepository->getUserById($id)->first();

        return $user->avatar ?? null;
    }
}
