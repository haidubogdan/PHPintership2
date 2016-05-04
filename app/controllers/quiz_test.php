<?php

namespace Quiz\controllers;

use Quiz\models\QuizModel as QuizModel;
use Quiz\models\QuizFlowModel as QuizFlowModel;
use Quiz\models\RenderModel as RenderModel;

class QuizTest extends RenderModel
{

    private $page_title = "Quiz Test";
    private $json_scripts = array("general_js.js", "admin_js.js");

    function __construct()
    {
        if (empty($_SESSION['logged'])) {
            header("Location:index.php?page=login");
        }

        include VIEW_PATH . "head_view.php";
        include VIEW_PATH . "main_menu_view.php";
        if (is_numeric($quiz_number = filter_input(INPUT_GET, 'start'))) {
            $quiz_flow = new QuizFlowModel();
            $quiz_flow->startQuiz($quiz_number);
            if (isset($_SESSION['quiz_finished'])) {
                header("Location:index.php?page=quiz_results");
            } else {
                $quiz_flow->createDynamicQuestionData();
                $this->createQuizQuestionPreview($quiz_flow);
            }
        } else {
            $this->resetCounter();
            include VIEW_PATH . "quiz_list_view.php";
        }
        include VIEW_PATH . "footer_view.php";
    }

    public function createQuizQuestionPreview($quiz_flow)
    {
        $data = $quiz_flow->getDynamicQuestionData(); //variable goes in include TODO REFACTOR IT
        include VIEW_PATH . "question_flow_view.php";
    }

    public function resetCounter()
    {
        unset($_SESSION['email_sent']);
        unset($_SESSION['quiz_finished']);
        unset($_SESSION['quiz_question']);
    }

    public function endQuiz()
    {
        
    }

}
