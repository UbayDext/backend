<?php

namespace App\Filament\Resources\NoneResource\Pages;

use App\Filament\Resources\NoneResource;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Filament\Resources\Pages\Page;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Components\TextInput;

class Register extends Page implements HasForms
{
    use InteractsWithForms;

    public $name;
    public $email;
    public $password;
    public $password_confirmation;

    protected static string $view = 'filament.resources.none-resource.pages.register';

    public function mount()
    {
        $this->form->fill();
    }

    protected function getFormSchema(): array
    {
        return [
            TextInput::make('name')->required(),
            TextInput::make('email')->email()->required(),
            TextInput::make('password')->password()->required()->minLength(6),
            TextInput::make('password_confirmation')->password()->required()->same('password'),
        ];
    }

    public function register()
    {
        $data = $this->form->getState();

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        Auth::login($user);

        return redirect()->route('filament.admin.pages.dashboard');
    }
}
