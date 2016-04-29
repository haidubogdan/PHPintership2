<?php //var_dump($available_questions[$question_number]); 
?>

<table>
<?php for ($i = 1; $i <= (int) $data['number_of_answers']; $i++): ?>
    <tr>
    <td ><?= $data['answer_' . $i] ?></td>
    <td><input type=checkbox name="answer_<?= $i ?>" value="<?= $data['answer_' . $i] ?>"/>
    </td>
    </tr>
<?php endfor ?>
</table> 