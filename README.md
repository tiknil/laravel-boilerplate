<p align="center">
<a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" height="100" alt="Laravel Logo"></a>
<a href="https://www.tiknil.com" target="_blank"><img src="https://www.tiknil.com/images/logo.png" height="100" alt="Tiknil Logo"></a>
</p>

Progetto Laravel con la struttura, i pattern e le best practices usate in Tiknil nei progetti backend.

L'obiettivo è tenere aggiornato questo repo, da tenere come reference e documentazione per tutti i progetti Laravel

### Versioni supportate

| Laravel                               | Reference                                                   |
|---------------------------------------|-------------------------------------------------------------|
| [v10](https://laravel.com/docs/10.x/) | [master](https://github.com/tiknil/boilerplate/tree/master) |

> Il master è riferito alla versione più recente supportata. Le versioni precedenti sono taggate al commit relativo

## Utilizzo

Cambia `[laravel-project]` con il nome del nuovo progetto:

```bash
# Clona questo repo nella cartella [laravel-project]
git clone git@github.com:tiknil/laravel-boilerplate.git [laravel-project] 
cd [laravel-project] 

rm -rf .git             # Rimuovi riferimenti a questo repo git
cp .env.example .env    # File .env iniziale (da personalizzare)

# Crea un nuovo repo git e crea il primo commit. Necessario per inizializzare skipper
git init                
git add .
git commit -m "Inizializzato progetto da boilerplate"

skipper init
skipper sail
....

skipper composer install
skipper artisan key:generate
skipper artisan migrate
skipper artisan db:seed # Crea utente info@tiknil.com con password 'password'

yarn install
yarn build      # Build iniziale per generare il manifest di vite
```

> Si suppone l'utilizzo di [skipper](https://github.com/tiknil/skipper) per l'avvio del progetto in locale

## Documentazione

- [Autenticazione web](docs/Auth.md)
- [Backend di amministrazione](docs/Backend.md)
- [API](docs/Api.md)
- [Utilities](docs/Utilities.md)
- [Setup PHPStorm](docs/PHPStorm.md)
