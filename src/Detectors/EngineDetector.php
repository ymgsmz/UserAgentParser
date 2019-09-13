<?php
/**
 *
 * Created By Mahdi Zarei (ymmsmz) at 2019-09-12
 *
 */

namespace Zarei\UserAgentParser\Detectors;


use Zarei\UserAgentParser\Entities\AbstractEntity;
use Zarei\UserAgentParser\Entities\Engine;

/**
 * Class EngineDetector
 * @package Zarei\UserAgentParser\Detectors
 */
class EngineDetector extends AbstractDetector
{
    /**
     * Child entity.
     * @return AbstractEntity
     */
    function entity(): AbstractEntity
    {
        return new Engine();
    }

    /**
     * Map data.
     * @return array
     */
    function map(): array
    {
        return [];
    }

    /**
     * List pattern to search and detect data.
     * @return array
     */
    function regex(): array
    {
        return [
            [

                '/windows.+\sedge\/([\w\.]+)/i '                                      // EdgeHTML
            ], [self::VERSION, [self::NAME, 'EdgeHTML']], [

                '/webkit\/537\.36.+chrome\/(?!27)/i'                                  // Blink
            ], [[self::NAME, 'Blink']], [

                '/(presto)\/([\w\.]+)/i',                                             // Presto
                '/(webkit|trident|netfront|netsurf|amaya|lynx|w3m|goanna)\/([\w\.]+)/i',
                // WebKit/Trident/NetFront/NetSurf/Amaya/Lynx/w3m/Goanna
                '/(khtml|tasman|links)[\/\s]\(?([\w\.]+)/i',                          // KHTML/Tasman/Links
                '/(icab)[\/\s]([23]\.[\d\.]+)/i'                                      // iCab
            ], [self::NAME, self::VERSION], [

                '/rv\:([\w\.]{1,9}).+(gecko)/i'                                       // Gecko
            ], [self::VERSION, self::NAME]

        ];
    }
}
