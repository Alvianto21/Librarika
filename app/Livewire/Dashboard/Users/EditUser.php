<?php

namespace App\Livewire\Dashboard\Users;

use App\Livewire\Forms\UserUpdate;
use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithFileUploads;

class EditUser extends Component
{
    use WithFileUploads;
    
    public UserUpdate $form;
    public $foto;

    /**
     * Class constructor
     */
    public function mount(User $user) {
        //Set defauld data
        $this->form->setUser($user);
        $this->foto = $user->foto_profil;
    }

    /**
     * submit form
     */
    public function save() {
        $this->form->update();

        session()->flash('UserUpdateSuccess', 'Profil anda berhasil diperbarui');
        $this->redirectRoute('profile');
    }
    
    // Layout
    #[Layout("components.dashboard.layout", ["title" => "Edit Data Profil"])]
    
    public function render()
    {
        return view('livewire.dashboard.users.edit-user');
    }
}
