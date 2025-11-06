window.addEventListener('DOMContentLoaded', function () {
    this.setTimeout(() => {
        document.body.classList.add('wdt-circle-loader-done');
    }, 300);
});

window.addEventListener('beforeunload', () => {
    document.body.classList.add('wdt-circle-loader');
});