<?php

use Livewire\Volt\Component;

new class extends Component {
    public string $tenant_name = '';

    /**
     * Handle an incoming registration request.
     */
    public function save(): void
    {
        $this->validate([
            'tenant_name' => ['required', 'string', 'max:255', 'unique:tenants,id', 'alpha_dash', 'min:3'],
        ]);
        try {
            $tenant = App\Models\Tenant::create(['id' => $this->tenant_name]);
            tenancy()->initialize($tenant);
            $user = App\Models\User::create([
                'name' => 'root',
                'email' => 'root@gmail.com',
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
            ]);
//            $user->assignRole('admin');
        } catch (\Exception $e) {
            $this->addError('tenant_name', $e->getMessage());
        }
    }
};
?>

<div>
    <form wire:submit="save">
        <!-- Email Address -->
        <div>
            <x-input-label for="tenant_name" :value="__('Tenant')"/>
            <x-text-input wire:model="tenant_name" id="tenant_name" class="block mt-1 w-full" type="text"
                          name="tenant_name" required autofocus autocomplete="tenant_name"/>
            <x-input-error :messages="$errors->get('tenant_name')" class="mt-2"/>
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button class="ms-3">
                {{ __('soumettre') }}
            </x-primary-button>
        </div>
    </form>
</div>
