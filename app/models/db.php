<?php

namespace Quiz\models;

class DB {

    private $data;
    private $json_content;

    public function __construct($database_file = "db/newjson.json") {
//        //TODO CONECT TO DATABASE
//        $contents = utf8_encode(file_get_contents($database_file));
//        $this->data = json_decode($contents);
    }

    public function getJsonContentFromFile($file, $path) {
        $contents = utf8_encode(file_get_contents($path . $file));
        return (array) $this->json_content = json_decode($contents,true);
    }

    public function getDataFromJson($file, $path) {
        $this->getJsonContentFromFile($path . $file);
        return (array) $this->json_content;
    }

    public function getData() {
        return (array) $this->data;
    }

    public function saveData($file, $path, $array = array()) {
        //WHERE?
        echo "<br>" . $path;
        file_put_contents($path . $file, json_encode($array));
    }
    public function deleteRow($file, $path, $id) {
        //WHERE?
        $data = $this->getJsonContentFromFile($file, $path);
        unset($data[$id]);
        file_put_contents($path . $file, json_encode($data));
    }
    
}
