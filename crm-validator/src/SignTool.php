<?php namespace Peakgames\CRM\Validator;

/**
 * Class SignTool
 *
 * @package Peakgames\CrmValidator
 */
class SignTool
{
    /**
     * @var string
     */
    private $key;

    /**
     * @var string
     */
    protected $algorithm = 'sha256';

    const PAYLOAD_SEPARATOR = '||';

    /**
     * @param string $key
     */
    public function __construct($key)
    {
        $this->key = $key;
    }

    /**
     * @param string $payload
     *
     * @return array
     */
    public function sign($payload)
    {
        $payload = $payload . self::PAYLOAD_SEPARATOR . round(microtime(true) * 1000);

        return [
            'payload'   => $payload,
            'signature' => hash_hmac($this->algorithm, $payload, $this->key),
        ];
    }

    /**
     * @param string $payload
     * @param string $signature
     *
     * @return bool
     */
    public function isSignatureValid($payload, $signature)
    {
        return hash_hmac($this->algorithm, $payload, $this->key) === $signature;
    }
}