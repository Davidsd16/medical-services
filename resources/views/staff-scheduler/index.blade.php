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
        <!-- Título del encabezado -->
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __(' Citas Staff') }} <!-- Traducción del título -->
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
                            <!-- Incluir el componente de calendario -->
                            <x-calendar url-handler="{{ route('staff-scheduler.index') }}"></x-calendar>
                        </div>
                        <!-- Detalles de las citas ocupando 2/3 del ancho -->
                        <div class="w-2/3">
                            <!-- Título para las citas del día -->
                            <h3 class="font-bold text-lg">Mis citas para: {{ $date->isoFormat('dddd Do MMMM YYYY') }}</h3>

                            {{-- Bucle para mostrar las citas del día --}}
                            @if ($dayScheduler->isEmpty())
                                <!-- Mensaje si no hay citas para el día -->
                                <div class="mt-2 bg-red-100 p-3 rounded">
                                    <div>No hay citas para la fecha seleccionada.</div>
                                </div>
                            @else
                                <x-auth-validation-errors></x-auth-validation-errors>
                                <!-- Mostrar las citas -->
                                @foreach ($dayScheduler as $schedule)
                                <div class="flex items-center mt-2 bg-indigo-100 p-3 rounded">
                                    <div class="w-1/2">
                                        <!-- Detalles de la cita -->
                                        <div>{{ $schedule->service->name }} a {{ $schedule->clientUser->name }}</div>
                                        <div>Desde <span class="font-bold">{{ $schedule->from->format('H:i') }}</span> hasta <span class="font-bold">{{ $schedule->to->format('H:i') }}</span></div>
                                    </div>
                                </div>    
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
