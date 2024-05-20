<x-app-layout>
    <x-slot name="headers">
        <style>
            [x-cloak] {
                display: none;
            }
        </style>
    </x-slot>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Mi agenda') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("Administrar citas medicas") }}
                <div class="flex">
                <div class="w-1/3">
                    <x-calendar></x-calendar>
                </div>
                <div class="w-2/3">
                    Mis citas aqui.
                </div>
                    
                    <x-button class="bg-red-600 hover:bg-orange-500">Acceder</x-button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>    