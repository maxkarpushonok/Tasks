<?php

/**
 * Class Model
 * Abstract class of model
 */
class Model {
    protected $mysqli = NULL;

    /**
     * Model constructor.
     */
    public function __construct()
    {
        $this->mysqli = new mysqli(
            'localhost',
            Config::get('db_user'),
            Config::get('db_pass'),
            Config::get('db_name')
        );
    }

    /**
     * Abstract method
     */
    public function get_page_count() {

    }

    /**
     * Abstract method
     */
    public function get_data() {

    }

    /**
     * Close connect
     */
    public function close_connect() {
        $this->mysqli->close();
    }
}