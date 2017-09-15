<?php

namespace Jameswmcnab\ConfigDb\Tests\Integration;

use Illuminate\Foundation\Testing\Concerns\InteractsWithDatabase;
use Jameswmcnab\ConfigDb\Facades\ConfigDb;

class ConfigDbTest extends TestCase
{
    use InteractsWithDatabase;

    /**
     * @return array
     */
    public function valueProvider()
    {
        return [
            ['bar'],
            [1],
            [0],
        ];
    }

    /**
     * @param $value
     * @dataProvider valueProvider
     */
    public function testSave($value)
    {
        ConfigDb::save('foo', $value);

        $this->assertDatabaseHas('config', ['key' => 'foo', 'value' => $value]);
        $this->assertEquals((string) $value, ConfigDb::get('foo'));
    }

    public function testGetWithDefault()
    {
        $this->assertSame('bar', ConfigDb::get('foo', 'bar'));
    }

    /**
     * Although it would be better for booleans to be returned as booleans, this is not what
     * has happened in the past. So we check that if the return value from `get` is cast as a
     * boolean, we get the same value as stored.
     */
    public function testSaveBoolean()
    {
        ConfigDb::save('foo', true);
        ConfigDb::save('bar', false);

        $this->assertTrue((bool) ConfigDb::get('foo'));
        $this->assertFalse((bool) ConfigDb::get('bar'));
    }

    /**
     * Although it would be better for arrays to be returned as arrays, this is not what
     * has happened in the past. We are currently using it as follows, i.e. JSON encoding/decoding
     * values we are storing. Therefore this test just checks that it does operate in this way.
     */
    public function testSaveArray()
    {
        ConfigDb::save('foo', json_encode($expected = ['bar' => 'baz']));

        $this->assertEquals($expected, json_decode(ConfigDb::get('foo'), true));
    }

    /**
     * @param $value
     * @dataProvider valueProvider
     */
    public function testHas($value)
    {
        $this->assertFalse(ConfigDb::has('foo'));
        ConfigDb::save('foo', $value);
        $this->assertTrue(ConfigDb::has('foo'));
    }
}
