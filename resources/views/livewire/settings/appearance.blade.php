<?php

use Livewire\Volt\Component;

new class extends Component {
    //
}; ?>

<section class="w-full">
  @include('partials.settings-heading')

  <x-settings.layout :heading="__('Penampilan')" :subheading=" __('Perbarui pengaturan tampilan untuk akun Anda')">
    <flux:radio.group x-data variant="segmented" x-model="$flux.appearance">
      <flux:radio value="light" icon="sun-dim">{{ __('Terang') }}</flux:radio>
      <flux:radio value="dark" icon="moon-star">{{ __('Gelap') }}</flux:radio>
      <flux:radio value="system" icon="monitor">{{ __('Sistem') }}</flux:radio>
    </flux:radio.group>
  </x-settings.layout>
</section>
