<?php

declare(strict_types=1);

namespace Params\Create;

use Params\ParamsExecutor;
use VarMap\VarMap;

trait CreateOrErrorFromVarMap
{
    /**
     * @param VarMap $variableMap
     * @return array<?object, \Params\ValidationProblem[]>
     * @throws \Params\Exception\RulesEmptyException
     * @throws \Params\Exception\ValidationException
     */
    public static function createOrErrorFromVarMap(VarMap $variableMap)
    {
        // TODO - change

        $namedRules = static::getInputToParamInfoList();

        return ParamsExecutor::createOrError(static::class, $namedRules, $variableMap);
    }
}
