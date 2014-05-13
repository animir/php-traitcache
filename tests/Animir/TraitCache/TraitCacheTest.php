<?php
namespace Animir\TraitCache;

use Animir\TraitCache\Cache\CacheHelper;
use Zend\Cache\Storage\Adapter\Memory;

class ParentA
{
    protected $var;
    use TraitCache;

    public function getResult($test)
    {
        return $this->var . $test;
    }
    
    public function setPrefix($newVar)
    {
        $this->var = $newVar; 
        return true;
    }

}

class A extends ParentA
{

}

class ChildAWithCall extends A
{
    public function __call($method, $args)
    {
        // some code
        
        return $this->__traitcache__call($method, $args);
    }
}

/**
 *
 * @author Animir
 */
class CacheTest extends \PHPUnit_Framework_TestCase
{

    protected $testClassA;
    protected $testClassB;

    public function setUp()
    {
        $this->testClassA = new A();       
        $this->testClassA->__traitcache__init(new Memory, ['A' => ['getResult' => [] ] ] );
        
        $this->testClassB = new ChildAWithCall();       
        $this->testClassB->__traitcache__init(new Memory, ['ChildAWithCall' => ['getResult' => [] ] ]);
    }
    
    public function testGetResultMethodFromCache()
    {
        $this->testClassA->setPrefix('1');
        $this->assertEquals('12', $this->testClassA->{'getResult' . CacheHelper::TRAITCACHE_METHOD_POSTFIX}('2'));
        
        $this->testClassA->setPrefix('3');
        $this->assertEquals('12', $this->testClassA->{'getResult' . CacheHelper::TRAITCACHE_METHOD_POSTFIX}('2'));                
    }
    
    public function testClassWithCallMethod() {
        $this->testClassB->setPrefix('1');
        $this->assertEquals('12', $this->testClassB->{'getResult' . CacheHelper::TRAITCACHE_METHOD_POSTFIX}('2'));
        
        $this->testClassB->setPrefix('3');
        $this->assertEquals('12', $this->testClassB->{'getResult' . CacheHelper::TRAITCACHE_METHOD_POSTFIX}('2')); 
    }
    
    public function tearDown()
    {
        unset($this->testClassA);
        unset($this->testClassB);
    }

}
