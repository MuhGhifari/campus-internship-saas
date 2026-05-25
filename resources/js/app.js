document.addEventListener('DOMContentLoaded', () => {
    const months = [
        'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember',
    ];

    const shortDays = ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'];

    const formatDateLabel = (value) => {
        if (!value) return 'Pilih tanggal';

        const [year, month, day] = value.split('-').map(Number);
        if (!year || !month || !day) return 'Pilih tanggal';

        return `${day} ${months[month - 1]} ${year}`;
    };

    const closeCustomFields = (except = null) => {
        document.querySelectorAll('[data-custom-field].is-open').forEach((field) => {
            if (field !== except) {
                field.classList.remove('is-open');
                field.querySelector('[aria-expanded]')?.setAttribute('aria-expanded', 'false');
            }
        });
    };

    const syncCustomSelect = (select) => {
        const field = select.closest('[data-custom-field]');
        if (!field) return;

        const trigger = field.querySelector('[data-custom-select-trigger]');
        const label = field.querySelector('[data-custom-select-label]');
        const options = field.querySelectorAll('[data-custom-select-option]');
        const selected = select.selectedOptions[0];

        if (label) {
            label.textContent = selected?.textContent?.trim() || 'Pilih opsi';
            label.classList.toggle('text-[#6B7E94]', !select.value);
        }

        options.forEach((option) => {
            const active = option.dataset.value === select.value;
            option.classList.toggle('is-selected', active);
            option.setAttribute('aria-selected', active ? 'true' : 'false');
        });

        field.classList.toggle('is-disabled', select.disabled);
        if (trigger) trigger.disabled = select.disabled;
    };

    const positionMenu = (field, menu) => {
        if (!field || !menu) return;

        field.classList.remove('is-drop-up');

        const fieldRect = field.getBoundingClientRect();
        const menuHeight = menu.offsetHeight || 280;
        const spaceBelow = window.innerHeight - fieldRect.bottom;
        const spaceAbove = fieldRect.top;

        if (spaceBelow < menuHeight + 16 && spaceAbove > spaceBelow) {
            field.classList.add('is-drop-up');
        }
    };

    const enhanceSelect = (select) => {
        if (select.dataset.customFieldReady === 'true' || select.multiple) return;

        select.dataset.customFieldReady = 'true';
        select.classList.add('cb-native-field');
        select.tabIndex = -1;

        const field = document.createElement('div');
        field.className = 'cb-custom-field';
        field.dataset.customField = 'select';

        const trigger = document.createElement('button');
        trigger.type = 'button';
        trigger.className = 'cb-custom-trigger';
        trigger.dataset.customSelectTrigger = '';
        trigger.setAttribute('aria-haspopup', 'listbox');
        trigger.setAttribute('aria-expanded', 'false');
        trigger.innerHTML = `
            <span class="cb-custom-label" data-custom-select-label></span>
            <span class="cb-custom-caret" aria-hidden="true">
                <svg viewBox="0 0 20 20" fill="none"><path d="m5 7.5 5 5 5-5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </span>
        `;

        const menu = document.createElement('div');
        menu.className = 'cb-custom-menu';
        menu.setAttribute('role', 'listbox');

        Array.from(select.options).forEach((nativeOption) => {
            const option = document.createElement('button');
            option.type = 'button';
            option.className = 'cb-custom-option';
            option.dataset.customSelectOption = '';
            option.dataset.value = nativeOption.value;
            option.setAttribute('role', 'option');
            option.textContent = nativeOption.textContent.trim();
            option.disabled = nativeOption.disabled;

            option.addEventListener('click', (event) => {
                event.preventDefault();
                event.stopPropagation();

                select.value = nativeOption.value;
                select.dispatchEvent(new Event('change', { bubbles: true }));
                closeCustomFields();
                syncCustomSelect(select);
            });

            menu.appendChild(option);
        });

        select.parentNode.insertBefore(field, select);
        field.appendChild(select);
        field.appendChild(trigger);
        field.appendChild(menu);

        trigger.addEventListener('click', (event) => {
            event.preventDefault();
            event.stopPropagation();

            if (select.disabled) return;

            const willOpen = !field.classList.contains('is-open');
            closeCustomFields(field);
            field.classList.toggle('is-open', willOpen);
            trigger.setAttribute('aria-expanded', willOpen ? 'true' : 'false');
            if (willOpen) positionMenu(field, menu);
        });

        select.addEventListener('change', () => syncCustomSelect(select));
        syncCustomSelect(select);
    };

    const getDateParts = (input) => {
        if (input.value) {
            const [year, month, day] = input.value.split('-').map(Number);
            if (year && month && day) {
                return new Date(year, month - 1, day);
            }
        }

        return new Date();
    };

    const renderCalendar = (input, state) => {
        const field = input.closest('[data-custom-field]');
        if (!field) return;

        const label = field.querySelector('[data-custom-date-label]');
        const monthLabel = field.querySelector('[data-custom-date-month]');
        const grid = field.querySelector('[data-custom-date-grid]');

        if (label) {
            label.textContent = formatDateLabel(input.value);
            label.classList.toggle('text-[#6B7E94]', !input.value);
        }

        if (monthLabel) {
            monthLabel.textContent = `${months[state.month]} ${state.year}`;
        }

        if (!grid) return;
        grid.innerHTML = '';

        shortDays.forEach((dayName) => {
            const day = document.createElement('span');
            day.className = 'cb-date-weekday';
            day.textContent = dayName;
            grid.appendChild(day);
        });

        const firstDay = new Date(state.year, state.month, 1);
        const lastDate = new Date(state.year, state.month + 1, 0).getDate();
        const today = new Date();

        for (let index = 0; index < firstDay.getDay(); index += 1) {
            const spacer = document.createElement('span');
            spacer.className = 'cb-date-spacer';
            grid.appendChild(spacer);
        }

        for (let date = 1; date <= lastDate; date += 1) {
            const value = `${state.year}-${String(state.month + 1).padStart(2, '0')}-${String(date).padStart(2, '0')}`;
            const day = document.createElement('button');
            day.type = 'button';
            day.className = 'cb-date-day';
            day.textContent = String(date);
            day.classList.toggle('is-selected', input.value === value);
            day.classList.toggle(
                'is-today',
                today.getFullYear() === state.year && today.getMonth() === state.month && today.getDate() === date,
            );

            day.addEventListener('click', (event) => {
                event.preventDefault();
                event.stopPropagation();

                input.value = value;
                input.dispatchEvent(new Event('input', { bubbles: true }));
                input.dispatchEvent(new Event('change', { bubbles: true }));
                closeCustomFields();
                renderCalendar(input, state);
            });

            grid.appendChild(day);
        }

        field.classList.toggle('is-disabled', input.disabled);
        field.querySelector('[data-custom-date-trigger]').disabled = input.disabled;
    };

    const enhanceDate = (input) => {
        if (input.dataset.customFieldReady === 'true') return;

        input.dataset.customFieldReady = 'true';
        input.dataset.originalType = 'date';
        input.type = 'text';
        input.inputMode = 'none';
        input.classList.add('cb-native-field');
        input.tabIndex = -1;

        const currentDate = getDateParts(input);
        const state = {
            month: currentDate.getMonth(),
            year: currentDate.getFullYear(),
        };

        const field = document.createElement('div');
        field.className = 'cb-custom-field';
        field.dataset.customField = 'date';

        const trigger = document.createElement('button');
        trigger.type = 'button';
        trigger.className = 'cb-custom-trigger';
        trigger.dataset.customDateTrigger = '';
        trigger.setAttribute('aria-haspopup', 'dialog');
        trigger.setAttribute('aria-expanded', 'false');
        trigger.innerHTML = `
            <span class="cb-custom-label" data-custom-date-label></span>
            <span class="cb-custom-caret" aria-hidden="true">
                <svg viewBox="0 0 20 20" fill="none"><path d="M5.5 3.5v3M14.5 3.5v3M4 8h12M4.5 5h11A1.5 1.5 0 0 1 17 6.5v9A1.5 1.5 0 0 1 15.5 17h-11A1.5 1.5 0 0 1 3 15.5v-9A1.5 1.5 0 0 1 4.5 5Z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </span>
        `;

        const menu = document.createElement('div');
        menu.className = 'cb-date-menu';
        menu.innerHTML = `
            <div class="cb-date-head">
                <button type="button" class="cb-date-nav" data-custom-date-prev aria-label="Bulan sebelumnya">‹</button>
                <strong data-custom-date-month></strong>
                <button type="button" class="cb-date-nav" data-custom-date-next aria-label="Bulan berikutnya">›</button>
            </div>
            <div class="cb-date-grid" data-custom-date-grid></div>
        `;

        input.parentNode.insertBefore(field, input);
        field.appendChild(input);
        field.appendChild(trigger);
        field.appendChild(menu);

        trigger.addEventListener('click', (event) => {
            event.preventDefault();
            event.stopPropagation();

            if (input.disabled) return;

            const willOpen = !field.classList.contains('is-open');
            closeCustomFields(field);
            field.classList.toggle('is-open', willOpen);
            trigger.setAttribute('aria-expanded', willOpen ? 'true' : 'false');
            renderCalendar(input, state);
            if (willOpen) positionMenu(field, menu);
        });

        field.querySelector('[data-custom-date-prev]').addEventListener('click', () => {
            state.month -= 1;
            if (state.month < 0) {
                state.month = 11;
                state.year -= 1;
            }
            renderCalendar(input, state);
        });

        field.querySelector('[data-custom-date-next]').addEventListener('click', () => {
            state.month += 1;
            if (state.month > 11) {
                state.month = 0;
                state.year += 1;
            }
            renderCalendar(input, state);
        });

        input.addEventListener('change', () => {
            const selected = getDateParts(input);
            state.month = selected.getMonth();
            state.year = selected.getFullYear();
            renderCalendar(input, state);
        });

        renderCalendar(input, state);
    };

    const refreshCustomFields = () => {
        document.querySelectorAll('select.cb-input').forEach(enhanceSelect);
        document.querySelectorAll('input[type="date"].cb-input').forEach(enhanceDate);
        document.querySelectorAll('select[data-custom-field-ready="true"]').forEach(syncCustomSelect);
        document.querySelectorAll('input[data-original-type="date"][data-custom-field-ready="true"]').forEach((input) => {
            const selected = getDateParts(input);
            renderCalendar(input, { month: selected.getMonth(), year: selected.getFullYear() });
        });
    };

    refreshCustomFields();
    window.CareerBridgeRefreshFields = refreshCustomFields;

    const closeModal = (modal) => {
        modal?.setAttribute('hidden', '');
        closeCustomFields();
    };

    document.querySelectorAll('[data-modal-target]').forEach((trigger) => {
        trigger.addEventListener('click', () => {
            const modal = document.querySelector(trigger.dataset.modalTarget);
            modal?.removeAttribute('hidden');
            refreshCustomFields();
        });
    });

    document.querySelectorAll('[data-modal-close]').forEach((trigger) => {
        trigger.addEventListener('click', () => closeModal(trigger.closest('[data-modal-backdrop]')));
    });

    document.querySelectorAll('[data-modal-backdrop]').forEach((modal) => {
        modal.addEventListener('click', (event) => {
            if (event.target === modal && !modal.classList.contains('cb-flash-modal')) {
                closeModal(modal);
            }
        });

        const autoClose = Number(modal.dataset.autoClose || 0);
        if (autoClose > 0) {
            setTimeout(() => closeModal(modal), autoClose);
        }
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            document.querySelectorAll('[data-modal-backdrop]:not([hidden])').forEach(closeModal);
            closeCustomFields();
        }
    });

    document.addEventListener('click', (event) => {
        if (!event.target.closest('[data-custom-field]')) {
            closeCustomFields();
        }
    });

    document.querySelectorAll('[data-back-button]').forEach((button) => {
        button.addEventListener('click', () => {
            if (window.history.length > 1) {
                window.history.back();
                return;
            }

            window.location.href = button.dataset.fallback || '/dashboard';
        });
    });
});
