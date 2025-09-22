<?php

return [
    'title'      => 'Ricerca Web',
    'page_title' => 'Ricerca Web',

    'form' => [
        'query'  => 'Query',
        'submit' => 'Cerca',
        // 'safe' rimosso: ora è sempre ON lato controller
    ],

    'start_hint'       => 'Inserisci una query per iniziare.',
    'no_results_yet'   => 'Nessun risultato (ancora).',
    'no_items'         => 'Nessun risultato trovato.',
    'total'            => 'Totale',

    'errors' => [
        'quota_exceeded' => 'Hai superato il limite di richieste disponibili. Riprova più tardi o aggiorna il piano.',
        'rate_limited'   => 'Stai effettuando troppe richieste in poco tempo. Attendi qualche istante e riprova.',
        'invalid_key'    => 'La chiave API non è valida o è stata revocata.',
        'invalid_cx'     => 'L’ID del motore di ricerca (cx) non è valido o non è abilitato.',
        'request_denied' => 'Richiesta rifiutata dall’API. Verifica configurazione e credenziali.',
        'generic'        => 'Si è verificato un errore durante la ricerca.',
    ],

    // Facoltativo: label per link rapido alla ricerca immagini (se lo aggiungi in pagina)
    'try_image_search' => 'Cerca immagini per questa query',
];
