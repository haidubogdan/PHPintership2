
<?php if (!empty($available_questions)) {
    $valid_answer = $available_questions[$question_number]['valid_answer'];
} else {
    $valid_answer="";
}
?>
<textarea name="valid_answer" > <?=$valid_answer ?></textarea> 
        
        