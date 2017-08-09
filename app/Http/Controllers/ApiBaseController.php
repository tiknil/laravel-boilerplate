<?php

namespace App\Http\Controllers;

use Chrisbjr\ApiGuard\Repositories\ApiKeyRepository;
use Dingo\Api\Routing\Helpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\JsonResponse;
use Tobscure\JsonApi\Document;
use Tobscure\JsonApi\Collection;
use Tobscure\JsonApi\Resource;

/**
 * @SWG\Swagger(
 *   basePath="/api",
 *   host="website.it",
 *   schemes={"https"},
 *
 *   @SWG\Info(
 *     title="Website API",
 *     version="1.0.0",
 *   ),
 * )
 *
 * @SWG\SecurityScheme(
 *   securityDefinition="bearer",
 *   type="apiKey",
 *   in="header",
 *   name="X-Authorization"
 * )
 */

abstract class ErrorCodes
{
    //Generic error
    const UnknownError = "100";
    //Request error
    const DataNotFound = "20";
    const InvalidParameters = "21";
    const NoValidParameters = "22";
    const NotFound = "23";

}

class ApiBaseController extends Controller
{
    use Helpers;

    /*public function validate(Request $request, array $rules, array $messages = [], array $customAttributes = [])
    {
    }*/

    /*******************************************************************************************************************
     * GESTIONE DELLE RISPOSTE
     ******************************************************************************************************************/

    /**
     * Risposta standard da utilizzare in caso di successo
     *
     * @param misc $content Informazioni da inviare in risposta in seguito al successo della richiesta (oggetto singolo o array)
     * @param array $meta informazioni meta aggiuntive
     * @param array $link informazioni link aggiuntive
     * @param AppModelSerializer $serializer serializer del content
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function successfulResponse($content, $meta = null, $link = null, $serializer = null)
    {
        return $this->successfulResponseWithCode(200, $content, $meta, $link, $serializer); // 200 : OK
    }

    /**
     * Risposta standard da utilizzare in caso di successo con contenuto e sue relazioni
     *
     * @param misc $content Informazioni da inviare in risposta in seguito al successo della richiesta (oggetto singolo o array)
     * @param array $relationships relazioni del contenuto
     * @param array $meta informazioni aggiuntive
     * @param array $link informazioni link aggiuntive
     * @param AppModelSerializer $serializer serializer del content
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function successfulResponseWithRelationships($content, $relationships = null, $meta = null, $link = null, $serializer = null)
    {
        return $this->successfulResponseWithCodeAndRelationships(200, $content, $relationships, $meta, $link, $serializer); // 200 : OK
    }


    /**
     * Risposta da utilizzare in caso di successo con codice di successo specifico e info aggiuntive (meta)
     *
     * @param int $code codice http da utilizzare per la risposta
     * @param Model $content valore/valori da restitutire nella risposta
     * @param array $meta informazioni aggiuntive
     * @param array $link informazioni link aggiuntive
     * @param AppModelSerializer $serializer serializer del content
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function successfulResponseWithCode($code, $content, $meta = null, $link = null, $serializer = null)
    {
        return $this->successfulResponseWithCodeAndRelationships($code, $content, null, $meta, $link, $serializer);
    }

    /**
     * Risposta da utilizzare in caso di successo con codice di successo specifico, relazioni e info aggiuntive (meta)
     * @param int $code codice http da utilizzare per la risposta
     * @param $content valore/valori da restitutire nella risposta
     * @param array $relationships relazioni (array di oggetti es: [ 'services' => $user->services() ])
     * @param array $meta informazioni aggiuntive
     * @param array $link informazioni link aggiuntive
     * @param AppModelSerializer $serializer serializer del content
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function successfulResponseWithCodeAndRelationships($code, $content, $relationships = null, $meta = null, $link = null, $serializer = null)
    {

        //dd(get_class($content));

        if (isset($content) && (is_a($content, 'Illuminate\Database\Eloquent\Model'))) {
            // è una resource
            // Crea una nuova Resource (Tobscure) da un serializer, e specifica le relationships.
            $row_data = (new Resource($content, $serializer))->with($relationships);

        } else if (isset($content) && $content->count() > 0) {
            // è un array di resource
            // Crea una nuova Collection (Tobscure) da un serializer, e specifica le relationships.
            $row_data = (new Collection($content, $serializer))->with($relationships);

        } else {
            return JsonResponse::create([
                'data' => []
            ], 200); // Dovrebbe essere "204 : No Content" ma per convenienza lato client lasciamo 200
        }

        // Crea un nuovo documento JSON-API con la collecion come data
        $response_data = new Document($row_data);

        if(isset($meta)) {
            // Aggiunge i meta
            foreach ($meta as $key=>$value) {
                $response_data->addMeta($key, $value);
            }
        }

        if(isset($link)) {
            // Aggiunge i link
            foreach ($link as $key=>$value) {
                $response_data->addLink($key, $value);
            }
        }

        return JsonResponse::create($response_data, $code);

    }

    /**
     * Risposta standard da utilizzare in caso di successo con un id di un elemento
     *
     * @param string $type tipo di stringa che si sta restituendo (es: 'user')
     * @param int $id id di un oggetto
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function successfulResponseWithId($type, $id, $meta = null)
    {
        $response_data = array();

        if (isset($meta)) {
            $response_data['meta'] = $meta;
        }

        if (isset($type) && isset($id)) {

            $response_data['data'] = [
                'type' => $type,
                'id' => "$id",
            ];

            return JsonResponse::create($response_data, 200); // 200 : OK
        } else {
            return JsonResponse::create(null, 204); // 204 : No Content
        }
    }

    //TODO: implementare la possibilità di inserire nella risposta avvenuta con successo i campi:
    //TODO: 'links' e 'included' (vedi http://jsonapi.org/format/)


    /**
     * Risposta standard da utilizzare in caso di errore
     *
     * @param int $httpErrorCode codice http di errore
     * @param String $errorCode codice di errore specifico dell'applicazione (se specifica meglio l'errore indicato in httpErrorCode
     * @param String $errorTitle Testo dell'errore
     * @param String $errorLocalizedMessage Messaggio localizzato dell'errore (può contenere la key per la stringa localizzata in app)
     * @param object $errorMeta Informazioni di dettaglio sull'errore
     * @return \Symfony\Component\HttpFoundation\Response
     *
     *
     * @SWG\Definition(
     *      definition="Error",
     *      @SWG\Property(
     *          property="errors",
     *          description="Lista di errori",
     *          type="array",
     *          @SWG\Items(
     *              type="object",
     *              @SWG\Property(property="code", type="string", description="Codice specifico dell'applicazione - se necessario"),
     *              @SWG\Property(property="title", type="string", description="Testo esplicativo dell'errore"),
     *              @SWG\Property(property="description", type="string", description="chiave per localizzare il messaggio di errore in-app"),
     *              @SWG\Property(property="meta", type="object", description="Informazioni aggiuntive eventuali")
     *          )
     *      )
     * )
     */
    public function errorResponse($httpErrorCode, $errorCode, $errorTitle, $errorLocalizedMessage, $errorMeta = null)
    {
        $details = [
            'code' => $errorCode ? $errorCode : "",
            'status' => (string)$httpErrorCode,
            'title' => $errorTitle ? $errorTitle : "",
            'detail' => $errorLocalizedMessage ? $errorLocalizedMessage : "",
        ];

        if (isset($errorMeta)) {
            $details['meta'] = $errorMeta;
        }

        return JsonResponse::create([
            'errors' => array($details)
        ], $httpErrorCode);
    }

