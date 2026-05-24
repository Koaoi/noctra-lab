// Bootstrap 5 CSS & JS via NPM (bukan CDN)
import 'bootstrap/dist/css/bootstrap.min.css';
import * as bootstrap from 'bootstrap';

// Buat Bootstrap tersedia secara global
window.bootstrap = bootstrap;

// Auto-hide toast setelah 4 detik
document.addEventListener('DOMContentLoaded', function () {
    // Toast notification
    const toastElList = [].slice.call(document.querySelectorAll('.toast'));
    toastElList.forEach(function (toastEl) {
        const toast = new bootstrap.Toast(toastEl, { delay: 4000 });
        toast.show();
    });

    // Countdown timer untuk product drop
    const countdowns = document.querySelectorAll('[data-countdown]');
    countdowns.forEach(function (el) {
        const target = new Date(el.dataset.countdown).getTime();
        const interval = setInterval(function () {
            const now = new Date().getTime();
            const distance = target - now;

            if (distance < 0) {
                clearInterval(interval);
                el.innerHTML = '<span class="badge bg-success">Available Now</span>';
                return;
            }

            const days    = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours   = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            el.innerHTML =
                `<span class="countdown-unit">${days}<small>d</small></span>` +
                `<span class="countdown-unit">${hours}<small>h</small></span>` +
                `<span class="countdown-unit">${minutes}<small>m</small></span>` +
                `<span class="countdown-unit">${seconds}<small>s</small></span>`;
        }, 1000);
    });

    // Confirm delete modal
    document.querySelectorAll('[data-confirm-delete]').forEach(function (btn) {
        btn.addEventListener('click', function (e) {
            if (!confirm('Yakin ingin menghapus item ini?')) {
                e.preventDefault();
            }
        });
    });
});