# CRM Validator
This project requires [Composer](https://getcomposer.org/) to install and use (i.e, your project must use Composer as its autoloader).

## Installation
Add the [Peak Games Composer Repository](http://composer.peakgames.net:9191/) to your `composer.json`:

```json
"repositories": [
    {
      "type": "composer",
      "url": "http://composer.peakgames.net:9191"
    }
]
```
Then install the validator with:
```bash
$ composer require peakgames/crm-validator ~1.0
```

## Usage

### Validating Requests

You need to use `Peakgames\CRM\Validator\Validator` with your shared secret `key`. For example:

```php
use Peakgames\CRM\Validator\Validator;
use Peakgames\CRM\Validator\SignTool;
use Peakgames\CRM\Validator\Reward;

$validator = new Validator(new SignTool($mySecretKey));

if ($validator->isValid())
{
    /** @var Reward $reward */
    $reward = $validator->getReturnable(Reward::class);

    $uid    = $reward->getUid();
    $type   = $reward->getType();
    $amount = $reward->getAmount();
    $status = $reward->getStatus();
    $reason = $reward->getStatusReason();

    /**
     * If you need a unique identifier for this request, use this
     */
    $validator->getUniquePayloadIdentifier();
}
```

Note that `Validator` has an optional second parameter to its constructor where you can pass the payload from CRM yourself. Without it, `Validator` will use the `$_REQUEST` array to look for the payload and signature.

### Lookup Table for Status Values

| Status | Status Reason           |
|--------|-------------------------|
| 0      | Reward valid            |
| 1      | Reward expired          |
| 2      | Reward already received |
| 3      | Reward already received |
