<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Mail\ContactMail;
use Illuminate\Http\Request;
use App\Mail\ContactFormSubmitted;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
     public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email',
            'message' => 'required|string|max:1000',
        ]);

      Mail::send([], [], function ($message) use ($validated) {
    $message->to('admin@tusitio.com')
            ->subject('New Contact Message')
            ->html("
                <h2>New Message</h2>
                <p><strong>Name:</strong> {$validated['name']}</p>
                <p><strong>Email:</strong> {$validated['email']}</p>
                <p><strong>Message:</strong></p>
                <p>{$validated['message']}</p>
            ");
});

        return redirect()->back()->with('success', 'Sended Message.');
    }

       // Mostrar el form
    public function index()
    {
        return view('contact');
    }

    // Enviar
    public function send(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string',
        ]);

        $name = $request->name;
        $email = $request->email;
        $message = $request->message;

        // Crear el objeto del correo con los datos
        $data = [
            'name' => $name,
            'email' => $email,
            'message' => $message,
        ];

        // Intentar enviar el correo
        try {
            // Enviar el correo utilizando el Mailable
            Mail::to('no-reply@pixollect.com')->send(new ContactMail($data));

            // Redirigir con message de éxito
            return redirect()->back()->with('message', 'Succesfull sended');
        } catch (\Exception $e) {
            // Redirigir con message de error si falla
            return redirect()->back()->with('error', 'ERROR: ' . $e->getMessage());
        }
    }

    public function create(){
        return Inertia::render('Contact');
}
}
