# Laravel Boilerplate
 Boilerplate di laravel 5.4 con le configurazioni di base necessarie per il nostro utilizzo standard (server per un app con API e backend di amministrazione)

## Pre-configurazioni effettuate
All'installazione laravel di base, sono stati aggiunti e configurati:
* [Dingo](https://github.com/dingo/api): preparata la definizione delle routes in `routes/api.php` e pubblicato il file di config `config/api.php`.
* [Swaggervel](https://github.com/appointer/swaggervel): configurato e importati i file per la visualizzazione grafica alla pagina `/api-docs`. 
Aggiunta definizione di errore generico e la configurazione dello Schema generico in `ApiBaseController`.
* [Laravel backup](https://github.com/spatie/laravel-backup)
* [Laravel HTML](https://laravelcollective.com/docs/5.4/html) 
* [Guzzle HTTP](http://docs.guzzlephp.org/en/stable/)
* [Bugsnag](https://docs.bugsnag.com/platforms/php/laravel/)
* [Datatables](https://yajrabox.com/docs/laravel-datatables): sia modulo composer per il backend che js/css per il frontend.
* [Json API](http://jsonapi.org/): impostato file `ApiBaseController` con metodi per parsare le richieste e wrappare le risposte comodamente. Presente anche il file `ApiTestTrait` con metodi per testare comodamente le API basate su JSON API.
* [AdminLTE](https://adminlte.io/): impostata view/sidebar di base, visibile all'url `/admin`.
* Migliorato il log: diviso in file giorno per giorno e utente per utente

## Utilizzo
1. Clonare il repo ed entrare nella cartella
2. Rimuovere la cartella `.git` e inizializzare il repository nuovo del progetto
```
rm -r .git
git init
```
3. Installa le dipendenze dal file di lock: `composer install`
4. Crea il file .env partendo dal .env.example: `cp .env.example .env`
5. Genera la chiave per il progetto `php artisan key:generate`
6. Modifica il .env con i valori specifici del progetto: Nome e indirizzo dell'app, MySQL, S3, Bugsnag, Dingo...
7. Installa le dipendenze Javascript `yarn install`
8. Effettua la build iniziale dei file js e scss `yarn dev`

### Opzionali
9. La cartella dei logs potrebbe dare problemi di permessi: assicurarsi che il gruppo dell'utente Apache (`www-data` solitamente) abbia i permessi di scrittura tramite il comando
`chmod -r g+w storage/logs`. Se la cartella logs non esiste, è possibile forzarne la creazione tramite un `\Log::info('test')` nel tinker.
10. Il modulo per il backup è impostato ma non attivo. Si possono decommentare le righe presenti nel metodo `schedule` di `app/Console/Kernel.php` per attivare il backup notturno quotidiano (in produzione).
Per effettuare il backup su s3, dopo aver configurato correttamente i valori nel `.env`, è sufficiente modificare il file `config/laravel-backup.php` alla riga 56
