@props([
    // Define la variable 'disabled' con valor predeterminado 'false'
    'disabled' => false,
    // Define la hora inicial con valor predeterminado '0'
    'initHour' => 0,
    // Define la hora final con valor predeterminado '23'
    'endHour' => 23,
    // Define la hora seleccionada con valor predeterminado vacío
    'selectedHour' => '',
])

<!-- Select con la capacidad de deshabilitarse -->
<select 
    <!-- Atributo 'disabled' si la variable 'disabled' es 'true' -->
    {{ $disabled ? 'disabled' : '' }}
    <!-- Fusión de atributos adicionales proporcionados -->
    {!! $attributes->merge([
        'class' => 'rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50'
    ]) !!}
>
    <!-- Opción por defecto -->
    <option>--Selecciona la hora--</option>
    <!-- Bucle para generar opciones de hora -->
    @foreach (range($initHour, $endHour) as $hour)
        <!-- Opción para cada hora completa -->
        <option value="{{ "{$initHour}:00" }}" {{ "{$initHour}:00" == $selectedHour ? 'selected' : '' }}>
            {{ "{$hour}:00" }}
        </option>
        <!-- Opción para cada media hora -->
        <option value="{{ "{$initHour}:30" }}" {{ "{$initHour}:30" == $selectedHour ? 'selected' : '' }}>
            {{ "{$hour}:30" }}
        </option>
    @endforeach
</select>
