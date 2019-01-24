<?php

namespace Wikichua\LaravelBread;

use App\Setting as SettingModel;

class Setting
{
    public function set($key, $value)
    {
        $setting = SettingModel::create(
            [
                'key' => $key,
                'value' => $value,
            ]
        );

        return $setting ? $value : false;
    }
    public function get($key)
    {
        $setting = SettingModel::where('key', $key)->first();

        return $setting ? $setting->value : false;
    }
}
