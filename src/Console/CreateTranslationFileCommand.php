<?php

namespace AmirHossein5\RequestTranslator\Console;

use Illuminate\Console\Command;

class CreateTranslationFileCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:translation-file {path?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a translation file';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $path = substr($path = $this->argument('path'), -4) === '.php'
            ? substr_replace($path, '', -4)
            : $path;
        $locale = config('app.locale') ?? 'en';
        $format = '.php';
        $fileName = $locale . '_request_translation';

        $path = lang_path($path ? $path . $format : $fileName . $format);

        if (file_exists($path)) {
            $this->error('already exists!');
            return;
        }

        if ($this->createFileFromStub($path, $this->getStub())) {
            $this->info('file created successfully!');
        } else {
            $this->error("couldn't create file, try again.");
        }
    }

    /**
     * Returns stub file path.
     * 
     * @return string
     */
    private function getStub(): string
    {
        return __DIR__ . '/../../stubs/translation-file.stub';
    }

    /**
     * Creates file in given path by stub contents.
     * 
     * @param string $path
     * @param string $stubPath
     * 
     * @return int|bool
     */
    private function createFileFromStub(string $path, string $stubPath): int|bool
    {
        if (!is_dir($directory = dirname($path))) {
            mkdir(dirname($path), 0777, true);
        }

        return file_put_contents($path, file_get_contents($stubPath));
    }
}
