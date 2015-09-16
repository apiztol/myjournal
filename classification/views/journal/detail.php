<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tbody>
		<tr>
			<td height="30">
				<a href="#">Home</a>
				&gt; <a href="classification_evaluated_journals.php">List of Journals</a>
				&gt; Journal Detail
			</td>
		</tr>
		<tr>
			<td height="30" background="images/tajukpanjang750.png">
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="fontWhiteBold">Journal Detail</span>
			</td>
		</tr>
		<tr>
			<td valign="top">
				<table cellspacing="3px" style="margin-top:20px;max-width: 100%; solid;position: relative;">
					<tr>
						<td class="tbold" width="100px;">Title</td><td><?php echo $journal['journal_name']; ?></td>
					</tr>
					<tr>
						<td class="tbold">Dicipline</td><td><?php echo $disciplineTitle; ?></td>
					</tr>
					<tr>
						<td class="tbold">Publisher</td><td><?php echo $journal['publisher']; ?></td>
					</tr>
					<tr>
						<td class="tbold">Year Evaluate</td><td><?php echo $journal['year']; ?></td>
					</tr>
					<tr>
						<td class="tbold">Form</td>
						<td>
							<form id="qform" action="" method="get">
								<input type="hidden" name="evaluation_id" value="<?php echo $evaluation_id ?>">
								<input type="hidden" name="level" value="<?php echo $_GET['level'] ?>">
								<select class="qselect" id="form" name="form">
									<?php foreach($forms as $row): ?>
										<option value="<?php echo $row['id'] ?>" <?php echo $_GET['form'] == $row['id'] ? 'selected' : '' ?>><?php echo $row['name'] ?></option>
									<?php endforeach; ?>
								</select>
							</form>
						</td>
					</tr>
					<tr>
						<td class="tbold">Score</td><td><?php echo $journal['totalMarks'] . ' / ' . $fullMarks . ' (' . round(($journal['totalMarks'] / $fullMarks) * 100, 2) . '%)'; ?></td>
					</tr>
					<tr>
						<td class="tbold">Level</td><td><?php echo "-"; ?></td>
					</tr>

				</table>

				<div style="float:left;width:100%;text-align:right">
					Export to:
					<select id="exportOption" >
						<option value="pdf">PDF</option>
						<option value="excel">Excel</option>
					</select>
					<input type="button" id="btnExport" value="Export"/>

				</div>

				<div>

					<table width="100%" class="table-list" style="padding-top:10px">
						<tr>
							<th></th>
							<th width="60%">Criteria</th>
							<th>Choice</th>
							<th>Score</th>
							<th>Remarks</th>
						</tr>
						<?php $i = 0 ?>
						<?php $scores = [] ?>
						<?php foreach ($journal['resultList'] as $row): ?>
							<tr>
								<td><?php echo ($i + 1) ?></td>
								<td><?php echo $row['criteria_name'] ?></td>
								<td><?php echo $row['choice_name'] ?></td>
								<td><?php echo $row['marks'] ?></td>
								<td><?php echo $row['remarks'] ?></td>
								<?php
								array_push($scores, [ 'value' => ($row['marks'] / $fullMarks * 100)]);
								$i++;
								?>
							</tr>
						<?php endforeach ?>
						<?php $scores = array_reverse($scores) // reverse array to show criteria 1 start from top when in graph ?>
						</table>
					</div>
					<div id="placeholder" style="height:<?php echo (40 * count($scores)) ?>px;margin-top:30px"></div>
				</td>
			</tr>
		</tbody>
	</table>
	<form id="downloadPDF" action="PDF/journal_detail_pdf.php">
	<input type="hidden" id="evaluation_id" name="evaluation_id"/>
	<input type="hidden" id="f" name="f"/>
	<input type="hidden" id="pfid" name="fid"/>

	</form>
	
	<form id="downloadExcel" action="Excel/journal_detail_excel.php">
	<input type="hidden" id="excelEID" name="evaluation_id"/>
	<input type="hidden" id="eForm" name="f"/>
	<input type="hidden" id="efid" name="fid"/>

	</form>
	<input type="hidden" id="jsonval" value='<?php echo json_encode($scores) ?>'>

	<script>
	$('#btnExport').click(function() {

		var exportOption = $('#exportOption').find(":selected").text()
		if(exportOption == "PDF"){
			form = $('#downloadPDF');
			$('#evaluation_id').val(<?php echo $_GET['evaluation_id']; ?>);
			$('#f').val($("#form option:selected").text());
			$('#pfid').val($("#form option:selected").val());
			form.submit();
		}
		else if(exportOption == "Excel"){
			form = $('#downloadExcel');
			$('#excelEID').val(<?php echo $_GET['evaluation_id']; ?>);
			$('#eForm').val($("#form option:selected").text());
			$('#efid').val($("#form option:selected").val());
			form.submit();
		}
		else{
			//Do nothing
		}
	})

	$('.qselect').change(function() {
		$(this).parent().submit();
	})

	// bar graph section

	// get json data in hidden input
	var stringData = $('#jsonval').val()
    var obj = $.parseJSON(stringData)
    var rawData = []
	var ticks = []
    $.each(obj, function(i,row) {
        rawData.push([row.value, i]) // data in percentage
		ticks.push([i, 'Criteria ' + (obj.length - i)]) // the left label (y label)
    })

	// set data
    var dataSet = [{ label: "Percentage (%)", data: rawData, color: "#FF9933" }];

	// set graph options
    var options = {
        series: {
            bars: {
                show: true
            }
        },
        bars: {
            align: "center",
            barWidth: 0.5,
            horizontal: true,
            fillColor: { colors: [{ opacity: 0.8 }, { opacity: 1}] },
            lineWidth: 1
        },
        xaxis: {
            axisLabelFontSizePixels: 12,
            axisLabelPadding: 10,
            max: 100
        },
        yaxis: {
            axisLabelUseCanvas: true,
            axisLabelFontSizePixels: 12,
            axisLabelPadding: 3,
            ticks: ticks,
        },
        legend: {
			show: true
        },
        grid: {
            hoverable: true,
            borderWidth: 2,
            backgroundColor: { colors: ["#fff", "#eee"] }
        }
    };

	// plot the graph
    $.plot($("#placeholder"), dataSet, options);

	</script>
