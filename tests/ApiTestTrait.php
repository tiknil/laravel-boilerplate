<?php

namespace Tests\Traits;


trait ApiTestTrait
{

    protected $response;

    /**
     * Controlla che la chiamata abbia restituito 200, che la risposta abbia un contenuto valido JsonApi,
     * che ci sia il campo 'data' e non ci sia il campo 'errore'
     */
    public function assertApiSuccess()
    {
        $this->assertApiSuccessWithCode(200);
    }

    /**
     * Controlla che la chiamata abbia restituito il codice passato come parametro, che la risposta abbia un contenuto valido JsonApi,
     * che ci sia il campo 'data' e non ci sia il campo 'errore'
     * @param $code
     */
    public function assertApiSuccessWithCode($code)
    {
        if ($this->response->getStatusCode() != $code){
            dump($this->response->getContent());
        }
        if ($code == 200) {
            $this->response->assertStatus($code);
        } else {
            $actual = $this->response->getStatusCode();
            $this->assertEquals($code, $actual, 'Il codice di stato è diverso da quello atteso (atteso: ' . $code . ' - ricevuto: ' . $actual . ')');
        }

        $this->assertApiValidJsonApi();

        $manager = new \Art4\JsonApiClient\Utils\Manager();
        $document = $manager->parse($this->response->getContent());

        $this->assertTrue($document->has('data'), 'La chiamata all\'endpoint ha avuto successo ma la risposta non contiene il campo \'data\'');
        $this->assertFalse($document->has('errors'), 'La chiamata all\'endpoint ha avuto successo ma la risposta contiene il campo\'errors\'');
    }


    /**
     * Controlla che la chiamata abbia avuto esito negativo con response status specificato
     *
     * @param int $response_status stato atteso
     */
    public function assertApiErrorWithResponseStatus($response_status)
    {
        $this->assertApiErrorWithResponseStatusAndErrorCode($response_status, null);
    }

    /**
     * Controlla che la chiamata abbia avuto esito negativo con response status e error code specifico se specificato
     *
     * @param integer $response_status status HTTP di risposta che indica l'errore
     * @param String $error_code errore specifico dell'applicazione
     */
    public function assertApiErrorWithResponseStatusAndErrorCode($response_status, $error_code)
    {
        $this->assertResponseStatus($response_status);
        $this->assertApiValidJsonApi();

        $manager = new \Art4\JsonApiClient\Utils\Manager();
        $document = $manager->parse($this->response->getContent());

        $this->assertFalse($document->has('data'), 'La chiamata all\'endpoint è fallita ma la risposta contiene il campo \'data\'');
        $this->assertTrue($document->has('errors'), 'La chiamata all\'endpoint è fallita ma la risposta non contiene il campo\'errors\'');
        if (isset($error_code)) {
            $errors = $document->get('errors');
            $this->assertTrue($errors->get(0)->has('code'), 'La chiamata all\'endpoint è fallita ma la risposta non contiene il campo \'code\' tra gli \'errors\'');
            $this->assertEquals($error_code, $errors->get(0)->get('code'), 'Il codice di errore specifico per l\'applicazione è diverso da quello atteso (atteso: ' . $error_code . ' - ricevuto: ' . $errors->get(0)->get('code') . ')');
        }
    }

    /**
     * Controlla la validità della specifica JsonApi del corpo della risposta
     */
    public function assertApiValidJsonApi()
    {
        $this->assertTrue(\Art4\JsonApiClient\Utils\Helper::isValid($this->response->getContent()), 'Il corpo della risposta non contiene un Json valido secondo la specifica JsonApi');
    }

    /**
     * Controlla se la risposta alla chiamata API ha successo e contiene le informazioni attese
     *
     * @param string $type tipo di oggetto atteso
     * @param array $expected_data oggetto con informazioni attese
     */
    public function assertApiSuccessfulResponse($type, Array $expected_data)
    {
        $this->assertApiSuccessfulResponseWithTypeIdAndData($type, $expected_data['id'], $expected_data);
    }

