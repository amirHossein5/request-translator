<?php

namespace AmirHossein5\RequestTranslator\Tests\Feature;

use AmirHossein5\RequestTranslator\Facades\Translator;
use AmirHossein5\RequestTranslator\Http\Middleware\RequestTranslatorMiddleware;
use AmirHossein5\RequestTranslator\Http\Middleware\TranslateFromMiddleware;
use AmirHossein5\RequestTranslator\Tests\TestCase;

class BaseTest extends TestCase
{
    public function test_translator_middleware()
    {
        (new RequestTranslatorMiddleware())->handle(request()->merge(TestCase::TARGET), function ($request) {
            $this->assertEquals($request->all(), $this->all_star_en());
        }, 'all.*');

        (new RequestTranslatorMiddleware())->handle(request()->merge(TestCase::TARGET), function ($request) {
            $this->assertEquals($request->all(), $this->all_inner_all_words_star_en_words_star_en());
        }, 'words.*', 'all.inner-all.words.*');

        (new RequestTranslatorMiddleware())->handle(request()->merge(TestCase::TARGET), function ($request) {
            $this->assertEquals($request->all(), $this->star_en());
        }, '*');
    }

    public function test_translate_from_middleware()
    {
        // wrong path does not translate
        (new TranslateFromMiddleware())->handle(request(), function ($request) {}, 'a32dv1a23sd');

        (new RequestTranslatorMiddleware())->handle(request()->merge(TestCase::TARGET), function ($request) {
            $this->assertEquals($request->all(), TestCase::TARGET);
        }, 'all.*');
        (new RequestTranslatorMiddleware())->handle(request()->merge(TestCase::TARGET), function ($request) {
            $this->assertEquals($request->all(), TestCase::TARGET);
        }, 'words.*', 'all.inner-all.words.*');
        (new RequestTranslatorMiddleware())->handle(request()->merge(TestCase::TARGET), function ($request) {
            $this->assertEquals($request->all(), TestCase::TARGET);
        }, '*');

        // correct file path
        (new TranslateFromMiddleware())->handle(request(), function ($request) {}, 'digits_translation.php');

        $this->assertEquals(Translator::file(), lang_path('digits_translation.php'));

        (new RequestTranslatorMiddleware())->handle(request()->merge(TestCase::TARGET), function ($request) {
            $this->assertEquals($request->all(), $this->all_star_digits());
        }, 'all.*');
        (new RequestTranslatorMiddleware())->handle(request()->merge(TestCase::TARGET), function ($request) {
            $this->assertEquals(
                $request->all(),
                $this->mobile_digits_words_star_digits()
            );
        }, 'mobile', 'all.inner-all.words.*');
        (new RequestTranslatorMiddleware())->handle(request()->merge(TestCase::TARGET), function ($request) {
            $this->assertEquals($request->all(), $this->star_digits());
        }, '*');
    }
}
