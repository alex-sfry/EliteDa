<?php

namespace app\helpers;

use yii\base\InvalidValueException;
use yii\helpers\BaseVarDumper;

/**
 * Dumper is a replacement of built-in VarDumper Class
 */
class Dumper extends BaseVarDumper
{
    private static $objects;
    private static $output;
    private static $depth;

    public static function dump($var, $depth = 10, $highlight = true)
    {
        echo static::dumpAsString($var, $depth, $highlight);
        echo '=====================End==========================' . '<br>';
    }

    public static function dumpAsString($var, $depth = 10, $highlight = false)
    {
        self::$output = '';
        self::$objects = [];
        self::$depth = $depth;
        self::dumpInternal($var, 0);
        if ($highlight) {
            $result = highlight_string("<?php\n" . self::$output, true);
            self::$output = preg_replace('/&lt;\\?php<br \\/>/', '', $result, 1);
        }

        return self::$output;
    }

    private static function dumpInternal($var, $level)
    {
        switch (gettype($var)) {
            case 'boolean':
                self::$output .= $var ? 'true' : 'false';
                break;
            case 'integer':
                self::$output .= (string)$var;
                break;
            case 'double':
                self::$output .= (string)$var;
                break;
            case 'string':
                self::$output .= "'" . addslashes($var) . "'";
                break;
            case 'resource':
                self::$output .= '{resource}';
                break;
            case 'NULL':
                self::$output .= 'null';
                break;
            case 'unknown type':
                self::$output .= '{unknown}';
                break;
            case 'array':
                if (self::$depth <= $level) {
                    self::$output .= '[...]';
                } elseif (empty($var)) {
                    self::$output .= 'array []';
                } else {
                    $keys = array_keys($var);
                    $spaces = str_repeat(' ', $level * 4);
                    self::$output .= 'array (' . count($keys) . ') [';
                    foreach ($keys as $key) {
                        self::$output .= "\n" . $spaces . '    ';
                        self::dumpInternal($key, 0);
                        self::$output .= ' => ';
                        self::dumpInternal($var[$key], $level + 1);
                    }
                    self::$output .= "\n" . $spaces . ']';
                }
                break;
            case 'object':
                if (($id = array_search($var, self::$objects, true)) !== false) {
                    self::$output .= get_class($var) . '#' . ($id + 1) . '(...)';
                } elseif (self::$depth <= $level) {
                    self::$output .= get_class($var) . '(...)';
                } else {
                    $id = array_push(self::$objects, $var);
                    $className = get_class($var);
                    $spaces = str_repeat(' ', $level * 4);
                    self::$output .= "$className#$id\n" . $spaces . '(';
                    if ('__PHP_Incomplete_Class' !== get_class($var) && method_exists($var, '__debugInfo')) {
                        $dumpValues = $var->__debugInfo();
                        if (!is_array($dumpValues)) {
                            throw new InvalidValueException('__debuginfo() must return an array');
                        }
                    } else {
                        $dumpValues = (array) $var;
                    }
                    foreach ($dumpValues as $key => $value) {
                        $keyDisplay = strtr(trim($key), "\0", ':');
                        self::$output .= "\n" . $spaces . "    [$keyDisplay] => ";
                        self::dumpInternal($value, $level + 1);
                    }
                    self::$output .= "\n" . $spaces . ')';
                }
                break;
        }
    }
}
