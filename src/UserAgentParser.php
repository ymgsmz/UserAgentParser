<?php
/**
 *
 * Created By Mahdi Zarei (ymmsmz) at 2019-09-09
 *
 */

namespace Zarei\UserAgentParser;


use Zarei\UserAgentParser\Detectors\BrowserDetector;
use Zarei\UserAgentParser\Detectors\CpuDetector;
use Zarei\UserAgentParser\Detectors\DeviceDetector;
use Zarei\UserAgentParser\Detectors\EngineDetector;
use Zarei\UserAgentParser\Detectors\OsDetector;
use Zarei\UserAgentParser\Entities\Browser;
use Zarei\UserAgentParser\Entities\Cpu;
use Zarei\UserAgentParser\Entities\Device;
use Zarei\UserAgentParser\Entities\Engine;
use Zarei\UserAgentParser\Entities\Os;

/**
 * Class UserAgentParser
 * @package Zarei\UserAgentParser
 */
class UserAgentParser
{
    /** @var string */
    private $ua;

    /** @var DeviceDetector */
    private $deviceDetector;

    /** @var CpuDetector */
    private $cpuDetector;

    /** @var OsDetector */
    private $osDetector;

    /** @var BrowserDetector */
    private $browserDetector;

    /** @var EngineDetector */
    private $engineDetector;

    /** @var Device */
    public $device;

    /** @var Cpu */
    public $cpu;

    /** @var Os */
    public $os;

    /** @var Browser */
    public $browser;

    /** @var Engine */
    public $engine;

    /**
     * Initialize detector classes.
     * UserAgentParser constructor.
     */
    public function __construct()
    {
        $this->osDetector = new OsDetector();
        $this->browserDetector = new BrowserDetector();
        $this->deviceDetector = new DeviceDetector();
        $this->engineDetector = new EngineDetector();
        $this->cpuDetector = new CpuDetector();
    }

    /**
     * Start data extraction of UA string
     * @param string $ua
     * @return UserAgentParser
     */
    public function parse(string $ua): UserAgentParser
    {
        $this->ua = $ua;

        $this->detectBrowser();
        $this->detectEngine();
        $this->detectDevice();
        $this->detectOs();
        $this->detectCpu();

        return $this;
    }

    /**
     * Start operation system detection
     */
    private function detectOs()
    {
        $osDetector = new OsDetector();

        $this->os = $osDetector->detect($this->ua);
    }

    /**
     * Start browser detection
     */
    private function detectBrowser()
    {
        $browserDetector = new BrowserDetector();

        $this->browser = $browserDetector->detect($this->ua);
    }

    /**
     * Start engine detection.
     */
    private function detectEngine()
    {
        $engineDetector = new EngineDetector();

        $this->engine = $engineDetector->detect($this->ua);
    }

    /**
     * Start central processing unit detection.
     */
    private function detectCpu()
    {
        $cpuDetector = new CpuDetector();

        $this->cpu = $cpuDetector->detect($this->ua);
    }

    /**
     * Start device detection.
     */
    private function detectDevice()
    {
        $deviceDetector = new DeviceDetector();

        $this->device = $deviceDetector->detect($this->ua);
    }
}
