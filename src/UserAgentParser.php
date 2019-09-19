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
    private $device;

    /** @var Cpu */
    private $cpu;

    /** @var Os */
    private $os;

    /** @var Browser */
    private $browser;

    /** @var Engine */
    private $engine;

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
     * Extract data from requesting UA string
     * @return UserAgentParser
     */
    public function get(): UserAgentParser
    {
        return $this->parse(request()->userAgent());
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

    /**
     * get device property
     * @return Device
     */
    public function device(): Device
    {
        return $this->device;
    }

    /**
     * get cpu property
     * @return Cpu
     */
    public function cpu(): Cpu
    {
        return $this->cpu;
    }

    /**
     * get os property
     * @return Os
     */
    public function os(): Os
    {
        return $this->os;
    }

    /**
     * get browser property
     * @return Browser
     */
    public function browser(): Browser
    {
        return $this->browser;
    }

    /**
     * get engine property
     * @return Engine
     */
    public function engine(): Engine
    {
        return $this->engine;
    }
}
