<h2><?=$data['quiz_name']?></h2>
<form method="post" action="index.php?page=quiz_test&start=<?=$data['id']?>" >
    <div class="quiz_question_preview" >
        <div class="OFF">

            <input type="text" name="question_type" value="<?=$data['question_type']?>"/>
            <input type="text" name="number_of_answers" value="<?=$data['number_of_answers']?>"/>
        </div>
        <div class="inneer_question_preview">
            <h3>Question nr. <?=$data['question_nr']?></h3>
            <h3><?=$data['question_name']?></h3>

            <div>Text:<br>
                 <?=$data['question_text']?>
            </div>
            <div class="answers">Answers:<br>
                
                <?php include "answers_". $data['question_type']. "_form_view.php";?>
                
            </div>
            <button type="submit" name="next" value="<?=$data['next_question_id']?>">Next</button>
        </div>
    </div>

</form>   
