<?php
namespace Animir\TraitCache\Cache;

use Animir\TraitCache\Cache\CacheProvider;
use Zend\Cache\Storage;
/**
 * Description of TraitCache
 *
 * @author Animir
 */
trait TraitCache {
    /**
     * @var CacheProvider\CacheProvider 
     */
    private $__traitcacheCacheProvider;
    private $__traitcacheIsInit = false;
    /**
     * 
     * @param \Zend\Cache\Storage\StorageInterface $cache
     */
    public function __traitcache__init(Storage\StorageInterface $cache) {
        $this->__traitcacheCacheProvider = new CacheProvider($cache);
        $this->__traitcacheIsInit = true;
    }
    
    /**
     * All the results of all methods will be placed in the cache
     * after first call.
     * 
     * If your class have method with such name, 
     * you must use $this->__traitcache__call() method
     * in your __call() method.
     * 
     * @param string $method
     * @param mixed $args
     * @return mixed
     */
    public function __call($method, $args) {
        return $this->__traitcache__get($method, $args);
    }
    
    private function __traitcache__call($method, $args) {
        return $this->__traitcache__get($method, $args);
    }
    
    private function __traitcache__get($method, $args) {        
        if ($this->_traitcache_is_init) {
            $key = CacheProvider::generateKey(get_class(), $method, implode(':', $args));
            $result = $this->__traitcache__work($key);
            return $result;
        }
    }
       
    private function __traitcache__work($key) {        
        $result = $this->__traitcacheCacheProvider->getItem($key);
        if (is_null($result)) {
            $result = call_user_func_array([$this, $method], $args);
            $this->__traitcacheCacheProvider->setItem($key, $result);
        }
        return $result;
    }

}
