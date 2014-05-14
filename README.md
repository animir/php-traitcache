TraitCache
==========

TraitCache is a PHP library for integration cache in your project. It use zend-cache, so can be implemented in system with any popular cache-library, such: xCache, memcached and other.

The goal of this library is a fast (from 5 minutes to 1 hour) integrate the cache no longer correct the code.

Setup TraitCache via composer then do 3 simply steps for integration:

1) Use trait 'TraitCache' in your class, like that:
```php
class YourClassName {
    use TraitCache;
    
    public function getSomeText() 
    {
        return 'some text';
    }
}
```

2) Add init of TraitCache in method, that should be run before all. 
Forexample, in __construct() method:

```php
class YourClassName {
    use TraitCache;
    
    public function __construct()
    {
        // must be instance of class implements \Zend\Cache\Storage\StorageInterface interface
        $cache   = \Zend\Cache\StorageFactory::factory(array(
            'adapter' => array(
                'name' => 'filesystem'
            )
        )
        
        /* config array like 
        *      array('classNameWithoutNamespaces' => array(
        *                'methodName' => array(),
        *                'methodNameTwo' => array(),
        *           ),
        *            'classNameTwoWithoutNamespaces' => array(
        *                'methodName' => array()
        *          )
        *      )
        */
        $config = ['YourClassName' => ['getSomeText' => [] ] ]
        
        $this->__traitcache__init($cache, $config);
    }
    
    public function getSomeText() 
    {
        return 'some text';
    }
}
```

3) Change code, where method 'getSomeText' used:

```php
    $yourClass = new YourClassName();
    
    // postfix for cache stored in \Animir\TraitCache\Cache\CacheHelper::TRAITCACHE_METHOD_POSTFIX
    $someTextFromCache = $yourClass->getSomeText__fromCache();
    
```
