<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Tickets</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-4">

    <!--Muestra un mensaje de éxito si existe en la sesión-->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!--Para crear ticket-->
    <div class="d-flex justify-content-between mb-3">
        <h4>Lista de Tickets</h4>
        @can('crear.tickets')
            <a href="{{ route('tickets.create') }}" class="btn btn-primary">Crear Ticket</a>
        @endcan
    </div>

    {{-- Tabla con listado de tickets --}}
    <!--Mostrando la información con tabla-->
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <!--Columnas-->
                    <tr>
                        <th>ID TICKET</th>
                        <th>Título</th>
                        <th>Usuario</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tickets as $ticket)
                        <!--Filas-->
                        <tr>
                            <td>{{ $ticket->id }}</td>
                            <td>{{ $ticket->titulo }}</td>
                            <td>{{ $ticket->usuario->nombre ?? 'N/A' }}</td>
                            <td>
                                <span class="badge bg-{{ $ticket->estado == 'abierto' ? 'success' : 'secondary' }}">
                                    {{ ucfirst($ticket->estado) }}
                                </span>
                            </td>
                            <td>
                                @can('editar.tickets')
                                    <a href="{{ route('tickets.edit', $ticket->id) }}" class="btn btn-sm btn-warning">Editar</a>
                                @endcan
                                @can('eliminar.tickets')
                                    <form action="{{ route('tickets.destroy', $ticket->id) }}" method="POST" class="d-inline"
                                          onsubmit="return confirm('¿Estás seguro de eliminar este ticket?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger">Eliminar</button>
                                    </form>
                                @endcan
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">No hay tickets disponibles.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>
