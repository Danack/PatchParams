<?php

declare(strict_types = 1);

namespace ParamsTest\Patch\Email;

use Params\ExtractRule\GetInt;
use Params\ExtractRule\GetString;
use Params\InputParameter;
use Params\ProcessRule\MaxIntValue;
use Params\ProcessRule\MinIntValue;
use Params\SafeAccess;
use Params\ProcessRule\MinLength;
use Params\ProcessRule\MaxLength;
use Params\ScalarPatchInput;

class CheckAdminEmailMatches implements \Params\PatchInputParameterList
{
    use SafeAccess;

    /** @var string */
    private $email;

    /**
     *
     * @param string $name
     * @param string $description
     * @param int $price_eur
     * @param int $price_gbp
     * @param int $price_usd
     */
    public function __construct(string $email)
    {
        $this->email = $email;
    }

    public static function getPatchInputParameterList()
    {
        return [
            new ScalarPatchInput(
                new GetString()
            ),
        ];
    }
}
