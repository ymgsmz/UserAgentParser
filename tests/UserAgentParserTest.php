<?php

namespace Zarei\UserAgentParser\Tests;

use Zarei\UserAgentParser\Entities\Browser;
use Zarei\UserAgentParser\Detectors\BrowserDetector;
use Zarei\UserAgentParser\Detectors\CpuDetector;
use Zarei\UserAgentParser\Detectors\DeviceDetector;
use Zarei\UserAgentParser\Detectors\EngineDetector;
use Zarei\UserAgentParser\Detectors\OsDetector;
use Zarei\UserAgentParser\Entities\Cpu;
use Zarei\UserAgentParser\Entities\Device;
use Zarei\UserAgentParser\Entities\Engine;
use Zarei\UserAgentParser\Entities\Os;
use Zarei\UserAgentParser\Facades\UserAgentParser;

/**
 *
 * Created By Mahdi Zarei (ymmsmz) at 2019-09-10
 *
 */
class UserAgentParserTest extends TestCase
{

    private $userAgents = [
        'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_2) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/12.0.2 Safari/605.1.15' => [
            'browserName' => 'Safari',
            'browserVersion' => '12.0.2',
            'browserMajor' => 12,
            'osName' => 'Mac OS',
            'osVersion' => '10.14.2',
            'osMajor' => 10,
            'architecture' => '',
            'deviceVendor' => '',
            'deviceModel' => '',
            'deviceType' => '',
            'engineName' => 'WebKit',
            'engineVersion' => '605.1.15',
            'engineMajor' => 605,
        ],

        'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/534.50 (KHTML, like Gecko) Version/5.1 Safari/534.50' => [
            'browserName' => 'Safari',
            'browserVersion' => '5.1',
            'browserMajor' => 5,
            'osName' => 'Windows',
            'osVersion' => '7',
            'osMajor' => 7,
            'architecture' => 'amd64',
            'deviceVendor' => '',
            'deviceModel' => '',
            'deviceType' => '',
            'engineName' => 'WebKit',
            'engineVersion' => '534.50',
            'engineMajor' => 534,
        ],

        'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.169 Safari/537.36' => [
            'browserName' => 'Chrome',
            'browserVersion' => '74.0.3729.169',
            'browserMajor' => 74,
            'osName' => 'Windows',
            'osVersion' => '10',
            'osMajor' => 10,
            'architecture' => 'amd64',
            'deviceVendor' => '',
            'deviceModel' => '',
            'deviceType' => '',
            'engineName' => 'Blink',
            'engineVersion' => '',
            'engineMajor' => null,
        ],

        'Mozilla/5.0 (iPhone; CPU iPhone OS 11_1_2 like Mac OS X) AppleWebKit/604.3.5 (KHTML, like Gecko) Mobile/15B202 [FBAN/FBIOS;FBAV/150.0.0.32.132;FBBV/80278251;FBDV/iPhone8,1;FBMD/iPhone;FBSN/iOS;FBSV/11.1.2;FBSS/2;FBCR/VIVO;FBID/phone;FBLC/pt_BR;FBOP/5;FBRV/0]' => [
            'browserName' => 'Facebook',
            'browserVersion' => '150.0.0.32.132',
            'browserMajor' => 150,
            'osName' => 'iOS',
            'osVersion' => '11.1.2',
            'osMajor' => 11,
            'architecture' => '',
            'deviceVendor' => 'Apple',
            'deviceModel' => 'iPhone',
            'deviceType' => 'mobile',
            'engineName' => 'WebKit',
            'engineVersion' => '604.3.5',
            'engineMajor' => 604,
        ],

        'Mozilla/5.0 (iPhone; CPU iPhone OS 12_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Mobile/16B92 [FBAN/FBIOS;FBAV/199.0.0.69.98;FBBV/132813153;FBDV/iPhone10,5;FBMD/iPhone;FBSN/iOS;FBSV/12.1;FBSS/3;FBCR/ClaroBrasil;FBID/phone;FBLC/pt_BR;FBOP/5;FBRV/134382271]' => [
            'browserName' => 'Facebook',
            'browserVersion' => '199.0.0.69.98',
            'browserMajor' => 199,
            'osName' => 'iOS',
            'osVersion' => '12.1',
            'osMajor' => 12,
            'architecture' => '',
            'deviceVendor' => 'Apple',
            'deviceModel' => 'iPhone',
            'deviceType' => 'mobile',
            'engineName' => 'WebKit',
            'engineVersion' => '605.1.15',
            'engineMajor' => 605,
        ],

        'Mozilla/5.0 (Linux; Android 8.1.0; motorola one Build/OPKS28.63-18-3; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/70.0.3538.80 Mobile Safari/537.36 Instagram 72.0.0.21.98 Android (27/8.1.0; 320dpi; 720x1362; motorola; motorola one; deen_sprout; qcom; pt_BR; 132081645)' => [
            'browserName' => 'Instagram',
            'browserVersion' => '72.0.0.21.98',
            'browserMajor' => 72,
            'osName' => 'Android',
            'osVersion' => '8.1.0',
            'osMajor' => 8,
            'architecture' => '',
            'deviceVendor' => 'motorola',
            'deviceModel' => 'one',
            'deviceType' => 'mobile',
            'engineName' => 'Blink',
            'engineVersion' => '',
            'engineMajor' => null,
        ],

        'Mozilla/5.0 (Linux; Android 7.0; SM-G950U1 Build/NRD90M; wv) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/64.0.3282.137 Mobile Safari/537.36 Instagram 34.0.0.12.93 Android (24/7.0; 420dpi; 1080x2094; samsung; SM-G950U1; dreamqlteue; qcom; pt_BR; 94080607)' => [
            'browserName' => 'Instagram',
            'browserVersion' => '34.0.0.12.93',
            'browserMajor' => 34,
            'osName' => 'Android',
            'osVersion' => '7.0',
            'osMajor' => 7,
            'architecture' => '',
            'deviceVendor' => 'Samsung',
            'deviceModel' => 'SM-G950U1',
            'deviceType' => 'mobile',
            'engineName' => 'Blink',
            'engineVersion' => '',
            'engineMajor' => null,
        ],

        'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:54.0) Gecko/20100101 Firefox/54.0' => [
            'browserName' => 'Firefox',
            'browserVersion' => '54.0',
            'browserMajor' => 54,
            'osName' => 'Windows',
            'osVersion' => '7',
            'osMajor' => 7,
            'architecture' => 'amd64',
            'deviceVendor' => '',
            'deviceModel' => '',
            'deviceType' => '',
            'engineName' => 'Gecko',
            'engineVersion' => '54.0',
            'engineMajor' => 54,
        ],

        'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36 OPR/43.0.2442.991' => [
            'browserName' => 'Opera',
            'browserVersion' => '43.0.2442.991',
            'browserMajor' => 43,
            'osName' => 'Windows',
            'osVersion' => '7',
            'osMajor' => 7,
            'architecture' => 'amd64',
            'deviceVendor' => '',
            'deviceModel' => '',
            'deviceType' => '',
            'engineName' => 'Blink',
            'engineVersion' => '',
            'engineMajor' => null,
        ],

        'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/69.0.3497.81 Chrome/69.0.3497.81 Safari/537.36' => [
            'browserName' => 'Chromium',
            'browserVersion' => '69.0.3497.81',
            'browserMajor' => 69,
            'osName' => 'Ubuntu',
            'osVersion' => '',
            'osMajor' => null,
            'architecture' => 'amd64',
            'deviceVendor' => '',
            'deviceModel' => '',
            'deviceType' => '',
            'engineName' => 'Blink',
            'engineVersion' => '',
            'engineMajor' => null,
        ],

        'Mozilla/5.0 (Macintosh; PPC Mac OS X 10_5_8) AppleWebKit/534.50.2 (KHTML, like Gecko) Version/5.0.6 Safari/533.22.3' => [
            'browserName' => 'Safari',
            'browserVersion' => '5.0.6',
            'browserMajor' => 5,
            'osName' => 'Mac OS',
            'osVersion' => '10.5.8',
            'osMajor' => 10,
            'architecture' => 'ppc',
            'deviceVendor' => '',
            'deviceModel' => '',
            'deviceType' => '',
            'engineName' => 'WebKit',
            'engineVersion' => '534.50.2',
            'engineMajor' => 534,
        ],

        'Mozilla/5.0 (DirectFB; Linux armv7l) AppleWebKit/534.26+ (KHTML, like Gecko) Version/5.0 Safari/534.26+ HbbTV/1.1.1 ( ;LGE ;NetCast 3.0 ;1.0 ;1.0M ;)' => [
            'browserName' => 'Safari',
            'browserVersion' => '5.0',
            'browserMajor' => 5,
            'osName' => 'Linux',
            'osVersion' => 'armv7l',
            'osMajor' => 7,
            'architecture' => 'arm',
            'deviceVendor' => 'LG',
            'deviceModel' => 'NetCast 3.0',
            'deviceType' => 'smart-tv',
            'engineName' => 'WebKit',
            'engineVersion' => '534.26',
            'engineMajor' => 534,
        ]
    ];

