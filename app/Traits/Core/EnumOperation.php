<?php

namespace App\Traits\Core;

use ReflectionClass;

trait EnumOperation
{
    public static function names(): array
    {
        $reflection = new ReflectionClass(static::class);
        $constants = $reflection->getConstants();

        $names = [];
        foreach ($constants as $name => $value) {
            $names[] = $name;
        }
        return $names;
    }

    public static function values(): array
    {
        $reflection = new ReflectionClass(static::class);
        $constants = $reflection->getConstants();

        $values = [];
        foreach ($constants as $value) {
            $values[] = $value;
        }

        return $values;
    }


    public static function options(): array
    {
        $reflection = new ReflectionClass(static::class);
        $constants = $reflection->getConstants();

        $options = [];
        foreach ($constants as $name => $value) {
            $options[$name] = $value;
        }
        return $options;
    }


    public static function toArray(): array
    {
        $reflection = new ReflectionClass(static::class);
        $constants = $reflection->getConstants();

        $arrays = [];
        foreach ($constants as $value) {
            $arrays[] = $value;
        }

        $arrays = array_map(function($item){
            return (array) $item;
        },$arrays);

        return $arrays;
    }


    public static function getName($name): string
    {
        $reflection = new ReflectionClass(static::class);
        $constants = $reflection->getConstants();

        $item = null;
        foreach ($constants as $key => $value) {
            if($key == $name){
                $item = $name;
            }
        }
        return $item;
    }

    public static function getValue($valueParam): string
    {
        $reflection = new ReflectionClass(static::class);
        $constants = $reflection->getConstants();

        $item = null;
        foreach ($constants as $key => $value) {
            if($valueParam == $key){
                $item = $value;
            }
        }
        return $item;
    }


    public static function getKeyValue($valueName): array
    {
        $reflection = new ReflectionClass(static::class);
        $constants = $reflection->getConstants();
        $item = null;
        foreach ($constants as $key => $value) {
            if($key == $valueName){
                $item = [$key => $value];
            }
        }
        return $item;
    }
}
