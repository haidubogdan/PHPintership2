<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Quiz\models;

/**
 * Description of Question
 *
 * @author bogdanhaidu
 */
class Question
{

    private $id;
    private $question_name;
    private $question_text;
    private $question_type;
    private $number_of_answers = 1;
    private $answers = null;
    private $valid_answers = array();
    private $date;
    private $question_author;

    public function setQuestionId($id = "id")
    {
        $this->id = $id;
    }

    public function setQuestionName($question_name = "question_name")
    {
        $this->question_name = $question_name;
    }

    public function setQuestionText($text = "question_text")
    {
        $this->question_text = $text;
    }

    public function setQuestionType($question_type = "question_type")
    {
        $this->question_type = $question_type;
    }

    public function setQuestionAnswersNumber($number_of_answers = "number_of_answers")
    {
        $this->number_of_answers = (int) $number_of_answers;
    }

    public function setSingleValidQuestionClass($answer)
    {
        $this->valid_answers['valid_answer'] = $answer;
    }

    public function setMultipleAnswerQuestionClassValues($question = array())
    {
        for ($i = 1; $i <= $this->number_of_answers; $i++) {
            $key = "answer_" . $i;
            $key2 = "valid_answer_" . $i;
            $this->answers[$key] = $question[$key];
            $this->valid_answers[$key2] = $question[$key2];
        }
    }

    public function setDate($date)
    {
        $this->date=$date;
    }
    public function setQuestionAuthor($question_author)
    {
        $this->question_author=$question_author;
    }
}
