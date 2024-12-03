<?php

namespace App\Http\Controllers;

use App\Models\Newsletter;
use Illuminate\Http\Request;
use App\Mail\NewsletterEmail;
use Illuminate\Support\Facades\Mail;
use App\Mail\SubscriptionConfirmation;
use Illuminate\Support\Facades\Validator;

class NewsletterController extends Controller
{
    // Muestra la vista de la página principal del newsletter.
    public function index()
    {
        return view('admin.newsletters.index');
    }


    // Guarda un nuevo suscriptor a la newsletter y redirige con un mensaje de éxito.
    public function store(Request $request)
    {
        $messages = [
            'email.unique' => 'Esta dirección de correo electrónico ya está suscrita a nuestro boletín.',
        ];
        // Validar el campo de correo electrónico
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:newsletters,email'
        ], $messages);

        // Si la validación falla, redirigir con errores
        if ($validator->fails()) {
            return redirect('/')
                ->withErrors($validator)
                ->withInput();
        }

        // Crear un nuevo objeto Newsletter y guardar el correo electrónico
        $newsletter = new Newsletter;
        $newsletter->email = $request->email;
        $newsletter->save();
         // Enviar correo electrónico de confirmación
         $unsubscribeLink = route('unsubscribe', ['email' => $newsletter->email]);

         Mail::to($newsletter->email)->send(new SubscriptionConfirmation($unsubscribeLink));
         

        return redirect('/')
            ->with('success', 'Gracias por suscribirte a nuestra newsletter!');
    }

    // Envía una newsletter a todos los suscriptores y redirige con un mensaje de éxito.
    public function send(Request $request)
    {
        // Validar los campos del formulario
        $request->validate([
            'subject' => 'required',
            'body' => 'required',
        ]);

        // Recopilar datos del formulario
        $subject = $request->input('subject');
        $body = $request->input('body');

        // Obtener todos los suscriptores
        $subscribers = Newsletter::all();

        // Enviar la newsletter a cada suscriptor
        foreach ($subscribers as $subscriber) {
            $unsubscribeLink = route('unsubscribe', ['email' => $subscriber->email]);
            Mail::to($subscriber->email)->send(new NewsletterEmail($subject, $body, $unsubscribeLink));
        }

        return redirect()->route('newsletters.index')->with('success', 'Newsletter enviada con éxito');
    }
}
