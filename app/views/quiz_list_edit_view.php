<?php

namespace Quiz\views;
use Quiz\models\QuizModel as QuizModel;
use Quiz\models\QuestionModel as QuestionModel;

$edit_quiz = new QuizModel ();
$questions = new QuestionModel ();
$current_index = "index.php?page=admin&operation=edit_quiz_list";
$quiz_edit_index = "index.php?page=admin&operation=edit_quiz";
$available_quiz = $edit_quiz->getAvailableQuiz();

if (!empty($_SESSION["question_id"])){
$_SESSION["question_id"]= array();
}
if (!empty($_SESSION['question_position'])){
unset($_SESSION['question_position']);
}
?>

<table class="quiz_table">
    <tr>
        <th>Id</th>
        <th>Available quiz</th>
        <th colspan="3">Options</th>
    </tr>
    <?php foreach ($available_quiz as $key => $row): ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= $row['quiz_name'] ?></td>
            <td><a data-del_id="<?=$key?>" class="delete_button" href="<?= $current_index . "&delete_quiz=" . ($key+1) ?>">X</a></td>
            <td><a class="edit_button" href="<?= $quiz_edit_index . "&quiz=" . $key ?>">EDIT</a></td>
        </tr>
    <?php endforeach; ?>

</table>  