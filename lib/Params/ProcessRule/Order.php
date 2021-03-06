<?php

declare(strict_types = 1);

namespace Params\ProcessRule;

use Params\DataLocator\InputStorageAye;
use Params\Messages;
use Params\OpenApi\ParamDescription;
use Params\ProcessedValues;
use Params\ValidationResult;
use Params\Value\OrderElement;
use Params\Value\Ordering;
use function Params\array_value_exists;
use function Params\normalise_order_parameter;

/**
 * Class Order
 *
 * Supports a parameter to specify ordering of results
 * For example "+name,-date" would be equivalent to ordering
 * by name ascending, then date descending.
 */
class Order implements ProcessRule
{
    /** @var string[] */
    private array $knownOrderNames;

    /**
     * OrderValidator constructor.
     * @param string[] $knownOrderNames
     */
    public function __construct(array $knownOrderNames)
    {
        $this->knownOrderNames = $knownOrderNames;
    }

    public function process(
        $value,
        ProcessedValues $processedValues,
        InputStorageAye $dataLocator
    ): ValidationResult {
        $parts = explode(',', $value);
        $orderElements = [];

        foreach ($parts as $part) {
            list($partName, $partOrder) = normalise_order_parameter($part);
            if (array_value_exists($this->knownOrderNames, $partName) !== true) {
                $message = sprintf(
                    Messages::UNKNOWN_ORDERING,
                    $partName,
                    implode(', ', $this->knownOrderNames)
                );

                return ValidationResult::errorResult($dataLocator, $message);
            }
            $orderElements[] = new OrderElement($partName, $partOrder);
        }

        return ValidationResult::valueResult(new Ordering($orderElements));
    }

    public function updateParamDescription(ParamDescription $paramDescription): void
    {
        $paramDescription->setType(ParamDescription::TYPE_ARRAY);
        $paramDescription->setCollectionFormat(ParamDescription::COLLECTION_CSV);
    }
}
