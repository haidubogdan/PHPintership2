<?php

namespace Quiz\models;

use Quiz\models\DB as DB;
use Quiz\models\Question as Question;

//require_once 'app/models/db.php';

class QuestionModel extends DB
{

    private $save_path = QUESTION_PATH;
    private $file_name = "admin_questions.json";
    private $class_file_name = "admin_class_questions.json";
    public function saveQuestion($data = array())
    {

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

    public function editQuestion($data = array())
    {

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

    public function deleteQuestion($id)
    {
        $this->deleteRow($this->file_name, $this->save_path, $id);
    }

    public function getAvailableQuestions()
    {
        return $this->getJsonContentFromFile($this->file_name, $this->save_path);
    }

    public function getQuestionById($id)
    {

        return $this->getJsonContentFromFile($this->file_name, $this->save_path)[$id];
    }

    public function getSortedQuestions($id = array())
    {
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

    public function convertArraytoClass()
    {
        $questions = $this->getAvailableQuestions();

        foreach ($questions as $key => $question) {
            $question_class[$key] = new Question ();
            $this->setQuestionClassValues($question_class[$key], $question);
            $serialized_class = serialize($question_class[$key]);
        }
        
        var_dump($serialized_class);
        $this->saveData($this->class_file_name, $this->save_path,$serialized_class);
    }

    public function setQuestionClassValues($class, $question)
    {
        $class->setQuestionId($question['id']);
        $class->setQuestionName($question['question_name']);
        $class->setQuestionText($question['question_text']);
        $class->setQuestionType($question['question_type']);
        if (!empty($question['number_of_answers'])) {
            $class->setQuestionAnswersNumber($question['number_of_answers']);
        }
        if ($question['question_type'] == 'complete_text' || $question['question_type'] == 'single_choice') {
            $class->setSingleValidQuestionClass($question['valid_answer']);
        }
        if ($question['question_type'] == 'single_choice' || $question['question_type'] == 'multiple_choice') {
            $class->setMultipleAnswerQuestionClassValues($question);
        }
        $class->setDate($question['date']);
        $class->setQuestionAuthor("admin");
    }

}
