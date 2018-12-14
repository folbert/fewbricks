<?php

namespace Fewbricks;

use Fewbricks\Helpers\Helper;

/**
 * Class DevTools
 * @package Fewbricks
 */
class DevTools
{

    /**
     *
     */
    const SETTINGS_NAME_FOR_DISPLAYING_ACF_ARRAY = 'fewbricks__display_in_dev_tools';

    /**
     * @var array
     */
    private static $acfSettingsArrays = [];

    /**
     * @var int
     */
    private static $executionTimerStart = 0;

    /**
     * @var int
     */
    private static $executionTimerEnd = 0;

    /**
     * @var
     */
    private static $startHeight;

    /**
     * @param mixed $startHeight
     */
    public static function run($startHeight)
    {

        self::setStartHeight($startHeight);

        self::injectJs();
        add_action('admin_enqueue_scripts', [self::class, 'enqueueAssets']);
        add_action('admin_footer', [self::class, 'display']);

    }

    /**
     * @param $startHeight
     */
    private static function setStartHeight($startHeight)
    {

        if (isset($_GET['fewbricks-dev-tools-takeover'])) {
            $startHeight = 100;
        } else if ($startHeight === true) {
            $startHeight = '"minimized"';
        }

        self::$startHeight = $startHeight;

    }

    /**
     *
     */
    private static function injectJs()
    {

        add_action('admin_head', function () {

            echo '<script>
              var fewbricksDevTools = {
                startHeight: ' . DevTools::$startHeight . '
              };
            </script>';

        });

    }

    /**
     *
     */
    public static function enqueueAssets()
    {

        wp_enqueue_script('fewbricks-dev-tools', Helper::getFewbricksAssetsBaseUri() . '/scripts/dev-tools.js',
            [], Helper::getInstalledVersionOrTimestamp(), true);

        wp_enqueue_style('fewbricks-dev-tools', Helper::getFewbricksAssetsBaseUri() . '/styles/dev-tools.css',
            [], Helper::getInstalledVersionOrTimestamp(), false);

    }

    /**
     *
     */
    public static function display()
    {

        ob_start();
        require_once __DIR__ . '/../views/dev-tools.view.php';
        echo ob_get_clean();

    }

    /**
     * @param array $acfSettingsArray
     */
    public static function maybeStoreAcfSettingsArrayForDevDisplay(array $acfSettingsArray)
    {

        if (self::isActivated()) {

            $settingsKey = $acfSettingsArray['key'];

            if (
                (
                    isset($acfSettingsArray[self::SETTINGS_NAME_FOR_DISPLAYING_ACF_ARRAY]) &&
                    $acfSettingsArray[self::SETTINGS_NAME_FOR_DISPLAYING_ACF_ARRAY] === true
                ) ||
                (
                    (false !== ($filterValue = self::getKeysToDisplaySettingsFor())) &&
                    (
                        $filterValue === true || // Not being false does not mean that it is true in this case
                        ($filterValue === $settingsKey) ||
                        (is_array($filterValue) && in_array($settingsKey, $filterValue))
                    )
                )
            ) {

                self::$acfSettingsArrays[$settingsKey] = $acfSettingsArray;

            } else if (isset($acfSettingsArray['fields']) && is_array($acfSettingsArray['fields'])) {

                foreach ($acfSettingsArray['fields'] AS $subField) {

                    self::maybeStoreAcfSettingsArrayForDevDisplay($subField);

                }

            }

        }

    }

    /**
     * @return string
     */
    public static function getFilterString()
    {

        $filterValue = self::getKeysToDisplaySettingsFor();

        if (is_array($filterValue)) {
            $string = '[' . implode(', ', $filterValue) . ']';
        } elseif ($filterValue === true) {
            $string = 'all field groups (since you sent "true")';
        } elseif ($filterValue === false) {
            $string = '';
        } else {
            $string = '"' . (string)$filterValue . '"';
        }

        return $string;

    }

    /**
     * @return array
     */
    public static function getAcfSettingsArrays()
    {

        return self::$acfSettingsArrays;

    }

    /**
     *
     */
    public static function startExecutionTimer()
    {
        self::$executionTimerStart = microtime(true);
    }

    /**
     *
     */
    public static function endExecutionTimer()
    {
        self::$executionTimerEnd = microtime(true);
    }

    /**
     * @return int
     */
    public static function getExecutionTime()
    {

        return round(self::$executionTimerEnd - self::$executionTimerStart, 4);

    }

    /**
     * @return mixed
     */
    public static function isActivated()
    {

        return self::getDisplayFilterValue() !== false;

    }

    /**
     * @return mixed
     */
    public static function getDisplayFilterValue()
    {

        return apply_filters('fewbricks/dev_tools/display', false);

    }

    /**
     * @return mixed
     */
    public static function getKeysToDisplaySettingsFor()
    {

        return apply_filters('fewbricks/dev_tools/acf_arrays/keys', false);

    }

    /**
     * @param $acfSettingsArray
     * @return string
     */
    public static function getTitleFromAcfArray(array $acfSettingsArray)
    {

        $title = '<i>unknown title</i>';

        $possibleKeys = ['title', 'label'];

        foreach($possibleKeys AS $possibleKey) {

            if(isset($acfSettingsArray[$possibleKey])) {

                $title = $acfSettingsArray[$possibleKey];
                break;

            }

        }

        return $title;

    }

}
