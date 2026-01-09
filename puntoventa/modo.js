const toggle = document.getElementById('modoToggle');
if (toggle) {
    toggle.addEventListener('click', () => {
        // Cambiar el modo oscuro/ligero
        document.body.classList.toggle('dark-mode');
        const nav = document.querySelector('.navbar');
        if (nav) nav.classList.toggle('dark-mode');

        // Cambiar el texto del botón según el estado
        toggle.textContent = document.body.classList.contains('dark-mode') ? 'Modo ☀️' : 'Modo 🌙';

        // Guardar el estado del modo en el localStorage
        localStorage.setItem('modo', document.body.classList.contains('dark-mode') ? 'oscuro' : 'claro');
    });

    // Cargar el estado guardado al cargar la página
    const modo = localStorage.getItem('modo');
    if (modo === 'oscuro') {
        document.body.classList.add('dark-mode');
        const nav = document.querySelector('.navbar');
        if (nav) nav.classList.add('dark-mode');
        toggle.textContent = 'Modo ☀️';
    } else {
        toggle.textContent = 'Modo 🌙';
    }
}
