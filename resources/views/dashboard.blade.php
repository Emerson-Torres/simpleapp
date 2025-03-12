<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - SimpleApp</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Dashboard</h3>
                    </div>
                    <div class="card-body">
                        <!-- Mostrar la información del usuario -->
                        <div class="text-center">
                            <img src="{{ $user->profile_picture }}" alt="Profile Picture" class="img-fluid rounded-circle" width="150">
                            <h4 class="mt-3">{{ $user->name }}</h4>
                            <p class="text-muted">{{ $user->email }}</p>
                        </div>

                        <!-- Mostrar el número de veces que ha iniciado sesión -->
                        <div class="mt-4">
                            <p class="text-center">
                                Has iniciado sesión <strong>{{ $user->login_count }}</strong> veces.
                            </p>
                        </div>

                        <!-- Botón para cerrar sesión -->
                        <div class="text-center">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-danger">Cerrar sesión</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    const inactivityTime = 5 * 60 * 1000; // 5 minutos
    const warningTime = 1 * 60 * 1000; // 1 minuto antes de cerrar la sesión

    let inactivityTimer;
    let warningTimer;

    function resetInactivityTimer() {
        clearTimeout(inactivityTimer);
        clearTimeout(warningTimer);

        // Muestra una advertencia 1 minuto antes de cerrar la sesión
        warningTimer = setTimeout(showWarning, inactivityTime - warningTime);

        // Cierra la sesión después de 5 minutos de inactividad
        inactivityTimer = setTimeout(logoutUser, inactivityTime);
    }

    function showWarning() {
        alert('Tu sesión está a punto de expirar. Por favor, realiza alguna acción para mantenerla activa.');
    }

    function logoutUser() {
        window.location.href = "{{ route('index') }}";
    }

    // Reinicia el temporizador en eventos de interacción del usuario
    document.addEventListener('mousemove', resetInactivityTimer);
    document.addEventListener('keypress', resetInactivityTimer);
    document.addEventListener('click', resetInactivityTimer);

    // Inicia el temporizador al cargar la página
    resetInactivityTimer();
</script>
</body>
</html>