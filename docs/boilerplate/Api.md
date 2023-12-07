[Torna all'indice](README.md)

----

### Organizzazione codice

I controllers relativi agli endpoint API sono raggruppati nella sotto cartella `/api/`.

Le route sono definite nel file `api.php` e in automatico gli URL definiti hanno il prefisso `/api`

Sono predisposti 5 endpoints generici:

- `POST auth/login` => Login utente
- `POST auth/reset-password` => Richiesta di reset password
- `POST auth/refresh` => Refresh token di accesso
- `POST auth/logout` => Revoca dei token
- `GET user` => Info profilo utente autenticato

### Autenticazione

L'autenticazione tramite API utilizza [Laravel Sanctum](https://laravel.com/docs/10.x/sanctum).

Al login vengono generati due token:

- Access token, durata 1gg per l'accesso agli endpoint protetti
- Refresh token, durata 1 anno per l'utilizzo dell'endpoint `auth/refresh`.

Il middleware `auth:sanctum` verifica che le richieste in entrata contengano un token valido e respingono le richieste
non idonee.

Ad esso si può aggiungere il middleware `abilities:access` per garantire che il token utilizzato sia un access
token. `abilities:refresh` garantisce invece che sia un refresh token e deve essere utilizzato solo per
l'endpoint `auth/refresh`

### Validazione

Estendendo il file `app/Http/Controllers/Api/ApiController`, i controller delle API possono verificare i parametri delle
richieste in entrata con il metodo `validateApiRequest` con un risultato analogo al `$request->validate` usato in ambito
web:

```php
$params = $this->validateApiRequest($request, [ 'field' => ['required|string']]);
```

Se la richiesta non viene validata, la risposta avrà status code `422` con codice `InvalidRequest`.

### Errori

Per ritornare una risposta di errore si può usare la classe `App\Http\Responses\Api\ErrorResponse` per garantire
uniformità del formato di risposta.

I possibili errori sono definiti nell'enumerativo `App\Http\Responses\Api\ApiError`.

Esempio: risposta di errore con status code 403 ed ApiError Forbidden:

```php
return ErrorResponse::json(403, ApiError::Forbidden);

return ErrorResponse::json(403, ApiError::Forbidden, "Testo aggiuntivo", ['dati' => 'opzionali']);
```

### Documentazione

Il file `docs/api.yaml` contiene la definizione OpenApi 3.0 degli endpoint implementati.

Il comando `yarn docs:api` genera il file html relativo, visitabile all'url `/docs/api.html`.

----

[Torna all'indice](README.md)
