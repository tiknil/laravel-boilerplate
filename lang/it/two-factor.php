<?php

return [

    /*
     * Translation keys for two-factor authentication
     */

    'confirm' => 'Conferma',
    'cancel' => 'Annulla',
    'logout' => 'Logout',
    'enable' => 'Abilita 2FA',
    'manage' => 'Gestisci 2FA',
    'disable' => 'Disabilita 2FA',
    'backend_access' => 'Accedi al backend',

    'password_confirm' => [
        'title' => 'Conferma la password per procedere',
        'label' => 'Conferma la password per procedere',
    ],

    'settings' => [
        'modal_title' => 'Configurazione autenticazione a due fattori',
        'security_notice' => "Per garantire la sicurezza del tuo account, è richiesto l'uso dell'autenticazione a due fattori.\nClicca sul pulsante sottostante per iniziare la configurazione.\n\nIn alternativa, effettua il logout ed accedi con un account diverso.",
        'qr_instruction' => '1. Scansiona il QR Code con la tua app autenticatore (es. Google Authenticator, 1Password, Authy).',
        'manual_key' => 'Chiave segreta (per inserimento manuale):',
        'code_instruction' => '2. Inserisci il codice a 6 cifre generato dall\'app',
        'code_invalid' => 'Il codice di autenticazione a due fattori inserito non è valido, si prega di riprovare.',
        'success_message' => 'Autenticazione a due fattori configurata correttamente per il tuo account!',
        'disable_confirm' => 'Procedendo, la configurazione per la 2FA verrà cancellata e per utilizzarla nuovamente sarà necessario procedere ad una nuova configurazione. Continuare?',
        'recovery_codes' => 'Codici di recupero',
        'recovery_desc' => "Ti permettono di accedere al tuo account se perdi l'accesso al dispositivo di autenticazione.",
        'show_codes' => 'Mostra codici di recupero',
        'hide_codes' => 'Nascondi codici di recupero',
        'regenerate_codes' => 'Rigenera codici di recupero',
        'regenerate_confirm' => 'Rigenerando i codici, quelli attuali verranno invalidati. Continuare?',
    ],

    'challenge' => [
        'title' => 'Autenticazione a due fattori',
        'otp_instruction' => 'Inserisci il codice a 6 cifre fornito dalla tua applicazione di autenticazione.',
        'recovery_instruction' => 'Inserisci uno dei tuoi codici di recupero.',
        'otp_error' => 'Il codice di autenticazione inserito non è valido.',
        'recovery_error' => 'Il codice di recupero inserito non è valido.',
        'toggle_recovery' => 'Usa un codice di recupero',
        'toggle_otp' => 'Usa il codice dell\'app autenticatore',
        'submit_btn' => 'Accedi',
    ],

    'setup' => [
        'title' => 'Configurazione 2FA',
        'heading' => 'Configurazione autenticazione a due fattori',
    ],

    'confirm_password' => [
        'title' => 'Conferma password',
        'heading' => 'Conferma password',
        'description' => 'Per procedere con questa operazione è richiesta la conferma della password.',
    ],

    'profile' => [
        'card_title' => 'Autenticazione a due fattori',
    ],

];
