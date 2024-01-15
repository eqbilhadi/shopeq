<?php

namespace App\Livewire\Profile\Forms;

use App\Models\User;
use Exception;
use Livewire\Attributes\Validate;
use Livewire\Form;
use Livewire\WithFileUploads;

class FormAvatar extends Form
{
    use WithFileUploads;

    #[Validate('image')]
    public $photo;

    public $avatar;

    public $id;

    public function update()
    {
        $this->validate();

        $filename = $this->storeImage();

        try {
            $params = [
                'avatar' => $filename,
            ];

            User::whereId($this->id)->update($params);

            flash()
                ->options([
                    'timeout' => 1800
                ])
                ->addSuccess('Profile picture updated successfully');
            return to_route('profile');
        } catch (Exception $e) {
            flash()
                ->options([
                    'timeout' => 1800
                ])
                ->addError('Profile picture failed to update');
            return to_route('profile');
        }
    }

    public function setAvatar($user)
    {
        $this->avatar = $user->avatar;
        $this->id = $user->id;
    }

    public function storeImage()
    {
        if ($this->avatar != null) {
            $deletePath = public_path($this->avatar);
            if (file_exists($deletePath)) {
                unlink($deletePath);
            }
        }
        $filename = $this->photo->store('images/user-profile', 'public_upload');
        return $filename;
    }
}
