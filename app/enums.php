<?php

abstract class BaseEnum
{
    private static $cache = null;

    private static function constCache()
    {
        if (self::$cache === null) {
            self::$cache = [];
        }

        $calledClass = get_called_class();

        if (!array_key_exists($calledClass, self::$cache)) {
            self::$cache[$calledClass] = (new \ReflectionClass($calledClass))->getConstants();
        }

        return self::$cache[$calledClass];
    }

    public static function getConstants()
    {
        return self::constCache();
    }

    public static function getNames()
    {
        return array_keys(self::constCache());
    }

    public static function getValues()
    {
        return array_values(self::constCache());
    }

    public static function isValidName($name)
    {
        return isset(array_change_key_case(self::constCache(), CASE_LOWER)[strtolower($name)]);
    }

    public static function isValidValue($value)
    {
        return in_array($value, self::constCache(), true);
    }

    public static function toName($value)
    {
        $name = array_search($value, self::constCache(), true);

        if ($name === false) {
            throw new Exception('Undefined value: '.$value);
        }

        return $name;
    }

    public static function toValue($name)
    {
        $lowerConstCache = array_change_key_case(self::constCache(), CASE_LOWER);
        $lowerName = strtolower($name);

        if (!isset($lowerConstCache[$lowerName])) {
            throw new Exception('Undefined name: '.$name);
        }

        return $lowerConstCache[$lowerName];
    }
}

abstract class AdminRole extends BaseEnum
{
    const ROOT = 0;
    const ADMIN = 1;
}

abstract class AdminStatus extends BaseEnum
{
    const DELETE = 0;
    const ACTIVE = 1;
    const DISABLE = 2;
}

abstract class MemberRole extends BaseEnum
{
    const AGENT = 0;
    const SUBAGENT = 1;
    const PLAYER = 2;
    const GUEST = 3;
}

abstract class MemberType extends BaseEnum
{
    const CASH = 0;
    const CREDIT = 1;
}

abstract class MemberStatus extends BaseEnum
{
    const DELETE = 0;
    const ACTIVE = 1;
    const DISABLE = 2;
}

abstract class GameCategory extends BaseEnum
{
    const SLOT_MACHINE = 0;
    const VIDEO_POKER = 1;
    const TABLE_GAME = 2;
}

abstract class GameStatus extends BaseEnum
{
    const PRIVATE = 0;
    const PUBLIC = 1;
    const PREVIEW = 2;
}
