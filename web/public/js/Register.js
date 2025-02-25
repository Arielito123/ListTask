function togglePassword(id) {
    const passwordInput = document.getElementById(id);
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
    } else {
        passwordInput.type = 'password';
    }
}



    
    // Validar contraseña
    const password = document.getElementById('password').value;
    if (password.length < 8) {
        passwordValidation.style.display = 'block';
        isValid = false;
    } else {
        passwordValidation.style.display = 'none';
    }
    
    // Validar que las contraseñas coincidan
    const repeatPassword = document.getElementById('repeatPassword').value;
    if (password !== repeatPassword) {
        matchValidation.style.display = 'block';
        isValid = false;
    } else {
        matchValidation.style.display = 'none';
    }
    
   