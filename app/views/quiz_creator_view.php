<?php

$current_index = "index.php?page=admin&operation=create_quiz";

?>

<table class="quiz_table2">
    <tr>
        <th colspan="4">Selected Questions</th>
        <th>Id</th>
        <th>Available question</th>
        <th colspan="2">Options</th>
    </tr>
    <?php $count = 0 ?>
    <?php foreach ($available_questions as $key => $row): ?>
        <tr>
            <td style="min-width: 200px;">
               
                <?php if (array_key_exists($count, $added_questions)): ?>
                    <?= ($count + 1) . ". " . $available_questions[$added_questions[$count]]['question_name'] ?>
                <?php endif; ?>
            </td>
            <td><a class="button" href="<?= $current_index ?>">&#8593;</a></td>
            <td><a class="button" href="<?= $current_index ?>">&#8595;</a></td>
            <td><a class="delete_button" href="<?= $current_index . "&delete_quiz_question=" . $count ?>">X</a></td>
            <td><?= $key ?></td>
            <td><?= $row['question_name'] ?></td>
            <td><a class="add_question" href="<?= $current_index . "&add_question_id=" . $key ?>">Add Question</a></td>
            <td><a href="<?= $current_index . "&see_question_id=" . $key ?>">See Question</a></td>
            <?php $count++ ?>
        </tr>
    <?php endforeach; ?>
    <?php foreach ($extra_rows as $key => $row): ?>
        <tr>
            <td style="min-width: 200px;">
                <?= $key . $available_questions[$added_questions[$key]]['question_name'] ?>
            </td>
            <td><a class="button" href="<?= $current_index ?>">&#8593;</a></td>
            <td><a class="button" href="<?= $current_index ?>">&#8595;</a></td>
            <td><a class="delete_button" href="<?= $current_index ?>">X</a></td>
        </tr>
    <?php endforeach; ?>  
</table>
<?php if (!empty($question_number) || $question_number != ""): ?>
    <?php $number_of_answers = $available_questions[$question_number]['number_of_answers']; ?>
    <?php include VIEW_PATH . "question_preview_view.php" ?>
<?php endif; ?>

<form method="post" action="index.php?page=save_quiz">
    <input class="quiz_name" type="text" name="quiz_name" value="<?=self::$quiz_name?>" placeholder="quiz name"/>
    <input type="text" name="description" placeholder="description"/>
    <button type="submit" name="save_quiz" >Save Quiz</button>
</form>