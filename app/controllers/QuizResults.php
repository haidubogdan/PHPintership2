<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Quiz\controllers;

use Quiz\models\QuizFlowModel as QuizFlowModel;
use Quiz\models\Emailer as Emailer;
/**
 * Description of QuizResults
 *
 * @author bogdanhaidu
 */
class QuizResults
{

    private $page_title = "Quiz Results";
    private $json_scripts = array("js_general.js", "admin_js.js");

    function __construct()
    {
        $result = json_decode(file_get_contents($_SESSION['file_name']), TRUE);
        echo "Ai gatat";

        $mail_val["Email"] = "haidu.bogdan@yahoo.com";
        $mail_val["Name"] = "Haidu Bogdan";

        $mail_val["Body"] = "
                Buna, eu sunt Bogdan, si la quiz-ul ". $result['quiz_name'] ." ai un rezultat de" . $result['score'] . " din 100%";
        //new Emailer($mail_val);

        include VIEW_PATH . "head_view.php";
        include VIEW_PATH . "main_menu_view.php";
        include VIEW_PATH . "quiz_result_view.php";
        include VIEW_PATH . "footer_view.php";
    }

    public function resetCounter()
    {
        unset($_SESSION['quiz_finished']);
        unset($_SESSION['quiz_question']);
    }

}
