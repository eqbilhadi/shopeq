<?php

namespace App\Livewire\Forms;

use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Validate;
use Livewire\Form;

class StepOneRegisterForm extends Form
{
    #[Validate('required|unique:users|string|min:3')]
    public $username = '';

    #[Validate('required|unique:users|string|email')]
    public $email = '';

    #[Validate('required|string|min:8')]
    public $password = '';
    
    #[Validate('required|string|min:8|same:password')]
    public $password_confirmation = '';

    public function validateStep()
    {
        $this->validate();
    }
    
    public function getAttribute()
    {
        return [
            'username' => $this->username,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ];

    }
}
