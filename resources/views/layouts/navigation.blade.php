<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800"/>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard', 'index')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('tasks.index')" :active="request()->routeIs('tasks.*')">
                        {{ __('Задачи') }}
                    </x-nav-link>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('task_statuses.index')" :active="request()->routeIs('task_statuses.*')">
                        {{ __('Статусы') }}
                    </x-nav-link>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('labels.index')" :active="request()->routeIs('labels.*')">
                        {{ __('Метки') }}
                    </x-nav-link>
                </div>
            </div>

            <div class="sm:flex sm:items-center sm:ms-6 space-x-2">
                @auth
                    <a href="{{ route('profile.edit') }}"
                       class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                        {{ __('Profile') }}
                    </a>

                    <a href="{{ route('logout') }}"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                       class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                        {{ __('Выход') }}
                    </a>
                    <form id="logout-form" method="POST" action="{{ route('logout') }}" class="hidden">
                        @csrf
                    </form>
                @else
                    <a href="{{ route('login') }}"
                       class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                        {{ __('Вход') }}
                    </a>
                    <a href="{{ route('register') }}"
                       class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                        {{ __('Регистрация') }}
                    </a>
                @endauth
            </div>
        </div>
    </div>
</nav>
