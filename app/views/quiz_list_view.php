<?php

namespace Quiz\views;
use Quiz\models\QuizModel as QuizModel;
use Quiz\models\QuestionModel as QuestionModel;

$edit_quiz = new QuizModel ();
$questions = new QuestionModel ();
$current_index = "index.php?page=quiz_test";
$available_quiz = $edit_quiz->getAvailableQuiz();

?>

<table>
    <tr>
        <th>Id</th>
        <th>Available quiz</th>
        <th>Description</th>
        <th>Number of Questions</th>
        <th>Author</th>
        <th>Creation date</th>
        <th>Options</th>
    </tr>
    <?php foreach ($available_quiz as $key => $row): ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= $row['quiz_name'] ?></td>
            <td><?= $row['description'] ?></td>
            <td style="text-align: center"><?= count($row['id_question_order']) ?></td>
            <td><?= $row['questions_author'] ?></td>
            <td><?= $row['date'] ?></td>
            <td><a class="start_button" href="<?= $current_index . "&start=" . $key ?>">START</a></td>
        </tr>
    <?php endforeach; ?>

</table>  