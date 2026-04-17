<?php

if (!function_exists('company')) {
    function company(string $key, $default = null) {
        return \App\Models\CompanySetting::get($key, $default);
    }
}
