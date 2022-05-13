<?php

namespace AmirHossein5\RequestTranslator\Tests\Traits;

trait FileContents
{
    /**
     * Content of digits_translation.
     *
     * @return string
     */
    private function digits_translation_content(): string
    {
        return <<< 'EOL'
            '۱' => '1',
            '۲' => '2',
            '۴' => '4',
            '۳' => '3',
            '۵' => '5',
            '۶' => '6',
            '۷' => '7',
            '۸' => '8',
            '۹' => '9',
            '۰' => '0',
            '٫' => '.'
        EOL;
    }

    /**
     * Content of word_translation.
     *
     * @return string
     */
    private function word_translation_content(): string
    {
        return <<< 'EOL'
            'تست' => 'test',
            'سلام' => 'hi',
        EOL;
    }

    /**
     * Content of sentence_translation.
     *
     * @return string
     */
    private function sentence_translation_content(): string
    {
        return <<< 'EOL'
            'این یک پیام تستی است' => 'this is a test message'
        EOL;
    }

    /**
     * Content of en_request_translation.
     *
     * @return string
     */
    private function en_request_translation_content(): string
    {
        return <<< 'EOL'
            'تست' => 'test',
        EOL;
    }
}
