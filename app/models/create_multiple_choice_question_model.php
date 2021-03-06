<?php

namespace Quiz\models;
use Quiz\models\QuestionCreatorModel as QuestionCreatorModel;

class MultipleChoiceQuestionModel implements QuestionCreatorModel {

    public $question_name;
    public $question_text;
    static $question_type_input = "multiple_choice";
    static $question_type = "Multiple Choice Question";
    private $view_path = "multiple_choice_question_form_view";
    private $number_of_answers;

    public function __construct($post_values) {
        $this->question_name = $post_values ["question_name"];
        $this->question_text = $post_values ["question_text"];
    }

    public function setNumberOfAnswers($number = 2) {
        $this->number_of_answers = $number;
    }

    public function getNumberOfAnswers() {
        return $this->number_of_answers;
    }

    public function setQuestionViewPath($path) {
        $this->view_path = $path;
    }

    public function questionViewPath($number = "") {
        return $this->view_path . $number . ".php";
    }

}
