<?php
/**
 *
 * Created By Mahdi Zarei (ymmsmz) at 2019-09-12
 *
 */

namespace Zarei\UserAgentParser\Detectors;


use Zarei\UserAgentParser\Entities\AbstractEntity;
use Zarei\UserAgentParser\Entities\Device;

/**
 * Class DeviceDetector
 * @package Zarei\UserAgentParser\Detectors
 */
class DeviceDetector extends AbstractDetector
{
    /**
     * Child entity.
     * @return AbstractEntity
     */
    function entity(): AbstractEntity
    {
        return new Device();
    }

    /**
     * Map data.
     * @return array
     */
    function map(): array
    {
        return [
            'amazon' => [
                'model' => [
                    'Fire Phone' => ['SD', 'KF']
                ]
            ],
            'sprint' => [
                'model' => [
                    'Evo Shift 4G' => '7373KT'
                ],
                'vendor' => [
                    'HTC' => 'APA',
                    'Sprint' => 'Sprint'
                ]
            ]
        ];
    }

    /**
     * List pattern to search and detect data.
     * @return array
     */
    function regex(): array
    {
        return [
            [

                '/\((ipad|playbook);[\w\s\),;-]+(rim|apple)/i'                        // iPad/PlayBook
            ], [self::MODEL, self::VENDOR, [self::TYPE, self::TABLET]], [

                '/applecoremedia\/[\w\.]+ \((ipad)/'                                  // iPad
            ], [self::MODEL, [self::VENDOR, 'Apple'], [self::TYPE, self::TABLET]], [

                '/(apple\s{0,1}tv)/i'                                                 // Apple TV
            ], [[self::MODEL, 'Apple TV'], [self::VENDOR, 'Apple']], [

                '/(archos)\s(gamepad2?)/i',                                           // Archos
                '/(hp).+(touchpad)/i',                                                // HP TouchPad
                '/(hp).+(tablet)/i',                                                  // HP Tablet
                '/(kindle)\/([\w\.]+)/i',                                             // Kindle
                '/\s(nook)[\w\s]+build\/(\w+)/i',                                     // Nook
                '/(dell)\s(strea[kpr\s\d]*[\dko])/i'                                  // Dell Streak
            ], [self::VENDOR, self::MODEL, [self::TYPE, self::TABLET]], [

                '/(kf[A-z]+)\sbuild\/.+silk\//i'                                      // Kindle Fire HD
            ], [self::MODEL, [self::VENDOR, 'Amazon'], [self::TYPE, self::TABLET]], [
                '/(sd|kf)[0349hijorstuw]+\sbuild\/.+silk\//i'                         // Fire Phone
            ], [[self::MODEL, '__str', 'amazon.model'], [self::VENDOR, 'Amazon'], [self::TYPE, self::MOBILE]], [
                '/android.+aft([bms])\sbuild/i'                                       // Fire TV
            ], [self::MODEL, [self::VENDOR, 'Amazon'], [self::TYPE, self::SMART_TV]], [

                '/\((ip[honed|\s\w*]+);.+(apple)/i'                                   // iPod/iPhone
            ], [self::MODEL, self::VENDOR, [self::TYPE, self::MOBILE]], [
                '/\((ip[honed|\s\w*]+);/i'                                            // iPod/iPhone
            ], [self::MODEL, [self::VENDOR, 'Apple'], [self::TYPE, self::MOBILE]], [

                '/(blackberry)[\s-]?(\w+)/i',                                         // BlackBerry
                '/(blackberry|benq|palm(?=\-)|sonyericsson|acer|asus|dell|meizu|motorola|polytron)[\s_-]?([\w-]*)/i',
                // BenQ/Palm/Sony-Ericsson/Acer/Asus/Dell/Meizu/Motorola/Polytron
                '/(hp)\s([\w\s]+\w)/i',                                               // HP iPAQ
                '/(asus)-?(\w+)/i'                                                    // Asus
            ], [self::VENDOR, self::MODEL, [self::TYPE, self::MOBILE]], [
                '/\(bb10;\s(\w+)/i'                                                   // BlackBerry 10
            ], [self::MODEL, [self::VENDOR, 'BlackBerry'], [self::TYPE, self::MOBILE]], [
                // Asus Tablets
                '/android.+(transfo[prime\s]{4,10}\s\w+|eeepc|slider\s\w+|nexus 7|padfone|p00c)/i'
            ], [self::MODEL, [self::VENDOR, 'Asus'], [self::TYPE, self::TABLET]], [

                '/(sony)\s(tablet\s[ps])\sbuild\//i',                                  // Sony
                '/(sony)?(?:sgp.+)\sbuild\//i'
            ], [[self::VENDOR, 'Sony'], [self::MODEL, 'Xperia Tablet'], [self::TYPE, self::TABLET]], [
                '/android.+\s([c-g]\d{4}|so[-l]\w+)(?=\sbuild\/|\).+chrome\/(?![1-6]{0,1}\d\.))/i'
            ], [self::MODEL, [self::VENDOR, 'Sony'], [self::TYPE, self::MOBILE]], [

                '/\s(ouya)\s/i',                                                      // Ouya
                '/(nintendo)\s([wids3u]+)/i'                                          // Nintendo
            ], [self::VENDOR, self::MODEL, [self::TYPE, self::CONSOLE]], [

                '/android.+;\s(shield)\sbuild/i'                                      // Nvidia
            ], [self::MODEL, [self::VENDOR, 'Nvidia'], [self::TYPE, self::CONSOLE]], [

                '/(playstation\s[34portablevi]+)/i'                                   // Playstation
            ], [self::MODEL, [self::VENDOR, 'Sony'], [self::TYPE, self::CONSOLE]], [

                '/(sprint\s(\w+))/i'                                                  // Sprint Phones
            ], [[self::VENDOR, '__str', 'sprint.vendor'], [self::MODEL, '__str', 'sprint.model'], [self::TYPE, self::MOBILE]], [

                '/(htc)[;_\s-]+([\w\s]+(?=\)|\sbuild)|\w+)/i',                        // HTC
                '/(zte)-(\w*)/i',                                                     // ZTE
                '/(alcatel|geeksphone|nexian|panasonic|(?=;\s)sony)[_\s-]?([\w-]*)/i'
                // Alcatel/GeeksPhone/Nexian/Panasonic/Sony
            ], [self::VENDOR, [self::MODEL, '/_/', ' '], [self::TYPE, self::MOBILE]], [

                '/(nexus\s9)/i'                                                       // HTC Nexus 9
            ], [self::MODEL, [self::VENDOR, 'HTC'], [self::TYPE, self::TABLET]], [

                '/d\/huawei([\w\s-]+)[;\)]/i',
                '/(nexus\s6p)/i'                                                      // Huawei
            ], [self::MODEL, [self::VENDOR, 'Huawei'], [self::TYPE, self::MOBILE]], [

                '/(microsoft);\s(lumia[\s\w]+)/i'                                     // Microsoft Lumia
            ], [self::VENDOR, self::MODEL, [self::TYPE, self::MOBILE]], [

                '/[\s\(;](xbox(?:\sone)?)[\s\);]/i'                                   // Microsoft Xbox
            ], [self::MODEL, [self::VENDOR, 'Microsoft'], [self::TYPE, self::CONSOLE]], [
                '/(kin\.[onetw]{3})/i'                                                // Microsoft Kin
            ], [[self::MODEL, '/\./', ' '], [self::VENDOR, 'Microsoft'], [self::TYPE, self::MOBILE]], [

                // Motorola
                '/\s(milestone|droid(?:[2-4x]|\s(?:bionic|x2|pro|razr))?:?(\s4g)?)[\w\s]+build\//i',
                '/mot[\s-]?(\w*)/i',
                '/(XT\d{3,4}) build\//i',
                '/(nexus\s6)/i'
            ], [self::MODEL, [self::VENDOR, 'Motorola'], [self::TYPE, self::MOBILE]], [
                '/android.+\s(mz60\d|xoom[\s2]{0,2})\sbuild\//i'
            ], [self::MODEL, [self::VENDOR, 'Motorola'], [self::TYPE, self::TABLET]], [

                '/hbbtv\/\d+\.\d+\.\d+\s+\([\w\s]*;\s*(\w[^;]*);([^;]*)/i'            // HbbTV devices
            ], [[self::VENDOR, '__trim'], [self::MODEL, '__trim'], [self::TYPE, self::SMART_TV]], [

                '/hbbtv.+maple;(\d+)/i'
            ], [[self::MODEL, '/^/', 'SMART_TV'], [self::VENDOR, 'Samsung'], [self::TYPE, self::SMART_TV]], [

                '/\(dtv[\);].+(aquos)/i'                                              // Sharp
            ], [self::MODEL, [self::VENDOR, 'Sharp'], [self::TYPE, self::SMART_TV]], [

                '/android.+((sch-i[89]0\d|shw-m380s|gt-p\d{4}|gt-n\d+|sgh-t8[56]9|nexus 10))/i',
                '/((SM-T\w+))/i'
            ], [[self::VENDOR, 'Samsung'], self::MODEL, [self::TYPE, self::TABLET]], [                  // Samsung
                '/smart-tv.+(samsung)/i'
            ], [self::VENDOR, [self::TYPE, self::SMART_TV], self::MODEL], [
                '/((s[cgp]h-\w+|gt-\w+|galaxy\snexus|sm-\w[\w\d]+))/i',
                '/(sam[sung]*)[\s-]*(\w+-?[\w-]*)/i',
                '/sec-((sgh\w+))/i'
            ], [[self::VENDOR, 'Samsung'], self::MODEL, [self::TYPE, self::MOBILE]], [

                '/sie-(\w*)/i'                                                        // Siemens
            ], [self::MODEL, [self::VENDOR, 'Siemens'], [self::TYPE, self::MOBILE]], [

                '/(maemo|nokia).*(n900|lumia\s\d+)/i',                                // Nokia
                '/(nokia)[\s_-]?([\w-]*)/i'
            ], [[self::VENDOR, 'Nokia'], self::MODEL, [self::TYPE, self::MOBILE]], [

                '/android[x\d\.\s;]+\s([ab][1-7]\-?[0178a]\d\d?)/i'                   // Acer
            ], [self::MODEL, [self::VENDOR, 'Acer'], [self::TYPE, self::TABLET]], [

                '/android.+([vl]k\-?\d{3})\s+build/i'                                 // LG Tablet
            ], [self::MODEL, [self::VENDOR, 'LG'], [self::TYPE, self::TABLET]], [
                '/android\s3\.[\s\w;-]{10}(lg?)-([06cv9]{3,4})/i'                     // LG Tablet
            ], [[self::VENDOR, 'LG'], self::MODEL, [self::TYPE, self::TABLET]], [
                '/(lg) netcast\.tv/i'                                                 // LG SMART_TV
            ], [self::VENDOR, self::MODEL, [self::TYPE, self::SMART_TV]], [
                '/(nexus\s[45])/i',                                                   // LG
                '/lg[e;\s\/-]+(\w*)/i',
                '/android.+lg(\-?[\d\w]+)\s+build/i'
            ], [self::MODEL, [self::VENDOR, 'LG'], [self::TYPE, self::MOBILE]], [

                '/(lenovo)\s?(s(?:5000|6000)(?:[\w-]+)|tab(?:[\s\w]+))/i'             // Lenovo tablets
            ], [self::VENDOR, self::MODEL, [self::TYPE, self::TABLET]], [
                '/android.+(ideatab[a-z0-9\-\s]+)/i'                                  // Lenovo
            ], [self::MODEL, [self::VENDOR, 'Lenovo'], [self::TYPE, self::TABLET]], [
                '/(lenovo)[_\s-]?([\w-]+)/i'
            ], [self::VENDOR, self::MODEL, [self::TYPE, self::MOBILE]], [

                '/linux;.+((jolla));/i'                                               // Jolla
            ], [self::VENDOR, self::MODEL, [self::TYPE, self::MOBILE]], [

                '/((pebble))app\/[\d\.]+\s/i'                                         // Pebble
            ], [self::VENDOR, self::MODEL, [self::TYPE, self::WEARABLE]], [

                '/android.+;\s(oppo)\s?([\w\s]+)\sbuild/i'                            // OPPO
            ], [self::VENDOR, self::MODEL, [self::TYPE, self::MOBILE]], [

                '/crkey/i'                                                            // Google Chromecast
            ], [[self::MODEL, 'Chromecast'], [self::VENDOR, 'Google']], [

                '/android.+;\s(glass)\s\d/i'                                          // Google Glass
            ], [self::MODEL, [self::VENDOR, 'Google'], [self::TYPE, self::WEARABLE]], [

                '/android.+;\s(pixel c)[\s)]/i'                                       // Google Pixel C
            ], [self::MODEL, [self::VENDOR, 'Google'], [self::TYPE, self::TABLET]], [

                '/android.+;\s(pixel( [23])?( xl)?)[\s)]/i'                              // Google Pixel
            ], [self::MODEL, [self::VENDOR, 'Google'], [self::TYPE, self::MOBILE]], [

                '/android.+;\s(\w+)\s+build\/hm\1/i',                                 // Xiaomi Hongmi 'numeric' models
                '/android.+(hm[\s\-_]*note?[\s_]*(?:\d\w)?)\s+build/i',               // Xiaomi Hongmi
                '/android.+(mi[\s\-_]*(?:a\d|one|one[\s_]plus|note lte)?[\s_]*(?:\d?\w?)[\s_]*(?:plus)?)\s+build/i',
                // Xiaomi Mi
                '/android.+(redmi[\s\-_]*(?:note)?(?:[\s_]*[\w\s]+))\s+build/i'       // Redmi Phones
            ], [[self::MODEL, '/_/', ' '], [self::VENDOR, 'Xiaomi'], [self::TYPE, self::MOBILE]], [
                '/android.+(mi[\s\-_]*(?:pad)(?:[\s_]*[\w\s]+))\s+build/i'            // Mi Pad tablets
            ], [[self::MODEL, '/_/', ' '], [self::VENDOR, 'Xiaomi'], [self::TYPE, self::TABLET]], [
                '/android.+;\s(m[1-5]\snote)\sbuild/i'                                // Meizu
            ], [self::MODEL, [self::VENDOR, 'Meizu'], [self::TYPE, self::MOBILE]], [
                '/(mz)-([\w-]{2,})/i'
            ], [[self::VENDOR, 'Meizu'], self::MODEL, [self::TYPE, self::MOBILE]], [

                '/android.+a000(1)\s+build/i',                                        // OnePlus
                '/android.+oneplus\s(a\d{4})\s+build/i'
            ], [self::MODEL, [self::VENDOR, 'OnePlus'], [self::TYPE, self::MOBILE]], [

                '/android.+[;\/]\s*(RCT[\d\w]+)\s+build/i'                            // RCA Tablets
            ], [self::MODEL, [self::VENDOR, 'RCA'], [self::TYPE, self::TABLET]], [

                '/android.+[;\/\s]+(Venue[\d\s]{2,7})\s+build/i'                      // Dell Venue Tablets
            ], [self::MODEL, [self::VENDOR, 'Dell'], [self::TYPE, self::TABLET]], [

                '/android.+[;\/]\s*(Q[T|M][\d\w]+)\s+build/i'                         // Verizon Tablet
            ], [self::MODEL, [self::VENDOR, 'Verizon'], [self::TYPE, self::TABLET]], [

                '/android.+[;\/]\s+(Barnes[&\s]+Noble\s+|BN[RT])(V?.*)\s+build/i'     // Barnes & Noble Tablet
            ], [[self::VENDOR, 'Barnes & Noble'], self::MODEL, [self::TYPE, self::TABLET]], [

                '/android.+[;\/]\s+(TM\d{3}.*\b)\s+build/i'                           // Barnes & Noble Tablet
            ], [self::MODEL, [self::VENDOR, 'NuVision'], [self::TYPE, self::TABLET]], [

                '/android.+;\s(k88)\sbuild/i'                                         // ZTE K Series Tablet
            ], [self::MODEL, [self::VENDOR, 'ZTE'], [self::TYPE, self::TABLET]], [

                '/android.+[;\/]\s*(gen\d{3})\s+build.*49h/i'                         // Swiss GEN Mobile
            ], [self::MODEL, [self::VENDOR, 'Swiss'], [self::TYPE, self::MOBILE]], [

                '/android.+[;\/]\s*(zur\d{3})\s+build/i'                              // Swiss ZUR Tablet
            ], [self::MODEL, [self::VENDOR, 'Swiss'], [self::TYPE, self::TABLET]], [

                '/android.+[;\/]\s*((Zeki)?TB.*\b)\s+build/i'                         // Zeki Tablets
            ], [self::MODEL, [self::VENDOR, 'Zeki'], [self::TYPE, self::TABLET]], [

                '/(android).+[;\/]\s+([YR]\d{2})\s+build/i',
                '/android.+[;\/]\s+(Dragon[\-\s]+Touch\s+|DT)(\w{5})\sbuild/i'        // Dragon Touch Tablet
            ], [[self::VENDOR, 'Dragon Touch'], self::MODEL, [self::TYPE, self::TABLET]], [

                '/android.+[;\/]\s*(NS-?\w{0,9})\sbuild/i'                            // Insignia Tablets
            ], [self::MODEL, [self::VENDOR, 'Insignia'], [self::TYPE, self::TABLET]], [

                '/android.+[;\/]\s*((NX|Next)-?\w{0,9})\s+build/i'                    // NextBook Tablets
            ], [self::MODEL, [self::VENDOR, 'NextBook'], [self::TYPE, self::TABLET]], [

                '/android.+[;\/]\s*(Xtreme\_)?(V(1[045]|2[015]|30|40|60|7[05]|90))\s+build/i'
            ], [[self::VENDOR, 'Voice'], self::MODEL, [self::TYPE, self::MOBILE]], [                    // Voice Xtreme Phones

                '/android.+[;\/]\s*(LVTEL\-)?(V1[12])\s+build/i'                     // LvTel Phones
            ], [[self::VENDOR, 'LvTel'], self::MODEL, [self::TYPE, self::MOBILE]], [

                '/android.+;\s(PH-1)\s/i'
            ], [self::MODEL, [self::VENDOR, 'Essential'], [self::TYPE, self::MOBILE]], [                // Essential PH-1

                '/android.+[;\/]\s*(V(100MD|700NA|7011|917G).*\b)\s+build/i'          // Envizen Tablets
            ], [self::MODEL, [self::VENDOR, 'Envizen'], [self::TYPE, self::TABLET]], [

                '/android.+[;\/]\s*(Le[\s\-]+Pan)[\s\-]+(\w{1,9})\s+build/i'          // Le Pan Tablets
            ], [self::VENDOR, self::MODEL, [self::TYPE, self::TABLET]], [

                '/android.+[;\/]\s*(Trio[\s\-]*.*)\s+build/i'                         // MachSpeed Tablets
            ], [self::MODEL, [self::VENDOR, 'MachSpeed'], [self::TYPE, self::TABLET]], [

                '/android.+[;\/]\s*(Trinity)[\-\s]*(T\d{3})\s+build/i'                // Trinity Tablets
            ], [self::VENDOR, self::MODEL, [self::TYPE, self::TABLET]], [

                '/android.+[;\/]\s*TU_(1491)\s+build/i'                               // Rotor Tablets
            ], [self::MODEL, [self::VENDOR, 'Rotor'], [self::TYPE, self::TABLET]], [

                '/android.+(KS(.+))\s+build/i'                                        // Amazon Kindle Tablets
            ], [self::MODEL, [self::VENDOR, 'Amazon'], [self::TYPE, self::TABLET]], [

                '/android.+(Gigaset)[\s\-]+(Q\w{1,9})\s+build/i'                      // Gigaset Tablets
            ], [self::VENDOR, self::MODEL, [self::TYPE, self::TABLET]], [

                '/\s(tablet|tab)[;\/]/i',                                             // Unidentifiable Tablet
                '/\s(mobile)(?:[;\/]|\ssafari)/i'                                     // Unidentifiable Mobile
            ], [[self::TYPE, '__lowerize'], self::VENDOR, self::MODEL], [

                '/[\s\/\(](smart-?tv)[;\)]/i'                                         // SMART_TV
            ], [[self::TYPE, self::SMART_TV]], [

                '/(android[\w\.\s\-]{0,9});.+build/i'                                 // Generic Android Device
            ], [self::MODEL, [self::VENDOR, 'Generic']]

        ];
    }
}
