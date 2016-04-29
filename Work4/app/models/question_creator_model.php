<?php

namespace Quiz\models;

interface QuestionCreatorModel
{
    public function setQuestionViewPath($path);
    public function questionViewPath ($path);
    public function getNumberOfAnswers();
}
