<?php

namespace AmirHossein5\RequestTranslator\Console;

use AmirHossein5\RequestTranslator\Http\Middleware\RequestTranslatorMiddleware;
use AmirHossein5\RequestTranslator\Http\Middleware\TranslateFromMiddleware;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'translator:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Registers middleware in kernel of project';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $replace = '"translate" => '.'\\'.RequestTranslatorMiddleware::class.'::class';
        $after = [
            '\Illuminate\Routing\Middleware\ThrottleRequests::class',
            '\App\Http\Middleware\Authenticate::class',
            '\Illuminate\Auth\Middleware\Authorize::class',
            '\Illuminate\Auth\Middleware\EnsureEmailIsVerified::class',
        ];

        if (!$this->replaceAfterMiddleware($after, $replace)) {
            return;
        }

        $after = $replace;
        $replace = '"translate_from" => '.'\\'.TranslateFromMiddleware::class.'::class';

        if (!$this->replaceAfterMiddleware([$after], $replace)) {
            return;
        }

        $this->info('Installation completed successfully');
    }

    /**
     * Adds something after something in middleware.
     *
     * @param array  $after
     * @param string $replace
     * @param string $middleware
     *
     * @return int|bool
     */
    public function replaceAfterMiddleware(array $after, string $replace, string $middleware = 'routeMiddleware'): int|bool
    {
        $httpKernel = file_get_contents(app_path('/Http/Kernel.php'));

        $routeMiddleware = Str::before(Str::after($httpKernel, '$'.$middleware.' = ['), '];');

        if (Str::contains($routeMiddleware, $replace)) {
            return true;
        }

        $expectedExistsMiddlewares = $after;
        $after = null;

        foreach ($expectedExistsMiddlewares as $middleware) {
            if (Str::contains($routeMiddleware, $middleware)) {
                $after = $middleware;
            }
        }

        if (!$after) {
            $this->error(
                'to register middleware one of these middlewares should exists in route middleware:'
            );

            foreach ($expectedExistsMiddlewares as $middleware) {
                $this->info($middleware);
            }

            return false;
        }

        $modifiedMiddleware = str_replace(
            $after.',',
            $after.','.PHP_EOL.'        '.$replace.',',
            $routeMiddleware
        );

        return file_put_contents(
            app_path('Http/Kernel.php'),
            str_replace($routeMiddleware, $modifiedMiddleware, $httpKernel)
        );
    }
}
