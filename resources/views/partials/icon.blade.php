@php
    $class = $class ?? 'h-5 w-5';
    $stroke = $stroke ?? 1.8;
@endphp

@switch($name)
    @case('university')
        <svg class="{{ $class }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="{{ $stroke }}" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <path d="M3 21h18" />
            <path d="M5 21V9" />
            <path d="M19 21V9" />
            <path d="M12 3 4 8h16l-8-5Z" />
            <path d="M9 21v-6h6v6" />
            <path d="M8 12h.01" />
            <path d="M16 12h.01" />
        </svg>
        @break

    @case('company')
        <svg class="{{ $class }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="{{ $stroke }}" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <path d="M4 21V5a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v16" />
            <path d="M16 9h2a2 2 0 0 1 2 2v10" />
            <path d="M8 7h4" />
            <path d="M8 11h4" />
            <path d="M8 15h4" />
            <path d="M9 21v-3h2v3" />
            <path d="M3 21h18" />
        </svg>
        @break

    @case('student')
        <svg class="{{ $class }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="{{ $stroke }}" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <path d="M22 10 12 5 2 10l10 5 10-5Z" />
            <path d="M6 12v5c3 2 9 2 12 0v-5" />
            <path d="M22 10v6" />
        </svg>
        @break

    @case('handshake')
        <svg class="{{ $class }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="{{ $stroke }}" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <path d="m11 17 2 2a3 3 0 0 0 4.2 0L22 14.2" />
            <path d="m2 14.2 4.8 4.8a3 3 0 0 0 4.2 0l4-4" />
            <path d="m7 13 3-3 2 2a3 3 0 0 0 4.2 0l.8-.8" />
            <path d="M2 9h5l3-3h4l3 3h5" />
        </svg>
        @break

    @case('clipboard')
        <svg class="{{ $class }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="{{ $stroke }}" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <path d="M9 5a3 3 0 0 1 6 0" />
            <path d="M9 5H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2" />
            <path d="M9 5h6v3H9z" />
            <path d="M9 13h6" />
            <path d="M9 17h4" />
        </svg>
        @break

    @case('users')
        <svg class="{{ $class }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="{{ $stroke }}" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <path d="M16 21v-2a4 4 0 0 0-4-4H7a4 4 0 0 0-4 4v2" />
            <path d="M9.5 11a4 4 0 1 0 0-8 4 4 0 0 0 0 8Z" />
            <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
            <path d="M16 3.13a4 4 0 0 1 0 7.75" />
        </svg>
        @break

    @case('mentor')
        <svg class="{{ $class }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="{{ $stroke }}" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <path d="M12 12a4 4 0 1 0 0-8 4 4 0 0 0 0 8Z" />
            <path d="M4 21v-1a6 6 0 0 1 12 0v1" />
            <path d="M18 8h3" />
            <path d="M19.5 6.5v3" />
        </svg>
        @break

    @case('note')
        <svg class="{{ $class }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="{{ $stroke }}" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <path d="M6 3h9l3 3v15H6z" />
            <path d="M15 3v4h4" />
            <path d="M9 12h6" />
            <path d="M9 16h6" />
        </svg>
        @break

    @case('chart')
        <svg class="{{ $class }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="{{ $stroke }}" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <path d="M4 19V5" />
            <path d="M4 19h16" />
            <path d="M8 16v-5" />
            <path d="M12 16V8" />
            <path d="M16 16v-3" />
        </svg>
        @break

    @case('scale')
        <svg class="{{ $class }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="{{ $stroke }}" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <path d="M12 3v18" />
            <path d="M5 7h14" />
            <path d="m6 7-3 6h6L6 7Z" />
            <path d="m18 7-3 6h6l-3-6Z" />
        </svg>
        @break

    @case('link')
        <svg class="{{ $class }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="{{ $stroke }}" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <path d="M10 13a5 5 0 0 0 7.1 0l2-2a5 5 0 0 0-7.1-7.1l-1.1 1.1" />
            <path d="M14 11a5 5 0 0 0-7.1 0l-2 2a5 5 0 0 0 7.1 7.1l1.1-1.1" />
        </svg>
        @break

    @case('growth')
        <svg class="{{ $class }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="{{ $stroke }}" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <path d="M12 21V9" />
            <path d="M12 13c-4 0-7-3-7-7 4 0 7 3 7 7Z" />
            <path d="M12 16c4 0 7-3 7-7-4 0-7 3-7 7Z" />
        </svg>
        @break

    @case('mail')
        <svg class="{{ $class }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="{{ $stroke }}" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <path d="M4 6h16v12H4z" />
            <path d="m4 7 8 6 8-6" />
        </svg>
        @break

    @case('phone')
        <svg class="{{ $class }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="{{ $stroke }}" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <path d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3.1 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.1 4.2 2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7c.1 1 .4 2 .7 2.9a2 2 0 0 1-.5 2.1L8.1 9.9a16 16 0 0 0 6 6l1.2-1.2a2 2 0 0 1 2.1-.5c.9.3 1.9.6 2.9.7a2 2 0 0 1 1.7 2Z" />
        </svg>
        @break

    @case('map-pin')
        <svg class="{{ $class }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="{{ $stroke }}" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <path d="M12 21s7-5.3 7-11a7 7 0 1 0-14 0c0 5.7 7 11 7 11Z" />
            <circle cx="12" cy="10" r="2.5" />
        </svg>
        @break

    @case('megaphone')
        <svg class="{{ $class }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="{{ $stroke }}" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <path d="M4 13h4l9 4V5L8 9H4z" />
            <path d="M8 13v5a2 2 0 0 0 2 2h1" />
            <path d="M19 9a3 3 0 0 1 0 4" />
        </svg>
        @break

    @case('briefcase')
        <svg class="{{ $class }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="{{ $stroke }}" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <path d="M10 6V5a2 2 0 0 1 2-2h0a2 2 0 0 1 2 2v1" />
            <path d="M4 7h16v12H4z" />
            <path d="M4 12h16" />
            <path d="M10 12v2h4v-2" />
        </svg>
        @break

    @case('calendar')
        <svg class="{{ $class }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="{{ $stroke }}" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <path d="M7 3v4" />
            <path d="M17 3v4" />
            <path d="M4 8h16" />
            <path d="M5 5h14a1 1 0 0 1 1 1v14H4V6a1 1 0 0 1 1-1Z" />
            <path d="M8 12h.01" />
            <path d="M12 12h.01" />
            <path d="M16 12h.01" />
            <path d="M8 16h.01" />
            <path d="M12 16h.01" />
        </svg>
        @break

    @case('compass')
        <svg class="{{ $class }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="{{ $stroke }}" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <circle cx="12" cy="12" r="9" />
            <path d="m15.5 8.5-2 5-5 2 2-5 5-2Z" />
        </svg>
        @break

    @case('check')
        <svg class="{{ $class }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="{{ $stroke }}" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <path d="M20 6 9 17l-5-5" />
        </svg>
        @break

    @case('inbox')
        <svg class="{{ $class }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="{{ $stroke }}" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <path d="M4 4h16v16H4z" />
            <path d="M4 14h4l2 3h4l2-3h4" />
            <path d="M8 8h8" />
            <path d="M8 11h8" />
        </svg>
        @break

    @case('eye')
        <svg class="{{ $class }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="{{ $stroke }}" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <path d="M2 12s3.5-6 10-6 10 6 10 6-3.5 6-10 6S2 12 2 12Z" />
            <circle cx="12" cy="12" r="3" />
        </svg>
        @break

    @case('arrow-left')
        <svg class="{{ $class }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="{{ $stroke }}" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <path d="M19 12H5" />
            <path d="m12 19-7-7 7-7" />
        </svg>
        @break

    @case('close')
        <svg class="{{ $class }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="{{ $stroke }}" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <path d="M18 6 6 18" />
            <path d="m6 6 12 12" />
        </svg>
        @break

    @default
        <svg class="{{ $class }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="{{ $stroke }}" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <circle cx="12" cy="12" r="9" />
        </svg>
@endswitch
