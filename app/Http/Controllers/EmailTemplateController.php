<?php

namespace App\Http\Controllers;

use App\Models\EmailTemplate;
use App\Mail\NewsletterEmail;
use App\Mail\SubscriptionConfirmation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
class EmailTemplateController  extends Controller
{
    // Muestra la vista de la página principal del newsletter.
    public function index()
    {
        $templates = EmailTemplate::where('deleted', false)->get()->map(function ($template) {
            $template->attachments = $template->attachments ? Storage::url($template->attachments) : null;
            return $template;
        });
    
        return response()->json($templates);
    }


    // Guarda un nuevo suscriptor a la newsletter y redirige con un mensaje de éxito.
    public function store(Request $request)
    { 
    
        $attachmentPath = null;
    
        if ($request->hasFile('attachments')) {
            $attachmentPath = $request->file('attachments')->store('attachments', 'public');
        }
    
        $template = EmailTemplate::create([
            'subject' => $request->subject,
            'body' => $request->body,
            'attachments' => $attachmentPath,
        ]);
    
        return response()->json(['success' => true, 'template' => $template]);
    }
 
    public function logicDelete(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:email_templates,id',
        ]);
    
        try {
            // Buscar la plantilla por ID
            $template = EmailTemplate::findOrFail($request->id);
    
            // Realizar la eliminación lógica
            $template->deleteLogically();
    
            return response()->json([
                'success' => true,
                'message' => 'Plantilla eliminada de forma lógica.',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Ocurrió un error al eliminar la plantilla.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
