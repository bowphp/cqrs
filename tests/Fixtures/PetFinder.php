<?php

namespace Bow\Tests\CQRS\Fixtures;

class PetFinder
{
    public static function all()
    {
        $data = file_get_contents(__DIR__ . '/pets.json');
        $pets = json_decode($data);

        return $pets;
    }

    public static function find($id)
    {
        $pets = static::all();

        foreach ($pets as $key => $pet) {
            if ($key + 1 === $id) {
                return (object) $pet;
            }
        }

        return null;
    }

    public static function create(array $data)
    {
        $pets = static::all();
        $pets[] = $data;

        file_put_contents(__DIR__ . '/pets.json', json_encode($pets));

        return count($pets);
    }

    public static function clear()
    {
        file_put_contents(__DIR__ . '/pets.json', '[]');
    }
}
