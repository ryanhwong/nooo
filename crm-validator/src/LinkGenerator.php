<?php namespace Peakgames\CRM\Validator;

use InvalidArgumentException;

/**
 * Class LinkGenerator
 *
 * @package Peakgames\CrmValidator
 */
final class LinkGenerator
{
    /**
     * @var string
     */
    private $endpoint;

    /**
     * @var Returnable
     */
    private $returnable;

    /**
     * @var SignTool
     */
    private $signTool;

    /**
     * @param string     $endpoint
     * @param Returnable $returnable
     * @param SignTool   $signTool
     *
     * @internal param array $params
     */
    public function __construct($endpoint, Returnable $returnable, SignTool $signTool)
    {
        if (filter_var($endpoint, FILTER_VALIDATE_URL) === false)
        {
            throw new InvalidArgumentException(sprintf("Endpoint \"%s\" must be a valid URL.", $endpoint));
        }

        $this->endpoint   = $endpoint;
        $this->returnable = $returnable;
        $this->signTool   = $signTool;
    }

    /**
     * @return SignedRequest
     */
    public function generate()
    {
        $payload = json_encode($this->returnable, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

        $signedPayload = $this->signTool->sign($payload);

        return new SignedRequest($this->endpoint, http_build_query($signedPayload));
    }
}