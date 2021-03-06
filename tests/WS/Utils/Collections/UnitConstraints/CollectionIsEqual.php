<?php
/**
 * @author Maxim Sokolovsky
 */

namespace WS\Utils\Collections\UnitConstraints;

use WS\Utils\Collections\Collection;

class CollectionIsEqual extends CollectionComparingConstraint
{

    public function comparingResult(Collection $expectedCollection, Collection $other): bool
    {
        return $expectedCollection->equals($other);
    }
}
