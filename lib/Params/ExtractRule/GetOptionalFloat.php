<?php

declare(strict_types=1);

namespace Params\ExtractRule;

use Params\DataLocator\InputStorageAye;
use Params\ProcessRule\FloatInput;
use Params\ValidationResult;
use VarMap\VarMap;
use Params\OpenApi\ParamDescription;
use Params\ProcessedValues;
use Params\Path;

/**
 *
 * If a parameter is not set, then the value is null, otherwise
 * it must be a valid integer.
 *
 */
class GetOptionalFloat implements ExtractRule
{
    public function process(
        ProcessedValues $processedValues,
        InputStorageAye $dataLocator
    ): ValidationResult {
        if ($dataLocator->valueAvailable() !== true) {
            return ValidationResult::valueResult(null);
        }

        $intRule = new FloatInput();
        return $intRule->process(
            $dataLocator->getCurrentValue(),
            $processedValues,
            $dataLocator
        );
    }

    public function updateParamDescription(ParamDescription $paramDescription): void
    {
        $paramDescription->setType(ParamDescription::TYPE_NUMBER);
        $paramDescription->setRequired(false);
    }
}
