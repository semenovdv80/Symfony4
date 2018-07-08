<?php

namespace App\Helper;

use Symfony\Component\Templating\Helper\Helper;
use Symfony\Component\Translation\Translator;

class Translater extends Helper
{
    protected static $locale;

    public function getName()
    {
        return 'translate';
    }

    public static function show($word)
    {
        $translator = new Translator(self::$locale);
        return $translator->trans($word);
    }

    public static function setLocale($locale)
    {
        self::$locale = $locale;
    }
}