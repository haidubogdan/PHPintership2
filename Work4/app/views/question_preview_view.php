<?php
if (empty($current_edit_index)) {
    $current_edit_index = $current_index;
}
?>


<div class="question_preview" >
    <div class="inneer_question_preview">
        <h3><?= $available_questions[$question_number]['question_name'] ?></h3>
        <a class="close_button" href="<?= $current_index ?>">X</a>
        <div>Text:
            <pre>
                <?= $available_questions[$question_number]['question_text'] ?>        
            </pre>
        </div>
        <div>Answers:
            <pre>
                <strong><?= $available_questions[$question_number] ["valid_answer"] ?></strong>
                <?php for ($i = 1; $i <= $number_of_answers; $i++): ?>
                         <strong>Answer<?= $i ?>(<?= $available_questions[$question_number] ["valid_answer_" . $i] ?>) : </strong><?= $available_questions[$question_number]["answer_" . $i] ?> <br>
                <?php endfor; ?>  
            </pre>
        </div>
        <a href="<?= $current_edit_index ?>">Close</a>
    </div>
</div>
