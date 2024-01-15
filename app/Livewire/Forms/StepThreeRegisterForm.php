<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;
use Livewire\WithFileUploads;

class StepThreeRegisterForm extends Form
{
    use WithFileUploads;

    #[Validate('image')]
    public $photo;

    public function validateStep()
    {
        $this->validate();
    }

    public function storeImage()
    {
        $filename = $this->photo->store('images/user-profile', 'public_upload');
        return $filename;
    }
}
