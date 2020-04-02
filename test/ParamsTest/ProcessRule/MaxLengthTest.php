<?php

declare(strict_types=1);

namespace ParamsTest\ProcessRule;

use ParamsTest\BaseTestCase;
use Params\ProcessRule\MaxLength;
use Params\ParamsValuesImpl;
use Params\Path;

/**
 * @coversNothing
 */
class MaxLengthTest extends BaseTestCase
{
    public function provideMaxLengthCases()
    {
        $maxLength = 10;
        $underLengthString = str_repeat('a', $maxLength - 1);
        $exactLengthString = str_repeat('a', $maxLength);
        $overLengthString = str_repeat('a', $maxLength + 1);

        return [
            [$maxLength, $underLengthString, false],
            [$maxLength, $exactLengthString, false],
            [$maxLength, $overLengthString, true],
        ];
    }

    /**
     * @dataProvider provideMaxLengthCases
     * @covers \Params\ProcessRule\MaxLength
     */
    public function testValidation(int $maxLength, string $string, bool $expectError)
    {
        $rule = new MaxLength($maxLength);
        $validator = new ParamsValuesImpl();
        $validationResult = $rule->process(
            Path::fromName('foo'),
            $string,
            $validator
        );

        if ($expectError === false) {
            $this->assertEmpty($validationResult->getValidationProblems());
        }
        else {
            $this->assertNotNull($validationResult->getValidationProblems());
        }
    }
}