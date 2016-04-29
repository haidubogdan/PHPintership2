<?php

namespace Quiz\views;
use Quiz\models\QuestionModel as QuestionModel;

$operations = new QuestionModel ();
$available_questions = $operations->getAvailableQuestions();
$current_index = "index.php?page=admin&operation=create_quiz";
$question_number = filter_input(INPUT_GET, 'see_question_id');
$added_question_id = filter_input(INPUT_GET, 'add_question_id');
$deleted_question_id = filter_input(INPUT_GET, 'delete_quiz_question');
$added_questions = array();

if (empty($_SESSION["check_start"])){
    $_SESSION["check_start"]=1;
    $_SESSION["question_id"]=array();
}

$_SESSION ["author"] = "admin";

if (!empty($added_question_id) || $added_question_id != "") {
    if (!isset($_SESSION['question_position'])) {
        $_SESSION['question_position'] = 0;
    } else if ($_SESSION['question_position'] >= 0) {
        $_SESSION['question_position'] ++;
    } else if ($_SESSION['question_position'] < 0) {
        $_SESSION['question_position'] = 0;
    }
    $_SESSION ["question_id"][$_SESSION['question_position']] = (int) $added_question_id;
    header("Location:$current_index");
}

if (!empty($deleted_question_id) || $deleted_question_id != "") {
    if (!isset($_SESSION['question_position'])) {
        $_SESSION['question_position'] = 0;
    } else if ($_SESSION['question_position'] >= 0) {
        $_SESSION['question_position'] --;
    }
    echo "Stergem<br>";
    unset($_SESSION ["question_id"][$deleted_question_id]);
    $_SESSION ["question_id"] = array_values($_SESSION ["question_id"]);
    header("Location:$current_index");
}

if (!empty($_SESSION['question_id'])) {
    $added_questions = $_SESSION ["question_id"];
    $number_of_questions = count($available_questions);
    $diff_count = count($added_questions) - $number_of_questions;
    $extra_rows = array_map(function($key, $value)use($number_of_questions, $diff_count) {
        if ($diff_count > 0 && $key > ($number_of_questions - 1)) {
            echo $key;
            return $value;
        }
    }, array_keys($added_questions), $added_questions);
    $extra_rows = array_filter($extra_rows, function($value) {
        if (!empty($value)) {
            return $value;
        }
    });

} else {
    $extra_rows = array();
}

?>

<table>
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
            <td><a class="delete_button" href="<?= $current_index ?>">&#8593;</a></td>
            <td><a class="delete_button" href="<?= $current_index ?>">&#8595;</a></td>
            <td><a class="delete_button" href="<?= $current_index . "&delete_quiz_question=" . $count ?>">X</a></td>
            <td><?= $key ?></td>
            <td><?= $row['question_name'] ?></td>
            <td><a href="<?= $current_index . "&add_question_id=" . $key ?>">Add Question</a></td>
            <td><a href="<?= $current_index . "&see_question_id=" . $key ?>">See Question</a></td>
            <?php $count++ ?>
        </tr>
    <?php endforeach; ?>
    <?php foreach ($extra_rows as $key => $row): ?>
        <tr>
            <td style="min-width: 200px;">
                <?= $key . $available_questions[$added_questions[$key]]['question_name'] ?>
            </td>
            <td><a class="delete_button" href="<?= $current_index ?>">&#8593;</a></td>
            <td><a class="delete_button" href="<?= $current_index ?>">&#8595;</a></td>
            <td><a class="delete_button" href="<?= $current_index ?>">X</a></td>
        </tr>
    <?php endforeach; ?>  
</table>

<?php if (!empty($question_number) || $question_number != ""): ?>
    <?php $number_of_answers = $available_questions[$question_number]['number_of_answers']; ?>
    <?php include VIEW_PATH . "question_preview_view.php" ?>
<?php endif; ?>

<form method="post" action="index.php?page=save_quiz">
    <input type="text" name="quiz_name" placeholder="quiz name"/>
    <input type="text" name="description" placeholder="description"/>
    <button type="submit" name="save_quiz" >Save Quiz</button>
</form>