<x-app-layout>
    <!-- Sección de encabezado -->
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar horarios de atención') }}
        </h2>
    </x-slot>

    <!-- Contenido principal de la página -->
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Contenedor principal con sombra y bordes redondeados -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    
                    <!-- Componente para mostrar errores de validación -->
                    <x-auth-validation-errors></x-auth-validation-errors>
                    @if (session()->has('success'))
                        <div class="bg-green-300 border-2 border-green-600">
                            {{ Session::get('success') }}                        
                        </div>
                    @endif
                    <!-- Formulario para actualizar horarios de atención -->
                    <form action="{{ route('opening-hours.update') }}" method="POST">
                        @csrf <!-- Directiva para incluir el token CSRF -->

                        <!-- Grid para organizar los campos de entrada -->
                        <div class="grid grid-cols-1 gap-4">
                            @foreach ($openingHours as $openingHour)
                                <div>
                                    <!-- Etiqueta para el día correspondiente -->
                                    <x-label for="open[{{ $openingHour->day }}]" value="{{ $openingHour->day_name }}" />

                                    <!-- Selectores de hora de apertura y cierre -->
                                    <x-select-time id="open[{{ $openingHour->day }}]" name="hours[{{ $openingHour->day }}][open]" selected-hour='{{ old("hours.{$openingHour->day}.open", $openingHour->open) }}'></x-select-time>
                                    <x-select-time id="close[{{ $openingHour->day }}]" name="hours[{{ $openingHour->day }}][close]" selected-hour='{{ old("hours.{$openingHour->day}.close", $openingHour->close) }}'></x-select-time>
                                </div>
                            @endforeach
                        </div>

                        <!-- Botón para enviar el formulario -->
                        <x-button class="mt-4">Actualizar</x-button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
