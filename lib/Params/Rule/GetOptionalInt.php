<?php

declare(strict_types=1);

namespace Params\Rule;

use Params\Rule;
use Params\ValidationResult;
use VarMap\VarMap;

/**
 * Class GetOptionalInt
 *
 * If a parameter is not set, then the value is null, otherwise
 * it must be a valid integer.
 *
 */
class GetOptionalInt implements Rule
{
    /** @var VarMap */
    private $variableMap;

    const ERROR_MESSAGE = 'Value not set for %s.';

    public function __construct(VarMap $variableMap)
    {
        $this->variableMap = $variableMap;
    }

    /**
     * @inheritdoc
     */
    public function __invoke(string $variableName, $_) : ValidationResult
    {
        if ($this->variableMap->has($variableName) !== true) {
            return ValidationResult::valueResult(null);
        }

        $intRule = new IntegerInput();
        return $intRule($variableName, $this->variableMap->get($variableName));
    }
}