    /**
     * Controlla se la risposta ricevuta dal server è ricevuta con successo (200), è di tipo JsonApi e ha i campi
     * equivalenti a quelli passati come parametri
     *
     * @param string $type tipo dell'oggetto atteso
     * @param int $id id dell'oggetto atteso. null se si attende un oggetto appena creato
     * @param array $expected_data valori dell'oggetto atteso
     */
    public function assertApiSuccessfulResponseWithTypeIdAndData($type, $id, Array $expected_data = null)
    {
        $this->assertApiSuccessfulResponseWithCodeTypeIdAndData(200, $type, $id, $expected_data);
    }

    /**
     * Controlla se la risposta ricevuta dal server è ricevuta con successo con il codice di stato passato,
     * è di tipo JsonApi e ha i campi equivalenti a quelli passati come parametri
     *
     * @param int $code codice di stato atteso
     * @param string $type tipo di oggetto 'data' atteso
     * @param int $id id atteso
     * @param array|null $expected_data
     */
    public function assertApiSuccessfulResponseWithCodeTypeIdAndData($code, $type, $id, Array $expected_data = null)
    {
        $this->assertApiSuccessWithCode($code);

        $manager = new \Art4\JsonApiClient\Utils\Manager();
        $document = $manager->parse($this->response->getContent());

        $this->assertEquals($document->get('data.type'), $type, 'Il tipo dell\' oggetto ricevuto è diverso da quello atteso (atteso: ' . $type . ' - ricevuto: ' . $document->get('data.type') . ')');

        if (isset($id)) {
            $this->assertEquals($document->get('data.id'), $id, 'L\'id dell\' oggetto ricevuto è diverso da quello atteso (atteso: ' . $id . ' - ricevuto: ' . $document->get('data.id') . ')');
        }

        if (isset($expected_data)) {
            $this->assertModelData($document->get('data.attributes')->asArray(), $expected_data);
        }
    }

    /**
     * Controlla se la risposta ricevuta dal server è ricevuta con successo con codice di stato 200,
     * è di tipo JsonApi e ha per ciascun elemento dell'array i campi equivalenti a quelli passati come parametri
     *
     * @param string $type tipo di oggetto 'data' atteso
     * @param array $id_array array di id attesi
     * @param array|null $data_array array di dati attesi
     */
    public function assertApiSuccessfulResponseWithTypeAndIdArraysAndData($type, $id_array, $data_array = null)
    {
        $this->assertApiSuccessfulResponseWithCodeTypeAndIdArraysAndData(200, $type, $id_array, $data_array);
    }

    /**
     * Controlla se la risposta ricevuta dal server è ricevuta con successo con il codice di stato passato,
     * è di tipo JsonApi e ha per ciascun elemento dell'array i campi equivalenti a quelli passati come parametri
     *
     * @param int $code codice di stato atteso
     * @param string $type tipo di oggetto 'data' atteso
     * @param array $id_array array di id attesi
     * @param array|null $data_array array di dati attesi
     */
    public function assertApiSuccessfulResponseWithCodeTypeAndIdArraysAndData($code, $type, $id_array, $data_array = null)
    {
        $this->assertApiSuccessWithCode($code);

        $manager = new \Art4\JsonApiClient\Utils\Manager();
        $document = $manager->parse($this->response->getContent());

        $results = $document->get('data')->asArray();

        for ($i = 0; $i < count($results); $i++) {
            //dump('Controllo l\'oggetto '.$i.'/'.count($results));
            $this->assertEquals($document->get('data')->get($i)->get('type'), $type, 'Il tipo dell\' oggetto ricevuto è diverso da quello atteso (atteso: ' . $type . ' - ricevuto: ' . $document->get('data')->get($i)->get('type') . ')');
            if (isset($id_array)) {
                $this->assertEquals($document->get('data')->get($i)->get('id'), $id_array[$i], 'L\'id dell\' oggetto ricevuto è diverso da quello atteso (atteso: ' . $id_array[$i] . ' - ricevuto: ' . $document->get('data')->get($i)->get('id') . ')');
            }
            if (isset($data_array)) {
                $this->assertModelData($document->get('data')->get($i)->get('attributes')->asArray(), $data_array[$i]);
            }
        }
    }

