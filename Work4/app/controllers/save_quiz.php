<?php

namespace Quiz\controllers;
use Quiz\models\QuizModel as QuizModel;

class SaveQuiz 
{

    private $page_title = "add question";
    private $json_scripts = array("general_js.js", "admin_js.js");

    function __construct($data = array()) 
    {

        $quiz = new QuizModel();
        $quiz_args = array(
            'id' => "FILTER_DEFAULT", //int
            'quiz_name' => "FILTER_SANITIZE_SPECIAL_CHARS",
            'description' => "FILTER_SANITIZE_SPECIAL_CHARS",
        );

        $quiz_questions ["id_question_order"] = $_SESSION["question_id"];
        $quiz_questions ["questions_author"] = $_SESSION["author"];

        //var_dump($quiz_questions);

        $quiz_inputs = filter_input_array(INPUT_POST, $quiz_args);
        date_default_timezone_set('Europe/Bucharest'); //Poate mutam in obiect
        $date = array("date" => date('Y/m/d h:i:sa ', time()));
        $quiz_data = $quiz_inputs + $quiz_questions + $date;
        $quiz->saveQuiz($quiz_data);
        unset($_SESSION["question_id"],$_SESSION["author"],$_SESSION['question_position']);
        header("Location:index.php?page=admin&operation=create_quiz");

    }

}
