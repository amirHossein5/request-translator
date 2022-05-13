<?php

namespace AmirHossein5\RequestTranslator\Tests\Feature\Commands;

use AmirHossein5\RequestTranslator\Tests\TestCase;
use Illuminate\Filesystem\Filesystem;

class CreateFileCommandTest extends TestCase
{
    public function test_creates_file()
    {
        $locale = config('app.locale') ?? 'en';
        $format = '.php';
        $fileName = $locale.'_request_translation';

        $this->removeFileIfExists();
        $this->assertFileDoesNotExist(lang_path($fileName.$format));

        $command = $this->artisan('make:translation-file');
        $command->expectsOutput('file created successfully!');
        // $this->assertFileExists(lang_path($fileName.$format));
        // $this->assertEquals(
        //     file_get_contents($this->getStub()),
        //     file_get_contents(lang_path($fileName.$format))
        // );

        $command = $this->artisan('make:translation-file');
        $command->expectsOutput('already exists!');
        // $this->assertFileExists(lang_path($fileName.$format));
        // $this->assertEquals(
        //     file_get_contents($this->getStub()),
        //     file_get_contents(lang_path($fileName.$format))
        // );
    }

    public function test_creates_file_in_deeper_folders()
    {
        $path = 'fa/test/request/translator/file_name';

        if (file_exists(lang_path('fa'))) {
            $fileSystem = new Filesystem();
            $fileSystem->deleteDirectory(lang_path('fa'));
        }

        $this->assertFileDoesNotExist(lang_path($path.'.php'));
        $this->assertDirectoryDoesNotExist(lang_path('fa'));

        $command = $this->artisan('make:translation-file', [
            'path' => $path,
        ]);

        $command->expectsOutput('file created successfully!');
        // $this->assertFileExists(lang_path($fileName.$format));
        // $this->assertEquals(
        //     file_get_contents($this->getStub()),
        //     file_get_contents(lang_path($fileName.$format))
        // );
        $command = $this->artisan('make:translation-file', [
            'path' => $path,
        ]);
        $command->expectsOutput('already exists!');
        // $this->assertFileExists(lang_path($fileName.$format));
        // $this->assertEquals(
        //     file_get_contents($this->getStub()),
        //     file_get_contents(lang_path($fileName.$format))
        // );
    }

    public function test_removes_php_format_from_end()
    {
        $path = 'file_name.php';

        if (file_exists(lang_path('fa'))) {
            $fileSystem = new Filesystem();
            $fileSystem->delete(lang_path($path));
        }

        $this->assertFileDoesNotExist(lang_path($path));

        $command = $this->artisan('make:translation-file', [
            'path' => $path,
        ]);
        $command->expectsOutput('file created successfully!');
        // $this->assertFileExists(lang_path($path));
        // $this->assertEquals(
        //     file_get_contents($this->getStub()),
        //     file_get_contents(lang_path($path))
        // );
        $command = $this->artisan('make:translation-file', [
            'path' => $path,
        ]);
        $command->expectsOutput('already exists!');
        // $this->assertFileExists(lang_path($path));
        // $this->assertEquals(
        //     file_get_contents($this->getStub()),
        //     file_get_contents(lang_path($path))
        // );
    }

    /**
     * Returns stub file path.
     *
     * @return string
     */
    private function getStub(): string
    {
        $this->assertFileExists(__DIR__.'/../../../stubs/translation-file.stub');

        return __DIR__.'/../../../stubs/translation-file.stub';
    }

    /**
     * Removes the translation file if exists.
     *
     * @return void
     */
    private function removeFileIfExists()
    {
        $locale = config('app.locale') ?? 'en';
        $format = '.php';
        $fileName = $locale.'_request_translation';
        $fileSystem = new Filesystem();

        if (file_exists(lang_path($fileName.$format))) {
            $fileSystem->delete(lang_path($fileName.$format));
        }
    }
}
