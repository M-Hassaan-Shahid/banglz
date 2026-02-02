function togglePasswordVisibility(field) {
    const passwordInput = document.getElementById(field === 'new' ? 'new-password' : 'confirm-password');
    const eyeOff = document.getElementById(field === 'new' ? 'eye-off-new' : 'eye-off-confirm');
    const eyeOn = document.getElementById(field === 'new' ? 'eye-on-new' : 'eye-on-confirm');

    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        eyeOff.style.display = 'none';
        eyeOn.style.display = 'inline';
    } else {
        passwordInput.type = 'password';
        eyeOff.style.display = 'inline';
        eyeOn.style.display = 'none';
    }
}
