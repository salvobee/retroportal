<?php

return [
    'title'      => 'Ricerca Immagini',
    'page_title' => 'Ricerca Immagini',

    'form' => [
        'query'    => 'Query',
        'submit'   => 'Cerca',
        'drawings' => 'Solo disegni (lineart)',
        'safe'     => 'Safe Search', // se un domani riattivi la scelta
    ],

    'start_hint'      => 'Inserisci una query per iniziare.',
    'no_results_yet'  => 'Nessun risultato (ancora).',
    'no_items'        => 'Nessuna immagine trovata.',
    'total'           => 'Totale',

    'errors' => [
        'quota_exceeded' => 'Hai superato il limite di richieste disponibili. Riprova più tardi o aggiorna il piano.',
        'rate_limited'   => 'Stai effettuando troppe richieste in poco tempo. Attendi e riprova.',
        'invalid_key'    => 'La chiave API non è valida o è stata revocata.',
        'invalid_cx'     => 'L’ID del motore di ricerca (cx) non è valido o non è abilitato.',
        'request_denied' => 'Richiesta rifiutata dall’API. Controlla configurazione e credenziali.',
        'generic'        => 'Si è verificato un errore durante la ricerca immagini.',
    ],

    // Link di cortesia per passare da web search
    'try_web_search' => 'Cerca sul Web per questa query',
];
