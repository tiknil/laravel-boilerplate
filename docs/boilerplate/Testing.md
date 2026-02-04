[Torna all'indice](README.md)

----

### Testing

Il progetto è preimpostato per il testing tramite `pest`. Si possono lanciare con il comando composer test

```
skipper composer test
```

Nella cartella tests/ sono già presenti alcuni test base da prendere come spunto iniziale.

#### Database

I test vengono eseguiti su una connessione database separata, chiamata `testing`, collegata al database `testing_db` nell'instanza MySQL gestita da docker compose.

Ogni test usa un DB isolato e vuoto, perché tutte le query sono raggruppate in una transazione che non viene mai committata (vedasi il trait `DatabaseTransactions` incluso nel file `Pest.php`).

L'unica accortezza necessaria è l'esecuzione delle migrazioni su questo database, quando vengono introdotte delle modifiche alla strutta del DB:

```
skipper artisan migrate --database=testing
```


----

[Torna all'indice](README.md)
