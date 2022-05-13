<?php

namespace AmirHossein5\RequestTranslator\Tests\Traits;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Artisan;

trait CreatesTranslationFile
{
    /**
     * Creates Translation files.
     *
     * @param array $files
     * @return void
     */
    private function createTranslationFiles(array $files): void
    {
        foreach ($files as $file) {
            Artisan::call('make:translation-file', [
                'path' => $file
            ]);

            $method = $file . '_content';

            if (method_exists($this, $method)) {
                $contents = file_get_contents(lang_path($file . '.php'));

                file_put_contents(
                    lang_path($file . '.php'),
                    str_replace(
                        Str::before(Str::after($contents, '['), '];'),
                        PHP_EOL . $this->$method() . PHP_EOL,
                        $contents
                    )
                );

                $this->assertTrue(Str::contains(
                    file_get_contents(lang_path($file . '.php')),
                    $this->$method()
                ));
            }

            $this->assertFileExists(lang_path($file . '.php'));
        }
    }
}
