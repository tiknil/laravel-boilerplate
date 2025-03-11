[Torna all'indice](README.md)

----

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
