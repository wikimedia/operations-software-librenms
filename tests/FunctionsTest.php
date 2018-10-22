<?php
/**
 * FunctionsTest.php
 *
 * tests functions in includes/functions.php
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @package    LibreNMS
 * @link       http://librenms.org
 * @copyright  2017 Tony Murray
 * @author     Tony Murray <murraytony@gmail.com>
 */

namespace LibreNMS\Tests;

class FunctionsTest extends TestCase
{
    public function testMacCleanToReadable()
    {
        $this->assertEquals('de:ad:be:ef:a0:c3', mac_clean_to_readable('deadbeefa0c3'));
    }

    public function testHex2Str()
    {
        $this->assertEquals('Big 10 UP', hex2str('426967203130205550'));
    }

    public function testSnmpHexstring()
    {
        $input = '4c 61 72 70 69 6e 67 20 34 20 55 00 0a';
        $this->assertEquals("Larping 4 U\n", snmp_hexstring($input));
    }

    public function testIsHexString()
    {
        $this->assertTrue(isHexString('af 28 02'));
        $this->assertTrue(isHexString('aF 28 02 CE'));
        $this->assertFalse(isHexString('a5 fj 53'));
        $this->assertFalse(isHexString('a5fe53'));
    }

    public function testLinkify()
    {
        $input = 'foo@demo.net	bar.ba@test.co.uk
www.demo.com	http://foo.co.uk/
sdfsd ftp://192.168.1.1/help/me/now.php
http://regexr.com/foo.html?q=bar
https://mediatemple.net.';

        $expected = 'foo@demo.net	bar.ba@test.co.uk
www.demo.com	<a href="http://foo.co.uk/">http://foo.co.uk/</a>
sdfsd <a href="ftp://192.168.1.1/help/me/now.php">ftp://192.168.1.1/help/me/now.php</a>
<a href="http://regexr.com/foo.html?q=bar">http://regexr.com/foo.html?q=bar</a>
<a href="https://mediatemple.net">https://mediatemple.net</a>.';

        $this->assertSame($expected, linkify($input));
    }

    public function testDynamicDiscoveryGetValue()
    {
        $pre_cache = array(
            'firstdata' => array(
                0 => array('temp' => 1),
                1 => array('temp' => 2),
            ),
            'high' => array(
                0 => array('high' => 3),
                1 => array('high' => 4),
            ),
            'table' => array(
                0 => array('first' => 5, 'second' => 6),
                1 => array('first' => 7, 'second' => 8),
            ),
            'single' => array('something' => 9),
            'oneoff' => 10,
            'singletable' => array(
                11 => array('singletable' => 'Pickle')
            ),
            'doubletable' => array(
                12 => array('doubletable' => 'Mustard'),
                13 => array('doubletable' => 'BBQ')
            ),
        );

        $data = array('value' => 'temp', 'oid' => 'firstdata');
        $this->assertNull(dynamic_discovery_get_value('missing', 0, $data, $pre_cache));
        $this->assertSame('yar', dynamic_discovery_get_value('default', 0, $data, $pre_cache, 'yar'));
        $this->assertSame(2, dynamic_discovery_get_value('value', 1, $data, $pre_cache));

        $data = array('oid' => 'high');
        $this->assertSame(3, dynamic_discovery_get_value('high', 0, $data, $pre_cache));

        $data = array('oid' => 'table');
        $this->assertSame(5, dynamic_discovery_get_value('first', 0, $data, $pre_cache));
        $this->assertSame(7, dynamic_discovery_get_value('first', 1, $data, $pre_cache));
        $this->assertSame(6, dynamic_discovery_get_value('second', 0, $data, $pre_cache));
        $this->assertSame(8, dynamic_discovery_get_value('second', 1, $data, $pre_cache));

        $this->assertSame(9, dynamic_discovery_get_value('single', 0, $data, $pre_cache));
        $this->assertSame(10, dynamic_discovery_get_value('oneoff', 3, $data, $pre_cache));
        $this->assertSame('Pickle', dynamic_discovery_get_value('singletable', 11, $data, $pre_cache));
        $this->assertSame('BBQ', dynamic_discovery_get_value('doubletable', 13, $data, $pre_cache));
    }
}
