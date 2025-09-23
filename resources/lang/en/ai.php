<?php

return [

    // UI labels
    'title'        => 'Chatbot AI',
    'page_title'   => 'Chatbot AI',
    'message'      => 'Message',
    'send'         => 'Send',
    'you'          => 'You',
    'ai'           => 'AI',
    'start_hint'   => 'Start the conversation by typing a message above.',
    'clear'        => 'Clear conversation',
    'limit_title'   => 'Chatbot Usage is Limited',
    'back_to_conversation' => 'Back to conversation',

    // Runtime error messages (user-facing)
    'error' => [
        'limit_title'       => 'Daily Limit Reached',
        'limit_message'     => 'You already used your daily request.',
        'limit_suggestion'  => 'Add your OpenAI API Key in the <a href=":url">profile settings</a> section to continue using the Chatbot limitless.',
        'bad_request'        => 'Your request could not be processed. Please review your input and try again.',
        'unauthorized'       => 'The AI service refused the request (unauthorized). Please check credentials.',
        'forbidden'          => 'Access to the AI service was denied.',
        'not_found'          => 'The AI endpoint was not found. Please contact support.',
        'too_many_requests'  => 'You have reached the request limit. Please try again later.',
        'server_error'       => 'The AI service encountered an error. Please try again later.',
        'unavailable'        => 'The AI service is temporarily unavailable. Please try again later.',
        'timeout'            => 'The AI service took too long to respond. Please try again.',
        'network'            => 'A network error occurred while contacting the AI service.',
        'invalid_response'   => 'The AI service returned an invalid response.',
        'generic'            => 'An unexpected error occurred. Please try again.',
    ],

    // Validation messages (optional override for clarity)
    'validation' => [
        'message_required' => 'Please enter a message.',
        'message_max'      => 'Your message is too long.',
    ],
];