    /*******************************************************************************************************************
     * GESTIONE REQUEST
     ******************************************************************************************************************/

    /**
     * Recupera dalla request il valore della proprietà 'data'
     * @param Request $request richiesta da cui recuperare il parametro
     * @return il valore della proprietà 'data'
     */
    public function getDataFromRequest(Request $request)
    {
        $result = [];
        if (isset($request)) {
            $data = $request->only(['data']);
            if (isset($data)) {
                $result = $data['data'];
            }
        }
        return $result;
    }


    /**
     * Recupera dalla request l'array degli 'attributes' dell'oggetto contenuto nel campo 'data'.
     * ATTENZIONE: da usare solo per request in cui il campo 'data' è un oggetto e non un array
     *
     * @param Request $request richiesta da cui recuperare gli attributes
     * @param array $valid_params eventuale array che contiene le chiavi dei parametri che si vogliono filtrare
     * @return array di attributes o null
     */
    public function getAttributesFromRequest(Request $request, $valid_params = null)
    {
        $result = [];
        $data = $this->getDataFromRequest($request);
        if (isset($data) && isset($data['attributes'])) {
            $result = $data['attributes'];

            if (isset($result) && isset($valid_params)) {
                $filtered_result = array();

                foreach ($result as $key => $value) {
                    if (in_array($key, $valid_params)) {
                        $filtered_result = array_merge($filtered_result, [$key => $value]);
                    }
                }
                $result = $filtered_result;
            }
        }
        return $result;
    }

    /**
     * Recupera dalla request l'id dell'oggetto contenuto nel campo 'data'.
     *
     * @param Request $request richiesta da cui recuperare l'id
     * @return string l'id dell'oggetto
     */
    public function getIdFromRequest(Request $request)
    {
        $result = [];
        $data = $this->getDataFromRequest($request);
        if (isset($data)) {
            $result = $data['id'];
        }
        return $result;
    }

    /**
     * Recupera dalla request l'array degli 'headers'.
     *
     * @param Request $request richiesta da cui recuperare gli headers
     * @return array di headers o null
     */
    public function getHeadersFromRequest(Request $request)
    {
        $result = [];
        if (isset($request)) {
            $data = $request->only(['headers']);
            if (isset($data)) {
                $result = $data['headers'];
            }
        }
        return $result;
    }

