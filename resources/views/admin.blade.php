<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - SimpleApp</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Ocultar el texto "Showing X to Y of Z results" */
        .text-sm.text-gray-700.leading-5.dark\\:text-gray-400 {
            display: none;
        }

        /* Ocultar las flechas de paginación (anterior y siguiente) */
        .relative.z-0.inline-flex.rtl\\:flex-row-reverse.shadow-sm.rounded-md {
            display: none;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-10">
                        <h1 class="text-center">Panel de Administración</h1>
                    </div>
                    <div class="col-md-2">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-danger">Cerrar sesión</button>
                        </form>
                    </div>
                </div>

                <!-- Lista de Usuarios Únicos -->
                <h2>Usuarios Únicos</h2>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>foto</th>
                            <th>Email</th>
                            <th># Sesiones</th>
                            <th>Último Inicio de Sesión</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td><img src="{{ $user->profile_picture }}" style="height:24px; width:24px;"></td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->login_count }}</td>
                                <td>{{ $user->logins->first()->login_time ?? 'N/A' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $users->appends(['logins_page' => $logins->currentPage()])->links() }}

                <!-- Tabla de Inicios de Sesión -->
                <h2>Inicios de Sesión</h2>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Usuario</th>
                            <th>Fecha y Hora</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($logins as $login)
                            <tr>
                                <td>{{ $login->user->name }}</td>
                                <td>{{ \Carbon\Carbon::parse($login->login_time)->timezone('America/El_Salvador')->format('Y-m-d H:i:s') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $logins->appends(['users_page' => $users->currentPage()])->links() }}
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    // Eliminar el texto "Showing X to Y of Z results"
    const showingText = document.querySelector('.text-sm.text-gray-700.leading-5.dark\\:text-gray-400');
    if (showingText) {
        showingText.remove();
    }

    // Eliminar las flechas de paginación (anterior y siguiente)
    const paginationArrows = document.querySelector('.relative.z-0.inline-flex.rtl\\:flex-row-reverse.shadow-sm.rounded-md');
    if (paginationArrows) {
        paginationArrows.remove();
    }
</script>
</body>
</html>