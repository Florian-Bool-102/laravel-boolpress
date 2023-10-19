<x-mail::message>
  # Un utente ti ha contattato!

  Ecco i suoi dati:

  - Nome: {{ $formData["name"] }}
  - Email: {{ $formData["email"] }}
  - Messaggio: {{ $formData["message"] }}

  ## Ricordati di rispondere!

</x-mail::message>