    /**
     * Funzione per controllare che il campo data esista e non abbia contenuto
     */
    public function assertDataHasNoContent()
    {
        $manager = new \Art4\JsonApiClient\Utils\Manager();
        $document = $manager->parse($this->response->getContent());

        $this->assertTrue($document->has('data'),'Il campo data non è presente nella risposta');
        $this->assertEquals(count($document->get('data')->asArray()),0,'Il campo data ha contenuto, non è vuoto come atteso');
    }

    /**
     * Controlla se il campo meta contiene il valore atteso
     *
     * @param array $expected_data valore atteso del campo meta
     */
    public function assertApiMetaEquals(Array $expected_data)
    {
        $manager = new \Art4\JsonApiClient\Utils\Manager();
        $document = $manager->parse($this->response->getContent());

        $this->assertModelData($expected_data, $document->get('meta')->asArray());
    }

    /**
     * Controlla se nel campo meta è presente il campo passato come parametro
     *
     * Serve quando non si deve controllare il valore del campo ma solo la sua esistenza
     *
     * @param string $expected_meta
     */
    public function assertApiMetaExists($expected_meta)
    {
        $manager = new \Art4\JsonApiClient\Utils\Manager();
        $document = $manager->parse($this->response->getContent());

        $this->assertTrue($document->has('meta'), 'La risposta non ha il campo \'meta\'');
        $this->assertTrue(array_key_exists($expected_meta, $document->get('meta')->asArray()), 'Nel campo \'meta\' non è presente il campo atteso ' . $expected_meta);
    }

    /**
     * Controlla che la relazione con nome passato come parametro non sia presente nel campo relazioni all'interno di 'data'
     * @param string $expected_relationship nome della relazione che si vuole controllare non esista all'interno del campo 'relationships'
     */
    public function assertApiRelationshipsNotExists($expected_relationship)
    {
        $manager = new \Art4\JsonApiClient\Utils\Manager();
        $document = $manager->parse($this->response->getContent());

        $this->assertFalse($document->has('data.relationships.'.$expected_relationship));
    }

    /**
     * Controlla che la relazione sia presente ed abbia contenuto identico a quello passato come parametro
     * @param string $expected_relationship nome della relazione attesa nel campo 'relationships'
     * @param array $expected_data dati che ci si aspetta siano contenuti all'interno della relazione attesa
     */
    public function assertApiRelationshipEquals($expected_relationship, Array $expected_data)
    {
        $manager = new \Art4\JsonApiClient\Utils\Manager();
        $document = $manager->parse($this->response->getContent());

        $this->assertTrue($document->has('data.relationships.'.$expected_relationship));

        dump('relationship: '.$expected_relationship);
        dump($this->response->getContent());

        $data = $document->get('data.relationships.'.$expected_relationship.'.data');
        $results = $data->asArray();
        dump($results);
        dump(count($results));

        //Controllo se è un elemento singolo o un array
        if ($data->has('attributes')){
            dump('toOne relation');

        }else if(count($results) > 0){
            dump('toMany relation - size: '.count($results));
//        dump($expected_data);
            for ($i = 0; $i < count($results); $i++){
                dump('index: '.$i);
                dump($data->get($i)->getKeys());
                dump($data->get($i));
                $this->assertModelData($data->get($i)->get('attributes')->asArray(), $expected_data[$i]);
            }
        }else {
            dump('is empy?');
            dump($expected_data);
            $this->assertEmpty($expected_data);
        }
    }


    /**
     * Controlla che i parametri contenuti in $expecetdData abbiano gli stessi valori dei parametri con lo stesso nome
     * contenuti in $jsonAttributes
     *
     * @param array $jsonAttributes dati recuperati da Json di risposta
     * @param array $expectedData dati attesi
     */
    public function assertModelData(Array $jsonAttributes, Array $expectedData)
    {
        $this->assertModelDataAlsoForDatesAndId($jsonAttributes, $expectedData, false, false);
    }

