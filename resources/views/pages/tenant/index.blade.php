<x-app-layout>
    <x-slot name="header">{{ __('list of tenants') }}</x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="max-w-xl">
                {{--<livewire:tenant.index-table />--}}
                <ul>
                    @foreach($tenants as $tenant)
                        <li class="text-gray-900">{{ $tenant->id }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</x-app-layout>
