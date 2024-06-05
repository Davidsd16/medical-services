@props(['urlHandler'])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100 flex items-center justify-center min-h-screen">

<div class="w-full max-w-4xl mx-auto p-4">
    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
        <div class="flex items-center justify-between px-6 py-3 bg-gray-700">
            <button id="prevMonth" class="text-white">Previous</button>
            <h2 id="currentMonth" class="text-white"></h2>
            <button id="nextMonth" class="text-white">Next</button>
        </div>
        <div class="grid grid-cols-7 gap-2 p-4" id="calendar">
            <!-- Calendar Days Go Here -->
        </div>
    </div>
</div>

<script>
    // Pasar la URL del manejador desde Blade a JavaScript
    const urlHandler = @json($urlHandler);

    function generateCalendar(year, month) {
        const calendarElement = document.getElementById('calendar');
        const currentMonthElement = document.getElementById('currentMonth');

        // Create a date object for the first day of the specified month
        const firstDayOfMonth = new Date(year, month, 1);
        const daysInMonth = new Date(year, month + 1, 0).getDate();

        // Clear the calendar
        calendarElement.innerHTML = '';

        // Set the current month text
        const monthNames = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
        currentMonthElement.innerText = `${monthNames[month]} ${year}`;

        // Calculate the day of the week for the first day of the month (0 - Sunday, 1 - Monday, ..., 6 - Saturday)
        const firstDayOfWeek = firstDayOfMonth.getDay();

        // Create headers for the days of the week
        const daysOfWeek = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
        daysOfWeek.forEach(day => {
            const dayElement = document.createElement('div');
            dayElement.className = 'text-center font-semibold';
            dayElement.innerText = day;
            calendarElement.appendChild(dayElement);
        });

        // Create empty boxes for days before the first day of the month
        for (let i = 0; i < firstDayOfWeek; i++) {
            const emptyDayElement = document.createElement('div');
            calendarElement.appendChild(emptyDayElement);
        }

        // Create boxes for each day of the month
        for (let day = 1; day <= daysInMonth; day++) {
            const dayElement = document.createElement('a');
            const formattedMonth = String(month + 1).padStart(2, '0');
            const formattedDay = String(day).padStart(2, '0');
            dayElement.href = `${urlHandler}?date=${year}-${formattedMonth}-${formattedDay}`;
            dayElement.className = 'text-center py-2 border cursor-pointer';
            dayElement.innerText = day;

            // Check if this date is the current date
            const currentDate = new Date();
            if (year === currentDate.getFullYear() && month === currentDate.getMonth() && day === currentDate.getDate()) {
                dayElement.classList.add('bg-blue-500', 'text-white'); // Add classes for the indicator
            }

            calendarElement.appendChild(dayElement);
        }
    }

    // Initialize the calendar with the current month and year
    const currentDate = new Date();
    let currentYear = currentDate.getFullYear();
    let currentMonth = currentDate.getMonth();
    generateCalendar(currentYear, currentMonth);

    // Event listeners for previous and next month buttons
    document.getElementById('prevMonth').addEventListener('click', () => {
        currentMonth--;
        if (currentMonth < 0) {
            currentMonth = 11;
            currentYear--;
        }
        generateCalendar(currentYear, currentMonth);
    });

    document.getElementById('nextMonth').addEventListener('click', () => {
        currentMonth++;
        if (currentMonth > 11) {
            currentMonth = 0;
            currentYear++;
        }
        generateCalendar(currentYear, currentMonth);
    });
</script>

</body>
</html>
