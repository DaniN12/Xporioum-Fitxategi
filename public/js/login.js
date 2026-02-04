document.addEventListener('DOMContentLoaded', function() {
    const passwordInput = document.getElementById('password');
    const toggle = document.getElementById('togglePassword');

    if (passwordInput && toggle) {
        const ojo = toggle.getAttribute('data-ojo');
        const ojoCerrado = toggle.getAttribute('data-ojo-cerrado');

        toggle.addEventListener('click', function() {
            const isPassword = passwordInput.type === 'password';

            passwordInput.type = isPassword ? 'text' : 'password';
            toggle.src = isPassword ? ojoCerrado : ojo;

            toggle.style.opacity = '1';
            setTimeout(() => {
                toggle.style.opacity = '0.6';
            }, 200);
        });
    }
});
