<x-app-layout>
    {{-- Encabezado de la página --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Asignación de servicios de {{ $user->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{-- Mostrar errores de validación --}}
                    <x-auth-validation-errors></x-auth-validation-errors>
                    
                    {{-- Formulario para actualizar servicios --}}
                    <form action="{{ route('users-services.update', ['user' => $user->id]) }}" method="POST">                        @method('PUT') {{-- Método HTTP PUT --}}
                        @csrf {{-- Token CSRF --}}
                        
                        {{-- Contenedor de servicios con columnas --}}
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                {{-- Iterar sobre los servicios --}}
                                @foreach ($services as $service)
                                    <label for="services_{{ $service->id }}" class="block">
                                        <input type="checkbox" name="services_ids[]" value="{{ $service->id }}" id="services_{{ $service->id }}">
                                        {{ $service->name }}
                                    </label>
                                @endforeach
                            </div>
                        </div>
                        
                        {{-- Botón para enviar el formulario --}}
                        <x-button class="mt-4">Actualizar</x-button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
