<?php
namespace Quiz\controllers;

define("VIEW_PATH", "app/views/");
define("MODELS_PATH", "app/models/");
define("CONTROLLERS_PATH", "app/controllers/");
define("QUESTION_PATH", "app/db/questions/");
define("QUIZ_PATH", "app/db/quiz/");
define("TEMPORARY_QUIZ_ANSWERS_PATH", "app/db/tmp/");

class Controller 
{

    public function __construct() 
    {

        $pages = array(
            "home" => array("path" => "home.php", "class" => "Home"),
            "create_question" => array("path" => "CreateQuestion.php", "class" => "CreateQuestion"),
            "add_question" => array("path" => "add_question.php", "class" => "AddQuestion"),
            "edit_question" => array("path" => "edit_question.php", "class" => "EditQuestion"),
            "create_question_part2" => array("path" => "create_question_part2.php", "class" => "CreateQuestion2"),
            "admin" => array("path" => "admin.php", "class" => "Admin"),
            "save_quiz" => array("path" => "save_quiz.php", "class" => "SaveQuiz"),
            "edit_quiz" => array("path" => "edit_quiz.php", "class" => "EditQuiz"),
            "quiz_test" => array("path" => "quiz_test.php", "class" => "QuizTest"),
            "quiz_results" => array("path" => "QuizResults.php", "class" => "QuizResults"),
            "login" => array("path" => "login.php", "class" => "Login"),
            "profile" => array("path" => "Profile.php", "class" => "Profile"),
            "registration" => array("path" => "registration.php", "class" => "Registration"),
            "page_not_found" => array("path" => "PageNotFound.php", "class" => "PageNotFound"),
        );

        $page = "home";
        $page_get_input = filter_input(INPUT_GET, "page");

        if (!empty($page_get_input)) {
            if (array_key_exists($page_get_input, $pages)) {
            $page = $page_get_input;
            } else {
                header("Location:index.php?page=page_not_found");
                $page = "page_not_found";
            }
        }

        $controllerPath = $pages[$page]["path"];
        $controller = 'Quiz\controllers\\' . $pages[$page]["class"];
        require_once $controllerPath;
        new $controller();
    }

}
