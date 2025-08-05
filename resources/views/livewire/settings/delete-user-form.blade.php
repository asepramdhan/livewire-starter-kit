<?php

use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;

new class extends Component {
    public string $password = '';

    /**
     * Delete the currently authenticated user.
     */
    public function deleteUser(Logout $logout): void
    {
        $this->validate([
            'password' => ['required', 'string', 'current_password'],
        ], messages: [
            'password.required' => 'Kata sandi harus diisi.',
            'password.string' => 'Kata sandi harus berupa teks.',
            'password.current_password' => 'Kata sandi tidak cocok.',
        ]);

        tap(Auth::user(), $logout(...))->delete();

        $this->redirect('/', navigate: true);
    }
}; ?>

<section class="mt-10 space-y-6">
  <div class="relative mb-5">
    <flux:heading>{{ __('Hapus akun') }}</flux:heading>
    <flux:subheading>{{ __('Hapus akun Anda dan semua sumber dayanya') }}</flux:subheading>
  </div>

  <flux:modal.trigger name="confirm-user-deletion">
    <flux:button variant="danger" x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')">
      {{ __('Hapus akun') }}
    </flux:button>
  </flux:modal.trigger>

  <flux:modal name="confirm-user-deletion" :show="$errors->isNotEmpty()" focusable class="max-w-lg">
    <form wire:submit="deleteUser" class="space-y-6">
      <div>
        <flux:heading size="lg">{{ __('Apakah Anda yakin ingin menghapus akun Anda?') }}</flux:heading>

        <flux:subheading>
          {{ __('Setelah akun Anda dihapus, semua sumber daya dan datanya akan dihapus secara permanen. Masukkan kata sandi Anda untuk mengonfirmasi bahwa Anda ingin menghapus akun secara permanen.') }}
        </flux:subheading>
      </div>

      <flux:input wire:model="password" :label="__('Kata sandi')" type="password" />

      <div class="flex justify-end space-x-2 rtl:space-x-reverse">
        <flux:modal.close>
          <flux:button variant="filled">{{ __('Batal') }}</flux:button>
        </flux:modal.close>

        <flux:button variant="danger" type="submit">{{ __('Hapus akun') }}</flux:button>
      </div>
    </form>
  </flux:modal>
</section>
