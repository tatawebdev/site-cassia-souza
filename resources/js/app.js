import Swal from 'sweetalert2';

// Expose to window if other scripts need it
window.Swal = Swal;
// Provide backward-compatible aliases used by some scripts/console
window.swal = Swal;
window.Swal2 = Swal;
window.swal2 = Swal;

// Register the listener after the DOM has loaded to ensure UI is ready.
