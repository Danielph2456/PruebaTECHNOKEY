function login() {
    var email = document.getElementById('email').value;
    var password = document.getElementById('password').value;

    var data = new FormData();
    data.append('email', email);
    data.append('password', password);

    fetch('./aerolinea/Consultas/loginValidate.php', {
        method: 'POST',
        body: data
    })
    .then(response => response.json())
    .then(data => {
        if (data) {
            mostrarAlertaExitosa()
        } else {
            alert('Inicio de sesión fallido');
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

function mostrarAlertaExitosa() {
    Swal.fire({
        icon: 'success',
        title: 'Inicio de sesión exitoso',
        showConfirmButton: false,
        timer: 1500
    });
    window.location.href = './aerolinea/dashboard.php';
}


function mostrarAlertaFallida() {
    Swal.fire({
        icon: 'error',
        title: 'Inicio de sesión fallido',
        text: 'Usuario o contraseña incorrectos',
        showConfirmButton: true
    });
}