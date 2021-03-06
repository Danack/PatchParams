<?php

declare(strict_types=1);

namespace Params;

use Params\OpenApi\ParamDescription;

interface Rule
{
    public function updateParamDescription(ParamDescription $paramDescription): void;
}
