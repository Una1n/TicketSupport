<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen font-sans antialiased bg-base-200">

    {{-- NAVBAR mobile only --}}
    <x-mary-nav sticky class="lg:hidden">
        <x-slot:brand>
            <div class="ml-5 pt-5">Ticket Support</div>
        </x-slot:brand>
        <x-slot:actions>
            <label for="main-drawer" class="lg:hidden mr-3">
                <x-mary-icon name="o-bars-3" class="cursor-pointer" />
            </label>
        </x-slot:actions>
    </x-mary-nav>

    {{-- MAIN --}}
    <x-mary-main full-width>
        {{-- SIDEBAR --}}
        <x-slot:sidebar drawer="main-drawer" collapsible class="bg-base-100 lg:bg-inherit">

            {{-- BRAND --}}
            <div class="ml-5 pt-5">Ticket Support</div>

            {{-- MENU --}}
            <x-mary-menu activate-by-route active-bg-color="bg-primary/30">

                {{-- User --}}
                @if ($user = auth()->user())
                    <x-mary-menu-separator />

                    <x-mary-list-item :item="$user" value="name" sub-value="email" no-separator no-hover
                        class="-mx-2 !-my-2 rounded">
                        <x-slot:actions>
                            <x-mary-button icon="o-power" class="btn-circle btn-ghost btn-xs" tooltip-left="logoff"
                                no-wire-navigate link="/logout" />
                        </x-slot:actions>
                    </x-mary-list-item>

                    <x-mary-menu-separator />
                @endif

                <x-mary-menu-item title="Home" icon="o-home" link="{{ route('dashboard') }}" />
                <x-mary-menu-item title="Tickets" icon="o-ticket" link="{{ route('tickets.index') }}" />
                <x-mary-menu-item title="Users" icon="o-users" link="{{ route('users.index') }}" />
                <x-mary-menu-item title="Ticket Logs" icon="o-envelope" link="{{ route('logs.index') }}" />
                <x-mary-menu-item title="Categories" icon="o-hashtag" link="{{ route('categories.index') }}" />
                <x-mary-menu-item title="Labels" icon="o-tag" link="{{ route('labels.index') }}" />
                <x-mary-menu-separator />
            </x-mary-menu>
            <div class="ml-5"><x-mary-theme-toggle /></div>
        </x-slot:sidebar>

        <x-slot:content>
            {{ $slot }}
        </x-slot:content>
    </x-mary-main>

    {{-- Toast --}}
    <x-mary-toast />
</body>

</html>
