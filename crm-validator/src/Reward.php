<?php namespace Peakgames\CRM\Validator;

use InvalidArgumentException;

/**
 * Class Reward
 *
 * @package Peakgames\CrmValidator
 */
class Reward implements Returnable
{
    /**
     * @var string
     */
    private $uid;

    /**
     * @var string
     */
    private $type;

    /**
     * @var int
     */
    private $amount;

    /**
     * @var int
     */
    private $status;

    /**
     * @var string
     */
    private $statusReason;

    /**
     * @param string $uid
     * @param string $type
     * @param int    $amount
     * @param int    $status
     * @param string $statusReason
     */
    public function __construct($uid = null, $type = null, $amount = null, $status = null, $statusReason = null)
    {
        $this->uid          = $uid;
        $this->type         = $type;
        $this->amount       = $amount;
        $this->status       = $status;
        $this->statusReason = $statusReason;
    }

    /**
     * @param string $json
     *
     * @return Reward
     *
     * @throws InvalidArgumentException
     */
    public function populateFromJsonString($json)
    {
        $decoded = json_decode($json);

        if (json_last_error() !== JSON_ERROR_NONE)
        {
            throw new InvalidArgumentException("Invalid JSON string.");
        }

        $this->uid          = isset($decoded->uid) ? $decoded->uid : null;
        $this->type         = isset($decoded->type) ? $decoded->type : null;
        $this->amount       = isset($decoded->amount) ? $decoded->amount : null;
        $this->status       = isset($decoded->status) ? $decoded->status : null;
        $this->statusReason = isset($decoded->statusReason) ? $decoded->statusReason : null;
    }

    /**
     * @return string
     */
    public function getUid()
    {
        return $this->uid;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return int
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @return string
     */
    public function getStatusReason()
    {
        return $this->statusReason;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return [
            'uid'          => $this->uid,
            'type'         => $this->type,
            'amount'       => $this->amount,
            'status'       => $this->status,
            'statusReason' => $this->statusReason,
        ];
    }
}