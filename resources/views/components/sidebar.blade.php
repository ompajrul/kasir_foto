{{-- <div class="min-h-screen bg-gray-100 flex">
    <div class="w-64 bg-slate-900 text-white min-h-screen shadow-lg hidden md:block">
        <div class="p-6 text-2xl font-bold text-orange-500 border-b border-slate-800">
            HOSHIGRAPH
        </div>

        <nav class="mt-6 px-4 space-y-2">
            <a href="{{ route('dashboard') }}"
                class="block px-4 py-2 rounded-lg hover:bg-slate-800 text-white border-none transition">
                Dashboard
            </a>

            <a href="{{ route('booking.index') }}"
                class="block px-4 py-2 rounded-lg hover:bg-slate-800 text-white border-none transition">
                Booking Foto
            </a>

            <a href="{{ route('kasir.index') }}"
                class="block px-4 py-2 rounded-lg hover:bg-slate-800 text-white border-none transition">
                Kasir / Payment
            </a>
        </nav>
        <!-- Settings Dropdown -->
        <div class="hidden sm:flex sm:items-center sm:ms-6">
            <x-dropdown align="right" width="48">
                <x-slot name="trigger">
                    <button
                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                        <div>{{ Auth::user()->name }}</div>

                        <div class="ms-1">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                    </button>
                </x-slot>

                <x-slot name="content">
                    <x-dropdown-link :href="route('profile.edit')">
                        {{ __('Profile') }}
                    </x-dropdown-link>

                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <x-dropdown-link :href="route('logout')" onclick="event.preventDefault();
                                                this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-dropdown-link>
                    </form>
                </x-slot>
            </x-dropdown>
        </div>

    </div>



</div>
--}}
<div class="min-h-screen bg-gray-100 flex" x-data="{ sidebarOpen: false }">
    <!-- Sidebar -->
    <div :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
        class="fixed inset-y-0 left-0 z-50 w-64 bg-slate-900 text-white flex flex-col transition-transform duration-300 transform md:translate-x-0 md:static md:inset-0 shadow-lg">

        <!-- Logo Section -->
        <div class="p-6 text-2xl font-bold text-orange-500 border-b border-slate-800 flex justify-between items-center">
            HOSHIGRAPH
            <button @click="sidebarOpen = false" class="md:hidden text-gray-400">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
        </div>

        <!-- Navigation Section -->
        <nav class="mt-6 px-4 space-y-2 flex-1">
            <a href="{{ route('dashboard') }}"
                class="block px-4 py-2 rounded-lg hover:bg-slate-800 transition">Dashboard</a>
            <a href="{{ route('booking.index') }}"
                class="block px-4 py-2 rounded-lg hover:bg-slate-800 transition">Booking Foto</a>
            <a href="{{ route('kasir.index') }}" class="block px-4 py-2 rounded-lg hover:bg-slate-800 transition">Kasir/Payment</a>
            <a href="{{ route('transaksi.index') }}" class="block px-4 py-2 rounded-lg hover:bg-slate-800 transition">transaksi</a>
        </nav>

        <!-- Settings Dropdown (Ditaruh di bawah dengan mt-auto) -->
        <!-- Settings Section (Collapsible) -->
        <div class="p-4 border-t border-slate-800 mt-auto" x-data="{ userMenuOpen: false }">
            <!-- Tombol Trigger -->
            <button @click="userMenuOpen = !userMenuOpen"
                class="flex items-center w-full px-3 py-2 text-sm font-medium rounded-md text-gray-300 hover:text-white hover:bg-slate-800 focus:outline-none transition">
                <div class="flex-1 text-left truncate">{{ Auth::user()->name }}</div>
                <svg class="w-4 h-4 transition-transform duration-200" :class="userMenuOpen ? 'rotate-180' : ''"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>

            <!-- Isi Menu (Muncul ke atas/bawah secara inline) -->
            <div x-show="userMenuOpen" x-cloak @click.away="userMenuOpen = false"
                x-transition:enter="transition ease-out duration-100"
                x-transition:enter-start="transform opacity-0 scale-95"
                x-transition:enter-end="transform opacity-100 scale-100" class="mt-2 space-y-1 px-2">

                <a href="{{ route('profile.edit') }}"
                    class="block px-3 py-2 text-sm text-gray-400 hover:text-white hover:bg-slate-800 rounded-md">
                    {{ __('Profile') }}
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="block w-full text-left px-3 py-2 text-sm text-gray-400 hover:text-white hover:bg-slate-800 rounded-md">
                        {{ __('Log Out') }}
                    </button>
                </form>
            </div>
        </div>
    </div>

</div>