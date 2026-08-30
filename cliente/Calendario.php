<?php
require_once "../servidor/conexionBD.php";

/* ============================================================
   OBTENER EVENTOS DESDE LA BASE DE DATOS
   ============================================================ */

$eventos = [];

$sql = "SELECT 
            id_evento,
            nombre_evento,
            descripcion,
            fecha_evento,
            hora_evento,
            lugar,
            estado
        FROM eventos
        WHERE fecha_evento IS NOT NULL
        ORDER BY fecha_evento ASC, hora_evento ASC";

$resultado = $conexion->query($sql);

if ($resultado) {
    while ($fila = $resultado->fetch_assoc()) {

        /* Solo mostrar eventos activos */
        if (isset($fila['estado']) && strtolower($fila['estado']) !== 'activo') {
            continue;
        }

        $fecha = $fila['fecha_evento'];

        $eventos[] = [
            'id' => (int)$fila['id_evento'],
            'title' => $fila['nombre_evento'],
            'description' => $fila['descripcion'],
            'date' => $fecha,
            'time' => $fila['hora_evento'],
            'location' => $fila['lugar']
        ];
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Calendario de Eventos - Oratorio y Liturgia</title>

    <style>

        /* ============================================================
           VARIABLES
           ============================================================ */

        :root {
            --blue: #2563eb;
            --blue-dark: #1e40af;
            --yellow: #facc15;
            --bg: #0b1220;
            --card: rgba(255,255,255,0.06);
            --text: #e5e7eb;
            --muted: #94a3b8;
            --white: #ffffff;
        }


        /* ============================================================
           GENERAL
           ============================================================ */

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #0b1220, #111827);
            color: var(--text);
            line-height: 1.6;
            padding: 15px;
        }


        /* ============================================================
           CONTENEDOR
           ============================================================ */

        .container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
        }


        /* ============================================================
           TITULO
           ============================================================ */

        .section-title {
            text-align: center;
            font-size: 28px;
            font-weight: 800;
            color: white;
            margin-bottom: 25px;
        }

        .section-title::after {
            content: "";
            display: block;
            width: 80px;
            height: 4px;
            margin: 10px auto;
            border-radius: 10px;
            background: linear-gradient(
                90deg,
                var(--blue),
                var(--yellow)
            );
        }


        /* ============================================================
           TARJETA DEL CALENDARIO
           ============================================================ */

        .calendar-section {
            background: var(--card);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 16px;
            padding: 18px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.4);
        }


        /* ============================================================
           CABECERA
           ============================================================ */

        .calendar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
            margin-bottom: 15px;
        }

        .calendar-header h2 {
            font-size: 22px;
            font-weight: 700;
        }


        /* ============================================================
           BOTONES DE NAVEGACION
           ============================================================ */

        .calendar-nav {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }

        .btn {
            background: linear-gradient(
                135deg,
                var(--blue),
                var(--blue-dark)
            );

            color: white;

            border: none;

            padding: 9px 13px;

            border-radius: 10px;

            font-weight: 600;

            cursor: pointer;

            transition: 0.3s;

            box-shadow: 0 6px 15px rgba(37,99,235,0.25);
        }

        .btn:hover {
            transform: translateY(-2px);

            box-shadow:
                0 10px 22px rgba(37,99,235,0.4);
        }

        .btn:active {
            transform: scale(0.97);
        }


        /* ============================================================
           GRID DEL CALENDARIO
           ============================================================ */

        .calendar-grid {
            display: grid;

            grid-template-columns:
                repeat(7, 1fr);

            gap: 6px;

            margin-top: 10px;
        }


        /* ============================================================
           DIAS DE LA SEMANA
           ============================================================ */

        .calendar-day {
            text-align: center;

            font-size: 12px;

            color: var(--muted);

            font-weight: 700;

            padding: 8px 0;
        }


        /* ============================================================
           CASILLAS DE FECHA
           ============================================================ */

        .calendar-date {
            min-height: 95px;

            background: rgba(255,255,255,0.04);

            border: 1px solid rgba(255,255,255,0.08);

            border-radius: 12px;

            padding: 7px;

            transition: 0.2s;

            overflow: hidden;

            position: relative;
        }

        .calendar-date:hover {
            transform: scale(1.02);

            border-color: var(--yellow);

            background:
                rgba(37,99,235,0.12);
        }


        /* ============================================================
           DIA ACTUAL
           ============================================================ */

        .calendar-date.today {
            border: 2px solid var(--yellow);

            background:
                rgba(250,204,21,0.12);
        }


        /* ============================================================
           OTROS MESES
           ============================================================ */

        .calendar-date.other-month {
            opacity: 0.3;
        }


        /* ============================================================
           NUMERO DEL DIA
           ============================================================ */

        .day-number {
            font-weight: 700;

            font-size: 13px;

            margin-bottom: 4px;
        }


        /* ============================================================
           INDICADOR DE EVENTO
           ============================================================ */

        .event-indicator {
            font-size: 10px;

            background:
                linear-gradient(
                    135deg,
                    var(--yellow),
                    var(--blue)
                );

            color: #111;

            padding: 3px 6px;

            border-radius: 6px;

            margin-top: 4px;

            display: block;

            white-space: nowrap;

            overflow: hidden;

            text-overflow: ellipsis;

            cursor: pointer;

            font-weight: 700;

            transition: 0.2s;
        }

        .event-indicator:hover {
            transform: translateX(2px);
        }


        /* ============================================================
           LISTA DE EVENTOS
           ============================================================ */

        .events-list {
            margin-top: 25px;
        }

        .events-list h3 {
            font-size: 20px;

            margin-bottom: 15px;

            color: white;
        }


        /* ============================================================
           EVENTO
           ============================================================ */

        .event-item {
            background:
                rgba(255,255,255,0.05);

            border:
                1px solid rgba(255,255,255,0.08);

            padding: 15px;

            border-radius: 12px;

            margin-bottom: 12px;

            display: flex;

            justify-content: space-between;

            gap: 15px;

            transition: 0.2s;
        }

        .event-item:hover {
            border-color: rgba(250,204,21,0.5);

            background:
                rgba(255,255,255,0.08);
        }


        /* ============================================================
           INFORMACION DEL EVENTO
           ============================================================ */

        .event-info {
            flex: 1;
        }

        .event-info h4 {
            color: white;

            font-size: 17px;

            margin-bottom: 8px;
        }

        .event-info p {
            color: var(--muted);

            font-size: 14px;

            margin-bottom: 4px;
        }

        .event-info strong {
            color: white;
        }


        /* ============================================================
           MENSAJE SIN EVENTOS
           ============================================================ */

        .no-events {
            text-align: center;

            padding: 25px;

            color: var(--muted);

            background:
                rgba(255,255,255,0.03);

            border-radius: 12px;
        }


        /* ============================================================
           MODAL DE INFORMACION
           ============================================================ */

        .modal {
            display: none;

            position: fixed;

            inset: 0;

            background:
                rgba(0,0,0,0.65);

            backdrop-filter: blur(6px);

            justify-content: center;

            align-items: center;

            padding: 15px;

            z-index: 9999;
        }

        .modal-content {
            background: #0f172a;

            border:
                1px solid rgba(255,255,255,0.1);

            border-radius: 16px;

            padding: 20px;

            width: 100%;

            max-width: 450px;

            box-shadow:
                0 20px 50px rgba(0,0,0,0.5);
        }

        .modal-header {
            display: flex;

            justify-content: space-between;

            align-items: center;

            margin-bottom: 15px;
        }

        .modal-header h3 {
            color: white;

            font-size: 20px;
        }

        .close-modal {
            font-size: 28px;

            color: var(--muted);

            cursor: pointer;
        }

        .close-modal:hover {
            color: white;
        }

        .modal-info p {
            margin-bottom: 10px;

            color: var(--muted);
        }

        .modal-info strong {
            color: white;
        }


        /* ============================================================
           RESPONSIVE
           ============================================================ */

        @media (max-width: 768px) {

            body {
                padding: 8px;
            }

            .section-title {
                font-size: 22px;
            }

            .calendar-header {
                flex-direction: column;

                text-align: center;
            }

            .calendar-nav {
                width: 100%;

                justify-content: center;
            }

            .btn {
                font-size: 12px;

                padding: 8px 10px;
            }

            .calendar-date {
                min-height: 70px;

                padding: 5px;
            }

            .calendar-day {
                font-size: 10px;
            }

            .day-number {
                font-size: 11px;
            }

            .event-indicator {
                font-size: 8px;

                padding: 2px 4px;
            }

            .event-item {
                flex-direction: column;
            }
        }


        @media (max-width: 480px) {

            .calendar-nav {
                display: grid;

                grid-template-columns:
                    repeat(2, 1fr);

                width: 100%;
            }

            .calendar-nav .btn {
                width: 100%;
            }

            .calendar-date {
                min-height: 60px;
            }

            .event-indicator {
                font-size: 7px;
            }
        }

    </style>
