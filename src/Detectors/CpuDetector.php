<?php
/**
 *
 * Created By Mahdi Zarei (ymmsmz) at 2019-09-12
 *
 */

namespace Zarei\UserAgentParser\Detectors;


use Zarei\UserAgentParser\Entities\AbstractEntity;
use Zarei\UserAgentParser\Entities\Cpu;

/**
 * Class CpuDetector
 * @package Zarei\UserAgentParser\Detectors
 */
class CpuDetector extends AbstractDetector
{
    /**
     * Child entity.
     * @return AbstractEntity
     */
    function entity(): AbstractEntity
    {
        return new Cpu();
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

                '/(?:(amd|x(?:(?:86|64)[_-])?|wow|win)64)[;\)]/i'                     // AMD64
            ], [[self::ARCHITECTURE, 'amd64']], [

                '/(ia32(?=;))/i'                                                      // IA32 (quicktime)
            ], [[self::ARCHITECTURE, '__lowerize']], [

                '/((?:i[346]|x)86)[;\)]/i'                                            // IA32
            ], [[self::ARCHITECTURE, 'ia32']], [

                // PocketPC mistakenly identified as PowerPC
                '/windows\s(ce|mobile);\sppc;/i'
            ], [[self::ARCHITECTURE, 'arm']], [

                '/((?:ppc|powerpc)(?:64)?)(?:\smac|;|\))/i'                           // PowerPC
            ], [[self::ARCHITECTURE, '/ower/', '', '__lowerize']], [

                '/(sun4\w)[;\)]/i'                                                    // SPARC
            ], [[self::ARCHITECTURE, 'sparc']], [

                '/((?:avr32|ia64(?=;))|68k(?=\))|arm(?:64|(?=v\d+[;l]))|(?=atmel\s)avr|(?:irix|mips|sparc)(?:64)?(?=;)|pa-risc)/i'
                // IA64, 68K, ARM/64, AVR/32, IRIX/64, MIPS/64, SPARC/64, PA-RISC
            ], [[self::ARCHITECTURE, '__lowerize']]
        ];
    }
}
