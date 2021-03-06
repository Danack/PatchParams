<?php

declare(strict_types = 1);

namespace Params\Exception;

class InvalidRulesException extends \Params\Exception\ParamsException
{
    /**
     * @param mixed $badValue
     * @return InvalidRulesException
     */
    public static function badTypeForArrayAccess($badValue)
    {
        $message = sprintf(
            "Cannot use type %s for array access",
            gettype($badValue)
        );

        return new self($message);
    }
}
