<?php

namespace Animir\TraitCache\Cache;

/**
 * @author Animir
 */
class CacheHelper
{
    protected static $prefix = "cache";
    protected static $delimiter = ":";
    
    const TRAITCACHE_METHOD_POSTFIX = '__fromCache';    
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
     * Generate cache key
     * 
     * @param mixed $argv,... unlimited OPTIONAL number of additional variables
     * @throws \InvalidArgumentException
     * @return string
     */
    public static function generateKey()
    {
        $args = func_get_args();
        if (empty($args)) {
            throw new \InvalidArgumentException('At least one argument must be passed to generate key.');
        }
        $implodedArgs = CacheHelper::implodeArgs($args);
        
        return self::$prefix . self::$delimiter . $implodedArgs;
    }
    
    /**
     * Implode mixed data into string with delimiter self::$delimiter
     * 
     * @param mixed $args
     * @return string
     */
    private static function implodeArgs($args) 
    {
        $result = '';
        foreach ($args as $key => $value) {
            if (!is_scalar($value)) {
                if (!is_array($value)) {
                    $value = (array) $value;
                }
                $value = CacheHelper::implodeArgs($value);
            }
            if (is_bool($value)) {
                $value = (int) $value;
            }
            $result .= $value . self::$delimiter;
        }
        
        $result = rtrim($result, self::$delimiter);
        
        return $result;
    }
    /**
     * If method name has postfix CacheHelper::TRAITCACHE_METHOD_POSTFIX
     * return TRUE, else return FALSE
     * 
     * @param string $method
     * @return boolean
     */
    
    public static function isTraitCacheMethodName($method)
    {
        if (mb_strpos($method, CacheHelper::TRAITCACHE_METHOD_POSTFIX) && strcmp(
                        mb_substr($method, mb_strlen($method) - mb_strlen(CacheHelper::TRAITCACHE_METHOD_POSTFIX)), CacheHelper::TRAITCACHE_METHOD_POSTFIX) == 0
        ) {
            return true;
        }
        return false;
    }

}
