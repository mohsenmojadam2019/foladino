<?php

use Morilog\Jalali\Jalalian;

if (! function_exists('fa_digits')) {
    function fa_digits($value): string
    {
        return strtr((string) $value, ['0'=>'۰','1'=>'۱','2'=>'۲','3'=>'۳','4'=>'۴','5'=>'۵','6'=>'۶','7'=>'۷','8'=>'۸','9'=>'۹']);
    }
}

if (! function_exists('jdate_fa')) {
    function jdate_fa($date = null, string $format = 'Y/m/d H:i'): string
    {
        if (! $date) return '—';
        try { return fa_digits(Jalalian::fromDateTime($date)->format($format)); }
        catch (Throwable $e) { return '—'; }
    }
}

if (! function_exists('jalali_to_carbon')) {
    function jalali_to_carbon(?string $value, string $format = 'Y/m/d H:i') {
        if (! $value) return null;
        $value = strtr($value, ['۰'=>'0','۱'=>'1','۲'=>'2','۳'=>'3','۴'=>'4','۵'=>'5','۶'=>'6','۷'=>'7','۸'=>'8','۹'=>'9']);
        try { return Jalalian::fromFormat($format, trim($value))->toCarbon(); }
        catch (Throwable $e) { return null; }
    }
}

if (! function_exists('money_fa')) {
    function money_fa($amount): string { return fa_digits(number_format((float) $amount)); }
}

if (! function_exists('site_asset')) {
    function site_asset(?string $path): string
    {
        if (! $path) return asset('images/logo-mark.svg');
        if (preg_match('#^(https?:)?//#', $path)) return $path;
        return asset(ltrim($path, '/'));
    }
}
