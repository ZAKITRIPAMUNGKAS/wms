<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class CompanySetting extends Model
{
    protected $fillable = ['key', 'value', 'group', 'label', 'type'];

    public static function get(string $key, $default = null)
    {
        return Cache::rememberForever("company_setting_{$key}", function () use ($key, $default) {
            return self::where('key', $key)->value('value') ?? $default;
        });
    }

    public static function getAddressFull(): string
    {
        return implode(', ', array_filter([
            self::get('address_street'),
            self::get('address_rt_rw'),
            self::get('address_kelurahan'),
            self::get('address_kecamatan'),
            self::get('address_kota'),
            self::get('address_provinsi') . ' ' . self::get('address_kode_pos'),
        ]));
    }
}
