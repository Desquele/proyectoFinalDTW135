<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Ticket</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">

    <h4>Editar Ticket</h4>

    <!--Formulario para editar ticket-->
    <form action="{{ route('tickets.update', $ticket->id) }}" method="POST">
        @csrf
        @method('PUT') 

        <!--Campo titulo obligatorio-->
        <div class="mb-3">
            <label for="titulo" class="form-label">Título</label>
            <input type="text" name="titulo" value="{{ old('titulo', $ticket->titulo) }}" class="form-control" required>
        </div>

        <!--Campo descripción obligatorio-->
        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea name="descripcion" class="form-control" required>{{ old('descripcion', $ticket->descripcion) }}</textarea>
        </div>

        <!--Campo usuario no se puede editar-->
        <div class="mb-3">
            <label for="usuario_id" class="form-label">Usuario</label>
            <select name="usuario_id" class="form-select" required>
                <option value="">Seleccione un usuario</option>
                @foreach($usuarios as $usuario)
                    <option value="{{ $usuario->id }}" {{ $ticket->usuario_id == $usuario->id ? 'selected' : '' }}>
                        {{ $usuario->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        <!--Campo para cambiar de estado-->
        <div class="mb-3">
            <label for="estado" class="form-label">Estado</label>
            <select name="estado" class="form-select" required>
                <option value="abierto" {{ $ticket->estado == 'abierto' ? 'selected' : '' }}>Abierto</option>
                <option value="cerrado" {{ $ticket->estado == 'cerrado' ? 'selected' : '' }}>Cerrado</option>
            </select>
        </div>

        <!--Botón para actualizar-->
        <button class="btn btn-success">Actualizar</button>
        <a href="{{ route('tickets.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
</body>
</html>
