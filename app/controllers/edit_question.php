<?php

namespace Quiz\controllers;

use Quiz\models\QuestionModel as QuestionModel;
use Quiz\models\RequestMethods as RequestMethods;

class EditQuestion
{

    private $page_title = "Edit question";
    private $json_scripts = array("general_js.js", "admin_js.js");
    private $question_args = array(
        'id' => "FILTER_VALIDATE_INT",
        'question_name' => "FILTER_SANITIZE_SPECIAL_CHARS",
        'question_text' => "FILTER_SANITIZE_SPECIAL_CHARS",
        'question_type' => "FILTER_SANITIZE_SPECIAL_CHARS",
        'number_of_answers' => "FILTER_VALIDATE_INT",
        'valid_answer' => "FILTER_SANITIZE_SPECIAL_CHARS",
    );
    private $question_type = array(
        "single_choice" => array("function" => 'saveSingleAnswerQuestion'),
        "multiple_choice" => array("function" => 'saveMultipleAnswerQuestion'),
        "complete_text" => array("function" => ''),
    );

    public static function getView()
    {
        $questions = new QuestionModel ();
        $current_index = "index.php?page=admin&operation=edit_question";
        $quiz_edit_index = "index.php?page=admin&operation=edit_quiz";
        $available_questions = $questions->getAvailableQuestions();
        $see_question_number = filter_input(INPUT_GET, 'see_question_id');
        $edit_question_number = filter_input(INPUT_GET, 'edit_question_id');
        $deleted_question_id = RequestMethods::get('delete_question');
        //TODO RENDER
        if (!empty($deleted_question_id) || ($deleted_question_id) != "") {
            self::deleteQuestionFromList($questions,$deleted_question_id);
        }
        include VIEW_PATH . "edit_question_view.php";
    }

    public static function deleteQuestionFromList($questions,$delete_question_id)
    {
            $questions->deleteQuestion($delete_question_id-1);
            header("Location:index.php?page=admin&operation=edit_question");
    }

    public function __construct($data = array())
    {
        $question = new QuestionModel ();

        $question_inputs = filter_input_array(INPUT_POST, $this->question_args);
        $question_inputs['id'] = (int) $question_inputs['id'];
        var_dump($question_inputs);
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
        $question->editQuestion($question_data);
        header("location:index.php?page=admin&operation=edit_question");
    }

    public function saveSingleAnswerQuestion()
    {
        $number_of_answers = RequestMethods::post('number_of_answers');
        for ($i = 1; $i <= $number_of_answers; $i++) {
            $key = "answer_" . $i;
            $question_answer[$key] = filter_input(INPUT_POST, $key);
            $key2 = "valid_answer_" . $i;
            $question_answer[$key2] = filter_input(INPUT_POST, $key2);
        }

        return $question_answer;
    }

    public function saveMultipleAnswerQuestion()
    {
        $number_of_answers = filter_input(INPUT_POST, 'number_of_answers');
        for ($i = 1; $i <= $number_of_answers; $i++) {
            $key = "answer_" . $i;
            $question_answer[$key] = filter_input(INPUT_POST, $key);
            $key2 = "valid_answer_" . $i;
            $question_answer[$key2] = filter_input(INPUT_POST, $key2);
        }
        return $question_answer;
    }

}