</head>


<body>

<div class="container">

    <h1 class="section-title">
        Calendario de Eventos 2026 - Oratorio y Liturgia
    </h1>


    <div class="calendar-section">

        <!-- ========================================================
             CABECERA
             ======================================================== -->

        <div class="calendar-header">

            <h2 id="current-month-year">
                Agosto 2026
            </h2>

            <div class="calendar-nav">

                <button class="btn" id="prev-year">
                    « Año
                </button>

                <button class="btn" id="prev-month">
                    ‹ Mes
                </button>

                <button class="btn" id="today">
                    Hoy
                </button>

                <button class="btn" id="next-month">
                    Mes ›
                </button>

                <button class="btn" id="next-year">
                    Año »
                </button>

            </div>

        </div>


        <!-- ========================================================
             CALENDARIO
             ======================================================== -->

        <div
            class="calendar-grid"
            id="calendar-grid">
        </div>


        <!-- ========================================================
             EVENTOS DEL MES
             ======================================================== -->

        <div class="events-list">

            <h3>
                Eventos del mes
            </h3>

            <div id="month-events"></div>

        </div>

    </div>

</div>


<!-- ================================================================
     MODAL SOLO PARA VER INFORMACION
     ================================================================ -->

<div class="modal" id="event-modal">

    <div class="modal-content">

        <div class="modal-header">

            <h3 id="modal-title">
                Información del evento
            </h3>

            <span
                class="close-modal"
                id="close-modal">
                &times;
            </span>

        </div>

        <div
            class="modal-info"
            id="modal-info">
        </div>

    </div>

