<?php

declare(strict_types=1);

namespace ParamsTest\ProcessRule;

use Params\DataLocator\DataStorage;
use ParamsTest\BaseTestCase;
use Params\ProcessRule\AlwaysEndsRule;
use Params\ProcessedValuesImpl;
use VarMap\ArrayVarMap;
use Params\Path;
use function Params\createPath;

/**
 * @coversNothing
 */
class AlwaysEndsRuleTest extends BaseTestCase
{
    /**
     * @covers \Params\ProcessRule\AlwaysEndsRule
     */
    public function testUnknownFilterErrors()
    {
        $finalValue = 123;
        $rule = new AlwaysEndsRule($finalValue);
        $processedValues = new ProcessedValuesImpl();
        $dataLocator = DataStorage::fromArraySetFirstValue([]);
        $result = $rule->process(
            $unused_input = 4,
            $processedValues,
            $dataLocator
        );

        $this->assertNoValidationProblems($result->getValidationProblems());
        $this->assertTrue($result->isFinalResult());
        $this->assertEquals($finalValue, $result->getValue());
    }
}
