<?php

namespace AmirHossein5\RequestTranslator\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static void fromFile(string $path)
 * @method static string file()
 * @method static void for(string $name, array $fields)
 * @method static array templates()
 * @method static array template(string $name)
 * @method static bool hasTemplate(string $name)
 * @method static string translate(string $data, string $translationFile = null)
 * @method static mixed data_set_closure(mixed &$target, string|array $key, mixed $value, bool $overwrite = true)
 * 
 * @see \AmirHossein5\RequestTranslator\Translator
 */
class Translator extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    public static function getFacadeAccessor()
    {
        return \AmirHossein5\RequestTranslator\Translator::class;
    }
}
