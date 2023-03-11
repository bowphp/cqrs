<?php

namespace Bow\Test\Fixtures;

class PetFinder
{
    public static function find($id)
    {
        $pets = file_get_contents(__DIR__.'/pets.json');

        return $pets[$id - 1] ?? [];
    }
}
