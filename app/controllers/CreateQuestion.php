<?php

namespace Quiz\controllers;

use Quiz\models\QuizModel as QuizModel;
use Quiz\models\QuestionModel as QuestionModel;
use Quiz\models\CompleteTextQuestionModel as CompleteTextQuestionModel;
use Quiz\models\SingleChoiceQuestionModel as SingleChoiceQuestionModel;
use Quiz\models\MultipleChoiceQuestionModel as MultipleChoiceQuestionModel;
use Quiz\models\RequestMethods as RequestMethods;

/**
 * Description of CreateQuestion
 * Controller class used to manage the views and forms when creating and adding new questions
 * There are two views for the multiple type questions
 * @author bogdanhaidu
 */
class CreateQuestion
{

    private $page_title = "Question Creator";
    private $json_scripts = array("general_js.js", "admin_js.js");
    private $current_question_type;
    private $current_question_type_path2;
    private $question_type = array(
        "single_choice" => array("function" => 'saveSingleAnswerQuestion', "class" => "SingleChoiceQuestionModel"),
        "multiple_choice" => array("function" => 'saveMultipleAnswerQuestion', "class" => "MultipleChoiceQuestionModel"),
        "complete_text" => array("function" => '', "class" => "CompleteTextQuestionModel"),
    );
    private $question_args1 = array(
        "question_name" => "FILTER_SANITIZE_SPECIAL_CHARS",
        "question_text" => "FILTER_SANITIZE_SPECIAL_CHARS"
    );

    public function __construct()
    {
        if (RequestMethods::post('save_question')) {
            $this->addQuestiontoDB();
        } else {
            $question = $this->createQuestionClass();
            $this->current_question_type_path2 = $question->questionViewPath('2');
            if (empty(RequestMethods::get("type"))) {
                include VIEW_PATH . "head_view.php";
                include VIEW_PATH . $question->questionViewPath();
                include VIEW_PATH . "footer_view.php";
            } else {
                include VIEW_PATH . "head_view.php";
                $number_of_answers = filter_input(INPUT_POST, 'number_of_options', FILTER_VALIDATE_INT);
                $question->setNumberOfAnswers($number_of_answers);
                include VIEW_PATH . $this->getCurrentQuestionTypePath2();

                include VIEW_PATH . "footer_view.php";
            }
        }
    }

    public static function getView()
    {

        if (isset($_SESSION['saved_question'])) {
            $succes_message = "Succes the question " . $_SESSION['saved_question'] . " has been saved!";
            unset($_SESSION['saved_question']);
        } else {
            $succes_message = "";
        }
        include VIEW_PATH . "create_question_view.php";
    }

    public function getCurrentQuestionTypePath2()
    {
        return $this->current_question_type_path2;
    }

    public function createQuestionClass()
    {
        $question_types = $this->question_type;
        $this->current_question_type = $selected_question_type = RequestMethods::post('question_type');
        $question_inputs = filter_input_array(INPUT_POST, $this->question_args1);
        $this->current_question_type = $selected_question_type = RequestMethods::post('question_type');
        $question_class = "Quiz\models\\" . $question_types [$selected_question_type]["class"];
        return new $question_class($question_inputs);
    }

    public function addQuestiontoDB()
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
