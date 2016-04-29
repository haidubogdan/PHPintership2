
<?php ?>

<table>
<?php for ($i = 1; $i <= (int) $data['number_of_answers']; $i++): ?>
    <tr>
        <td ><?= $i . ": " .$data['answer_' . $i] ?></td>
        <td><input type=radio name="answer" value="valid_answer_<?= $i ?>"/>
        </td>
    </tr>
<?php endfor ?>
</table>