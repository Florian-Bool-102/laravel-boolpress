<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ContactController extends Controller {
    public function store(Request $request) {
        $data = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'message' => 'required|max:500',
            'attachment' => 'nullable|file|max:5000'
        ]);

        // Send an email
        // Mail::to($data['email'])->send(new ContactFormMail($data));

        // salvo dentro la tabella contacts i dati ricevuti
        $newContact = new Contact();

        $newContact->name = $data["name"];
        $newContact->email = $data["email"];
        $newContact->message = $data["message"];

        // salvo il file allegato se c'è
        if (key_exists("attachment", $data)) {
            $path = Storage::put("contacts", $data["attachment"]);
            $newContact->attachment = $path;

            // abbreviazione di Storage::put e ritorno del path
            // $newContact->attachment = $data["attachment"]->store("contacts");
        }

        $newContact->save();

        return response()->json([
            'message' => "Thank you {$data['name']} for your message. We will be in touch soon."
        ], 201);
    }
}
