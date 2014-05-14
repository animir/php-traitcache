<?php

namespace Animir\TraitCache;

use Animir\TraitCache\Cache\CacheAdapter;
use Animir\TraitCache\Cache\CacheHelper;
use Zend\Cache\Storage\StorageInterface;

/**
 * Description of TraitCache
 *
 * @author Animir
 */
trait TraitCache
{

    /**
     * @var CacheAdapter
     */
    protected $__traitcacheCacheAdapter;
    protected $__traitcacheIsInit = false;

    /**
     * 
     * @param \Zend\Cache\Storage\StorageInterface $cache
     */
    public function __traitcache__init(StorageInterface $cache, array $config = [] )
    {
        $this->__traitcacheCacheAdapter = new CacheAdapter($cache, $config /* TODO config */);
        $this->__traitcacheIsInit = true;
    }

    /**
     * All the results of configured methods will be placed in the cache
     * after first call.
     * 
     * If your class have method with such name, 
     * you must use $this->__traitcache__call() method
     * in your __call() method.
     * 
     * @param string $method
     * @param mixed $args
     * @return mixed
     * @throws \Exception
     */
    public function __call($method, $args)
    {
        if (CacheHelper::isTraitCacheMethodName($method)) {
            return $this->__traitcache__get($method, $args);
        }
        
        throw new \Exception('Method \'' . $method . '\' in class \'' . get_class($this) . '\' not exists');
    }

    public function __traitcache__call($method, array $args)
    {
        if (CacheHelper::isTraitCacheMethodName($method)) {
            return $this->__traitcache__get($method, $args);
        }
    }

    /**
     * Check method name and config for them and work with cache
     * 
     * @param string $method
     * @param mixed $args
     * @return mixed
     * @throws \Exception
     */
    private function __traitcache__get($method, &$args)
    {
        $method = mb_substr($method, 0, mb_strlen($method) - mb_strlen(CacheHelper::TRAITCACHE_METHOD_POSTFIX));
        if (!is_callable( [get_class($this), $method] )) {
            throw new \Exception('Method \'' . $method . '\' in class \'' . get_class($this) . '\' not exists');
        }
        if ($this->__traitcacheIsInit && $this->__traitcacheCacheAdapter->canWorkWithCache(get_class($this), $method)) {
            $result = $this->__traitcache__work($method, $args);
            return $result;
        } else {
            return call_user_func_array( [$this, $method] , $args);
        }
    }

    /**
     * Work with cache for $method with arguments $args
     *      
     * @param string $method
     * @param mixed $args
     * @return mixed
     * @throws \Exception
     */
    private function __traitcache__work($method, &$args)
    {
        $key = CacheHelper::generateKey(get_class($this), $method, $args);
        $result = $this->__traitcacheCacheAdapter->getItem($key);
        if (is_null($result)) {
            $result = call_user_func_array( [$this, $method] , $args);
            $this->__traitcacheCacheAdapter->setItem($key, $result);
        }
        return $result;
    }    

}
