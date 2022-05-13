<?php

namespace AmirHossein5\RequestTranslator\Tests\Traits;

trait DigitsTranslatedArrays
{
    /**
     * Translates all.* with digits_translation file.
     *
     * @return array
     */
    public function all_star_digits()
    {
        return [
            'cash'   => '۱۲٫۵۰۰',
            'mobile' => '۰۹۱۲۳۴۵۶۷۸۹',
            'words'  => [
                'تست', 'سلام',
            ],
            'sentence' => 'این یک پیام تستی است',
            'all'      => [
                'cash'   => '12.500',
                'mobile' => '09123456789',
                'words'  => [
                    'تست', 'سلام',
                ],
                'sentence'  => 'این یک پیام تستی است',
                'inner-all' => [
                    'cash'   => '12.500',
                    'mobile' => '09123456789',
                    'words'  => [
                        'تست', 'سلام',
                    ],
                    'sentence' => 'این یک پیام تستی است',
                ],
            ],
        ];
    }

    /**
     * Translates all.inner_all.words.* and mobile with digits_translation file.
     *
     * @return array
     */
    public function mobile_digits_words_star_digits()
    {
        return [
            'cash'   => '۱۲٫۵۰۰',
            'mobile' => '09123456789',
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
    }

    /**
     * Translates * with digits_translation file.
     *
     * @return array
     */
    public function star_digits()
    {
        return [
            'cash'   => '12.500',
            'mobile' => '09123456789',
            'words'  => [
                'تست', 'سلام',
            ],
            'sentence' => 'این یک پیام تستی است',
            'all'      => [
                'cash'   => '12.500',
                'mobile' => '09123456789',
                'words'  => [
                    'تست', 'سلام',
                ],
                'sentence'  => 'این یک پیام تستی است',
                'inner-all' => [
                    'cash'   => '12.500',
                    'mobile' => '09123456789',
                    'words'  => [
                        'تست', 'سلام',
                    ],
                    'sentence' => 'این یک پیام تستی است',
                ],
            ],
        ];
    }
}
