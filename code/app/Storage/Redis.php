<?php


namespace App\Storage;


class Redis
{
    public const STORAGE_TIME_AGGREGATIONS_IN_MINUTES = 60 * 24;

    public static function getKeyName( string $type, string $category, string $id ) : string
    {
        return $type . ':' . $category . '#' . $id;
    }

}
