<?php

declare(strict_types=1);

namespace Params\ExtractRule;

use Params\DataLocator\InputStorageAye;
use Params\Messages;
use Params\OpenApi\ParamDescription;
use Params\ProcessedValues;
use Params\ValidationResult;
use VarMap\VarMap;
use Params\Path;

class GetString implements ExtractRule
{
    public function process(
        ProcessedValues $processedValues,
        InputStorageAye $dataLocator
    ): ValidationResult {
        if ($dataLocator->valueAvailable() !== true) {
            return ValidationResult::errorResult($dataLocator, Messages::VALUE_NOT_SET);
        }

        $value = $dataLocator->getCurrentValue();

        if (is_array($value) === true) {
            return ValidationResult::errorResult($dataLocator, Messages::STRING_EXPECTED_BUT_FOUND_NON_SCALAR);
        }

        if (is_scalar($value) !== true) {
            return ValidationResult::errorResult(
                $dataLocator,
                Messages::STRING_EXPECTED_BUT_FOUND_NON_SCALAR,
            );
        }

        // TODO - reject bools/ints?
        // TODO - needs string input
        $value = (string)$dataLocator->getCurrentValue();

        return ValidationResult::valueResult($value);
    }

    public function updateParamDescription(ParamDescription $paramDescription): void
    {
        $paramDescription->setType(ParamDescription::TYPE_STRING);
        $paramDescription->setRequired(true);
    }
}
