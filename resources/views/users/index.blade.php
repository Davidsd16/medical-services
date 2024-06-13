<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Usuarios') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="-mx-4 sm:-mx-8 px-4 sm:px-8 py-4 overflow-x-auto">
                        <div class="inline-block min-w-full shadow rounded-lg overflow-hidden">
                            <table class="min-w-full leading-normal w-full">
                                <thead>
                                    <tr>
                                        <th class="px-6 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            Nombre
                                        </th>
                                        <th class="px-6 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            Servicios
                                        </th>
                                        <th class="px-6 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            Creado el 
                                        </th>
                                        <th class="px-6 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            Acciones
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                    <tr>
                                        <td class="px-6 py-4 border-b border-gray-200 bg-white text-sm">
                                            <div class="flex items-center">
                                                <div class="ml-4">
                                                    <p class="text-gray-900 whitespace-no-wrap">
                                                        {{ $user->name }}
                                                    </p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 border-b border-gray-200 bg-white text-sm">
                                            @foreach ($user->service as $service)
                                                <p class="text-gray-900 whitespace-no-wrap">
                                                    {{ $service->name }}
                                                </p>
                                            @endforeach
                                        </td>
                                        <td class="px-6 py-4 border-b border-gray-200 bg-white text-sm">
                                            <span class="text-gray-900">{{ $user->created_at->isoFormat('ddd Do MMM YYYY') }}</span>
                                        </td>
                                        <td class="px-6 py-4 border-b border-gray-200 bg-white text-sm">
                                            <x-link href="#">Editar</x-link>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="px-6 py-4 bg-white border-t flex flex-col xs:flex-row items-center xs:justify-between">
                                <span class="text-xs xs:text-sm text-gray-900">
                                    Mostrando 1 a {{ count($users) }} de {{ count($users) }} entradas
                                </span>
                                <div class="inline-flex mt-2 xs:mt-0">
                                    <button class="text-sm text-indigo-50 transition duration-150 hover:bg-indigo-500 bg-indigo-600 font-semibold py-2 px-4 rounded-l">
                                        Prev
                                    </button>
                                    <button class="text-sm text-indigo-50 transition duration-150 hover:bg-indigo-500 bg-indigo-600 font-semibold py-2 px-4 rounded-r">
                                        Next
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
