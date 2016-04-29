<?php

class AutoLoader
{

    private static $loader;

    public static function getLoader()
    {
        if (null !== self::$loader) {
            return self::$loader;
        }
        require "app/controllers/controller.php";
        require "app/controllers/CreateQuestion.php";
        require "app/controllers/edit_question.php";
        require 'app/models/db.php';
        require 'app/Entity/UserRepository.php';
        require "app/models/question_model.php";
        require "app/models/quiz_model.php";
        require "app/models/question_creator_model.php";
        require "app/models/render_model.php";
        require "app/models/quiz_flow_model.php";
        require "app/models/AuthentificateModel.php";
        require "app/models/RequestMethods.php";
        require "app/models/User.php";
        require "app/models/RegistrationModel.php";
        require "app/models/create_complete_text_question_model.php";
        require "app/models/create_multiple_choice_question_model.php";
        require "app/models/create_single_choice_question_model.php";
        require "app/PHPMailer-master/PHPMailerAutoload.php";
        require "app/models/Emailer.php";
        
        new Quiz\controllers\controller();
        
    }

}
