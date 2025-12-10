<x-app-layout>
    <x-slot name="header">
        
        

    <div class="container">

    </x-slot>
        @auth
        
        
        @yield('admin-dashboard')
        
        
        @yield('doctor-dashboard')
        
        @endauth
</div>


</x-app-layout>