<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Medical Services Dashboard') }}
            </h2>
            <img src="https://via.placeholder.com/150" alt="Medical Logo" class="h-12">
        </div>
    </x-slot>

    <div class="py-12 bg-blue-50 dark:bg-gray-900">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h3 class="text-lg font-bold mb-4">{{ __('Equipo') }}</h3>
                        <ul class="list-disc pl-5">
                            <li> Dr. Juan Martínez</li>
                            <li>Dra. Elena García</li>
                            <li>Dr. Carlos Pérez</li>
                            <li>Dra. Laura Fernández</li>
                            <li>Dra. Ana Rodríguez</li>
                            <li>Dr. José Sánchez</li>
                            <li>Dra. Marta Gómez</li>
                        </ul>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h3 class="text-lg font-bold mb-4">{{ __('Registros médicos') }}</h3>
                        <ul class="list-disc pl-5">
                            <li>Consulta médica general</li>
                            <li>Examen físico</li>
                            <li>Extracción de sangre</li>
                            <li>Electrocardiograma</li>
                            <li>Radiografía de tórax</li>
                            <li>Ecografía abdominal</li>
                            <li>Resonancia magnética</li>
                            <li>Psicoterapia individual</li>
                            <li>Consulta con especialista</li>
                        </ul>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <h3 class="text-lg font-bold mb-4">{{ __('Tarifas') }}</h3>
                        <ul class="list-disc pl-5">
                            <li>{{ __("Mensualidad básica: $50.00 por mes") }}</li>
                            <li>{{ __("Mensualidad premium: $100.00 por mes") }}</li>
                            <li>{{ __("Tarifa anual básica: $550.00 por año (ahorra $50.00)") }}</li>
                            <li>{{ __("Tarifa anual premium: $1,100.00 por año (ahorra $100.00)") }}</li>
                        </ul>
                    </div>
                </div>                
            </div>

            <div class="mt-8 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-bold mb-4">{{ __('Ultimas Noticias') }}</h3>
                    <ul class="list-disc pl-5">
                        <li>{{ __("Nuestra clínica ha sido reconocida por su excelencia en atención al paciente, recibiendo el premio de Calidad de Salud 2024.") }}</li>
                        <li>{{ __("Hemos inaugurado una nueva unidad de diagnóstico por imágenes con tecnología de vanguardia para ofrecer diagnósticos más precisos y rápidos.") }}</li>
                        <li>{{ __("Se ha ampliado el horario de atención de nuestra clínica para brindar servicios médicos de emergencia las 24 horas del día, los 7 días de la semana.") }}</li>
                    </ul>
                </div>
            </div>

            <div class="mt-8 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-bold mb-4">{{ __('Contact Your Doctor') }}</h3>
                    <form>
                        <div class="mb-4">
                            <label for="message" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Message') }}</label>
                            <textarea id="message" name="message" rows="4" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm focus:border-indigo-500 dark:focus:border-indigo-300 focus:ring focus:ring-indigo-200 dark:focus:ring-indigo-800 dark:bg-gray-700 dark:text-gray-300"></textarea>
                        </div>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-500 dark:bg-blue-800 dark:hover:bg-blue-700">{{ __('Send Message') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
