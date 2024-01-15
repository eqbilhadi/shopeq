<?php

namespace App\Livewire\Profile\Forms;

use App\Models\User;
use Exception;
use Livewire\Attributes\Validate;
use Livewire\Form;

class FormPersonal extends Form
{
    #[Validate('required')]
    public $first_name = '';

    #[Validate('required')]
    public $last_name = '';

    #[Validate('required')]
    public $birthplace = '';

    #[Validate('required')]
    public $birthdate = '';

    #[Validate('required')]
    public $gender = '';

    #[Validate('required|numeric')]
    public $phone = '';

    #[Validate('required')]
    public $address = '';

    public $id;

    public function update()
    {
        $this->validate();

        try {
            $params = [
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'birthplace' => $this->birthplace,
                'birthdate' => $this->birthdate,
                'gender' => $this->gender,
                'phone' => $this->phone,
                'address' => $this->address,
            ];

            User::whereId($this->id)->update($params);
            
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
        $this->first_name = $user->first_name;
        $this->last_name = $user->last_name;
        $this->birthplace = $user->birthplace;
        $this->birthdate = $user->birthdate;
        $this->gender = $user->gender;
        $this->phone = $user->phone;
        $this->address = $user->address;

        $this->id = $user->id;
    }
}