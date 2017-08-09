<?php
/**
 * Created by PhpStorm.
 * User: flaviosuardi
 * Date: 08/03/2017
 * Time: 11:09
 */

namespace App\Models\Serializers;


use Tobscure\JsonApi\AbstractSerializer;

class AppModelSerializer extends AbstractSerializer
{

    public function getAttributes($obj, array $fields = null)
    {

        $attributes = array_diff_key($obj['attributes'], ['id' => '']);

        return $attributes;
    }
}
