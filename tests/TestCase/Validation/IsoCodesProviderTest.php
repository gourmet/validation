<?php

namespace Gourmet\Validation\Test\TestCase\Validation;

use Cake\TestSuite\TestCase;
use Gourmet\Validation\Validation\IsoCodesProvider;

class IsoCodesProviderTest extends TestCase
{
    public function setUp()
    {
        $this->provider = new IsoCodesProvider();
    }

    public function tearDown()
    {
        unset($this->provider);
    }

    /**
     * @expectedException \Exception
     */
    public function testUndefinedMethod()
    {
        $this->provider->undefinedRule('');
    }

    public function testZipCode()
    {
        $this->assertTrue($this->provider->__call('zip_code', ['A0A 1A0', 'Canada']));
    }

    public function testIsbn10()
    {
        $this->assertTrue($this->provider->__call('isbn10', ['2-2110-4199-X']));
    }
}
