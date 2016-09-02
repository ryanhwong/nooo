<?php namespace Peakgames\CRM\Validator;

/**
 * Class SignedRequest
 *
 * @package Peakgames\CrmValidator
 */
final class SignedRequest
{
    /**
     * @var string
     */
    private $url;

    /**
     * @var string
     */
    private $body;

    /**
     * @param string $url
     * @param string $body
     */
    public function __construct($url, $body)
    {
        $this->url  = $url;
        $this->body = $body;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }
}