    private $detector;
    private $expected;

    public function test_should_able_detect_browser()
    {
        foreach ($this->userAgents as $userAgent => $attrs) {
            $this->detector = UserAgentParser::parse($userAgent);
            $this->expected = new Browser();
            foreach ($attrs as $key => $value) {
                if ($key == 'browserName')
                    $this->expected->setName($value);
                if ($key == 'browserVersion')
                    $this->expected->setVersion($value);
            }
            $this->assertEquals($this->expected, $this->detector->browser);
        }
    }

    public function test_should_able_detect_os()
    {
        foreach ($this->userAgents as $userAgent => $attrs) {
            $this->detector = UserAgentParser::parse($userAgent);
            $this->expected = new Os();
            foreach ($attrs as $key => $value) {
                if ($key == 'osName')
                    $this->expected->setName($value);
                if ($key == 'osVersion')
                    $this->expected->setVersion($value);
            }
            $this->assertEquals($this->expected, $this->detector->os);
        }
    }

    public function test_should_able_detect_cpu()
    {
        foreach ($this->userAgents as $userAgent => $attrs) {
            $this->detector = UserAgentParser::parse($userAgent);
            $this->expected = new Cpu();
            foreach ($attrs as $key => $value) {
                if ($key == 'architecture')
                    $this->expected->setArchitecture($value);
            }
            $this->assertEquals($this->expected, $this->detector->cpu);
        }
    }

    public function test_should_able_detect_device()
    {
        foreach ($this->userAgents as $userAgent => $attrs) {
            $this->detector = UserAgentParser::parse($userAgent);
            $this->expected = new Device();
            foreach ($attrs as $key => $value) {
                if ($key == 'deviceVendor')
                    $this->expected->setVendor($value);
                if ($key == 'deviceType')
                    $this->expected->setType($value);
                if ($key == 'deviceModel')
                    $this->expected->setModel($value);
            }
            $this->assertEquals($this->expected, $this->detector->device);
        }
    }

    public function test_should_able_detect_engine()
    {
        foreach ($this->userAgents as $userAgent => $attrs) {
            $this->detector = UserAgentParser::parse($userAgent);
            $this->expected = new Engine();
            foreach ($attrs as $key => $value) {
                if ($key == 'engineName')
                    $this->expected->setName($value);
                if ($key == 'engineVersion')
                    $this->expected->setVersion($value);
            }
            $this->assertEquals($this->expected, $this->detector->engine);
        }
    }
}
