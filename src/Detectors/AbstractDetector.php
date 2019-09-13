<?php
/**
 *
 * Created By Mahdi Zarei (ymmsmz) at 2019-09-09
 *
 */

namespace Zarei\UserAgentParser\Detectors;


use Illuminate\Support\Str;
use Zarei\UserAgentParser\Entities\AbstractEntity;

/**
 * Class AbstractDetector
 * @package Zarei\UserAgentParser\Detectors
 */
abstract class AbstractDetector
{
    /**
     * Data types and definitions
     */
    protected const NAME = 'name';
    protected const VERSION = 'version';
    protected const ARCHITECTURE = 'architecture';
    protected const MODEL = 'model';
    protected const VENDOR = 'vendor';
    protected const TYPE = 'type';
    protected const CONSOLE = 'console';
    protected const MOBILE = 'mobile';
    protected const TABLET = 'tablet';
    protected const SMART_TV = 'smart-tv';
    protected const WEARABLE = 'wearable';
    protected const UNKNOWN = '?';

    /** @var array */
    protected $map;

    /** @var array */
    protected $regex;

    /** @var AbstractEntity */
    protected $entity;

    /**
     * AbstractDetector constructor.
     * Initialize children given data that need to parsing.
     */
    public function __construct()
    {
        $this->entity = $this->entity();
        $this->map = $this->map();
        $this->regex = $this->regex();
    }

    /**
     * Replace given string using map data.
     * @param string $str
     * @param array $map
     * @return string|null
     */
    private function str(string $str, array $map)
    {
        foreach ($map as $key => $value) {
            if (is_array($value) && count($value) > 0) {
                for ($j = 0; $j < count($value); $j++) {
                    if (strpos($value[$j], $str) !== false)
                        return ($key === self::UNKNOWN) ? null : $key;
                }
            } elseif (strpos($value, $str) !== false) {
                return ($key === self::UNKNOWN) ? null : $key;
            }
        }

        return null;
    }

    /**
     * String lower.
     * @param string $str
     * @return string
     */
    private function lowerize(string $str)
    {
        return Str::lower($str);
    }

    /**
     * Split version by DOT.
     * @param string $str
     * @return string|string[]|null
     */
    private function trim(string $str)
    {
        return preg_replace('/^[\s\uFEFF\xA0]+|[\s\uFEFF\xA0]+$/', '', $str);
    }

    /**
     * Start detection using initialized data.
     * @param string $userAgent
     * @return AbstractEntity
     */
    public function detect(string $userAgent)
    {
        $regex = $this->regex();
        $i = 0;
        $match = $matches = null;
        while ($i < count($regex) && !$matches) {

            $reg = $regex[$i];

            $prop = $regex[$i + 1];

            $j = $k = 0;

            while ($j < count($reg) && !$matches) {
                preg_match($reg[$j++], $userAgent, $matches);

                if (count($matches) > 0) {
                    for ($p = 0; $p < count($prop); $p++) {
                        $q = $prop[$p];
                        if (array_key_exists(++$k, $matches)) {
                            $match = $matches[$k];
                        }
                        if (is_array($q) && count($q) > 0) {
                            if (count($q) == 2) {
                                if (Str::startsWith($q[1], '__')) {
                                    $functionName = Str::replaceFirst('__', '', $q[1]);
                                    $result = null;
                                    if (method_exists($this, $functionName)) {
                                        $result = $this->$functionName($match);
                                    }
                                    $this->fillEntity([$q[0] => $result]);
                                } else
                                    $this->fillEntity([$q[0] => $q[1]]);
                            } elseif (count($q) == 3) {
                                if (Str::startsWith($q[1], '__')) {

                                    $functionName = Str::replaceFirst('__', '', $q[1]);
                                    $explodeArgs = explode('.', $q[2]);
                                    $argument = $this->map();
                                    foreach ($explodeArgs as $key) {
                                        $argument = $argument[$key];
                                    }

                                    $result = null;
                                    if (method_exists($this, $functionName)) {
                                        $result = $this->$functionName($match, $argument);
                                    }
                                    $this->fillEntity([$q[0] => $result]);
                                } else {
                                    $replacedMatch = preg_replace($q[1], $q[2], $match);
                                    $this->fillEntity([$q[0] => $replacedMatch]);
                                }
                            } elseif (count($q) == 4) {
                                if (Str::startsWith($q[3], '__')) {

                                    $functionName = Str::replaceFirst('__', '', $q[3]);
                                    $result = preg_replace($q[1], $q[2], $match);
                                    if (method_exists($this, $functionName)) {
                                        $result = $this->$functionName($result);
                                    }
                                    $this->fillEntity([$q[0] => $result]);
                                }
                            }
                        } else
                            $this->fillEntity([$q => $match]);
                    }
                }
            }
            $i += 2;
        }

        return $this->entity;
    }

    /**
     * Fill model by given array
     * @param array $data
     */
    private function fillEntity(array $data)
    {
        $this->entity->setData($data);
    }

    /**
     * Child entity.
     * @return AbstractEntity
     */
    abstract function entity();

    /**
     * Map data.
     * @return array
     */
    abstract function map(): array;

    /**
     * List pattern to search and detect data.
     * @return array
     */
    abstract function regex(): array;
}
