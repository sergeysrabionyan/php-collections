<?php
/**
 * @author Maxim Sokolovsky
 */

namespace WS\Utils\Collections;

class ArrayList extends AbstractCollection implements ListSequence
{

    public function stream(): Stream
    {
        return new SerialStream($this);
    }

    public function get(int $index)
    {
        return $this->elements[$index];
    }

    public function set($el, int $index)
    {
        $res = $this->elements[$index];
        $this->elements[$index] = $el;

        return $res;
    }

    public function indexOf($el): ?int
    {
        return array_search($el, $this->elements, true) ?: null;
    }

    public function remove($element): bool
    {
        $hashCodeRemoved = false;
        if ($element instanceof HashCodeAware) {
            $hashCodeRemoved = $this->removeThroughHashCode($element);
        }
        if ($hashCodeRemoved) {
            return true;
        }
        $key = array_search($element, $this->elements, true);
        if (false === $key) {
            return false;
        }
        $this->removeAt($key);
        return true;
    }

    public function lastIndexOf($el): ?int
    {
        $reverseIndex = array_search($el, array_reverse($this->elements), true);
        if ($reverseIndex === false) {
            return null;
        }

        return count($this->elements) - $reverseIndex - 1;
    }

    public function removeAt(int $index)
    {
        $size = $this->size();
        if (!isset($this->elements[$index]) || $size < $index + 1) {
            return null;
        }

        $el = $this->elements[$index];
        unset($this->elements[$index]);
        $this->elements = array_values($this->elements);

        return $el;
    }

    private function removeThroughHashCode(HashCodeAware $element): bool
    {
        foreach ($this->elements as $i => $iElement) {
            if ($iElement instanceof HashCodeAware && $iElement->getHashCode() === $element->getHashCode()) {
                $this->removeAt($i);
                return true;
            }
        }
        return false;
    }
}