</div>


<script>

/* ================================================================
   EVENTOS PROCEDENTES DE PHP / MYSQL
   ================================================================ */

const events = <?php echo json_encode(
    $eventos,
    JSON_UNESCAPED_UNICODE |
    JSON_UNESCAPED_SLASHES
); ?>;


/* ================================================================
   FECHA ACTUAL
   ================================================================ */

let currentDate = new Date();


/* ================================================================
   ELEMENTOS
   ================================================================ */

const calendarGrid =
    document.getElementById('calendar-grid');

const currentMonthYear =
    document.getElementById('current-month-year');

const monthEvents =
    document.getElementById('month-events');

const eventModal =
    document.getElementById('event-modal');

const modalTitle =
    document.getElementById('modal-title');

const modalInfo =
    document.getElementById('modal-info');

const closeModal =
    document.getElementById('close-modal');


/* ================================================================
   INICIAR
   ================================================================ */

document.addEventListener(
    'DOMContentLoaded',
    function() {

        renderCalendar();

        setupEventListeners();

    }
);


/* ================================================================
   BOTONES
   ================================================================ */

function setupEventListeners() {

    document
        .getElementById('prev-month')
        .addEventListener(
            'click',
            prevMonth
        );

    document
        .getElementById('next-month')
        .addEventListener(
            'click',
            nextMonth
        );

    document
        .getElementById('prev-year')
        .addEventListener(
            'click',
            prevYear
        );

    document
        .getElementById('next-year')
        .addEventListener(
            'click',
            nextYear
        );

    document
        .getElementById('today')
        .addEventListener(
            'click',
            goToToday
        );

    closeModal.addEventListener(
        'click',
        closeEventModal
    );

    eventModal.addEventListener(
        'click',
        function(e) {

            if (e.target === eventModal) {

                closeEventModal();

            }

        }
    );

}


/* ================================================================
   RENDERIZAR CALENDARIO
   ================================================================ */

