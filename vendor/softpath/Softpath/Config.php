<?php

namespace Softpath;

class Config {

    public function __construct($config_file) {
        $config = json_decode(utf8_encode(file_get_contents($config_file)),true);
        $json_error = json_last_error();
        if ($json_error === JSON_ERROR_NONE) {
            $this->config = array_replace_recursive($config['development'],$config['production']);
        }
        else {
            $this->config = array("error",$json_error);
        }
    }

    public function __get($config_key) {
        return $this->config[$config_key] ?: false;
    }
}
