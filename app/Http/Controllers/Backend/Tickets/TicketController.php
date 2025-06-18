<?php

namespace App\Http\Controllers\Backend\Tickets;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\Ticket;

class TicketController extends Controller
{
    public function index()
    {
        $tickets = Ticket::with('usuario')->get();
        return view('backend.tickets.index', compact('tickets'));
    }

    public function create()
    {
        $this->authorize('crear.tickets');
        $usuarios = Usuario::all();
        return view('backend.tickets.create', compact('usuarios'));
    }

    public function store(Request $request)
    {
        $this->authorize('crear.tickets');

        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string|min:10',
            'usuario_id' => 'required|exists:usuarios,id',
            'estado' => 'required|in:abierto,cerrado',
        ], [
            'titulo.required' => 'El título del ticket es obligatorio',
            'titulo.max' => 'El título no puede tener más de 255 caracteres',
            'descripcion.required' => 'La descripción es obligatoria',
            'descripcion.min' => 'La descripción debe tener al menos 10 caracteres',
            'usuario_id.required' => 'Debe seleccionar un usuario responsable',
            'usuario_id.exists' => 'El usuario seleccionado no existe',
            'estado.required' => 'Debe seleccionar un estado para el ticket',
            'estado.in' => 'El estado debe ser "abierto" o "cerrado"',
        ]);

        Ticket::create($validated);

        return redirect()->route('tickets.index')
               ->with('success', 'Ticket creado correctamente.');
    }

    public function edit($id)
    {
        $ticket = Ticket::findOrFail($id);
        $this->authorize('editar.tickets', $ticket);
        $usuarios = Usuario::all();
        
        return view('backend.tickets.edit', [
            'ticket' => $ticket,
            'usuarios' => $usuarios,
            'errors' => session('errors')
        ]);
    }

    public function update(Request $request, $id)
    {
        $ticket = Ticket::findOrFail($id);
        $this->authorize('editar.tickets', $ticket);

        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string|min:10',
            'usuario_id' => 'required|exists:usuarios,id',
            'estado' => 'required|in:abierto,cerrado',
        ], [
            'titulo.required' => 'El título del ticket es obligatorio',
            'titulo.max' => 'El título no puede tener más de 255 caracteres',
            'descripcion.required' => 'La descripción es obligatoria',
            'descripcion.min' => 'La descripción debe tener al menos 10 caracteres',
            'usuario_id.required' => 'Debe seleccionar un usuario responsable',
            'usuario_id.exists' => 'El usuario seleccionado no existe',
            'estado.required' => 'Debe seleccionar un estado para el ticket',
            'estado.in' => 'El estado debe ser "abierto" o "cerrado"',
        ]);

        $ticket->update($validated);

        return redirect()->route('tickets.index')
               ->with('success', 'Ticket actualizado correctamente.');
    }

    public function destroy($id)
    {
        $ticket = Ticket::findOrFail($id);
        $this->authorize('eliminar.tickets', $ticket);
        $ticket->delete();
        return redirect()->route('tickets.index')
               ->with('success', 'Ticket eliminado correctamente.');
    }
}