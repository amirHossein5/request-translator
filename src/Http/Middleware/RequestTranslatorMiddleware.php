<?php

namespace AmirHossein5\RequestTranslator\Http\Middleware;

use AmirHossein5\RequestTranslator\Facades\Translator;
use AmirHossein5\RequestTranslator\Translator as TranslatorClass;
use Closure;

class RequestTranslatorMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     * @param array<string>            $fields
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle($request, Closure $next, string ...$fields)
    {
        $translatedArray = $request->toArray();
        $translatorClass = new TranslatorClass();

        foreach ($fields as $field) {
            if (Translator::hasTemplate($field)) {
                $field = Translator::template($field);
            }

            if (is_array($field)) {
                foreach ($field as $key => $value) {
                    if (is_string($key)) {
                        $field = $key;
                        $filePath = $value;
                    } else {
                        $filePath = null;
                        $field = $value;
                    }

                    try {
                        $translatorClass->data_set_closure(
                            $translatedArray,
                            $field,
                            fn ($data) => Translator::translate($data, $filePath)
                        );
                    } catch (\Throwable $e) {
                    }
                }
            } else {
                try {
                    $translatorClass->data_set_closure(
                        $translatedArray,
                        $field,
                        fn ($data) => Translator::translate($data)
                    );
                } catch (\Throwable $e) {
                }
            }
        }

        $request->merge($translatedArray);

        return $next($request);
    }
}
