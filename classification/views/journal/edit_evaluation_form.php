<?php

function checkAnswer($list, $criteria_id, $choice_id) {
    foreach ($list as $row) {
        if ($row['choice_id'] == $choice_id && $row['criteria_id'] == $criteria_id) {
            return $row;
        }
    }

    return null;
}
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tbody>
        <tr>
            <td height="30">
                <a href="#">Home</a> &gt; <a href="#">Journal List</a> &gt; Edit Evaluate
            </td>
        </tr>
        <tr>
            <td height="30" background="images/tajukpanjang750.png">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="fontWhiteBold">Edit Evaluate</span>
            </td>
        </tr>
        <tr>
            <td valign="top" style="padding:20px">
                <div>
                    <form method="post" action="">
                        <table width="100%">
                            <tr>
                                <td>
                                    <b>Title</b>
                                </td>
                                <td width="60%"><?php echo $journal['journal_name']; ?></td>
                                <td rowspan="3" style="text-align:right">
                                    <b>Total</b>&nbsp;&nbsp;
                                    <input class="input-result" type="text" size="4" disabled>
                                    <div style="padding-top:10px">
                                        <input type="submit" class="btn-submit" name="submitButton" value="Save">&nbsp;&nbsp;
                                        <input type="reset" class="statusBtn" value="Reset">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <b>Dicipline</b>
                                </td>
                                <td><?php echo $disciplineName ?></td>
                            </tr>
                            <tr>
                                <td>
                                    <b>Year</b>
                                </td>
                                <td>
                                    <select name="year">
                                        <option value="<?php echo (date('Y') - 1) ?>" <?php echo $journal['year'] == date('Y') - 1 ? 'selected' : ''?> ><?php echo (date('Y') - 1) ?></option>
                                        <option value="<?php echo date('Y') ?>" <?php echo $journal['year'] == date('Y') ? 'selected' : ''?> ><?php echo date('Y') ?></option>
                                        <option value="<?php echo (date('Y') + 1) ?>" <?php echo $journal['year'] == date('Y') + 1 ? 'selected' : ''?>><?php echo (date('Y') + 1) ?></option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3">
                                    <table width="100%" class="table-list" style="padding-top:10px">
                                        <tr>
                                            <th></th>
                                            <th>Criteria</th>
                                            <th width="30%">Answer</th>
                                            <th width="20%">Remarks</th>
                                            <th>Score</th>
                                        </tr>
                                        <tr class="section">
                                            <td></td>
                                            <td colspan="4">Wajib</td>
                                        </tr>
                                        <?php $i = 0  ?>
                                        <?php foreach ($compulsory as $row): ?>
                                            <tr>
                                                <td><?php echo ++$i ?></td>
                                                <td><p><?php echo $row['criteria_name'] ?></p></td>
                                                <td class="td-choice">
                                                    <?php foreach ($row['choices'] as $choice): ?>

                                                        <?php $oldChoice = checkAnswer($journal['resultList'], $row['id'],  $choice['id']); ?>
                                                        <input class="input-choice" type="<?php echo $row['criteria_type'] ?>" name="compulsory[<?php echo $row['id'] ?>][]" value="<?php echo $choice['id'] ?>"  data-value="<?php echo $choice['marks'] ?>" <?php echo $oldChoice != null ? 'checked' : '' ?> >
                                                        <?php echo $choice['choice_name'] ?><br>
                                                    <?php endforeach ?>
                                                </td>
                                                <td>
                                                    <textarea name="remarks[<?php echo $row['id'] ?>]" style="width:100%" rows="2"><?php echo $oldChoice != null ? $oldChoice['remarks'] : '' ?></textarea>
                                                </td>
                                                <td class="td-score" style="text-align:center">0</td>
                                            </tr>
                                        <?php endforeach; ?>
                                        <tr class="section">
                                            <td></td>
                                            <td colspan="4">Optional</td>
                                        </tr>
                                        <?php foreach ($optional as $row): ?>
                                            <tr>
                                                <td><?php echo ++$i ?></td>
                                                <td><p><?php echo $row['criteria_name'] ?></p></td>
                                                <td class="td-choice">
                                                    <?php foreach ($row['choices'] as $choice): ?>
                                                        <?php $oldChoice = checkAnswer($journal['resultList'], $row['id'],  $choice['id']); ?>
                                                        <input class="input-choice" type="<?php echo $row['criteria_type'] ?>" name="optional[<?php echo $row['id'] ?>][]" value="<?php echo $choice['id'] ?>" data-value="<?php echo $choice['marks'] ?>" <?php echo $oldChoice != null ? 'checked' : '' ?>>
                                                        <?php echo $choice['choice_name'] ?><br>
                                                    <?php endforeach ?>
                                                </td>
                                                <td>
                                                    <textarea name="remarks[<?php echo $row['id'] ?>]" style="width:100%" rows="2"><?php echo $oldChoice != null ? $oldChoice['remarks'] : '' ?></textarea>
                                                </td>
                                                <td class="td-score" style="text-align:center">0</td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3" style="text-align:right">
                                    <br><br><hr><br><br>
                                    <b>Total</b>&nbsp;&nbsp;
                                    <input class="input-result" type="text" size="4" disabled>
                                    <div style="padding-top:10px">
                                        <input type="submit" class="statusBtn btn-submit" name="submitButton" value="Save">&nbsp;&nbsp;
                                        <input type="reset" class="statusBtn" value="Reset">
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
            </td>
        </tr>
    </tbody>
</table>
<script>

$(document).ready(function() {
    $('input[type=radio]:checked').each(function() {
        // get input value
    	var value = $(this).data('value');

    	// get td where to print value
        var tdScore = $(this).parent().siblings('.td-score')

        // print value
       	$(tdScore).text(value);

       	sumScore();
    })

    $('input[type=checkbox]:checked').each(function() {

    	var totalCheckboxValue = 0;
    	$(this).parent().children('.input-choice').each(function(i, input) {
    		if ($(input).is(':checked')) {
    			var v = $(input).data('value');
    			totalCheckboxValue += parseInt(v);
    		};

    	})

    	// // get td where to print value
        var tdScore = $(this).parent().siblings('.td-score')

        // print value
       	$(tdScore).text(totalCheckboxValue);

       	sumScore();
    })

    // function to sum up all .td-score
    function sumScore() {
    	var sum = 0;
    	$('.td-score').each(function(i, td) {
    		var tdValue = $(td).text();
    		sum += parseInt(tdValue)
    	})

    	$('.input-result').val(sum);
    }
})


</script>
