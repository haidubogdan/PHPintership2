<?php

abstract class AbstractQuestion {

    private $question;

    // Force Extending class to define this method

    abstract protected function getQuestion();

    abstract protected function addQuestion();

    // Common method
    public function printOut() {
        print $this->getQuestion() . "<br>";
    }

}

class textareaQuestion extends AbstractQuestion {

    protected function addQuestion() {
        return "ConcreteClass1";
    }

    protected function getQuestion() {
        return "ConcreteClass1";
    }

}

$class1 = new textareaQuestion;
$class1->printOut();

//

abstract class animal {

    abstract function getowned();

    private $age;

    protected function __construct($age) {
        $this->age = $age;
    }

    public function getage() {
        return $this->age;
    }

}

interface insurable {

    public function getvalue();
}

class pet extends animal implements insurable {

    private $name;

    public function __construct($name, $age) {
        parent::__construct($age);
        $this->name = $name;
    }

    public function getname() {
        return $this->name;
    }

    public function getowned() {
        return ("Owner String");
    }

    public function getvalue() {
        return ("Priceless");
    }

}

class house implements insurable {

    public function getvalue() {
        return ("Rising fast");
    }

}
?>

<body><h1>Abstract class code</h1>

<?php
$charlie = new pet("Charlie", 6);
$catage = $charlie->getage();
$catname = $charlie->getname();
print "$catname is $catage years old!<br><br>";

if ($charlie instanceof pet)
    print ("charlie is a pet<br>");
if ($charlie instanceof animal)
    print ("charlie is an animal<br>");
if ($charlie instanceof house)
    print ("charlie is a house<br>");
if ($charlie instanceof insurable)
    print ("charlie is insurable<br>");
?>
    <hr>
</body>


   }

<?php

//        else if ($_SERVER['REQUEST_URI']!="/BLOG-PROIECT.1/index.php"&&$_SERVER['REQUEST_URI']!="/BLOG-PROIECT.1/"){
//            //echo $_SERVER[REQUEST_URI];
//            exit;
//     


abstract class AbstractQuestion {

    private $question;

    // Force Extending class to define this method

    abstract protected function getQuestion();

    abstract protected function addQuestion();

    // Common method
    public function printOut() {
        print $this->getQuestion() . "<br>";
    }

}

class textareaQuestion extends AbstractQuestion {

    protected function addQuestion() {
        return "ConcreteClass1";
    }

    protected function getQuestion() {
        return "ConcreteClass1";
    }

}

$class1 = new textareaQuestion;
$class1->printOut();

//

abstract class animal {

    abstract function getowned();

    private $age;

    protected function __construct($age) {
        $this->age = $age;
    }

    public function getage() {
        return $this->age;
    }

}

interface insurable {

    public function getvalue();
}

class pet extends animal implements insurable {

    private $name;

    public function __construct($name, $age) {
        parent::__construct($age);
        $this->name = $name;
    }

    public function getname() {
        return $this->name;
    }

    public function getowned() {
        return ("Owner String");
    }

    public function getvalue() {
        return ("Priceless");
    }

}

class house implements insurable {

    public function getvalue() {
        return ("Rising fast");
    }

}
?>

<body><h1>Abstract class code</h1>

<?php
$charlie = new pet("Charlie", 6);
$catage = $charlie->getage();
$catname = $charlie->getname();
print "$catname is $catage years old!<br><br>";

if ($charlie instanceof pet)
    print ("charlie is a pet<br>");
if ($charlie instanceof animal)
    print ("charlie is an animal<br>");
if ($charlie instanceof house)
    print ("charlie is a house<br>");
if ($charlie instanceof insurable)
    print ("charlie is insurable<br>");
?>
    <hr>
</body>

<?php

        if (!isset($_SESSION['quiz_question'])) {
            $this->current_question_id = $_SESSION['quiz_question'] = 1;
            $next_question_id = $this->current_question_id + 1;
        } else if ($_SESSION['quiz_question']<=$this->current_questions_number_set){
            $next_question_id = $this->current_question_id + 1;
            $this->current_question_id = $_SESSION['quiz_question'];
            $next_question_id = $this->current_question_id + 1;
            echo "<br>VAR DUMP DE POST";
            var_dump($_POST);
            if (!empty($current_button_id)&&$current_button_id==$this->current_question_id+1) {
                
                $this->current_question_id = (int)$_SESSION['quiz_question']++;
                $next_question_id = $this->current_question_id + 1;
            } else {
                echo "Id-ul butonului este" . $current_button_id . "<br>";
                echo "Intrebarea curenta este" . $this->current_question_id . "<br>";
                echo "GATA sau Nu-i bine<br>";
            }
            if ($_SESSION['quiz_question']==$this->current_questions_number_set-1){
               $_SESSION['quiz_finished']=1; 
            }
        }
        $compact_keys = array('current_question_id', 'next_question_id');
        $this->data = $this->data + compact($this, 'current_question_id', 'next_question_id', $compact_keys);
        $this->greet();
        
        if (!empty($current_button_id) && $current_button_id == $this->current_question_id + 1) {
            $this->current_question_id = (int) $_SESSION['quiz_question'] ++;
            $next_question_id = $this->current_question_id + 1;
        }
        
                    $template = str_replace("{% if (" . $key . "!=\"\") %}", "<?php if ($value!=\"\") ?>", $template);
            $template = str_replace("{% endif %}", "<?php endif ?>", $template);