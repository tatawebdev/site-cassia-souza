import Swal from 'sweetalert2';

// Expose to window if other scripts need it
window.Swal = Swal;

// Listener for Livewire 3 dispatch('swal', payload)
window.addEventListener('swal', event => {
    let detail = event.detail;
    // Livewire 3 often wraps params in an array: [payload]
    if (Array.isArray(detail) && detail.length) detail = detail[0];
    detail = detail || {};

    Swal.fire({
        icon: detail.type || 'success',
        title: detail.title || '',
        text: detail.text || '',
        showConfirmButton: detail.showConfirmButton !== false,
        timer: detail.timer || undefined,
    });
});
