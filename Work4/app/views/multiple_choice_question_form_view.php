
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
   
    <form class='questions_list' method="post" action="index.php?page=create_question&type=multiple_choice" >
        <div class="OFF">
            <input type='text' name='question_name' placeholder="question name" value="<?= $question->question_name ?>"/>
            <input name='question_type' value="<?= $question::$question_type_input ?>" />
            <textarea name='question_text'><?= $question->question_text ?></textarea>
        </div>
        <select name="number_of_options">
            <?php for ($i = 2; $i <= 6; $i++): ?>
                <option value="<?= $i ?>"><?= $i ?></option>
            <?php endfor ?>
        </select>
        <button name='next_operation'>Next</button>

        <?php //real time answer type   ?>
    </form>
</section>
