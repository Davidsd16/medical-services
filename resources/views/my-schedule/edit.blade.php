<x-app-layout>
    {{-- Encabezado de la página --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Actualizar cita') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Contenedor principal con fondo blanco y sombras --}}
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{-- Mostrar errores de validación --}}
                    <x-auth-validation-errors></x-auth-validation-errors>
                    {{-- Formulario para actualizar la cita --}}
                    <form action="{{ route('my-schedule.update', ['schedule' => $schedule->id]) }}" method="POST">
                        @method('PUT') {{-- Método HTTP PUT para actualizar --}}
                        @csrf {{-- Token CSRF para proteger contra ataques CSRF --}}
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                {{-- Campo para seleccionar la fecha de la cita --}}
                                <x-label for="from[date]" :value="__('Fecha para la cita')" />
                                <x-input id="from[date]" class="block mt-1 w-full" type="date" name="from[date]"
                                    :value="old('from.date', $schedule->from->format('Y-m-d'))" autofocus />
                            </div>

                            <div>
                                {{-- Campo para seleccionar la hora de inicio de la cita --}}
                                <x-label for="from[time]" :value="__('Elije la hora de inicio')" />
                                <x-select-time id="from[time]" init-hour="8" end-hour="17" 
                                    :selected-hour="old('from.time', $schedule->from->format('H:i'))"
                                    class="block mt-1 w-full" name="from[time]"></x-select-time>
                            </div>

                            <div>
                                {{-- Campo para seleccionar el servicio --}}
                                <x-label for="service_id" :value="__('Elige el servicio')" />
                                <x-select id="service_id" class="block mt-1 w-full" name="service_id">
                                    <option value="">--Selecciona el servicio--</option>
                                    @foreach ($services as $service)
                                        <option value="{{ $service->id }}" {{ old('service_id', $schedule->service_id) == $service->id ? 'selected' : '' }}>
                                            {{ $service->name }}
                                        </option>
                                    @endforeach
                                </x-select>
                            </div>

                            <div>
                                {{-- Campo para seleccionar el usuario del personal que atenderá --}}
                                <x-label for="staff_user_id" :value="__('Elige quién te atenderá')" />
                                <x-select id="staff_user_id" class="block mt-1 w-full" name="staff_user_id">
                                    <option value="">--Selecciona quién te atenderá--</option>
                                    @foreach ($staffUsers as $user)
                                        <option value="{{ $user->id }}" {{ old('staff_user_id', $schedule->staff_user_id) == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }}
                                        </option>
                                    @endforeach
                                </x-select>
                            </div>
                        </div>
                        {{-- Botón para enviar el formulario y actualizar la cita --}}
                        <x-button class="mt-4">Actualizar</x-button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
