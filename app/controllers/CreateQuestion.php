<?php

namespace Quiz\controllers;

use Quiz\models\QuizModel as QuizModel;
use Quiz\models\CompleteTextQuestionModel as CompleteTextQuestionModel;
use Quiz\models\SingleChoiceQuestionModel as SingleChoiceQuestionModel;
use Quiz\models\MultipleChoiceQuestionModel as MultipleChoiceQuestionModel;
use Quiz\models\RequestMethods as RequestMethods;

class CreateQuestion
{

    private $page_title = "Question Creator";
    private $json_scripts = array("js_general.js", "admin_js.js");
    private $current_question_type;
    private $current_question_type_path2;

    public function __construct()
    {

        //$operations = new AdminOperations ();
        $question_types = array(
            "single_choice" => array("class" => "SingleChoiceQuestionModel"),
            "multiple_choice" => array("class" => "MultipleChoiceQuestionModel"),
            "complete_text" => array("class" => "CompleteTextQuestionModel"),
            "true_or_false" => array("class" => "TrueOrFalseQuestionModel"),
        );
        $selected_question_type = filter_input(INPUT_POST, 'question_type');
        $this->current_question_type = $selected_question_type;
        $question_args = array(
            "question_name" => "FILTER_SANITIZE_SPECIAL_CHARS",
            "question_text" => "FILTER_SANITIZE_SPECIAL_CHARS"
        );
        $question_inputs = filter_input_array(INPUT_POST, $question_args);

        //require_once "app/models/" . $question_types [$selected_question_type]["path"];
        $question_class = "Quiz\models\\" . $question_types [$selected_question_type]["class"];
        $question = new $question_class($question_inputs);

        $this->current_question_type_path2 = $question->questionViewPath('2');
        if (empty(RequestMethods::get("type"))) {
            include VIEW_PATH . "head_view.php";

            include VIEW_PATH . $question->questionViewPath();

            include VIEW_PATH . "footer_view.php";
        } else {
            include VIEW_PATH . "head_view.php";
            //echo "linia este " . $this->getCurrentQuestionTypePath2();
            $number_of_answers = filter_input(INPUT_POST, 'number_of_options', FILTER_VALIDATE_INT);
            $question->setNumberOfAnswers($number_of_answers);
            include VIEW_PATH . $this->getCurrentQuestionTypePath2();

            include VIEW_PATH . "footer_view.php";
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

}