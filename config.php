<?php

/**
 * Class Config
 * Saving global params
 */
class Config {
    static $_stack = array();

    /**
     * @param $key
     * @return mixed|null
     */
    static function get($key) {
        return (isset(self::$_stack[$key])) ? self::$_stack[$key] : NULL;
    }

    /**
     * @param $key
     * @param null $value
     */
    static function set($key, $value = NULL) {
        self::$_stack[$key] = $value;
    }
}