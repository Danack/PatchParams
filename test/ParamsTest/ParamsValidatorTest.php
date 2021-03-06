<?php

declare(strict_types=1);

namespace ParamsTest\Exception\Validator;

use Params\ExtractRule\GetInt;
use Params\InputParameter;
use Params\ProcessRule\MaxIntValue;
use ParamsTest\BaseTestCase;
use VarMap\ArrayVarMap;
use Params\ProcessedValuesImpl;
use Params\ProcessRule\AlwaysEndsRule;
use Params\Path;
use Params\DataLocator\DataStorage;
use function Params\processInputParameter;

/**
 * @coversNothing
 */
class ParamsValidatorTest extends BaseTestCase
{

//    public function testMissingRuleThrows()
//    {
//        $this->markTestSkipped("does this provide useful info?");
////        $validator = new ParamsValidator();
////        $this->expectException(\Params\Exception\ParamsException::class);
////        $validator->validate('foobar', []);
//    }

//    public function testInvalidInputThrows()
//    {
//        $arrayVarMap = new ArrayVarMap([]);
//        $validator = new ParamsValuesImpl();
//
//        $value = $validator->validateRulesForParam(
//            'foo',
//            $arrayVarMap,
//            new GetInt()
//        );
//
//        $this->assertNull($value);
//        $errors = $validator->getValidationProblems();
//
//        $this->assertEquals(1, count($errors));
//        $this->assertStringMatchesFormat(GetInt::ERROR_MESSAGE, $errors['/foo']);
//    }

    /**
     * @covers \Params\ProcessedValuesImpl
     */
    public function testFinalResultStopsProcessing()
    {
        $finalValue = 123;

        $param = new InputParameter(
            'foo',
            new GetInt(),
            // This rule will stop processing
            new AlwaysEndsRule($finalValue),
            // this rule would give an error if processing was not stopped.
            new MaxIntValue($finalValue - 5)
        );

        $processedValues = new ProcessedValuesImpl();

        $errors = processInputParameter(
            $param,
            $processedValues,
            DataStorage::fromArray(['foo' => 5])
        );

        $this->assertNoValidationProblems($errors);

        $this->assertTrue($processedValues->hasValue('foo'));
        $value = $processedValues->getValue('foo');

        $this->assertEquals($finalValue, $value);
    }
}
