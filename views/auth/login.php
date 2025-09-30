<h4 class="text-center mb-4">Iniciar Sesión</h4>

<form action="login.php" method="POST" id="loginForm">
    <div class="form-group mb-4">
        <label class="form-label" for="email">Email</label>
        <input type="email" class="form-control" placeholder="Ingresa tu email" id="email" name="email" required value="<?= htmlspecialchars($email ?? '') ?>">
    </div>
    
    <div class="mb-sm-4 mb-3 position-relative">
        <label class="form-label" for="password">Contraseña</label>
        <input type="password" id="password" name="password" class="form-control" placeholder="Ingresa tu contraseña" required>
        <span class="show-pass eye" onclick="togglePassword()">
            <i class="fa fa-eye-slash" id="eye-slash"></i>
            <i class="fa fa-eye" id="eye" style="display: none;"></i>
        </span>
    </div>
    
    <div class="form-row d-flex flex-wrap justify-content-between mb-2">
        <div class="form-group mb-sm-4 mb-1">
            <div class="form-check custom-checkbox ms-1">
                <input type="checkbox" class="form-check-input" id="remember" name="remember">
                <label class="form-check-label" for="remember">Recordar sesión</label>
            </div>
        </div>
        <div class="form-group ms-2">
            <a href="forgot-password.php">¿Olvidaste tu contraseña?</a>
        </div>
    </div>
    
    <div class="text-center">
        <button type="submit" class="btn btn-primary btn-block">Iniciar Sesión</button>
    </div>
</form>

<div class="new-account mt-3">
    <p>¿No tienes una cuenta? <a class="text-primary" href="register.php">Regístrate</a></p>
</div>

<div class="mt-4 text-center">
    <small class="text-muted">
        <strong>Credenciales de prueba:</strong><br>
        Email: admin@altair.com<br>
        Contraseña: password
    </small>
</div>

<script>
function togglePassword() {
    const passwordField = document.getElementById('password');
    const eyeSlash = document.getElementById('eye-slash');
    const eye = document.getElementById('eye');
    
    if (passwordField.type === 'password') {
        passwordField.type = 'text';
        eyeSlash.style.display = 'none';
        eye.style.display = 'inline';
    } else {
        passwordField.type = 'password';
        eyeSlash.style.display = 'inline';
        eye.style.display = 'none';
    }
}

// Form validation
document.getElementById('loginForm').addEventListener('submit', function(e) {
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    
    if (!email || !password) {
        e.preventDefault();
        alert('Por favor, completa todos los campos.');
        return false;
    }
    
    if (!email.includes('@')) {
        e.preventDefault();
        alert('Por favor, ingresa un email válido.');
        return false;
    }
});
</script>
