<?php ?>

<section>

    <form class='questions_list' method="post" action="index.php?page=create_question" >

        <?php if (!empty($succes_message)): ?>
        <h2><?=$succes_message?></h2>
        <?php endif; ?>
        <input class="question_title" type='text' name='question_name' placeholder="question name"/>
        <br>
        <br>
        <select name='question_type'>
            <option value='multiple_choice'>Multiple Choice</option>
            <option value='single_choice'>Single Choice</option>
            <option value='complete_text'>Complete Text</option>
            <!--MAYBE LATER ADD A TRUE OR FALSE QUESTION TYPE-->
            <!--            <option value='true_or_false'>True Or False</option>--> 
        </select>
        <div><br>
            <textarea class="question_text" name='question_text' placeholder="question text"></textarea>
        </div>
        <button name='next_operation'>Next</button>

    </form>
</section>
