
<table>
    <tr>
        <th>Id</th>
        <th>Available questions</th>
        <th colspan="2">Options</th>
    </tr>
    <?php foreach ($available_questions as $key => $row): ?>
        <tr>
            <td><?= $key ?></td>
            <td><?= $row['question_name'] ?></td>
            <td><a class="delete_button" href="<?= $current_index . "&delete_question=" . ($key+1) ?>">X</a></td>
            <td><a class="edit_button" href="<?= $current_index . "&edit_question_id=" . $key ?>">EDIT</a></td>
            <td><a href="<?= $current_index . "&see_question_id=" . $key ?>">See Question</a></td>
        </tr>
    <?php endforeach; ?>

</table>  

<?php if (!empty($see_question_number) || $see_question_number != ""): ?>
    <?php $question_number = $see_question_number;?>
    <?php $number_of_answers = $available_questions[$see_question_number]['number_of_answers']; ?>
    <?php include VIEW_PATH . "question_preview_view.php" ?>
<?php endif; ?>

<?php if (!empty($edit_question_number) || $edit_question_number != ""): ?>
    <?php $question_number = $edit_question_number;?>
    <?php $number_of_answers = $available_questions[$edit_question_number]['number_of_answers']; ?>
    <?php include VIEW_PATH . "question_edit_preview_view.php" ?>
<?php endif; ?>