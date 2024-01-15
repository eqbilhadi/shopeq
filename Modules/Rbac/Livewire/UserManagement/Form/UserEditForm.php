<?php

namespace Modules\Rbac\Livewire\UserManagement\Form;

use Exception;
use Livewire\Form;
use Livewire\Attributes\Validate;
use Modules\Rbac\Services\UserService;

class UserEditForm extends Form
{
    #[Validate]
    public $username;

    #[Validate]
    public $email;

    #[Validate('nullable|string|min:8')]
    public $password;

    #[Validate('required')]
    public $role = [];

    #[Validate('required')]
    public $first_name;

    #[Validate('required')]
    public $last_name;

    public $birthplace;
    public $birthdate;
    public $gender;
    public $phone;
    public $address;
    public $photo;
    public $avatar;

    public $user;

    protected $userService;

    public function boot(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function rules()
    {
        return [
            'username' => 'required|unique:users,username,' . $this->user->id . '|string|min:3',
            'email' => 'required|unique:users,email,' . $this->user->id . '|string|email',
        ];
    }

    public function setUser($user)
    {
        $this->username = $user->username;
        $this->email = $user->email;
        $this->first_name = $user->first_name;
        $this->last_name = $user->last_name;
        $this->birthplace = $user->birthplace;
        $this->birthdate = $user->birthdate;
        $this->gender = $user->gender;
        $this->phone = $user->phone;
        $this->address = $user->address;
        $this->avatar = $user->avatar;

        $this->user = $user;

        foreach ($user->roles->pluck('id') as $key => $role) {
            array_push($this->role, $role);
        }
    }

    public function update()
    {
        $this->validate();

        try {
            $filename = $this->storeImage();
            $form = array_merge($this->all(), ['avatar' => $filename]);
            $this->userService->update($form, $this->user->id);
            flash()
                ->options([
                    'timeout' => 1800
                ])
                ->addSuccess('Data updated successfully');
            return redirect()->route('rbac.user.index');
        } catch (Exception $e) {
            flash()
                ->options([
                    'timeout' => 1800
                ])
                ->addError('Data failed to update');
            return redirect()->route('rbac.user.index');
        }
    }

    public function storeImage()
    {
        if ($this->photo != null) {
            $avatar = $this->userService->getAvatarUser($this->user->id);
            if ($avatar != null) {
                $deletePath = public_path($avatar);
                if (file_exists($deletePath)) {
                    unlink($deletePath);
                }
            }
            $filename = $this->photo->store('images/user-profile', 'public_upload');
            return $filename;
        } else {
            return null;
        }
    }
}
