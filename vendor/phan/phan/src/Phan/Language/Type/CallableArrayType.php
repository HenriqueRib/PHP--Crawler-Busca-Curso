<?php declare(strict_types=1);

namespace Phan\Language\Type;

use Phan\CodeBase;
use Phan\Language\UnionType;

/**
 * Phan's representation of the type for `callable-array`.
 */
class CallableArrayType extends ArrayType
{
    /** @phan-override */
    const NAME = 'callable-array';

    public function isAlwaysTruthy() : bool
    {
        return !$this->is_nullable;
    }

    public function isPossiblyObject() : bool
    {
        return false;  // Overrides IterableType returning true
    }

    public function isPossiblyTruthy() : bool
    {
        return true;
    }

    public function isPossiblyFalsey() : bool
    {
        return $this->is_nullable;
    }

    /**
     * @return UnionType int|string for arrays
     * @override
     */
    public function iterableKeyUnionType(CodeBase $unused_code_base) : UnionType
    {
        // Reduce false positive partial type mismatch errors
        return IntType::instance(false)->asPHPDocUnionType();
    }

    /**
     * @override
     */
    public function iterableValueUnionType(CodeBase $unused_code_base) : UnionType
    {
        return UnionType::fromFullyQualifiedPHPDocString('string|object');
    }
}
