<?php

namespace AmirHossein5\RequestTranslator\Tests\Traits;

trait EnTranslatedArrays
{
    /**
     * Translates all.* with en_request_translation file.
     *
     * @return array
     */
    public function all_star_en()
    {
        return [
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
                    'test', 'سلام',
                ],
                'sentence'  => 'این یک پیام testی است',
                'inner-all' => [
                    'cash'   => '۱۲٫۵۰۰',
                    'mobile' => '۰۹۱۲۳۴۵۶۷۸۹',
                    'words'  => [
                        'test', 'سلام',
                    ],
                    'sentence' => 'این یک پیام testی است',
                ],
            ],
        ];
    }

    /**
     * Translates all.inner_all.words.* and words.* with en_request_translation file.
     *
     * @return array
     */
    public function all_inner_all_words_star_en_words_star_en()
    {
        return [
            'cash'   => '۱۲٫۵۰۰',
            'mobile' => '۰۹۱۲۳۴۵۶۷۸۹',
            'words'  => [
                'test', 'سلام',
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
                        'test', 'سلام',
                    ],
                    'sentence' => 'این یک پیام تستی است',
                ],
            ],
        ];
    }

    /**
     * Translates * with en_request_translation file.
     *
     * @return array
     */
    public function star_en()
    {
        return [
            'cash'   => '۱۲٫۵۰۰',
            'mobile' => '۰۹۱۲۳۴۵۶۷۸۹',
            'words'  => [
                'test', 'سلام',
            ],
            'sentence' => 'این یک پیام testی است',
            'all'      => [
                'cash'   => '۱۲٫۵۰۰',
                'mobile' => '۰۹۱۲۳۴۵۶۷۸۹',
                'words'  => [
                    'test', 'سلام',
                ],
                'sentence'  => 'این یک پیام testی است',
                'inner-all' => [
                    'cash'   => '۱۲٫۵۰۰',
                    'mobile' => '۰۹۱۲۳۴۵۶۷۸۹',
                    'words'  => [
                        'test', 'سلام',
                    ],
                    'sentence' => 'این یک پیام testی است',
                ],
            ],
        ];
    }
}
