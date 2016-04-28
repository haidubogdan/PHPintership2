
<form method="post" action="index.php?page=edit_question" >
    <div class="question_preview" >
        <div class="OFF">

            <input type="text" name="question_type" value="<?= $available_questions[$question_number]['question_type'] ?>"/>
            <input type="text" name="number_of_answers" value="<?= $available_questions[$question_number]['number_of_answers'] ?>"/>
        </div>
        <div class="inneer_question_preview">
            <h3><?= $available_questions[$question_number]['question_name'] ?></h3>
            <a class="close_button" href="<?= $current_index ?>">X</a>
            <div>Id:
                <input type="text" name="id" value="<?= $question_number ?>"/>
            </div>
            <div>Name:
                <input type="text" name="question_name" value="<?= $available_questions[$question_number]['question_name'] ?>"/>
            </div>
            <div>Text:<br>
                <textarea name="question_text"><?= $available_questions[$question_number]['question_text'] ?></textarea>
            </div>
            <div>Answers:<br>
                <?php include VIEW_PATH . "answers_" . $available_questions[$question_number]['question_type'] . "_edit_form_view.php" ?>
            </div>
            <a href="<?= $current_index ?>">Close</a>
            <button type="submit" name="save_changes">Save Changes</button>
        </div>
    </div>

</form>   
