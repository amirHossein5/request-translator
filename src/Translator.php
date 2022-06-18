<?php

namespace AmirHossein5\RequestTranslator;

use Illuminate\Support\Arr;

class Translator
{
    /**
     * Registered translation field templates.
     *
     * @var array
     */
    public $templates = [];

    /**
     * Path of translation File.
     *
     * @var string
     */
    public $file = '';

    /**
     * Create a new translator instance.
     *
     * @return void
     */
    public function __construct()
    {
        $locale = config('app.locale') ?? 'en';

        $this->file = lang_path($locale.'_request_translation.php');
    }

    /**
     * Modifies translation file path.
     *
     * @param string $path
     *
     * @return void
     */
    public function fromFile(string $path): void
    {
        $this->file = lang_path($path);
    }

    /**
     * Returns translation file.
     *
     * @return string
     */
    public function file(): string
    {
        return $this->file;
    }

    /**
     * Adds field template.
     *
     * @param string $name
     * @param array $fields
     * @param string $path
     *
     * @return void
     */
    public function for(string $name, array $fields, string $path = null): void
    {
        if ($path) {
            $pathableFields = [];

            foreach ($fields as $key => $value) {
                if (is_int($key)) {
                    $key = $value;
                    $value = $path;
                }
                $pathableFields[$key] = $value;
            }
            
            $this->templates[$name] = $pathableFields;
        } else {
            $this->templates[$name] = $fields;
        }
    }

    /**
     * Returns all of the templates.
     *
     * @return array
     */
    public function templates(): array
    {
        return $this->templates;
    }

    /**
     * Returns intended the template.
     *
     * @param string $name
     *
     * @return array
     */
    public function template(string $name): array
    {
        return $this->templates[$name];
    }

    /**
     * Determines the intended template exists.
     *
     * @param string $name
     *
     * @return bool
     */
    public function hasTemplate(string $name): bool
    {
        return isset($this->templates[$name]);
    }

    /**
     * Translates the given text.
     *
     * @param string $data
     * @param string $translationFile
     *
     * @return string
     */
    public function translate(string $data, string $translationFile = null): string
    {
        $translationFile = $translationFile
            ? lang_path($translationFile)
            : $this->file();

        $translationFile = include $translationFile;

        return strtr($data, $translationFile);
    }

    /**
     * Set an item on an array or object using dot notation and is compatible with closure.
     *
     * @param mixed        $target
     * @param string|array $key
     * @param mixed        $value
     * @param bool         $overwrite
     *
     * @return mixed
     */
    public function data_set_closure(mixed &$target, string|array $key, mixed $value, bool $overwrite = true): mixed
    {
        $segments = is_array($key) ? $key : explode('.', $key);

        if (($segment = array_shift($segments)) === '*') {
            if (!Arr::accessible($target)) {
                $target = [];
            }

            if ($segments) {
                foreach ($target as &$inner) {
                    $this->data_set_closure($inner, $segments, $value, $overwrite);
                }
            } elseif ($overwrite) {
                foreach ($target as &$inner) {
                    if ($value instanceof \Closure) {
                        if (is_array($inner)) {
                            $this->data_set_closure($inner, '*', $value, $overwrite);
                        } else {
                            $inner = $value($inner);
                        }
                    } else {
                        if (is_array($inner)) {
                            $this->data_set_closure($inner, '*', $value, $overwrite);
                        } else {
                            $inner = $value;
                        }
                    }
                }
            }
        } elseif (Arr::accessible($target)) {
            if ($segments) {
                // if (!Arr::exists($target, $segment)) {
                //     $target[$segment] = [];
                // }
                // $this->data_set_closure($target[$segment], $segments, $value, $overwrite);

                if (Arr::exists($target, $segment)) {
                    $this->data_set_closure($target[$segment], $segments, $value, $overwrite);
                }
            } elseif ($overwrite || !Arr::exists($target, $segment)) {
                if ($value instanceof \Closure) {
                    $target[$segment] = $value($target[$segment]);
                } else {
                    $target[$segment] = $value;
                }
            }
        } elseif (is_object($target)) {
            if ($segments) {
                if (!isset($target->{$segment})) {
                    $target->{$segment} = [];
                }

                $this->data_set_closure($target->{$segment}, $segments, $value, $overwrite);
            } elseif ($overwrite || !isset($target->{$segment})) {
                if ($value instanceof \Closure) {
                    $target->{$segment} = $value($target->{$segment});
                } else {
                    $target->{$segment} = $value;
                }
            }
        } else {
            $target = [];

            if ($segments) {
                $this->data_set_closure($target[$segment], $segments, $value, $overwrite);
            } elseif ($overwrite) {
                if ($value instanceof \Closure) {
                    $target[$segment] = $value($target[$segment]);
                } else {
                    $target[$segment] = $value;
                }
            }
        }

        return $target;
    }
}