    /**
     * Ritorna il modello ApiKeyRepository della API Key relativa alla chiave passata come argomento
     *
     * @param string $key la chiave
     * @return ApiKeyRepository il modello ApiKeyRepository
     */
    public function getApiKeyRepositoryFromKey($key) {
        // creazione del model ApiKey
        $apiKeyModel = App::make(config('apiguard.models.apiKey', 'Chrisbjr\ApiGuard\Models\ApiKey'));
        return $apiKeyModel->getByKey($key, config('apiguard.rememberApiKeyDuration', 0));
    }

    /*******************************************************************************************************************
     * FUNZIONI PRIVATE
     ******************************************************************************************************************/

    /**
     * Questa funzione esplode il contenuto per prepararlo al campo 'data' JsonApi come oggetto o come array in base al
     * parametro passato
     * @param $content Model o Collection
     * @param \League\Fractal\TransformerAbstract $transformer eventuale transformer del content
     * @return array|Array|null
     */
    private function explodeContentInData($content, $transformer = null)
    {
        $data = null;
        if (is_a($content, 'Illuminate\Database\Eloquent\Collection')) {
            $data = array();
            foreach ($content as $item) {
                array_push($data, $this->explodeObject($item, $transformer));
            }
        } else {
            $data = $this->explodeObject($content, $transformer);
        }
        return $data;
    }

    /**
     * Funzione che esplode un oggetto nella struttura proposta da JsonApi
     *
     * @param Model $object oggetto da esplodere
     * @param \League\Fractal\TransformerAbstract $transformer eventuale transformer del content
     * @return Array oggetto esploso
     */
    private function explodeObject(Model $object, $transformer = null)
    {
        if (isset($object)) {
            $reflection = new \ReflectionClass($object);
            $type = strtolower($reflection->getShortName());

            $id = (string)$object->id;

            $attributes = [];

            $object_array = null;
            if (isset($transformer)) {
                $object_array = $transformer->transform($object);
            } else {
                $object_array = $object->toArray();
            }

            //se ci sono elementi dell'array che devono essere messi in 'meta' li aggiungo
            $metas = null;
            if (property_exists($object, 'possible_metas')) {
                foreach ($object->toArray() as $key => $value) {
                    if (in_array($key, $object->possible_metas)) {
                        if (isset($metas)) {
                            $metas = array_merge([$key => $value], $metas);
                        } else {
                            $metas = [$key => $value];
                        }
                    }
                }
            }

            //se ci sono elementi dell'array che devono essere messi in 'relationships' li aggiungo
            $relationships = null;
            if (method_exists($object, 'relationships') && property_exists($object, 'included_relationships')) {
                $rels = $object->relationships();
                if (isset($rels) && count($rels) > 0) {
                    $relationships = array();

                    foreach ($rels as $relationship_key => $relationship_value) {
                        $relationship_content = $relationship_value['content'];
                        $relationship_transformer = $relationship_value['transformer'];

                        $relationships = array_merge($relationships, [
                            $relationship_key => [
                                'data' => $this->explodeContentInData($relationship_content, $relationship_transformer)
                            ]
                        ]);
                    }
                }
            }


            foreach ($object_array as $key => $value) {
                $attributes[$key] = $value;
            }

            //TODO: implementare gestione oggetti correlati in 'relationship' (http://jsonapi.org/format/#document-resource-identifier-objects)
            $exploded_object = [
                'type' => $type,
                'id' => $id,
                'attributes' => $attributes,
            ];

            //se ci sono aggiungo i campi meta
            if (isset($metas)) {
                $exploded_object = array_merge($exploded_object, [
                    'meta' => $metas
                ]);
            }

            //se ci sono aggiungo i campi relationships
            if (isset($relationships)) {
                $exploded_object = array_merge($exploded_object, [
                    'relationships' => $relationships
                ]);
            }

            return $exploded_object;
        } else {
            return null;
        }
    }

    /**
     * Error Response definition
     * @SWG\Definition(
     *      definition="ErrorResponse",
     *      required={"errors"},
     *      @SWG\Property(
     *          title="error",
     *          property="errors",
     *          type="object",
     *          required={"code", "status", "title", "detail"},
     *          @SWG\Property(
     *              property="code",
     *              type="string",
     *              description="API error code",
     *          ),
     *          @SWG\Property(
     *              property="status",
     *              type="string",
     *              description="HTTP status code",
     *          ),
     *          @SWG\Property(
     *              property="title",
     *              type="string",
     *              description="Error title",
     *              enum={"Unauthorized", "Bad Request", "Forbidden", "Not Found"}
     *          ),
     *          @SWG\Property(
     *              property="detail",
     *              type="string",
     *              description="Error description"
     *          ),
     *      )
     * )
     */

}
