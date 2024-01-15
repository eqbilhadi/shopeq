<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use App\Livewire\Forms\StepOneRegisterForm;
use App\Livewire\Forms\StepThreeRegisterForm;
use App\Livewire\Forms\StepTwoRegisterForm;
use App\Models\User;
use Livewire\WithFileUploads;

class RegisterPage extends Component
{
    use WithFileUploads;

    public $currentStep = 1;
    public bool $isStepOne = false;
    public bool $isStepTwo = false;
    public bool $isStepThree = false;
    public bool $isStepFour = false;

    public StepOneRegisterForm $stepOneForm;
    public StepTwoRegisterForm $stepTwoForm;
    public StepThreeRegisterForm $stepThreeForm;

    public $first_name;
    public $last_name;
    public $birthplace;
    public $birthdate;
    public $gender;
    public $avatar;
    public $phone;
    public $address;
    public $is_active;

    public function render()
    {
        return view('livewire.auth.register-page');
    }

    public function firstStepSubmit()
    {
        $this->isStepOne = false;
        $this->stepOneForm->validateStep();
        
        $this->isStepOne = true;
        $this->currentStep = 2;
    }

    public function secondStepSubmit()
    {
        $this->isStepTwo = false;
        $this->stepTwoForm->validateStep();

        $this->isStepTwo = true;
        $this->currentStep = 3;
    }

    public function thirdStepSubmit()
    {
        $this->isStepThree = false;
        $this->stepThreeForm->validateStep();

        $filename = $this->stepThreeForm->storeImage();
        $form = array_merge($this->stepOneForm->getAttribute(), $this->stepTwoForm->getAttribute(), ['avatar' => $filename]);
        
        User::create($form);

        $this->isStepThree = true;
        $this->currentStep = 4;
    }

    public function back($step)
    {
        $this->currentStep = $step;
    }
}
