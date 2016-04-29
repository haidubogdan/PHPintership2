
<section>
    <div>
        <?= $question->question_name ?>
    </div>
    <div>
        <?= $question->question_text ?>
    </div>
    <div>
        <?= $question::$question_type ?>
    </div>
    <div>
        <?= $question->getNumberOfAnswers() ?>
    </div>

    <form class='questions_list' method="post" action="index.php?page=add_question" >
        <div class="OFF">
            <input type='text' name='question_name' placeholder="question name" value="<?= $question->question_name ?>"/>
            <input type='text' name='question_type' placeholder="question type" value="<?= $question::$question_type_input ?>"/>
            <textarea name='question_text'><?= $question->question_text ?></textarea>
            <input name='number_of_answers' value="<?= $question->getNumberOfAnswers() ?>" />
        </div>
        <?php for ($i = 1; $i <= $question->getNumberOfAnswers(); $i++): ?>
            <input class="answer_input" type=text name="answer_<?= $i ?>" placeholder="Answer Nr<?= $i ?>"/>
            <input type=checkbox name="valid_answer_<?= $i ?>"/>
            <br>
        <?php endfor ?>

        <button name='next_operation'>Next</button>

        <?php //real time answer type   ?>
    </form>
</section>