<?php

namespace Animir\TraitCache\Cache;

use Animir\TraitCache\Cache\TraitCache;
use Zend\Cache\Storage\Adapter\Memory;

/**
 *
 * @author Animir
 */
class CacheAdapterTest extends \PHPUnit_Framework_TestCase
{

    /**
     *
     * @var CacheAdapter 
     */
    private $cacheAdapter;

    public function setUp()
    {
        $this->cacheAdapter = new CacheAdapter(new Memory, [] );
    }

    public function testSetAndGet()
    {
        $this->assertTrue($this->cacheAdapter->setItem('test', 1));
        $this->assertEquals(1, $this->cacheAdapter->getItem('test'));
    }

    public function tearDown()
    {
        unset($this->cacheAdapter);
    }

}