function renderCalendar() {

    calendarGrid.innerHTML = '';


    /* ------------------------------------------------------------
       DIAS DE LA SEMANA
       ------------------------------------------------------------ */

    const daysOfWeek = [
        'Dom',
        'Lun',
        'Mar',
        'Mié',
        'Jue',
        'Vie',
        'Sáb'
    ];

    daysOfWeek.forEach(day => {

        const dayElement =
            document.createElement('div');

        dayElement.className =
            'calendar-day';

        dayElement.textContent =
            day;

        calendarGrid.appendChild(
            dayElement
        );

    });


    /* ------------------------------------------------------------
       INFORMACION DEL MES
       ------------------------------------------------------------ */

    const year =
        currentDate.getFullYear();

    const month =
        currentDate.getMonth();


    currentMonthYear.textContent =
        `${getMonthName(month)} ${year}`;


    const firstDay =
        new Date(year, month, 1);

    const lastDay =
        new Date(year, month + 1, 0);


    const firstDayOfWeek =
        firstDay.getDay();


    const prevMonthLastDay =
        new Date(year, month, 0).getDate();


    /* ------------------------------------------------------------
       DIAS DEL MES ANTERIOR
       ------------------------------------------------------------ */

    for (
        let i = firstDayOfWeek - 1;
        i >= 0;
        i--
    ) {

        const dateElement =
            document.createElement('div');

        dateElement.className =
            'calendar-date other-month';

        dateElement.textContent =
            prevMonthLastDay - i;

        calendarGrid.appendChild(
            dateElement
        );

    }


    /* ------------------------------------------------------------
       DIAS DEL MES ACTUAL
       ------------------------------------------------------------ */

    const today =
        new Date();


    for (
        let day = 1;
        day <= lastDay.getDate();
        day++
    ) {

        const dateElement =
            document.createElement('div');

        dateElement.className =
            'calendar-date';


        /* Numero del día */

        const dayNumber =
            document.createElement('div');

        dayNumber.className =
            'day-number';

        dayNumber.textContent =
            day;

        dateElement.appendChild(
            dayNumber
        );


        /* Marcar hoy */

        if (
            year === today.getFullYear() &&
            month === today.getMonth() &&
            day === today.getDate()
        ) {

            dateElement.classList.add(
                'today'
            );

        }


        /* Fecha en formato YYYY-MM-DD */

        const dateKey =
            `${year}-${String(month + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;


        /* Buscar eventos */

        const dayEvents =
            events.filter(
                event => event.date === dateKey
            );


        /* Mostrar eventos */

        dayEvents.forEach(event => {

            const eventIndicator =
                document.createElement('div');

            eventIndicator.className =
                'event-indicator';

            eventIndicator.textContent =
                event.title;

            eventIndicator.title =
                'Ver información del evento';


            eventIndicator.addEventListener(
                'click',
                function(e) {

                    e.stopPropagation();

                    showEvent(event);

                }
            );


            dateElement.appendChild(
                eventIndicator
            );

        });


        calendarGrid.appendChild(
            dateElement
        );

    }


    /* ------------------------------------------------------------
       COMPLETAR CALENDARIO
       ------------------------------------------------------------ */

    const totalCells = 42;

    const daysInCalendar =
        firstDayOfWeek +
        lastDay.getDate();

    const nextMonthDays =
        totalCells -
        daysInCalendar;


    for (
        let day = 1;
        day <= nextMonthDays;
        day++
    ) {

        const dateElement =
            document.createElement('div');

        dateElement.className =
            'calendar-date other-month';

        dateElement.textContent =
            day;

        calendarGrid.appendChild(
            dateElement
        );

    }


    /* ------------------------------------------------------------
       LISTA DE EVENTOS
       ------------------------------------------------------------ */

    renderMonthEvents();

}


/* ================================================================
   MOSTRAR EVENTOS DEL MES
   ================================================================ */

function renderMonthEvents() {

    monthEvents.innerHTML = '';


    const year =
        currentDate.getFullYear();

    const month =
        currentDate.getMonth();


    const monthEventsList =
        events
            .filter(event => {

                const eventDate =
                    new Date(
                        event.date + 'T00:00:00'
                    );

                return (
                    eventDate.getFullYear() === year &&
                    eventDate.getMonth() === month
                );

            })
            .sort((a, b) => {

                if (a.date !== b.date) {

                    return a.date.localeCompare(
                        b.date
                    );

                }

                return (
                    (a.time || '')
                    .localeCompare(
                        b.time || ''
                    )
                );

            });


    /* ------------------------------------------------------------
       SIN EVENTOS
       ------------------------------------------------------------ */

    if (monthEventsList.length === 0) {

        monthEvents.innerHTML = `
            <div class="no-events">
                <i>📅</i>
                <p>
                    No hay eventos programados
                    para este mes.
                </p>
            </div>
        `;

        return;

    }


    /* ------------------------------------------------------------
       MOSTRAR EVENTOS
       ------------------------------------------------------------ */

    monthEventsList.forEach(event => {

        const eventItem =
            document.createElement('div');

        eventItem.className =
            'event-item';


        const formattedDate =
            formatDate(event.date);


        eventItem.innerHTML = `

            <div class="event-info">

                <h4>
                    ${escapeHtml(event.title)}
                </h4>

                <p>
                    <strong>📅 Fecha:</strong>
                    ${formattedDate}
                </p>

                ${
                    event.time
                    ? `
                    <p>
                        <strong>🕐 Hora:</strong>
                        ${escapeHtml(
                            formatTime(event.time)
                        )}
                    </p>
                    `
                    : ''
                }

                ${
                    event.location
                    ? `
                    <p>
                        <strong>📍 Lugar:</strong>
                        ${escapeHtml(
                            event.location
                        )}
                    </p>
                    `
                    : ''
                }

                ${
                    event.description
                    ? `
                    <p>
                        <strong>Descripción:</strong>
                        ${escapeHtml(
                            event.description
                        )}
                    </p>
                    `
                    : ''
                }

            </div>

        `;


        eventItem.addEventListener(
            'click',
            function() {

                showEvent(event);

            }
        );


        monthEvents.appendChild(
            eventItem
        );

    });

}


/* ================================================================
   MOSTRAR INFORMACION DEL EVENTO
   ================================================================ */

function showEvent(event) {

    modalTitle.textContent =
        event.title;


    modalInfo.innerHTML = `

        <p>
            <strong>📅 Fecha:</strong>
            ${formatDate(event.date)}
        </p>

        ${
            event.time
            ? `
            <p>
                <strong>🕐 Hora:</strong>
                ${escapeHtml(
                    formatTime(event.time)
                )}
            </p>
            `
            : ''
        }

        ${
            event.location
            ? `
            <p>
                <strong>📍 Lugar:</strong>
                ${escapeHtml(
                    event.location
                )}
            </p>
            `
            : ''
        }

        ${
            event.description
            ? `
            <p>
                <strong>📝 Descripción:</strong><br>
                ${escapeHtml(
                    event.description
                )}
            </p>
            `
            : ''
        }

    `;


    eventModal.style.display =
        'flex';

}


/* ================================================================
   CERRAR MODAL
   ================================================================ */

function closeEventModal() {

    eventModal.style.display =
        'none';

}


/* ================================================================
   NAVEGACION
   ================================================================ */

function prevMonth() {

    currentDate.setMonth(
        currentDate.getMonth() - 1
    );

    renderCalendar();

}


function nextMonth() {

    currentDate.setMonth(
        currentDate.getMonth() + 1
    );

    renderCalendar();

}


function prevYear() {

    currentDate.setFullYear(
        currentDate.getFullYear() - 1
    );

    renderCalendar();

}


function nextYear() {

    currentDate.setFullYear(
        currentDate.getFullYear() + 1
    );

    renderCalendar();

}


function goToToday() {

    currentDate = new Date();

    renderCalendar();

}


/* ================================================================
   NOMBRES DE LOS MESES
   ================================================================ */

function getMonthName(monthIndex) {

    const months = [

        'Enero',
        'Febrero',
        'Marzo',
        'Abril',
        'Mayo',
        'Junio',
        'Julio',
        'Agosto',
        'Septiembre',
        'Octubre',
        'Noviembre',
        'Diciembre'

    ];

    return months[monthIndex];

}


/* ================================================================
   FORMATEAR FECHA
   ================================================================ */

function formatDate(dateString) {

    const [
        year,
        month,
        day
    ] = dateString.split('-');


    return `${parseInt(day)} de ${getMonthName(
        parseInt(month) - 1
    )} de ${year}`;

}


/* ================================================================
   FORMATEAR HORA
   ================================================================ */

function formatTime(timeString) {

    if (!timeString) {
        return '';
    }

    return timeString.substring(
        0,
        5
    );

}


/* ================================================================
   SEGURIDAD
   Evita insertar directamente HTML proveniente
   de la base de datos.
   ================================================================ */

function escapeHtml(text) {

    if (!text) {
        return '';
    }

    return String(text)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#039;');

}

</script>

</body>
</html>

