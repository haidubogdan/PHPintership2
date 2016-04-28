<?php //var_dump($available_questions[$question_number]); 
    $checked["on"]="checked";
    $checked[null]=""
?>

<?php for ($i = 1; $i <= $available_questions[$question_number]['number_of_answers']; $i++): ?>
    <input type=text name="answer_<?= $i ?>" value="<?= $available_questions[$question_number]['answer_' . $i] ?>"/>
    <input type=checkbox name="valid_answer_<?= $i ?>" <?= $checked[$available_questions[$question_number]['valid_answer_' . $i]] ?>/>
    <br>
<?php endfor ?>