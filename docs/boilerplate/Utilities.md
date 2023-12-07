[Torna all'indice](README.md)

----

### Backup

[`spatie/laravel-backup`](https://spatie.be/docs/laravel-backup/v8/introduction) è installato e configurato per salvare
il backup giornaliero su S3,
basta configurare le credenziali S3 nell'env e abilitare
lo [scheduling di laravel](https://laravel.com/docs/10.x/scheduling)

### Bugsnag

Per abilitare il logging su bugsnag in production è sufficiente impostare la variabile `BUGSNAG_API_KEY` nell'env

### Telescope

In locale viene installato anche [Telescope](https://laravel.com/docs/10.x/telescope), per utilizzarlo è sufficiente:

- Impostare a true la variabile `TELESCOPE_ENABLED` nell'env
- (solo la prima volta) Runnare le migrazioni con `skipper artisan migrate`
- Aprire l'url `/telescope` sul browser

### Factories e DB seed

Il modello `User` ha una [factory](https://laravel.com/docs/10.x/eloquent-factories) configurata.

Facendo il seed del database (`skipper artisan db:seed`) in automatico viene creato l'utente admin **info@tiknil.com**
con password **password**

----

[Torna all'indice](README.md)
