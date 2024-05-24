<x-app-layout>
    <!-- Slot para estilos o scripts adicionales en el encabezado -->
    <x-slot name="headers">
        <style>
            /* Este estilo ocultará elementos con el atributo x-cloak */
            [x-cloak] {
                display: none;
            }
        </style>
    </x-slot>

    <!-- Slot para el encabezado de la página -->
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Mi agenda') }}
        </h2>
    </x-slot>

    <!-- Sección principal del contenido -->
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex">
                        <!-- Componente del calendario ocupando 1/3 del ancho -->
                        <div class="w-1/3">
                            <x-calendar></x-calendar>
                        </div>
                        <!-- Detalles de las citas ocupando 2/3 del ancho -->
                        <div class="w-2/3">
                            Mis citas para: {{ $date->isoFormat('dddd D MMMM YYYY') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
