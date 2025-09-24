<?php

namespace App\Http\Controllers\Backend\admin;

use App\Models\Documento;
use App\Models\EstadoFechaTicket;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;

class DocumentoController extends Controller
{
    
    public function documentDeleteTicket($id)
    {
        $documentos = Documento::findOrFail($id);
        $estadoTicket = EstadoFechaTicket::where('id', $documentos->id_ticket_estado)->first();
        $documentos->update([
            'estado' => false,
        ]);

        return redirect()->route('admin.ticket.show', ['id' => Crypt::encrypt($estadoTicket->id_ticket)])->with('success', 'Documento eliminado correctamente.');
    }
}
