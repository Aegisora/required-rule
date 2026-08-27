<?php

namespace Aegisora\Rules;

use Aegisora\RuleContract\Models\Context;
use Aegisora\RuleContract\Models\Result;
use Aegisora\RuleContract\Rule;

class RequiredRule extends Rule
{
    public static function create(): self
    {
        return new self();
    }

    protected function executeValidate(Context $context): Result
    {
        return ($context->getValue() !== null) ?
            $this->getDefaultValidResult() :
            $this->getDefaultInvalidResult();
    }
}
