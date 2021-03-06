<?php

declare(strict_types=1);

namespace ParamsTest\ExtractRule;

use Params\DataLocator\DataStorage;
use VarMap\ArrayVarMap;
use ParamsTest\BaseTestCase;
use Params\ExtractRule\GetInt;
use Params\ProcessedValuesImpl;
use Params\Path;
use Params\DataLocator\SingleValueInputStorageAye;
use Params\DataLocator\NotAvailableInputStorageAye;

/**
 * @coversNothing
 */
class GetIntTest extends BaseTestCase
{
    /**
     * @covers \Params\ExtractRule\GetString
     */
    public function testMissingGivesError()
    {
        $rule = new GetInt();
        $validator = new ProcessedValuesImpl();
        $validationResult = $rule->process(
            $validator, new NotAvailableInputStorageAye()
        );
        $this->assertExpectedValidationProblems($validationResult->getValidationProblems());
    }

    public function provideTestWorksCases()
    {
        return [
            ['5', 5],
            [5, 5],
        ];
    }

    /**
     * @covers \Params\ExtractRule\GetInt
     * @dataProvider provideTestWorksCases
     */
    public function testWorks($input, $expectedValue)
    {
        $validator = new ProcessedValuesImpl();
        $rule = new GetInt();
        $dataLocator  = DataStorage::fromSingleValue('foo', $input);

        $validationResult = $rule->process(
            $validator, $dataLocator
        );

        $this->assertNoValidationProblems($validationResult->getValidationProblems());
        $this->assertEquals($validationResult->getValue(), $expectedValue);
    }


    public function provideTestErrorCases()
    {
        yield [null];
        yield [''];
        yield ['6 apples'];
        yield ['banana'];
        // TODO add expected error string
    }

    /**
     * @covers \Params\ExtractRule\GetInt
     * @dataProvider provideTestErrorCases
     */
    public function testErrors($input)
    {
        $rule = new GetInt();
        $validator = new ProcessedValuesImpl();
        $dataLocator = DataStorage::fromSingleValue('foo', $input);

        $validationResult = $rule->process(
            $validator, $dataLocator
        );

        $this->assertExpectedValidationProblems($validationResult->getValidationProblems());
    }
}
