<?php
/**
 * Created by PhpStorm.
 * User: kamal
 * Date: 10/3/18
 * Time: 10:14 PM
 */

namespace App\Mangers;

use App\Models\Country;
use App\Models\Settings;

final class SettingsManger
{
    private static $options = [];
    private static $country;
    private static $scopeCountry = false;


    public static function Instance()
    {
        static $inst = null;
        if ($inst === null) {
            $inst = new SettingsManger();
        }
        return $inst;
    }

    public static function setstopScopCountry($val)
    {
        self::$scopeCountry = $val;
    }
    public static function getstopScopCountry()
    {
        return self::$scopeCountry;
    }

    private function __construct()
    {
        $this->getAutoLoadOptions();
    }

    public function getAutoLoadOptions()
    {
        $settings = Settings::where('auto_load', 1)->pluck('value','key')->toArray();
        self::$options = $settings;

        $code = 'eg';
        $country[$code] = Country::where('is_active', 1)->where('code', $code)->first();

        self::$country[$code] = $country[$code];
    }

    public function get_option($key, $default = '')
    {
        if(array_key_exists($key, self::$options))
            return self::$options[$key];

        $setting = Settings::where('key', $key)->first();
        if($setting)
        {
            self::$options[$key] = $setting->value;
            return $setting->value;
        }

        return $default;
    }

    public function getCountries()
    {
        return Country::where('is_active', 1)->get();
    }

    public static function getCountryById($code = 'eg')
    {
        return Country::where('is_active', 1)->where('code', $code)->first();
    }

    public static function getCountry()
    {
        list($code, $lang) = handleLangCountryDomain();

        if ($code == 'eg')
            $country = self::$country[$code];
        else
            $country = \App\Mangers\SettingsManger::Instance()->getCountryById($code);

        $stdClass = new \stdClass();
        $stdClass->code = $code;
        $stdClass->country = $country;
        $stdClass->id = $country->id;
        return $stdClass;
    }
}
