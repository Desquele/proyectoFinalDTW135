<?php

namespace App\Http\Controllers\Backend\Tickets;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\Ticket;

// controlador de tickets
class TicketController extends Controller
{
    // Mostramos la lista de tickets
    public function index()
    {
        // Obtenemos todos los tickets
        $tickets = Ticket::with('usuario')->get();
        
        // Retornamos la vista con los tickets
        return view('backend.tickets.index', compact('tickets'));
    }

    // Mostramos el formulario para crear un nuevo ticket
    public function create()
    {
        // Verificamos si hay permiso para crear tickets
        $this->authorize('crear.tickets');

        // Obtenemos todos los usuarios
        $usuarios = User::all();

        // Mostramos la vista de creación
        return view('frontend.tickets.create', compact('usuarios'));
    }

    // Guardar un nuevo ticket en la base de datos
    public function store(Request $request)
    {
        $this->authorize('crear.tickets');

        // Realizamos una pequeña validación de los datos recibidos
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'usuario_id' => 'required|exists:users,id',
            'estado' => 'required|in:abierto,cerrado',
        ]);

        // Creamos el ticket asociado (se debe de cambiar)
        Ticket::create([
            'titulo' => $validated['titulo'],
            'descripcion' => $validated['descripcion'],
            'usuario_id' => $validated['usuario_id'],
            'estado' => 'abierto',
        ]);

        // Informamos que todo está correcto
        return redirect()->route('tickets.index')->with('success', 'Ticket creado correctamente.');
    }

    // Mostramos formulario de edición para un ticket
    public function edit($id)
    {
        // Buscamos el ticket y en caso de no encontrarlo, lanzamos el error 404
        $ticket = Ticket::findOrFail($id);


        $this->authorize('editar.tickets', $ticket);

        // Obtenemos los usuarios
        $usuarios = User::all();

        return view('frontend.tickets.edit', compact('ticket', 'usuarios'));
    }

    // Actualizamos un ticket existente
    public function update(Request $request, $id)
    {
        // Buscamos el ticket y en caso de no encontrarlo, lanzamos el error 404
        $ticket = Ticket::findOrFail($id);

        $this->authorize('editar.tickets', $ticket);

        // Validamos los dstos del formulario
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'usuario_id' => 'required|exists:users,id',
            'estado' => 'required|in:abierto,cerrado',
        ]);

        // Actualizamos el ticket con los datos validados
        $ticket->update($validated);

        // Informamos que se realizó correctamente
        return redirect()->route('tickets.index')->with('success', 'Ticket actualizado correctamente.');
    }

    // Eliminar un ticket
    public function destroy($id)
    {
        // Buscamos el ticket y en caso de no encontrarlo, lanzamos el error 404
        $ticket = Ticket::findOrFail($id);

        $this->authorize('eliminar.tickets', $ticket);

        // borramos el ticket
        $ticket->delete();

        return redirect()->route('tickets.index')->with('success', 'Ticket eliminado correctamente.');
    }
}
