<?php

return [

    /*
     * Translation keys for login and auth flow
     */

    'login_page' => [
        'title' => 'Area riservata',
        'subtext' => 'Accedi con le tue credenziali',

        'remember_me' => 'Rimani collegato',

        'submit_btn' => 'Accedi',

        'password_forgot_link' => 'Password dimenticata ?',
    ],

    'forgot_psw_page' => [
        'title' => 'Reimposta la tua password',
        'subtext' => "Inserisci l'indirizzo email del tuo account e riceverai un link per reimpostare la tua password",

        'submit_btn' => 'Invia',

        'login_link' => 'Accesso con la password',

        'success_message' => 'Link inviato correttamente. Controlla la tua posta in arrivo',
        'error_message' => 'Non siamo riusciti ad inviare la mail. Verifica che l\'indirizzo indicato sia corretto',
    ],

    'reset_page' => [
        'title' => 'Reimposta la tua password',
        'subtext' => 'Scegli la nuova password del tuo account',

        'submit_btn' => 'Reimposta',
    ],

    'reset_email' => [
        'subject' => 'Reimposta la tua password',
        'main_text' => 'Abbiamo ricevuta una richiesta di aggiornamento della password per il tuo account :name',
        'reset_btn' => 'Reimposta password',
        'expiration_notice' => 'Questo link scadrà tra :count minuti',
        'final_text' => 'Se non sei stato tu a fare richiesta, puoi ignorare questa email',
    ],

];
