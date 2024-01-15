<?php

namespace App\Livewire\Profile\Forms;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Validate;
use Livewire\Form;

class FormAccount extends Form
{
    #[Validate]
    public $username;

    #[Validate]
    public $email;

    #[Validate('nullable|string|min:8')]
    public $password;

    #[Validate('nullable|string|min:8|same:password')]
    public $password_confirmation;

    public $id;

    public function rules()
    {
        return [
            'username' => 'required|unique:users,username,' . $this->id . '|string|min:3',
            'email' => 'required|unique:users,email,' . $this->id . '|string|email',
        ];
    }

    public function update()
    {
        $this->validate();

        try {
            $params = [
                'username' => $this->username,
                'email' => $this->email,
            ];

            if ($this->password != null) {
                $params['password'] = Hash::make($this->password);
            }

            User::whereId($this->id)->update($params);

            $this->password = '';
            $this->password_confirmation = '';
            
            flash()
                ->options([
                    'timeout' => 1800
                ])
                ->addSuccess('Data updated successfully');
        } catch (Exception $e) {
            flash()
                ->options([
                    'timeout' => 1800
                ])
                ->addError('Data failed to update');
        }
    }

    public function setForm($user)
    {
        $this->username = $user->username;
        $this->email = $user->email;
        $this->id = $user->id;
    }
}
