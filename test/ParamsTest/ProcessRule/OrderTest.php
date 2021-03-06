<?php

declare(strict_types=1);

namespace ParamsTest\ProcessRule;

use Params\DataLocator\DataStorage;
use ParamsTest\BaseTestCase;
use Params\ProcessRule\Order;
use Params\Value\Ordering;
use Params\ProcessedValuesImpl;
use Params\Path;
use function Params\createPath;

/**
 * @coversNothing
 */
class OrderTest extends BaseTestCase
{
    public function provideTestCases()
    {
        return [
            ['time', ['time' => Ordering::ASC], false],
            ['bar', null, true],
        ];
    }

    /**
     * @dataProvider provideTestCases
     * @covers \Params\ProcessRule\Order
     */
    public function testValidation($testValue, $expectedOrdering, $expectError)
    {
        $orderParams = ['time', 'distance'];

        $rule = new Order($orderParams);
        $processedValues = new ProcessedValuesImpl();
        $dataLocator = DataStorage::fromArraySetFirstValue([]);

        $validationResult = $rule->process(
            $testValue, $processedValues, $dataLocator
        );

        if ($expectError === true) {
            $this->assertExpectedValidationProblems($validationResult->getValidationProblems());
            return;
        }

        $value = $validationResult->getValue();
        $this->assertInstanceOf(Ordering::class, $value);
        /** @var $value Ordering */
        $this->assertEquals($expectedOrdering, $value->toOrderArray());
    }
}
