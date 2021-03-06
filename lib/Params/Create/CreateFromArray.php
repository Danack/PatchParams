<?php

declare(strict_types=1);

namespace Params\Create;

use Params\DataLocator\DataStorage;
use VarMap\ArrayVarMap;
use VarMap\VarMap;
use function Params\create;

/**
 * Use this trait when the parameters arrive as named parameters e.g
 * either as query string parameters, form elements, or other form body.
 */
trait CreateFromArray
{
    /**
     * @param VarMap $variableMap
     * @return self
     * @throws \Params\Exception\RulesEmptyException
     * @throws \Params\Exception\ValidationException
     */
    public static function createFromArray($data)
    {
        $rules = static::getInputParameterList();

        $dataLocator = DataStorage::fromArray($data);

        $variableMap = new ArrayVarMap($data);
        $object = create(
            static::class,
            $rules,
            $variableMap,
            $dataLocator
        );

        /** @var $object self */
        return $object;
    }
}
