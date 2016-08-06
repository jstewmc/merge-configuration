<?php
/**
 * The file for the squash-config-directory tests
 *
 * @author     Jack Clayton <clayjs0@gmail.com>
 * @copyright  2016 Jack Clayton
 * @license    MIT
 */

namespace Jstewmc\SquashConfigDirectory;

use Jstewmc\TestCase\TestCase;
use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamDirectory;

// define a concrete config class for tests
class Foo implements Config 
{
    public $config = [];
    
    public function __construct(array $config = [])
    {
        $this->config = $config;
    }
    
    public function merge(array $config) 
    {
        $this->config = array_merge($this->config, $config);
        
        return;
    }
};

/**
 * Tests for the squash-config-directory context
 */
class SquashTest extends TestCase
{    
    /* !Private properties */
    
    /**
     * @var  vfsStreamDirectory  the "root" virtual file system directory
     */
    private $root;
    
    
    /* !Framework methods */
    
    /**
     * Called before every test
     *
     * @return  void
     */
    public function setUp()
    {
        $this->root = vfsStream::setup('test');
        
        return;
    }
    
    
    /* !__invoke() */
    
    /**
     * __invoke() should throw exception if directory is not readable
     */
    public function testConstructThrowsExceptionIfDirectoryIsNotReadable()
    {
        $this->setExpectedException('InvalidArgumentException');
        
        (new Squash())(vfsStream::url('path/to/foo'), new Foo());
        
        return;
    }
    
    /**
     * __invoke() should return config if zero files exist
     */
    public function testInvokeReturnsConfigIfZeroFilesExist()
    {
        $this->assertEquals(
            new Foo(), 
            (new Squash())(vfsStream::url('test'), new Foo())
        );
        
        return;
    }
    
    /**
     * __invoke() should return config if one file exists
     */
    public function testInvokeReturnsConfigIfOneFileExists()
    {
        // create a configuration file
        $file = vfsStream::url('test/foo.php');
        file_put_contents($file, "<?php return ['foo' => 'bar'];");
        
        // set our *expected* and *actual* results
        $expected = new Foo(['foo' => 'bar']);
        $actual   = (new Squash())(vfsStream::url('test'), new Foo());
        
        $this->assertEquals($expected, $actual);
        
        return;
    }
    
    /**
     * __invoke() should return config if many files exist
     */
    public function testInvokeReturnsConfigIfManyFilesExists()
    {
        // create two configuration files
        $file1 = vfsStream::url('test/foo.php');
        file_put_contents($file1, "<?php return ['foo' => 'bar'];");
        
        $file1 = vfsStream::url('test/bar.php');
        file_put_contents($file1, "<?php return ['bar' => 'baz'];");
        
        // set our *expected* and *actual* results
        $expected = new Foo(['foo' => 'bar', 'bar' => 'baz']);
        $actual   = (new Squash())(vfsStream::url('test'), new Foo());
        
        $this->assertEquals($expected, $actual);
        
        return;
    }
}
