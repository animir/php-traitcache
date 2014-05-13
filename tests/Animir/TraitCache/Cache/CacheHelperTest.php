<?php

namespace Animir\TraitCache\Cache;

/**
 *
 * @author Animir
 */
class CacheHelperTest extends \PHPUnit_Framework_TestCase
{

    public function testGenerateKey()
    {
        $this->assertEquals(0, strcmp(CacheHelper::generateKey(1, 'test', 0.1, false), 'cache:1:test:0.1:0'));
        ;
    }

    public function testGenerateKeyAfterSetPrefix()
    {
        CacheHelper::setPrefix('test');
        $this->assertEquals(0, strcmp(CacheHelper::generateKey(1, 'test', 0.1, false), 'test:1:test:0.1:0'));
    }

    public function testGenerateKeyAfterSetDelimiter()
    {
        CacheHelper::setDelimiter('_');
        $this->assertEquals(0, strcmp(CacheHelper::generateKey(1, 'test', 0.1, false), 'test_1_test_0.1_0'));
    }

    public function testImplodeArgs()
    {
        $method = new \ReflectionMethod(
                new CacheHelper, 'implodeArgs'
        );

        $method->setAccessible(true);

        $this->assertEquals(
                0, strcmp('test_1_0.1', $method->invoke(null, ['test', [1, 0.1] ] ))
        );
    }

    public function testCheckMethodName()
    {
        $this->assertTrue(CacheHelper::isTraitCacheMethodName('test' . CacheHelper::TRAITCACHE_METHOD_POSTFIX));
        $this->assertFalse(CacheHelper::isTraitCacheMethodName('test' . 'Cache'));
    }

}
