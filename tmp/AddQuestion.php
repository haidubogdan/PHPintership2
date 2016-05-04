<?php

namespace Quiz\controllers;

use Quiz\models\QuestionModel as QuestionModel;
use Quiz\models\QuizModel as QuizModel;
use Quiz\models\RequestMethods as RequestMethods;

/**
 * Description of AddQuestion
 * Controller class which is the post link for the question creator form
 * @author bogdanhaidu
 */
class AddQuestion
{

    private $page_title = "add question";
    private $json_scripts = array("general_js.js", "admin_js.js");
    private $question_type = array(
        "single_choice" => array("function" => 'saveSingleAnswerQuestion'),
        "multiple_choice" => array("function" => 'saveMultipleAnswerQuestion'),
        "complete_text" => array("function" => ''),
    );

    function __construct()
    {

        $question = new QuestionModel ();
        $question_args = array(
            'question_name' => "FILTER_SANITIZE_SPECIAL_CHARS",
            'question_text' => "FILTER_SANITIZE_SPECIAL_CHARS",
            'question_type' => "FILTER_SANITIZE_SPECIAL_CHARS",
            'number_of_answers' => "FILTER_VALIDATE_INT",
            'valid_answer' => "FILTER_SANITIZE_SPECIAL_CHARS",
        );

        $question_inputs = filter_input_array(INPUT_POST, $question_args);
        $type = $question_inputs['question_type'];
        $function = $this->question_type[$type]["function"];

        if ($function != "") {
            $question_answer = $this->$function();
        } else {
            $question_answer = array();
        }
        date_default_timezone_set('Europe/Bucharest'); //Poate mutam in obiect
        $date = array("date" => date('Y/m/d h:i:sa ', time()));
        var_dump($question_inputs + $question_answer + $date);
        $question_data = $question_inputs + $question_answer + $date;
        $result = $question->saveQuestion($question_data);
        if ($result == 1) {
            $_SESSION['saved_question'] = $question_inputs['question_name'];
            header("location:index.php?page=admin&operation=create_question");
        }
    }

    /**
     * creates an array with the question answers and valid answers
     * @return array
     */
    public function saveSingleAnswerQuestion()
    {
        $number_of_answers = RequestMethods::post('number_of_answers');
        for ($i = 1; $i <= $number_of_answers; $i++) {
            $key = "answer_" . $i;
            $question_answer[$key] = RequestMethods::post($key);
            $key2 = "valid_answer_" . $i;
            $question_answer[$key2] = RequestMethods::post($key2);
        }

        return $question_answer;
    }

    /**
     * creates an array with the question answers and valid answers
     * @return array
     */
    public function saveMultipleAnswerQuestion()
    {
        $number_of_answers = RequestMethods::post('number_of_answers');
        for ($i = 1; $i <= $number_of_answers; $i++) {
            $key = "answer_" . $i;
            $question_answer[$key] = RequestMethods::post($key);
            $key2 = "valid_answer_" . $i;
            $question_answer[$key2] = RequestMethods::post($key2);
        }
        return $question_answer;
    }

}
