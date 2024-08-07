<x-app-layout>
    <!-- Slot para el encabezado de la página -->
    <x-slot name="header">
        <!-- Título del encabezado -->
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Reserva tu nueva cita en el formulario') }} <!-- Traducción del título -->
        </h2>
    </x-slot>

    <!-- Sección principal del contenido -->
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <!-- Validar registro en fortmulario -->
                    <x-auth-validation-errors></x-auth-validation-errors>
                    <!-- Formulario para reservar una cita -->
                    <form action="{{ route('my-schedule.store') }}" method="POST">
                        @csrf
                        @method('POST')
                        <!-- Grid para organizar los elementos del formulario en dos columnas -->
                        <div class="grid grid-cols-2 gap-4">
                            <!-- Campo de entrada de fecha para la cita -->
                            <div>
                                <x-label for="from[date]" :value="__('Fecha para la cita')" /> <!-- Etiqueta para el campo de fecha -->
                                <x-input id="from[date]" class="block mt-1 w-full" type="date" name="from[date]"
                                    :value="old('from.date', request('date'))" autofocus /> <!-- Campo de entrada de fecha -->
                            </div>

                            <!-- Campo de entrada de hora de inicio para la cita -->
                            <div>
                                <x-label for="from[time]" :value="__('Elije la hora de inicio')" /> <!-- Etiqueta para el campo de hora de inicio -->
                                <x-select-time id="from[time]" init-hour="8" end-hour="17" :selected-hour="old('from.time')"
                                    class="block mt-1 w-full" name="from[time]"></x-select-time> <!-- Selector de hora de inicio -->
                            </div>

                            <!-- Selector de servicio disponible -->
                            <div>
                                <x-label for="service_id" :value="__('Elige el servicio')" /> <!-- Etiqueta para el selector de servicio -->
                                <x-select id="service_id" class="block mt-1 w-full" name="service_id">
                                    <option value="">--Selecciona el servicio--</option> <!-- Opción predeterminada -->
                                    @foreach ($services as $service)
                                        <option value="{{ $service->id }}">{{ $service->name }}</option> <!-- Opción de servicio -->
                                    @endforeach
                                </x-select> <!-- Selector de servicio -->
                            </div>

                            <!-- Selector del personal que atenderá -->
                            <div>
                                <x-label for="staff_user_id" :value="__('Elige quién te atenderá')" /> <!-- Etiqueta para el selector de personal -->
                                <x-select id="staff_user_id" class="block mt-1 w-full" name="staff_user_id">
                                    <option value="">--Selecciona quien te atenderá--</option> <!-- Opción predeterminada -->
                                    @foreach ($staffUsers as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option> <!-- Opción de personal -->
                                    @endforeach 
                                </x-select> <!-- Selector de personal -->
                            </div>
                        </div>
                        <!-- Botón para enviar el formulario de reserva -->
                        <x-button class="mt-4">Reservar</x-button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
