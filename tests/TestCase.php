<?php

namespace AmirHossein5\RequestTranslator\Tests;

use AmirHossein5\RequestTranslator\Tests\Traits\CreatesTranslationFile;
use AmirHossein5\RequestTranslator\Tests\Traits\DigitsTranslatedArrays;
use AmirHossein5\RequestTranslator\Tests\Traits\EnTranslatedArrays;
use AmirHossein5\RequestTranslator\Tests\Traits\FileContents;
use AmirHossein5\RequestTranslator\Tests\Traits\TemplateTranslatedArrays;
use AmirHossein5\RequestTranslator\TranslatorServiceProvider;
use Orchestra\Testbench\TestCase as TestbenchTestCase;

class TestCase extends TestbenchTestCase
{
    use CreatesTranslationFile;
    use FileContents;
    use EnTranslatedArrays;
    use DigitsTranslatedArrays;
    use TemplateTranslatedArrays;

    const TARGET = [
        'cash'   => '۱۲٫۵۰۰',
        'mobile' => '۰۹۱۲۳۴۵۶۷۸۹',
        'words'  => [
            'تست', 'سلام',
        ],
        'sentence' => 'این یک پیام تستی است',
        'all'      => [
            'cash'   => '۱۲٫۵۰۰',
            'mobile' => '۰۹۱۲۳۴۵۶۷۸۹',
            'words'  => [
                'تست', 'سلام',
            ],
            'sentence'  => 'این یک پیام تستی است',
            'inner-all' => [
                'cash'   => '۱۲٫۵۰۰',
                'mobile' => '۰۹۱۲۳۴۵۶۷۸۹',
                'words'  => [
                    'تست', 'سلام',
                ],
                'sentence' => 'این یک پیام تستی است',
            ],
        ],
    ];

    /**
     * Set up method of TestCase.
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->createTranslationFiles([
            'digits_translation',
            'word_translation',
            'sentence_translation',
            'en_request_translation',
        ]);
    }

    /**
     * Returns package ServiceProvider.
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            TranslatorServiceProvider::class,
        ];
    }

    /**
     * Returns environment of tests.
     *
     *  @return mixed
     */
    protected function getEnvironmentSetUp($app)
    {
        // perform environment setup
    }
}
