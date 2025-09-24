<?php

namespace App\Http\Controllers\Backend\admin;

use App\Models\EstadoFechaTicket;
use App\Models\Ticket;
use App\Models\Documento;
use App\Models\FacturaTicket;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class EstadoFechaTicketController extends Controller
{
    
    public function storeCamEstado(Request $request, $id){
        $ticket = Ticket::findOrFail($id);

        $request->desc_status = strtoupper($request->desc_status);

        $factura_id = null;

        if ($request->estado_cam == 8 && empty($ticket->oc_bolsa)) {
            return back()->with('error', 'Debe completar el número de OC Bolsa antes de facturar.');
        }
        
        if($request->estado_cam == 8){
            $factura = FacturaTicket::create([
                'numero_factura' => $request->num_factura,
                'fecha_factura' => $request->fecha_est,
            ]);

            $factura_id = $factura->id;
        }
        

        $estado_fecha_ticket = EstadoFechaTicket::create([
            'id_ticket' => $id,
            'id_estado' => $request->estado_cam,
            'fecha_estado' => $request->fecha_est,
            'descripcion' => $request->desc_status ?? null,
        ]);

        $id_estadoFecha = $estado_fecha_ticket->id;

        $ticket->update([
            'id_estado' => $request->estado_cam,
            'factura_id' => $factura_id,
        ]);

        $uploadedFiles = [];
        $ruta_doc = [];

        if ($request->hasFile('archivos')) {
            // Carpeta por fecha: "uploads/2025-07-18/"
            $fechaCarpeta = now()->format('Y-m-d');
            $carpeta = 'documentos/' . $fechaCarpeta;

            // Crear carpeta si no existe
            if (!file_exists(public_path($carpeta))) {
                mkdir(public_path($carpeta), 0777, true);
            }

            foreach ($request->file('archivos') as $file) {
                $fechaHora = now()->format('Y-m-d_H-i-s');
                $uniqueId = uniqid(); // o Str::uuid()
                $nombreOriginal = $file->getClientOriginalName();
                $filename = $fechaHora . '_' . $uniqueId . '_' . $nombreOriginal;
                $extension = $file->getClientOriginalExtension();
                $size = $file->getSize();

                $file->move(public_path($carpeta), $filename);

                $rutaCompleta = $carpeta . '/' . $filename;

                $uploadedFiles[] = $filename;
                $ruta_doc[] = $rutaCompleta;

                $subido_por = Auth::user()->id;

                $documentos = Documento::create([
                    'id_ticket_estado' => $id_estadoFecha,
                    'nombre_original' => $nombreOriginal,
                    'extension' => $extension,
                    'ruta_documento' => $rutaCompleta,
                    'tamano_bytes' => $size,
                    'subido_por' => $subido_por,
                    'fecha_subida' => now(),
                    'estado' => true,
                ]);
            }

        }

        if($request->estado_cam == 9){
            return redirect()->route('admin.ticket.cancelado.show', ['id' => Crypt::encrypt($id)])->with('success', 'Ticket Cancelado.');
        }
        
        return redirect()->route('admin.ticket.show', ['id' => Crypt::encrypt($id)])->with('success', 'Cambio de estado correctamente.');
    }
    
}
