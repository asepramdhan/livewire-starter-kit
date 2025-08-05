<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth')] class extends Component {
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ], message: [
            'name.required' => 'Nama harus diisi.',
            'name.string' => 'Nama harus berupa teks.',
            'name.max' => 'Nama tidak boleh lebih dari :max karakter.',
            'email.required' => 'Email harus diisi.',
            'email.string' => 'Email harus berupa teks.',
            'email.email' => 'Email tidak valid.',
            'email.max' => 'Email tidak boleh lebih dari :max karakter.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.required' => 'Password harus diisi.',
            'password.string' => 'Password harus berupa teks.',
            'password.confirmed' => 'Password konfirmasi harus cocok.',
        ]);

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered(($user = User::create($validated))));

        Auth::login($user);

        $this->redirectIntended(route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div class="flex flex-col gap-6">
  <x-auth-header :title="__('Buat akun')" :description="__('Masukkan detail Anda di bawah ini untuk membuat akun')" />

  <!-- Session Status -->
  <x-auth-session-status class="text-center" :status="session('status')" />

  <form wire:submit="register" class="flex flex-col gap-6">
    <!-- Name -->
    <flux:input wire:model="name" :label="__('Nama')" type="text" required autofocus autocomplete="name" :placeholder="__('Nama lengkap')" />

    <!-- Email Address -->
    <flux:input wire:model="email" :label="__('E-mail')" type="email" required autocomplete="email" placeholder="email@example.com" />

    <!-- Password -->
    <flux:input wire:model="password" :label="__('Kata sandi')" type="password" required autocomplete="new-password" :placeholder="__('Kata sandi')" viewable />

    <!-- Confirm Password -->
    <flux:input wire:model="password_confirmation" :label="__('Konfirmasi kata sandi')" type="password" required autocomplete="new-password" :placeholder="__('Konfirmasi kata sandi')" viewable />

    <div class="flex items-center justify-end">
      <flux:button type="submit" variant="primary" class="w-full">
        {{ __('Buat akun') }}
      </flux:button>
    </div>
  </form>

  <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-600 dark:text-zinc-400">
    <span>{{ __('Sudah punya akun?') }}</span>
    <flux:link :href="route('login')" wire:navigate>{{ __('Masuk') }}</flux:link>
  </div>
</div>
