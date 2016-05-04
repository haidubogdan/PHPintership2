<section>
    <div>
        <strong> <?= $question->question_name ?></strong>
    </div>
    <div>
        <?= $question::$question_type ?>
    </div>
   
    <form class='questions_list' method="post" action="index.php?page=create_question" >
        <div class="OFF">
            <input type='text' name='question_name' placeholder="question name" value="<?= $question->question_name ?>"/>
            <input name='question_type' value="<?= $question::$question_type_input ?>" />
            
        </div>
            <textarea class="question_text" name='question_text'><?= $question->question_text ?></textarea>
            <br>
            <textarea class="question_text" name='valid_answer' placeholder="Complete the valid answer"></textarea>
            
        <button name='save_question' value="save">Save</button>

        <?php //real time answer type   ?>
    </form>
</section>

