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

if (! function_exists('money_fa')) {
    function money_fa($amount): string { return fa_digits(number_format((float) $amount)); }
}
