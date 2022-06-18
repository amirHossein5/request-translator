<?php

namespace AmirHossein5\RequestTranslator\Tests\Feature;

use AmirHossein5\RequestTranslator\Facades\Translator;
use AmirHossein5\RequestTranslator\Http\Middleware\RequestTranslatorMiddleware;
use AmirHossein5\RequestTranslator\Http\Middleware\TranslateFromMiddleware;
use AmirHossein5\RequestTranslator\Tests\TestCase;

class TemplateTest extends TestCase
{
    public function test_template_creates()
    {
        Translator::for('example', [
            'all.sentence',
            'all.words.*',
            'all.inner-all.*',
        ]);

        (new RequestTranslatorMiddleware())->handle(request()->merge(TestCase::TARGET), function ($request) {
            $this->assertEquals($request->all(), $this->all_star_en());
        }, 'example');

        Translator::for('example', ['words.*']);

        (new RequestTranslatorMiddleware())->handle(request()->merge(TestCase::TARGET), function ($request) {
            $this->assertEquals($request->all(), $this->all_inner_all_words_star_en_words_star_en());
        }, 'all.inner-all.words.*', 'example');

        (new RequestTranslatorMiddleware())->handle(request()->merge(TestCase::TARGET), function ($request) {
            $this->assertEquals($request->all(), $this->star_en());
        }, '*', 'example');

        Translator::for('digits', ['forbeingoverride']);
        Translator::for('digits', [
            'all.mobile'           => 'digits_translation.php',
            'all.cash'             => 'digits_translation.php',
            'all.inner-all.mobile' => 'digits_translation.php',
            'all.inner-all.cash'   => 'digits_translation.php',
            'notExists',
            'notExists.*',
            'all.notExists.*',
            'notExists.notExists.*',
        ]);

        $this->assertEquals(Translator::file(), lang_path('en_request_translation.php'));

        (new RequestTranslatorMiddleware())->handle(request()->merge(TestCase::TARGET), function ($request) {
            $this->assertEquals($request->all(), $this->all_star_digits());
        }, 'digits');

        Translator::for('digits', [
            'mobile'                => 'digits_translation.php',
            'all.inner-all.words.*' => 'digits_translation.php',
            'notExists',
            'notExists.*',
            'all.notExists.*',
            'notExists.notExists.*',
        ]);

        (new RequestTranslatorMiddleware())->handle(request()->merge(TestCase::TARGET), function ($request) {
            $this->assertEquals(
                $request->all(),
                $this->mobile_digits_words_star_digits()
            );
        }, 'digits');
    }

    public function test_order_of_translation_files()
    {
        // 1-in template 3-default path
        Translator::for('template-default-path', [
            'mobile'   => 'digits_translation.php',
            'sentence' => 'sentence_translation.php',
            'words.*',
        ]);

        (new RequestTranslatorMiddleware())->handle(request()->merge(TestCase::TARGET), function ($request) {
            $this->assertEquals($request->all(), $this->template_default_path());
        }, 'all.words.*', 'mobile', 'template-default-path');

        // 1-in template 2-in middleware
        Translator::for('template-middleware', [
            'mobile'   => 'digits_translation.php',
            'sentence' => 'sentence_translation.php',
            'words.*',
        ]);

        (new TranslateFromMiddleware())->handle(request(), function ($request) {}, 'word_translation.php');

        $this->assertEquals(lang_path('word_translation.php'), Translator::file());

        (new RequestTranslatorMiddleware())->handle(request()->merge(TestCase::TARGET), function ($request) {
            $this->assertEquals($request->all(), $this->template_middleware());
        }, 'all.words.*', 'mobile', 'template-middleware');
    }

    public function test_path_can_be_define_globally_in_template()
    {
        // 1-in template 3-default path
        Translator::for('template-default-path', [
            'mobile'   => 'digits_translation.php',
            'sentence',
            'words.*' => 'en_request_translation.php',
        ], 'sentence_translation.php');

        (new RequestTranslatorMiddleware())->handle(request()->merge(TestCase::TARGET), function ($request) {
            $this->assertEquals($request->all(), $this->template_default_path());
        }, 'all.words.*', 'mobile', 'template-default-path');

        // 1-in template 2-in middleware
        Translator::for('template-middleware', [
            'mobile'   => 'digits_translation.php',
            'sentence',
        ], 'sentence_translation.php');

        (new TranslateFromMiddleware())->handle(request(), function ($request) {
        }, 'word_translation.php');

        $this->assertEquals(lang_path('word_translation.php'), Translator::file());

        (new RequestTranslatorMiddleware())->handle(request()->merge(TestCase::TARGET), function ($request) {
            $this->assertEquals($request->all(), $this->template_middleware());
        }, 'all.words.*', 'words.*', 'mobile', 'template-middleware');
    }
}
