<?php

declare(strict_types = 1);

namespace Params\ProcessRule;

use Params\DataLocator\InputStorageAye;
use Params\OpenApi\ParamDescription;
use Params\ProcessedValues;
use Params\ValidationResult;

/**
 * Takes input data and converts it to a bool value, or
 * generates appropriate validationProblems.
 */
class BoolInput implements ProcessRule
{
    public function process(
        $value,
        ProcessedValues $processedValues,
        InputStorageAye $dataLocator
    ): ValidationResult {
        if (is_bool($value) === true) {
            return ValidationResult::valueResult($value);
        }

        if (is_string($value) === true) {
            if ($value === 'true' ||
                $value === '1') {
                return ValidationResult::valueResult(true);
            }

            return ValidationResult::valueResult(false);
        }

        if (is_integer($value) === true) {
            if ($value === 0) {
                return ValidationResult::valueResult(false);
            }
            return ValidationResult::valueResult(true);
        }

        if ($value === null) {
            return ValidationResult::valueResult(false);
        }

        $message = sprintf(
            "Unsupported input type of '%s'",
            gettype($value)
        );

        return ValidationResult::errorResult($dataLocator, $message);
    }

    public function updateParamDescription(ParamDescription $paramDescription): void
    {
        $paramDescription->setType(ParamDescription::FORMAT_BOOLEAN);
    }
}
