<?php

namespace Animir\TraitCache\Cache;

use Zend\Cache\Storage\StorageInterface;

class CacheAdapter implements StorageInterface
{

    /**
     * @var \Zend\Cache\Storage\StorageInterface
     */
    protected $cache;
    protected $config;

    /**
     * @param \Zend\Cache\Storage\StorageInterface $cache
     * @param array $config
     */
    public function __construct(StorageInterface $cache, array $config)
    {
        $this->cache = $cache;
        $this->config = $config;
    }
    
    /**
     * Check config for $class and $method
     * If exists and can work with cache, return TRUE,
     * else return FALSE
     * 
     * @param string $class
     * @param string $method
     * @return boolean
     */
    public function canWorkWithCache($class, $method)
    {
        if (strpos($class, '\\')) {
            $class = join('', array_slice(explode('\\', $class), -1));
        }

        if (array_key_exists($class, $this->config) 
                && is_array($this->config[$class]) 
                && array_key_exists($method, $this->config[$class])) {
            return true;
        }
        return false;
    }

    public function getItem($key, & $success = null, & $casToken = null)
    {
        return $this->cache->getItem($key, $success, $casToken);
    }

    public function setItem($key, $value)
    {
        return $this->cache->setItem($key, $value);
    }

    public function setOptions($options)
    {
        return $this->cache->setOptions($options);
    }

    public function getOptions()
    {
        return $this->cache->getOptions();
    }

    public function getItems(array $keys)
    {
        return $this->cache->getItems($keys);
    }

    public function hasItem($key)
    {
        return $this->cache->hasItem($key);
    }

    public function hasItems(array $keys)
    {
        return $this->cache->hasItems($keys);
    }

    public function getMetadata($key)
    {
        return $this->cache->getMetadata($key);
    }

    public function getMetadatas(array $keys)
    {
        return $this->cache->getMetadatas($keys);
    }

    public function setItems(array $keyValuePairs)
    {
        return $this->cache->setItems($keyValuePairs);
    }

    public function addItem($key, $value)
    {
        return $this->cache->addItem($key, $value);
    }

    public function addItems(array $keyValuePairs)
    {
        return $this->cache->addItems($keyValuePairs);
    }

    public function replaceItem($key, $value)
    {
        return $this->cache->replaceItem($key, $value);
    }

    public function replaceItems(array $keyValuePairs)
    {
        return $this->cache->replaceItems($keyValuePairs);
    }

    public function checkAndSetItem($token, $key, $value)
    {
        return $this->cache->checkAndSetItem($token, $key, $value);
    }

    public function touchItem($key)
    {
        return $this->cache->touchItem($key);
    }

    public function touchItems(array $keys)
    {
        return $this->cache->touchItems($keys);
    }

    public function removeItem($key)
    {
        return $this->cache->removeItem($key);
    }

    public function removeItems(array $keys)
    {
        return $this->cache->removeItems($keys);
    }

    public function incrementItem($key, $value)
    {
        return $this->cache->incrementItem($key, $value);
    }

    public function incrementItems(array $keyValuePairs)
    {
        return $this->cache->incrementItems($keyValuePairs);
    }

    public function decrementItem($key, $value)
    {
        return $this->cache->decrementItem($key, $value);
    }

    public function decrementItems(array $keyValuePairs)
    {
        return $this->cache->decrementItems($keyValuePairs);
    }

    public function getCapabilities()
    {
        return $this->cache->getCapabilities();
    }

}
