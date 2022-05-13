<?php

namespace AmirHossein5\RequestTranslator\Tests\Traits;

trait TemplateTranslatedArrays
{
    /**
     * Path defined in template is prioritier than default.
     *
     * @return array
     */
    public function template_default_path()
    {
        return [
            'cash'   => '۱۲٫۵۰۰',
            'mobile' => '09123456789',
            'words'  => [
                'test', 'سلام',
            ],
            'sentence' => 'this is a test message',
            'all'      => [
                'cash'   => '۱۲٫۵۰۰',
                'mobile' => '۰۹۱۲۳۴۵۶۷۸۹',
                'words'  => [
                    'test', 'سلام',
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
     * Path defined in template is prioritier than middleware.
     *
     * @return array
     */
    public function template_middleware()
    {
        return [
            'cash'   => '۱۲٫۵۰۰',
            'mobile' => '09123456789',
            'words'  => [
                'test', 'hi',
            ],
            'sentence' => 'this is a test message',
            'all'      => [
                'cash'   => '۱۲٫۵۰۰',
                'mobile' => '۰۹۱۲۳۴۵۶۷۸۹',
                'words'  => [
                    'test', 'hi',
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
}
