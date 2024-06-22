<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;

new class extends Component {
    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
}; ?>

<nav class="flex-1 p-4">
    <ul>
        <li>
            <a href="{{ route('dashboard.index') }}" class="flex items-center p-2 rounded hover:bg-gray-700">
                <span class="material-icons">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"><path
                                fill="currentColor" d="M4 21V9l8-6l8 6v12h-6v-7h-4v7z"/></svg>
                </span>
                <span class="ml-2">Dashboard</span>
            </a>
        </li>
        <li>
            <a href="{{ route('tenant.index') }}" class="flex items-center p-2 rounded hover:bg-gray-700">
                <span class="material-icons">
                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"><path fill="currentColor" d="M17 9h2V7h-2zm0 4h2v-2h-2zm0 4h2v-2h-2zM1 21V11l7-5l7 5v10h-5v-6H6v6zm16 0V10l-7-5.05V3h13v18z"/></svg>
                </span>
                <span class="ml-2">
                    Tenants
                </span>
            </a>
        </li>
    </ul>
    <div class="mt-4">
        <h3 class="text-xs uppercase tracking-wider text-gray-400">
            Racourcis
        </h3>
        <ul>
            <li>
                <a href="{{ route('tenant.create') }}" class="flex items-center p-2 rounded hover:bg-gray-700">
                    <span class="bg-gray-700 w-6 h-6 rounded-full flex items-center justify-center text-xs">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"><path fill="currentColor" d="M18 20v-3h-3v-2h3v-3h2v3h3v2h-3v3zM3 21q-.825 0-1.412-.587T1 19V5q0-.825.588-1.412T3 3h14q.825 0 1.413.588T19 5v5h-2V8H3v11h13v2zM3 6h14V5H3zm0 0V5z"/></svg>
                    </span>
                    <span class="ml-2">
                        create tenant
                    </span>
                </a>
            </li>
        </ul>
    </div>
</nav>
