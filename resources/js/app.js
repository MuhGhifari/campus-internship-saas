document.addEventListener('DOMContentLoaded', () => {
    const closeModal = (modal) => {
        modal?.setAttribute('hidden', '');
    };

    document.querySelectorAll('[data-modal-target]').forEach((trigger) => {
        trigger.addEventListener('click', () => {
            const modal = document.querySelector(trigger.dataset.modalTarget);
            modal?.removeAttribute('hidden');
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
