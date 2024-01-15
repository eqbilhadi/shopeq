<?php

namespace App\Livewire\Profile;

use Livewire\Component;
use App\Livewire\Profile\Forms\FormAccount;
use App\Livewire\Profile\Forms\FormAvatar;
use App\Livewire\Profile\Forms\FormPersonal;
use Livewire\WithFileUploads;

class ProfilePage extends Component
{
    use WithFileUploads;
    
    public $user;

    public FormAccount $formAccount;
    public FormPersonal $formPersonal;
    public FormAvatar $formAvatar;

    public $currentTab = "formPersonal";

    public $loginLog;


    public function mount($user)
    {
        $this->user = $user;
        $this->formAccount->setForm($user);
        $this->formPersonal->setForm($user);
        $this->formAvatar->setAvatar($user);
    }

    public function updateAccount()
    {
        $this->formAccount->update();
    }

    public function updatePersonal()
    {
        $this->formPersonal->update();
    }

    public function updateAvatar()
    {
        $this->formAvatar->update();
    }

    public function changeTab($tab)
    {
        $this->currentTab = $tab;
    }

    public function render()
    {
        return view('livewire.profile.profile-page');
    }
}
