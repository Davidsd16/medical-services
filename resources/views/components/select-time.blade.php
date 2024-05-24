@props([
    // Establece si el select está deshabilitado o no
    'disabled' => false,
    // Hora inicial del rango de horas
    'initHour' => 0,
    // Hora final del rango de horas
    'endHour' => 23,
    // Hora seleccionada por defecto
    'selectedHour' => '',
])

<!-- Selector de hora -->
<select {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50']) !!}>
    <!-- Opción predeterminada -->
    <option>--Selecciona la hora--</option>
    <!-- Bucle para generar las opciones de hora -->
    @foreach (range($initHour, $endHour) as $hour)
        <!-- Opción para la hora en punto -->
        <option value="{{ "{$hour}:00" }}" {{ "{$hour}:00" == $selectedHour ? 'selected' : '' }}>
            {{ "{$hour}:00" }}
        </option>
        <!-- Opción para la hora y media -->
        <option value="{{ "{$hour}:30" }}" {{ "{$hour}:30" == $selectedHour ? 'selected' : '' }}>
            {{ "{$hour}:30" }}
        </option>
    @endforeach
</select>
