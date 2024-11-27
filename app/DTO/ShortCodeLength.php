<?php

namespace App\DTO;

use InvalidArgumentException;
class ShortCodeLength
{
    public int $length;

    /**
     * ShortCodeGenerationDTO constructor.
     *
     * @param int|null $length
     * @throws InvalidArgumentException
     */
    public function __construct(int $length = null)
    {
        $this->setLength($length);
    }

    /**
     * Set and validate the length.
     *
     * @param int|null $length
     * @throws InvalidArgumentException
     */
    private function setLength(?int $length): void
    {
        if ($length === null) {
            $this->length = 6;
        } elseif ($length === 6) {
            $this->length = $length;
        } else {
            throw new InvalidArgumentException("Length must be exactly 6 characters.");
        }
    }
}
