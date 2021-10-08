<?php declare(strict_types=1);


namespace Fabric;


use JetBrains\PhpStorm\Pure;

final class Area
{
    private int $width;
    private int $length;

    public function __construct(int $width, int $length)
    {
        $this->width = $width;
        $this->length = $length;
    }

    #[Pure]
    public static function create(int $width, int $height): Area
    {
        return new Area($width, $height);
    }

    /**
     * @return int
     */
    public function getWidth(): int
    {
        return $this->width;
    }

    /**
     * @return int
     */
    public function getLength(): int
    {
        return $this->length;
    }


    public function size() : int
    {
        return $this->getLength() * $this->getWidth();
    }

}