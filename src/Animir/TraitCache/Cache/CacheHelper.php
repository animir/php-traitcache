<?php

namespace Animir\TraitCache\Cache\CacheHelper;

/**
 * @author Animir
 */
class CacheHelper
{
    protected static $prefix = "cache";
    protected static $delimiter = ":";

    /**
     * @param string $prefix
     */
    public static function setPrefix($prefix)
    {
        self::$prefix = $prefix;
    }

    /**
     * @param string $delimiter
     */
    public static function setDelimiter($delimiter)
    {
        self::$delimiter = $delimiter;
    }

    /**
     * Generate cache key.
     * @throws \InvalidArgumentException
     * @return string
     */
    public static function generateKey()
    {
        $args = func_get_args();
        if (empty($args)) {
            throw new \InvalidArgumentException('At least one argument must be passed to generate key.');
        }
        return self::$prefix . self::$delimiter . implode(self::$delimiter, $args);
    }

}
