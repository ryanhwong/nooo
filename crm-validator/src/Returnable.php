<?php namespace Peakgames\CRM\Validator;

use JsonSerializable;

interface Returnable extends JsonSerializable
{
    /**
     * @param string $json
     *
     * @return void
     */
    public function populateFromJsonString($json);
}