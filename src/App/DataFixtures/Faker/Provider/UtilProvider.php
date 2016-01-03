<?php
namespace App\DataFixtures\Faker\Provider;

class UtilProvider
{
    /**
     * @param array $array
     * @param string $glue
     * @return string
     */
    public static function join(array $array, string $glue)
    {
        return join($glue, $array);
    }
}
