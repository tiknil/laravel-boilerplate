<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| The closure you provide to your test functions is always bound to a specific PHPUnit test
| case class. By default, that class is "PHPUnit\Framework\TestCase". Of course, you may
| need to change it using the "uses()" function to bind a different classes or traits.
|
*/
uses(
    TestCase::class,
    DatabaseTransactions::class,
)->beforeEach(function () {
    // Imposto file storage come fake, per evitare inconsistenza con i file in locale
    Storage::fake('s3');
    Storage::fake('local');
})->afterEach(function () {
    // Svuota redis da qualsiasi dato vi è stato salvato durante i test
    // Redis::flushdb();
})->in('Feature', 'Unit');

/*
|--------------------------------------------------------------------------
| Hooks
|--------------------------------------------------------------------------
|
| Pest fornisce diversi hook per eseguire codice in specifici momenti
| del ciclo di vita dei test.
|
*/

// Esegui questo codice UNA SOLA VOLTA prima di tutti i test della suite
beforeAll(function () {
    echo "Before all is working now!\n";
});

afterAll(function () {
    echo "After all is working now!\n";
});

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| When you're writing tests, you often need to check that values meet certain conditions. The
| "expect()" function gives you access to a set of "expectations" methods that you can use
| to assert different things. Of course, you may extend the Expectation API at any time.
*/

/*
expect()->extend('toBeOne', function () {
    return $this->toBe(1);
});
*/

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| While Pest is very powerful out-of-the-box, you may have some testing code specific to your
| project that you don't want to repeat in every file. Here you can also expose helpers as
| global functions to help you to reduce the number of lines of code in your test files.
|
*/
/**
 * Permette di accedere al valore di proprietà private di un oggetto/instanza
 *
 * @throws ReflectionException
 */
function getReflectedProperty($object, $property): mixed
{
    $reflectedClass = new \ReflectionClass($object);
    $reflection = $reflectedClass->getProperty($property);
    $reflection->setAccessible(true);

    return $reflection->getValue($object);
}
