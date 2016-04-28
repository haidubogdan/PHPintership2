<?php

namespace Quiz\controllers;

use Quiz\controllers\EditQuestion as EditQuestion;
use Quiz\models\QuestionModel as QuestionModel;
use Quiz\models\QuizModel as QuizModel;
use Quiz\models\RequestMethods as RequestMethods;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of admin
 *
 * @author bogdanhaidu
 */
class Admin
{

    private $page_title = "admin";
    private $json_scripts = array("general_js.js", "admin_js.js");
    private $valid_sub_pages_view = array(
        "create_quiz" => array("path" => "quiz_creator_view.php", "class" => "CreateQuiz"),
        "edit_quiz" => array("path" => "quiz_edit_view.php", "class" => "createQuizParameters"),
        "create_question" => array("path" => "create_question_view.php", "class" => "CreateQuestion"),
        "edit_question" => array("path" => "edit_question_view.php", "class" => "EditQuestion"),
        "edit_quiz_list" => array("path" => "quiz_list_edit_view.php", "class" => "createQuizParameters")
    );

    function __construct()
    {
        if (empty($_SESSION['admin']) && !empty($_SESSION['logged'])) {
            header("Location:index.php?page=home");
        }
        include VIEW_PATH . "head_view.php";
        include VIEW_PATH . "main_menu_view.php";

        if (empty($_SESSION['admin'])) {
            include VIEW_PATH . "admin_login_form_view.php";
        } else {
            include VIEW_PATH . "admin_menu_view.php";

            $sub_page = RequestMethods::get('operation');

            if (!empty($sub_page)) {
                $class = $this->valid_sub_pages_view[$sub_page]['class'];
                call_user_func(array(__NAMESPACE__ . "\\" . $class, 'getView'), $sub_page);
                $element_id = RequestMethods::get($sub_page."_id");
            }
        }
        include VIEW_PATH . "footer_view.php";
    }

    function loadDeleteProcesses()
    {
        $delete_question_id = filter_input(INPUT_GET, 'delete_question');
        if (!empty($delete_question_id) || ($delete_question_id) != "") {
            $question = new QuestionModel ();
            $question->deleteQuestion($delete_question_id);
            header("Location:index.php?page = admin&operation = edit_question");
        }
        $delete_quiz_id = filter_input(INPUT_GET, 'delete_quiz');
        if (!empty($delete_quiz_id) || ($delete_quiz_id) != "") {
            $question = new QuizModel ();
            $question->deleteQuiz($delete_quiz_id);
            header("Location:index.php?page = admin&operation = edit_quiz_list");
        }
    }

}
