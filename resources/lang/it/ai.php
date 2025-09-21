<?php

return [

    // Etichette UI
    'title'        => 'Chatbot AI',
    'page_title'   => 'Chatbot AI',
    'message'      => 'Messaggio',
    'send'         => 'Invia',
    'you'          => 'Tu',
    'ai'           => 'AI',
    'start_hint'   => 'Inizia la conversazione scrivendo un messaggio qui sopra.',
    'clear'        => 'Cancella conversazione',
    'limit_title'   => 'Utilizzo del Chatbot Limitato',

    // Errori runtime (mostrati all’utente)
    'error' => [
        'limit_title'       => 'Limite giornaliero raggiunto',
        'limit_message'     => 'Hai già usato la tua richiesta gratuita per oggi.',
        'limit_suggestion'  => 'Aggiungi la tua chiave API personale per continuare a usare il chatbot senza limiti.',
        'bad_request'        => 'La tua richiesta non può essere elaborata. Controlla i dati e riprova.',
        'unauthorized'       => 'Il servizio AI ha rifiutato la richiesta (non autorizzata). Verifica le credenziali.',
        'forbidden'          => 'Accesso al servizio AI negato.',
        'not_found'          => 'Endpoint AI non trovato. Contatta il supporto.',
        'too_many_requests'  => 'Hai raggiunto il limite di richieste. Riprova più tardi.',
        'server_error'       => 'Il servizio AI ha riscontrato un errore. Riprova più tardi.',
        'unavailable'        => 'Il servizio AI è temporaneamente non disponibile. Riprova più tardi.',
        'timeout'            => 'Il servizio AI impiega troppo tempo a rispondere. Riprova.',
        'network'            => 'Errore di rete durante il contatto con il servizio AI.',
        'invalid_response'   => 'Il servizio AI ha restituito una risposta non valida.',
        'generic'            => 'Si è verificato un errore imprevisto. Riprova.',
    ],

    // Messaggi di validazione (facoltativi)
    'validation' => [
        'message_required' => 'Inserisci un messaggio.',
        'message_max'      => 'Il messaggio è troppo lungo.',
    ],
];
