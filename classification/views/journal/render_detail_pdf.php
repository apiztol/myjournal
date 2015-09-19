<h3>Journal Classification Detail</h3><hr>
<table cellspacing="3px" style="margin:20px;max-width: 100%; solid;position: relative;">
	<tr>
		<td class="tbold" width="100px;">Title</td><td><?php echo $journal['journal_name']; ?></td>
	</tr>
	<tr>
		<td class="tbold">Dicipline</td><td><?php echo $disciplineTitle; ?></td>
	</tr>
	<tr>
		<td class="tbold">Publisher</td><td><?php echo $journal['publisher']; ?></td>
	</tr>
	<tr >
		<td class="tbold">Year Evaluate</td><td><?php echo $journal['year']; ?></td>
	</tr>
	<tr>
		<td class="tbold">Form</td><td><?php echo $_GET['f'] ?></td>
	</tr>
	<tr>
		<td class="tbold">Score</td><td><?php echo $journal['totalMarks'] . ' / ' . $fullMarks . ' (' . round(($journal['totalMarks'] / $fullMarks) * 100, 2) . '%)'; ?></td>
	</tr>

</table>




<table cellspacing="3px" style="width: 100%; border:1px solid;margin:20px;" class="table-list">

	<tr bgcolor="#999999">
		<th>&nbsp;</th>
		<th>Criteria.</th>
		<th>Choice</th>
		<th>Score</th>
		<th>Percentage</th>
		<th>Remarks</th>
	</tr>
	<?php $i = 0 ?>
	<?php $scores = [] ?>
	<?php foreach ($journal['resultList'] as $row): ?>
		<tr >
			<td><?php echo ($i + 1) ?></td>
			<td style="width: 35%; text-align: left;"><?php echo $row['criteria_name'] ?></td>
			<td style="width: 20%; text-align: left;"><?php echo $row['choice_name'] ?></td>
			<td style="width: 10%; text-align: left;"><?php echo $row['marks'] . ' / ' . $row['totalCriteriaMarks'] ?></td>
			<td style="width: 10%; text-align: left;"><?php echo round($row['marks'] / $row['totalCriteriaMarks'] * 100, 2) . '%' ?></td>
			<td style="width: 15%; text-align: left;"><?php echo $row['remarks'] ?></td>
			<?php
			array_push($scores, [ 'value' => ($row['marks'] / $fullMarks * 100)]);
			$i++;
			?>
		</tr>
	<?php endforeach ?>

</table>
