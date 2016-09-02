<?php namespace Peakgames\CRM\Validator;

use InvalidArgumentException;

/**
 * Class Validator
 *
 * @package Peakgames\CrmValidator
 */
final class Validator
{
    /**
     * @var string
     */
    private $payload;

    /**
     * @var string
     */
    private $actualPayload;

    /**
     * @var string
     */
    private $signature;

    /**
     * @var SignTool
     */
    private $signTool;

    /**
     * @param SignTool $signTool
     * @param array    $body
     *
     * @throws InvalidArgumentException
     */
    public function __construct(SignTool $signTool, array $body = null)
    {
        if ($body === null)
        {
            $this->payload   = isset($_REQUEST['payload']) ? $_REQUEST['payload'] : null;
            $this->signature = isset($_REQUEST['signature']) ? $_REQUEST['signature'] : null;
        }
        else
        {
            if (!isset($body['payload']) || !isset($body['signature']))
            {
                throw new InvalidArgumentException("body must contain a \"payload\" and \"signature\".");
            }

            $this->payload   = $body['payload'];
            $this->signature = $body['signature'];
        }

        /**
         * We need to remove the timestamp from $payload before passing it
         * into the instance
         */
        $separatorPosition = strrpos($this->payload, SignTool::PAYLOAD_SEPARATOR);

        if ($separatorPosition === false || $separatorPosition < 1)
        {
            throw new InvalidArgumentException("Broken payload. This should not happen.");
        }

        $this->actualPayload = substr($this->payload, 0, $separatorPosition);

        $this->signTool = $signTool;
    }

    /**
     * @return bool
     */
    public function isValid()
    {
        return $this->signTool->isSignatureValid($this->payload, $this->signature);
    }

    /**
     * @param string $class
     *
     * @return Returnable
     */
    public function getReturnable($class)
    {
        if (class_exists($class) === false)
        {
            throw new InvalidArgumentException(sprintf("No such class \"%s\"", $class));
        }

        /** @var Returnable $instance */
        $instance = new $class();

        $instance->populateFromJsonString($this->actualPayload);

        return $instance;
    }

    /**
     * @return string
     */
    public function getPayload()
    {
        return $this->actualPayload;
    }

    /**
     * @return string
     */
    public function getRawPayload()
    {
        return $this->payload;
    }

    /**
     * @return string
     */
    public function getSignature()
    {
        return $this->signature;
    }

    /**
     * @return string
     */
    public function getUniquePayloadIdentifier()
    {
        return hash('sha256', $this->payload);
    }
}