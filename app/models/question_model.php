<?php

namespace Quiz\models;
use Quiz\models\DB as DB;
//require_once 'app/models/db.php';

class QuestionModel extends DB {

    private $save_path = QUESTION_PATH;
    private $file_name = "admin_questions.json";

    public function saveQuestion($data = array()) {

        if (!file_exists($this->save_path . $this->file_name)) {
            echo "File doesn't exist!!";
            $id = array("id" => 0);
            $new_data [] = $id + $data;
            $this->saveData($this->file_name, $this->save_path, $new_data);
        } else {
            echo "File exists!!";
            $new_data = $this->getJsonContentFromFile($this->file_name, $this->save_path);
            $id = array("id" => count($new_data) + 1);
            array_push($new_data, $id + $data);
            $this->saveData($this->file_name, $this->save_path, $new_data);
            return 1;
        }
    }

    public function editQuestion($data = array()) {

        if (!file_exists($this->save_path . $this->file_name)) {
            echo "File doesn't exist!!";
            $id = array("id" => 1);
            $new_data [] = $id + $data;
            $this->saveData($this->file_name, $this->save_path, $new_data);
        } else {
            echo "File exists!!";
            $old_data = $this->getJsonContentFromFile($this->file_name, $this->save_path);
            $old_data [$data['id']] = $data;
            $this->saveData($this->file_name, $this->save_path, $old_data);
        }
    }
    public function deleteQuestion($id){
        $this->deleteRow($this->file_name, $this->save_path, $id);
    }
    public function getAvailableQuestions() {
        return $this->getJsonContentFromFile($this->file_name, $this->save_path);
    }

    public function getQuestionById($id) {
 
        return $this->getJsonContentFromFile($this->file_name, $this->save_path)[$id];
    }

    public function getSortedQuestions($id = array()) {
        $questions = $this->getAvailableQuestions();
        $result_array = array();
        $id_column = array_column($questions, 'id');
        array_walk($id, function($item, $key)use($id_column, $questions, &$result_array) {
            echo $test_key = array_search($item, $id_column);
            if (gettype(array_search($item, $id_column)) != "boolean") {
                $result_array[$key] = $questions [$test_key];
            }
        });
        return $result_array;
    }

    
}
