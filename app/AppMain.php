<?php

namespace vzp;

class AppMain {
    
    /** @var vzp\AppMain*/
    protected static $instance = null;

    protected function __construct() {
    }

    protected function __destruct() {

        public function __destruct() {
        }
        
        /** @return vzp\AppMain **/
        static public function getInstance() {
            if(is_null(self::$instance)) {
                self::$instance = new AppMain();
            }
            return self::$instance;
        }
    }
    