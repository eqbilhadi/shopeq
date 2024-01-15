<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class StepTwoRegisterForm extends Form
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

    public function validateStep()
    {
        $this->validate();
    }

    public function getAttribute()
    {
        return [
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'birthplace' => $this->birthplace,
            'birthdate' => $this->birthdate,
            'gender' => $this->gender,
            'phone' => $this->phone,
            'address' => $this->address,
        ];
    }
}