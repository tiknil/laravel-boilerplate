[Torna all'indice](README.md)

--- 

## Flag cartelle

Per ottimizzare gli autocompletamenti e la ricerca, conviene segnalare PHPStorm la tipologia di alcune cartelle.

> Si può cambiare la *tipologia* di una cartella con tasto destro > Mark directory as

- `app/` => Sources Root
- `public/` => Resource Root
- `bootstrap/cache` => Excluded
- `public/build` => Excluded
- `public/docs` => Excluded
- `public/vendor` => Excluded
- `storage/logs` => Excluded
- `storage/framework` => Excluded

## Formattazione codice

Vengono predisposti i tool per la formattazione del codice PHP (tramite [Pint](https://laravel.com/docs/10.x/pint)) e
JS/TS (tramite ESLint + Prettier).

Serve comunque configurare PHPStorm per utilizzare questi tool in automatico al salvataggio di un file.

#### Pint

PHPStorm supporta Pint come formatter di codice in automatic. Lo si può abilitare nelle impostazioni PHPStorm:

`Preferences (⌘,) > Quality Tools > Pint`

Per fare in moda che i file venga automaticamente formattati al salvaggio, è necessario abilitare la formattazione di
PHPStorm per i file PHP. Vedi l'opzione "Reformat code" in:

```
Preferences (⌘,) > Tools > Actions on save
```

> è consigliato abilitare il "Reformat code" per tutti i file

#### ESLint e prettier

`Preferences (⌘,) > Javascript > Code Quality Tools > ESlint`

Abitare la configurazione automatica e l'esecuzione di `eslint --fix` ad ogni salvataggio di file.

`Preferences (⌘,) > Javascript > Prettier`

Abitare la configurazione automatica e l'esecuzione ad ogni salvataggio di file.

[Torna all'indice](README.md)
