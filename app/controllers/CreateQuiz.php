<?php

namespace Quiz\controllers;

use Quiz\models\QuizModel as QuizModel;
use Quiz\models\QuestionModel as QuestionModel;
use Quiz\models\RequestMethods as RequestMethods;

/**
 * Description of CreateQuiz
 * Controller class used to manage the views and forms when creating and adding new quiz
 * There are two views for the multiple type questions
 * @author bogdanhaidu
 */
class CreateQuiz
{

    private $page_title = "add quiz";
    private $json_scripts = array("general_js.js", "admin_js.js");
    private $quiz_args = array(
        'id' => "FILTER_DEFAULT", //int
        'quiz_name' => "FILTER_SANITIZE_SPECIAL_CHARS",
        'description' => "FILTER_SANITIZE_SPECIAL_CHARS",
    );
    private static $quiz_url = "index.php?page=admin&operation=create_quiz";
    private static $added_questions = array();
    private static $current_edit_index;
    private static $the_quiz = array();
    private static $quiz_name = "";

    function __construct($data = array())
    {

        $quiz = new QuizModel();


        $quiz_questions ["id_question_order"] = $_SESSION["question_id"];
        $quiz_questions ["questions_author"] = $_SESSION["author"];

        $quiz_inputs = filter_input_array(INPUT_POST, $this->quiz_args);
        date_default_timezone_set('Europe/Bucharest'); //Poate mutam in obiect
        $date = array("date" => date('Y/m/d h:i:sa ', time()));
        $quiz_data = $quiz_inputs + $quiz_questions + $date;
        $quiz->saveQuiz($quiz_data);
        unset($_SESSION["question_id"], $_SESSION["author"], $_SESSION['question_position']);
        header("Location:index.php?page=admin&operation=create_quiz");
    }

    /**
     * static function to get a QuizModel form view
     * @param string $sub_page_path
     */
    public static function getView($sub_page_path, $sub_page_index)
    {
        $questions = new QuestionModel ();
        $quiz = new QuizModel ();
        $available_questions = $questions->getAvailableQuestions();
        $available_quiz = $quiz->getAvailableQuiz();
        $added_question_id = RequestMethods::get('add_question_id');
        $deleted_question_id = RequestMethods::get('delete_quiz_question');
        $question_number = RequestMethods::get('see_question_id');
        $_SESSION["edited_quiz_id"]=$edited_quiz_id = RequestMethods::get('quiz');
        $deleted_quiz_id = RequestMethods::get('delete_quiz');
        $extra_rows = array();

        $_SESSION ["author"] = "admin";
        if (empty($_SESSION["check_start"])) {
            $_SESSION["check_start"] = 1;
            $_SESSION["question_id"] = array();
        } 
        
        self::$quiz_url = "index.php?page=admin&operation=" . $sub_page_index;

        if ($sub_page_index == 'create_quiz') {
            if (!empty($_SESSION["edited_quiz_id"])){
                unset($_SESSION["edited_quiz_id"]);
                unset($_SESSION["question_id"]);
            }
            self::createQuizParametersView($available_questions);
        } else if ($sub_page_index == 'edit_quiz') {
            
            //unset($_SESSION['question_id']);
            //unset($_SESSION['question_position']);
            $the_quiz = $quiz->getQuizById($edited_quiz_id);
            $added_questions = self::$added_questions = $the_quiz['id_question_order'];
            self::editQuizParametersView($quiz, $edited_quiz_id);
            $current_edit_index = self::$current_edit_index;
            self::$quiz_url = $current_edit_index;
            if (empty($_SESSION ["question_id"])){
                $_SESSION ["question_id"]=$added_questions;
            } else {
                //if ($_SESSION['question_position']>count($_SESSION ["question_id"])){
                    $_SESSION['question_position']=count($_SESSION ["question_id"])-1;
                //}
                self::$added_questions = $_SESSION ["question_id"];
            }
        }

        if (!empty($added_question_id) || $added_question_id != "") {
            self::addQuestion($added_question_id, $sub_page_index);
        } else {
            //$added_questions = array();
        }

        if (!empty($deleted_question_id) || $deleted_question_id != "") {
            self::deleteQuestionFromList($deleted_question_id-1);
        }
        if (!empty($deleted_quiz_id) || ($deleted_quiz_id) != "") {
            self::deleteQuizFromList($quiz, $deleted_quiz_id-1);
        }
        $added_questions = self::$added_questions;
        include VIEW_PATH . $sub_page_path;
    }

    /**
     * Deletes a question from quiz and then returns back to the list view page
     * @param object $quiz
     * @param int $deleted_quiz_id
     */
    public static function createQuizParametersView($available_questions)
    {
        if (!empty(RequestMethods::get('save_name'))) {
            self::$quiz_name = $_SESSION['quiz_name'] = RequestMethods::get('save_name');
            echo "test" . $_SESSION['quiz_name'];
        } else if (!empty($_SESSION['quiz_name'])) {
            self::$quiz_name = $_SESSION['quiz_name'];
        }

        if (!empty($_SESSION['question_id'])) {
            self::updateQuestionIndexSession($available_questions);
        }
    }

    public static function editQuizParametersView($quiz, $edited_quiz_id)
    {
        if (empty($edited_quiz_id)) {
            self::$current_edit_index = "index.php?page=admin&operation=edit_quiz";
        } else {
            $id = $quiz->getQuizQuestionsIDsIdByID($edited_quiz_id);
            $added_questions = $id;
            self::$current_edit_index = "index.php?page=admin&operation=edit_quiz&quiz=" . $edited_quiz_id;
            self::$the_quiz = $quiz->getQuizById($edited_quiz_id);
        }
 
    }

    public static function deleteQuizFromList($quiz, $deleted_quiz_id)
    {
        if (RequestMethods::get('confirm')) {
            $quiz->deleteQuiz($deleted_quiz_id);
            header("Location:index.php?page = admin&operation = edit_quiz_list");
        } else {
            //echo "Nu Stergem";
        }
    }

    public static function deleteQuestionFromList($deleted_question_id)
    {
        if (!isset($_SESSION['question_position'])) {
            $_SESSION['question_position'] = 0;
        } else if ($_SESSION['question_position'] >= 0) {
            $_SESSION['question_position'] --;
        }
        echo "Stergem<br>";
        unset($_SESSION ["question_id"][$deleted_question_id]);
        $_SESSION ["question_id"] = array_values($_SESSION ["question_id"]);
        header("Location:" . self::$quiz_url);
    }

    public static function addQuestion($added_question_id, $sub_page)
    {
        if (!isset($_SESSION['question_position'])) {
            $_SESSION['question_position'] = 0;
        } else if ($_SESSION['question_position'] >= 0) {
            $_SESSION['question_position']++ ;
        } else if ($_SESSION['question_position'] < 0) {
            $_SESSION['question_position'] = 0;
        }
        $_SESSION ["question_id"][$_SESSION['question_position']] = (int) $added_question_id;
        header("Location:" . self::$quiz_url);
    }

    public static function updateQuestionIndexSession($available_questions)
    {
        self::$added_questions = $_SESSION ["question_id"];
        $number_of_questions = count($available_questions);
        $diff_count = count(self::$added_questions) - $number_of_questions;
        $extra_rows_map = array_map(function($key, $value)use($number_of_questions, $diff_count) {
            if ($diff_count > 0 && $key > ($number_of_questions - 1)) {
                echo $key;
                return $value;
            }
        }, array_keys(self::$added_questions), self::$added_questions);
        $extra_rows = array_filter($extra_rows_map, function($value) {
            if (!empty($value)) {
                return $value;
            }
        });
    }

}
