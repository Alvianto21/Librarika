<?php

namespace App\Livewire\Forms;

use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class UserUpdate extends Form
{
    public ?User $user;

    public $nama = '';
    public $password = null;
    public $password_confirmation = null;

    #[Validate]
    public $foto_profil = '';

    #[validate]
    public $username = '';

    #[Validate]
    public $email = '';

    /**
     * Set data
     */
    public function setUser(User $user) {
        $this->user = $user;

        $this->nama = $user->nama;
        $this->email = $user->email;
        $this->username = $user->username;
    }

    /**
     * Validation rules
     */
    protected function rules() {
        return [
            'nama' => 'required|regex:/^[\pL\s]+$/u|max:255',
            'foto_profil' => 'nullable|image|mimes:jpg,png,jpeg,gif|max:2048',
            'password' => 'nullable|confirmed|min:8|max:255',
            'email' => [
                'required',
                'email:dns',
                Rule::unique('users', 'email')->ignore($this->user->id)
            ],
            'username' => [
                'required',
                'alpha_num',
                'max:150',
                Rule::unique('users','username')->ignore($this->user->id)
            ]
        ];
    }

    /**
     * Update user
     */
    public function update() {
        $validate = $this->validate();

        if ($validate['password'] == null) {
            $validate['password'] = $this->user->password;
        }

        if ($this->foto_profil instanceof \Illuminate\Http\UploadedFile) {
            if(!empty($this->user->foto_profil)) {
                Storage::disk('public')->delete($this->user->foto_profil);
            }

            $validate['foto_profil'] = $this->foto_profil->store('foto-profil', 'public');
        }

        $this->user->update($validate);
    }
}
