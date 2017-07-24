<?php
/**
 * Created by PhpStorm.
 * User: Vladimir Pavlov <kolobokhtc@gmail.com>
 * Date: 24.07.2017 9:54
 */

namespace FacebookBot\Api;

use FacebookBot\Api\Exception\ApiException;

class Entity
{

    /**
     * Map api-response keys to class setters
     *
     * @var array
     */
    protected $propertiesMap = [];

    public function __construct($properties = null)
    {

        if (is_null($properties)) {
            return FALSE;
        }

        if (!is_array($properties) && !$properties instanceof \ArrayAccess){
            throw new ApiException('Properties must be array or implement array access');
        }

        if (empty($this->propertiesMap)){
            foreach ($properties as $propertyName => $propertyValue){
                if (property_exists(get_class($this), $propertyName)){
                    $this->$propertyName = $propertyValue;
                }
            }
        } else {
            foreach ($properties as $propertyName => $propertyValue){
                if (isset($this->propertiesMap[$propertyName])){
                    $setterName = $this->propertiesMap[$propertyName];
                    $this->$setterName($propertyValue);
                }
            }
        }

    }

    /**
     * Build array single-level array
     *
     * @return array
     */
    public function toArray()
    {

        return [];

    }

}