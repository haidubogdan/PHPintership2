<?php

namespace Quiz\models;

use Quiz\models\QuizModel as QuizModel;
use Quiz\models\DB as DB;
use Quiz\models\QuestionModel as QuestionModel;

class QuizFlowModel extends DB
{

    private $username;
    private $user_id;
    private $current_quiz_number;
    private $current_quiz_name;
    private $current_question_id;
    private $current_question_id_set;
    private $current_questions_number_set;
    private $data = array();
    private $save_path = TEMPORARY_QUIZ_ANSWERS_PATH;
    private $final_save_path = "app/db/quiz_rezults/";
    private $file_name = "file_name.json";

    public function __construct()
    {
        $this->setUsername($_SESSION['user']['username']);
    }

    public function startQuiz($quiz_number)
    {
        //VERIFY QUIZ NUMBER
        $this->current_quiz_number = $quiz_number;
        $this->file_name = "quiz_" . $this->current_quiz_number . "_rezults_" . $this->username . ".json";
        $quiz = new QuizModel();
        $this->data = $the_quiz = $quiz->getQuizById($quiz_number);
        $this->current_quiz_name = $the_quiz['quiz_name'];
        $this->current_question_id_set = $the_quiz['id_question_order'];
        $this->current_questions_number_set = count($the_quiz['id_question_order']);
        //var_dump($the_quiz);
        $this->quizFlow($the_quiz);
    }

    public function setUsername($value)
    {
        $this->username = $value;
    }

    public function quizFlow()
    {
        //LOOK FOR tmpfile
        $current_button_id = filter_input(INPUT_POST, 'next');
        if (!isset($_SESSION['quiz_question'])) {
            $_SESSION['quiz_question'] = 1;
            $this->current_question_id = 1;
        } else if ($current_button_id <= $this->current_questions_number_set + 1) {
            if (!empty($current_button_id) && $current_button_id == $_SESSION['quiz_question'] + 1) {
                (int) $_SESSION['quiz_question'] ++;
                $this->saveProgress($this->checKPostInput());
            }
        }
        if ($_SESSION['quiz_question'] == $this->current_questions_number_set + 1) {
            $file = $this->save_path . $this->file_name;
            $newfile = $this->final_save_path . strstr($this->file_name, '.json', true) . "_" . date('Y-m-d-his', time()) . ".json";
            if (!copy($file, $newfile)) {
                echo "failed to copy $newfile...\n";
            }
            $_SESSION['file_name'] = $newfile;
            $_SESSION['quiz_finished'] = 1;
        }
        $this->current_question_id = $_SESSION['quiz_question'];
        $next_question_id = $this->current_question_id + 1;
        $compact_keys = array('current_question_id', 'next_question_id');
        $this->data = $this->data + compact($this, 'current_question_id', 'next_question_id', $compact_keys);
    }

    public function saveProgress($data)
    {
        if (!file_exists($this->save_path . $this->file_name)) {
            echo "File doesn't exist!!";
            $values [] = $data;
            $new_data = array("quiz_id" => $this->current_quiz_number,
                            "quiz_name" => $this->current_quiz_name,
                            "username" => $this->username, 
                            "user_id" => $this->user_id,
                            "answers" => $values);
            $this->saveData($this->file_name, $this->save_path, $new_data);
        } else {
            echo "File exists!!";
            $new_data = $this->getJsonContentFromFile($this->file_name, $this->save_path);
            $new_data ['quiz_name'] =  $this->current_quiz_name;
            if (count($new_data['answers']) >= $this->current_questions_number_set) {
                $new_data["answers"] = array();
            }
            array_push($new_data["answers"], $data);
            $sum = array_reduce($new_data["answers"], function($result, $item) {
                if ($item['response'] == "true") {
                    echo "<br>true ";
                    echo $result+=1;
                } else {
                    echo "<br>false";
                    $result+=0;
                }
                return $result;
            });
            $new_data['score'] = (round($sum * 100 / count($new_data["answers"]), 2)) . "%";
            
        }
        $this->saveData($this->file_name, $this->save_path, $new_data);
    }

    public function readJsonProgress()
    {
        return $this->getJsonContentFromFile($this->file_name, $this->save_path);
    }

    public function checKPostInput()
    {
        echo "<br>fisier este" . $this->file_name;
        echo "<br>path este" . $this->save_path;
        date_default_timezone_set('Europe/Bucharest'); //Poate mutam in obiect
        $answer_args = array(
            'question_type' => "FILTER_SANITIZE_SPECIAL_CHARS",
            'number_of_answers' => "FILTER_VALIDATE_INT",
            'answer' => "FILTER_SANITIZE_SPECIAL_CHARS",
        );

        $answer_inputs = filter_input_array(INPUT_POST, $answer_args);
        $question_data = $this->getQuestionAnswer();
        $response = array('response' => $answer_inputs['answer'] == $question_data['valid_answer']);
        if ($answer_inputs['question_type'] == "multiple_choice") {
            for ($i = 1; $i <= (int) $answer_inputs['number_of_answers']; $i++) {
                if ($question_data ['valid_answer_' . $i]) {
                    $solutions['valid_answer_' . $i] = $question_data ['answer_' . $i];
                } else {
                    $solutions['valid_answer_' . $i] = null;
                }
                $check['valid_answer_' . $i] = $answer_inputs['answer_' . $i] = filter_input(INPUT_POST, 'answer_' . $i);
            }
            $response = array('response' => array_intersect($check, $question_data) == $solutions);
        }


        $question_id = array("question_id" => $this->current_question_id_set[$_SESSION['quiz_question'] - 2]);
        $date = array("date" => date('Y/m/d h:i:sa ', time()));


        return $answer_inputs + $question_id + $response + $date;
    }

    public function greet()
    {
        echo "Welcome " . $this->username . " !";
    }

    public function createDynamicQuestionData()
    {
        $questions = new QuestionModel ();
        $id = $this->current_question_id - 1;
        $question_data = $questions->getQuestionById($this->current_question_id_set[$id]);
        $question_data['question_nr'] = $this->current_question_id;
        unset($question_data['id']);
        $this->data = $this->data + $question_data;
    }

    public function getQuestionAnswer()
    {
        $questions = new QuestionModel ();
        $id = $_SESSION['quiz_question'] - 2;
        if (array_key_exists($id, $this->current_question_id_set)) {
            return $question_data = $questions->getQuestionById($this->current_question_id_set[$id]);
        }
    }

    public function getDynamicQuestionData()
    {
        return $this->data;
    }

    public function getFilename()
    {
        return $this->file_name;
    }

}
