<?php

namespace Aegisora\Rules\Tests\Unit;

use Aegisora\RuleContract\Models\Context;
use Aegisora\RuleContract\Models\Result;
use Aegisora\RuleContract\RuleInterface;
use Aegisora\Rules\RequiredRule;
use PHPUnit\Framework\TestCase;
use stdClass;

class RequiredRuleTest extends TestCase
{
    private RequiredRule $requiredRule;

    protected function setUp(): void
    {
        parent::setUp();

        $this->requiredRule = new RequiredRule();
    }

    public function testCreate(): void
    {
        self::assertInstanceOf(RuleInterface::class, RequiredRule::create());
    }

    /**
     * @dataProvider getValidateProvidedData
     */
    public function testValidate(
        Context $context,
        array $expectedResult
    ): void {
        self::assertActualResultEqualsExpected(
            $this->requiredRule->validate($context),
            $expectedResult
        );
    }

    public static function getValidateProvidedData(): array
    {
        return [
            'context value - zero integer' => [
                'context' => Context::create(0),
                'expectedResult' => [
                    'isValid' => true,
                    'failedRuleCode' => null,
                ],
            ],
            'context value - positive integer' => [
                'context' => Context::create(1),
                'expectedResult' => [
                    'isValid' => true,
                    'failedRuleCode' => null,
                ],
            ],
            'context value - negative integer' => [
                'context' => Context::create(-1),
                'expectedResult' => [
                    'isValid' => true,
                    'failedRuleCode' => null,
                ],
            ],
            'context value - zero float' => [
                'context' => Context::create(0.0),
                'expectedResult' => [
                    'isValid' => true,
                    'failedRuleCode' => null,
                ],
            ],
            'context value - negative float' => [
                'context' => Context::create(-0.01),
                'expectedResult' => [
                    'isValid' => true,
                    'failedRuleCode' => null,
                ],
            ],
            'context value - false' => [
                'context' => Context::create(false),
                'expectedResult' => [
                    'isValid' => true,
                    'failedRuleCode' => null,
                ],
            ],
            'context value - true' => [
                'context' => Context::create(true),
                'expectedResult' => [
                    'isValid' => true,
                    'failedRuleCode' => null,
                ],
            ],
            'context value - empty string' => [
                'context' => Context::create(''),
                'expectedResult' => [
                    'isValid' => true,
                    'failedRuleCode' => null,
                ],
            ],
            'context value - not empty string' => [
                'context' => Context::create('foo'),
                'expectedResult' => [
                    'isValid' => true,
                    'failedRuleCode' => null,
                ],
            ],
            'context value - zero string' => [
                'context' => Context::create('0'),
                'expectedResult' => [
                    'isValid' => true,
                    'failedRuleCode' => null,
                ],
            ],
            'context value - empty array' => [
                'context' => Context::create([]),
                'expectedResult' => [
                    'isValid' => true,
                    'failedRuleCode' => null,
                ],
            ],
            'context value - not empty array' => [
                'context' => Context::create([1, 2, 3]),
                'expectedResult' => [
                    'isValid' => true,
                    'failedRuleCode' => null,
                ],
            ],
            'context value - object' => [
                'context' => Context::create(new stdClass()),
                'expectedResult' => [
                    'isValid' => true,
                    'failedRuleCode' => null,
                ],
            ],
            'context value - callable' => [
                'context' => Context::create(
                    static function () {
                    }
                ),
                'expectedResult' => [
                    'isValid' => true,
                    'failedRuleCode' => null,
                ],
            ],
            'context value - null' => [
                'context' => Context::create(null),
                'expectedResult' => [
                    'isValid' => false,
                    'failedRuleCode' => 'required_rule',
                ],
            ],
        ];
    }

    private static function assertActualResultEqualsExpected(
        Result $result,
        array $expectedResult
    ): void {
        self::assertEquals($expectedResult['isValid'], $result->isValid());
        self::assertEquals($expectedResult['failedRuleCode'], $result->getFailedRuleCode());
    }
}
