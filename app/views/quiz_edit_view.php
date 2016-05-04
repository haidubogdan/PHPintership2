<?php

namespace Quiz\views;

$current_index = "index.php?page=admin&operation=edit_quiz";




//use Quiz\models\QuizModel as QuizModel;
//use Quiz\models\QuestionModel as QuestionModel;
//
//$edit_quiz = new QuizModel ();
//$questions = new QuestionModel ();
//
//$available_quiz = $edit_quiz->getAvailableQuiz();
//$edited_quiz_id = filter_input(INPUT_GET, 'quiz');
//
//$quiz = $edit_quiz->getQuizById($edited_quiz_id);
//$available_questions = $questions->getAvailableQuestions();
//$question_number = filter_input(INPUT_GET, 'see_question_id');
//$added_question_id = filter_input(INPUT_GET, 'add_question_id');
//$deleted_question_id = filter_input(INPUT_GET, 'delete_quiz_question');
//
//
//$extra_rows = array();
//$_SESSION["author"] = $quiz["questions_author"];
//$_SESSION["edited_quiz_id"] = $edited_quiz_id;
//
//if (!empty($added_question_id) || $added_question_id != "") {
//    if (!isset($_SESSION['question_position'])) {
//        $_SESSION['question_position'] = count($added_questions);
//    } else if ($_SESSION['question_position'] >= 0) {
//        $_SESSION['question_position']++;
//    } else if ($_SESSION['question_position'] < 0) {
//        $_SESSION['question_position'] = 0;
//    }
//    $_SESSION ["question_id"][$_SESSION['question_position']] = (int) $added_question_id;
//    header("Location:$current_edit_index");
//}
//
//if (!empty($deleted_question_id) || $deleted_question_id != "") {
//    if (!isset($_SESSION['question_position'])) {
//        $_SESSION['question_position'] = count($added_questions) - 1;
//    } else if ($_SESSION['question_position'] >= 0) {
//        $_SESSION['question_position'] --;
//    }
//    unset($_SESSION ["question_id"][$deleted_question_id]);
//    $_SESSION ["question_id"] = array_values($_SESSION ["question_id"]);
//    header("Location:$current_edit_index");
//}
//
//if (!empty($_SESSION['question_id'])) {
//    $added_questions = $_SESSION ["question_id"];
//    var_dump($added_questions);
//    $number_of_questions = count($available_questions);
//    $diff_count = count($added_questions) - $number_of_questions;
//
//    $extra_rows = array_map(function($key, $value)use($number_of_questions, $diff_count) {
//        if ($diff_count > 0 && $key > ($number_of_questions - 1)) {
//            echo $key;
//            return $value;
//        }
//    }, array_keys($added_questions), $added_questions);
//    $extra_rows = array_filter($extra_rows, function($value) {
//        if (!empty($value)) {
//            return $value;
//        }
//    });
//} else {
//    $_SESSION ["question_id"] = $added_questions;
//    $extra_rows = array();
//}
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
        <tr><td style="min-width: 200px;">
                <?php if (array_key_exists($count, $added_questions)): ?>
                    <?= ($added_questions[$count]) . ". " . $available_questions[$added_questions[$count]]['question_name'] ?>
                <?php endif; ?>
            </td>
            <td><a class="delete_button" href="<?= $current_index ?>">&#8593;</a></td>
            <td><a class="delete_button" href="<?= $current_index ?>">&#8595;</a></td>
            <td><a class="delete_button" href="<?= $current_edit_index . "&delete_quiz_question=" . ($count+1) ?>">X</a></td>
            <td><?= $key ?></td>
            <td><?= $row['question_name'] ?></td>
            <td><a href="<?= $current_edit_index . "&add_question_id=" . $key ?>">Add Question</a></td>
            <td><a href="<?= $current_edit_index . "&see_question_id=" . $key ?>">See Question</a></td>
        </tr>
        <?php $count++ ?>
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
<form method="post" action="index.php?page=edit_quiz">
    <input type="text" name="quiz_id" value="<?= $the_quiz["id"] ?>" placeholder="quiz id" style='width:60px;'/>
    <input type="text" name="quiz_name" value="<?= $the_quiz["quiz_name"] ?>" placeholder="quiz name"/>
    <input type="text" name="description" value="<?= $the_quiz["description"] ?>" placeholder="description"/>
    <button type="submit" name="save_quiz" >Save Quiz</button>
</form>