    /**
     * @param array $jsonAttributes
     * @param array $expectedData
     * @param $check_also_dates
     * @param $check_also_id
     */
    public function assertModelDataAlsoForDatesAndId(Array $jsonAttributes, Array $expectedData, $check_also_dates, $check_also_id)
    {
        foreach ($jsonAttributes as $key => $value) {
            if (!$check_also_dates && ($key == 'updated_at' || $key == 'created_at' || $key == 'deleted_at')) {
                //Se si è scelto di non controllare le date e la chiave è un campo data non fa niente
            } else if (!$check_also_id && $key == 'id') {
                //Se si è scelto di non controllare il campo id (per esempio perché siamo in fase di creazione) e la chiave è l'id non fa niente
            } else {
                if (array_key_exists($key, $expectedData)) {
                    $this->assertEqualsStringOrArray($jsonAttributes[$key], $expectedData[$key], $key);
                }
            }
        }
    }


    /**
     * Questa funzione controlla se il valore attuale passato è identico a quello atteso controllando se il valore atteso
     * è di tipo array e in tal caso trasforma il stdObject ricevuto in un array in modo iterativo per tutti i suoi
     * items
     * @param misc $actualValue valore ricevuto
     * @param misc $expectedValue valore atteso
     * @param null $message messaggio da visualizzare
     */
    public function assertEqualsStringOrArray($actualValue, $expectedValue, $key, $message = null)
    {
        if (is_array($expectedValue)) {
            $obj_as_array = json_decode(json_encode($actualValue), true);
            foreach ($obj_as_array as $subkey => $subvalue) {
                if (isset($subvalue)) {
                    if (array_key_exists($subkey, $expectedValue)) {
                        $this->assertEqualsStringOrArray($obj_as_array[$subkey], $expectedValue[$subkey], $subkey);
                    }
                }
            }
        } else {
            $this->assertEquals($actualValue, $expectedValue,
                $message != null ? $message : 'Il campo ' . $key. ' ha valore diverso da quello atteso. (Attuale: '.$actualValue.', atteso: '.$expectedValue.')',
                0.0,
                10,
                false,
                true);
        }
    }


    /**
     * Controlla che tutti i valori dell'array 'data' abbiano il campo meta passato come parametro
     * @param $expected_meta campo di cui si vuole controllare l'esistenza nel campo meta di ciascun oggetto dell'array ritornato dalla richiesta
     */
    public function assertThatDataArrayHasMeta($expected_meta)
    {
        $manager = new \Art4\JsonApiClient\Utils\Manager();
        $document = $manager->parse($this->response->getContent());

        $data = $document->get('data');
        $i = 0;
        while($data->has($i) != null){
            $this->assertTrue($data->get($i)->has('meta',$expected_meta));
            $i++;
        }
    }

    /**
     * Controlla che tutti i valori dell'array 'errors' abbiano il campo meta passato come parametro
     * @param $expected_meta campo di cui si vuole controllare l'esistenza nel campo meta di ciascun oggetto dell'array ritornato dalla richiesta
     */
    public function assertThatErrorsArrayHasMeta($expected_meta)
    {
        $manager = new \Art4\JsonApiClient\Utils\Manager();
        $document = $manager->parse($this->response->getContent());

        $errors = $document->get('errors');

        $i = 0;
        while($errors->has($i) != null){
            $this->assertTrue($errors->get($i)->has('meta',$expected_meta));
            $i++;
        }
    }

    /**
     * Controlla che tutti gli elementi restituiti nell'array 'data' siano ordinati alfabeticamente (dalla A alla z)
     * in base alla proprietà con nome passato come parametro
     * @param $column_name
     */
    public function assertThatArrayValuesIsOrderedAlphabeticallyForColumn($column_name)
    {
        $this->assertNotNull($column_name);
        $this->assertNotEmpty($column_name);

        $manager = new \Art4\JsonApiClient\Utils\Manager();
        $document = $manager->parse($this->response->getContent());

        $results = $document->get('data')->asArray();

        for ($i = 0; $i < (count($results) - 1); $i++) {
            $element_to_check = $document->get('data')->get($i)->get('attributes')->get($column_name);
            $next_element_to_check = $document->get('data')->get($i + 1)->get('attributes')->get($column_name);
            $this->assertTrue(strcmp($element_to_check, $next_element_to_check) < 0);
        }
    }

}