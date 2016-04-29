<?php
namespace Quiz\models;
use Quiz\models\DB as DB;

class QuizModel extends DB {

    private $save_path = QUIZ_PATH;
    private $file_name = "quiz_collection.json";

    public function saveQuiz($data = array()) {

        if (!file_exists($this->save_path . $this->file_name)) {
            echo "File doesn't exist!!";
            $id = array("id" => 0);
            $new_data [] = $id + $data;
            $this->saveData($this->file_name, $this->save_path, $new_data);
        } else {
            echo "File exists!!";
            $new_data = $this->getJsonContentFromFile($this->file_name, $this->save_path);
            $id = array("id" => count($new_data));
            array_push($new_data, $id + $data);
            $this->saveData($this->file_name, $this->save_path, $new_data);
        }
    }

    public function editQuiz($data = array()) {

        if (!file_exists($this->save_path . $this->file_name)) {
            echo "File doesn't exist!!";
            $id = array("id" => 1);
            $old_data [] = $id + $data;
            $this->saveData($this->file_name, $this->save_path, $old_data);
        } else {
            echo "File exists!!";
            $old_data = $this->getJsonContentFromFile($this->file_name, $this->save_path);
            $old_data [$data['id']] = $data;
            $this->saveData($this->file_name, $this->save_path, $old_data);
        }
    }

    public function deleteQuiz($id) {
        $this->deleteRow($this->file_name, $this->save_path, $id);
    }

    public function getAvailableQuiz() {
        return $this->getJsonContentFromFile($this->file_name, $this->save_path);
    }

    public function getQuizById($id = 0) {
        return $this->getAvailableQuiz()[$id];
    }

    public function getQuizQuestionsIDsIdByID($id = 0) {
        $ids = $this->getQuizById($id)['id_question_order'];
        array_walk($ids, function(&$item) {
            $item = (int) ($item);
        });
        return $ids;
    }

}
