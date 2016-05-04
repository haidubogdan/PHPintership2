<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Quiz\controllers;

use Quiz\models\QuizFlowModel as QuizFlowModel;
use Quiz\models\Emailer as Emailer;
use Quiz\Entitiy\UserRepository as UserRepository;

/**
 * Description of QuizResults
 * Quiz Rezults
 * @author bogdanhaidu
 */
class QuizResults
{

    private $page_title = "Quiz Results";
    private $json_scripts = array("general_js.js", "admin_js.js");

    function __construct()
    {
        $user_repository = new UserRepository();
        $result = json_decode(file_get_contents($_SESSION['file_name']), TRUE);
        echo "Ai gatat";
        if (empty($_SESSION['admin'])&&empty($_SESSION['email_sent'])) {
            $mail_val["Email"] = $user_repository->getEmailById($_SESSION['user']['id']);
            $mail_val["Name"] = $user_repository->getUsernameById($_SESSION['user']['id']);

            $mail_val["Body"] = "
                Buna, la quiz-ul " . $result['quiz_name'] . " ai un rezultat de " . $result['score'] . " din 100%";

            $_SESSION['email_sent']=1;
            new Emailer($mail_val);
        }
        include VIEW_PATH . "head_view.php";
        include VIEW_PATH . "main_menu_view.php";
        include VIEW_PATH . "quiz_result_view.php";
        include VIEW_PATH . "footer_view.php";

        $this->resetCounter();
    }

    public function resetCounter()
    {
        unset($_SESSION['quiz_finished']);
        unset($_SESSION['quiz_question']);
    }

}
