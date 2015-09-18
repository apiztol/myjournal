
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tbody>
        <tr>
            <td height="30">
                <a href="#">Home</a> &gt; List of Journals
            </td>
        </tr>
        <tr>
            <td height="30" background="images/tajukpanjang750.png">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="fontWhiteBold">Journals with Classification</span>
            </td>
        </tr>
        <tr>
            <td valign="top" style="padding:20px">
                <div style="margin-bottom:20px">
                    <form id="form-search" method="get" action="">
                    <div style="float:left;width:20%">
                        Year
                        <select  class="qselect" id="year" name="year">
                            <option value="<?php echo (date('Y') - 1) ?>" <?php echo $_GET['year'] == (date('Y') - 1) ? 'selected' : '' ?> ><?php echo (date('Y') - 1) ?></option>
                            <option value="<?php echo date('Y') ?>"  <?php echo $_GET['year'] == date('Y') ? 'selected' : '' ?> ><?php echo date('Y') ?></option>
                            <option value="<?php echo (date('Y') + 1) ?>"  <?php echo $_GET['year'] == (date('Y') + 1) ? 'selected' : '' ?> ><?php echo (date('Y') + 1) ?></option>
                        </select>
                    </div>
                    <div style="float:left;width:50%;text-align:center">
                        Dicipline
                        <select class="qselect" id="discipline" name="discipline">
                            <option value="">All</option>
                            <?php foreach($disciplines as $row): ?>
                                <option value="<?php echo $row['id'] ?>" <?php echo $_GET['discipline'] == $row['id'] ? 'selected' : '' ?>><?php echo $row['dis_desc'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div style="float:left;width:30%; text-align:right">
                        Form Category
                        <select class="qselect" id="form" name="form">
                            <?php foreach($forms as $row): ?>
                                <option value="<?php echo $row['id'] ?>" <?php echo $_GET['form'] == $row['id'] ? 'selected' : '' ?>><?php echo $row['name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                        <br>
                        <br>
                        Full Mark: <?php echo $fullMarks; ?>
                        <br>
                        <br>
                    </div>
                </div>
                <div style="width:100%;margin-bottom:90px">
                    <div style="float:left;width:50%;">
                        <input type="text" name="search" placeholder=" Search Journal" size="40" value="<?php echo $_GET['search'] ?>">
                        <input type="submit" class="btn-submit" value="Search">
                    </div>
                    </form>
                    <div style="float:left;width:50%;text-align:right">
                        Export to:
                        <select id="exportOption" >
                            <option value="pdf">PDF</option>
                            <option value="excel">Excel</option>
                        </select>

                        <input type="button" class="btn-submit" id="btnExport" value="Export"/>

                    </div>

                </div>
                <div>
                    <div class="pagination"><?php echo $pagination ?></div>
                    <table width="100%" class="table-list" style="padding-top:10px">
                        <tr>
                            <th rowspan="2">No.</th>
                            <th rowspan="2">Journal Title</th>
                            <th colspan="4">Score</th>
                            <th rowspan="2" width="120">Action</th>
                        </tr>
                        <tr>
                            <th>Wajib</th>
                            <th>Optional</th>
                            <th>Total</th>
                            <th>%</th>
                        </tr>
                        <?php $i = $offset ?>
                        <?php
                        // variables to keep number of journal have for each level
                        $counts = [0, 0, 0, 0, 0];

                        // to keep the threshold value of each level
                        $classes = [90, 70, 30, 20, 10];

                        // labels for each levels
                        $levels = ['A1', 'A2', 'B1', 'B2', 'B5'];

                        $curentLevel = '';
                        ?>
                        <?php foreach ($journals as $journal): ?>
                            <?php $percentage = round(($journal['totalMarks'] / $fullMarks) * 100, 2) ?>
                            <?php
                            for ($k = 0; $k < count($classes); $k++) {
                                if ($percentage >= $classes[$k]) {
                                    $counts[$k]++;
                                    if ($currentLevel != $levels[$k]) {
                                        echo '
                                        <tr class="section">
                                            <td></td>
                                            <td colspan="6">Tahap ' . $levels[$k] . '</td>
                                        </tr>
                                        ';

                                        $currentLevel = $levels[$k];
                                    }
                                    break;
                                }
                            }

                            ?>
                            <tr>
                                <td><?php echo ++$i ?></td>
                                <td><?php echo $journal['name'] ?></td>
                                <td><?php echo $journal['compulsory'] ?></td>
                                <td><?php echo $journal['optional'] ?></td>
                                <td><?php echo $journal['totalMarks'] ?></td>
                                <td><?php echo $percentage ?></td>
                                <td>
                                    <center>
                                        <a href="classification_journals_detail.php?level=<?php echo $currentLevel ?>&form=<?php echo $_GET['form'] ?>&evaluation_id=<?php echo $journal['evaluation_id'] ?>">Detail</a> |
                                        <a href="classification_evaluate.php?id=<?php echo $journal['evaluation_id'] ?>&e=1">Edit</a> |
                                        <a class="btn-delete" href="javascript:;">Delete</a>
                                        <form class="form-delete" action="" method="post">
                                            <input type="hidden" name="delete" value="<?php echo $journal['evaluation_id'] ?>">
                                        </form>
                                    </center>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <div id="placeholder" style="height:300px;margin-top:30px"></div>
                <h3 style="text-align:center">Percentage of journal classification for each levels</h3>
            </td>
        </tr>
    </tbody>
</table>
<form id="downloadPDF" action="PDF/journal_list_pdf.php" method="get">
<input type="hidden" id="s" name="s"/>
<input type="hidden" id="y" name="y"/>
<input type="hidden" id="d" name="d"/>
<input type="hidden" id="f" name="f"/>
<input type="hidden" id="did" name="did"/>
<input type="hidden" id="pfid" name="formID"/>

</form>

<form id="downloadExcel" action="Excel/journal_list_excel.php">
<input type="hidden" id="es" name="s"/>
<input type="hidden" id="ey" name="y"/>
<input type="hidden" id="ed" name="d"/>
<input type="hidden" id="ef" name="f"/>
<input type="hidden" id="edid" name="did"/>
<input type="hidden" id="efid" name="formID"/>

</form>

<?php
$pieData = [];
for ($i = 0; $i < count($levels); $i++) {
    array_push($pieData, ['level' => $levels[$i], 'val' => $counts[$i]]);
}
$pieData = json_encode($pieData);
?>
<input type="hidden" id="jsonval" value='<?php echo $pieData ?>'>
<script>

$('#y').val($('year').val());
$('#d').val($('discipline').val());
$('#f').val($('form').val());

$('#btnExport').click(function() {



    var exportOption = $('#exportOption').find(":selected").text()
    if(exportOption == "PDF"){
        form = $('#downloadPDF');
		$('#s').val($("input[name=search]").val());
		$('#y').val($("#year option:selected").text());
		$('#f').val($("#form option:selected").text());
		$('#pfid').val($("#form option:selected").val());
		$('#d').val($("#discipline option:selected").text());
		$('#did').val($("#discipline option:selected").val());
		form.submit();
    }
    else if(exportOption == "Excel"){
        form = $('#downloadExcel');
		$('#es').val($("input[name=search]").val());
		$('#ey').val($("#year option:selected").text());
		$('#ef').val($("#form option:selected").text());
		$('#efid').val($("#form option:selected").val());
		$('#ed').val($("#discipline option:selected").text());
		$('#edid').val($("#discipline option:selected").val());
		form.submit();
    }
    else{
        //Do nothing
    }


})

$(document).ready(function() {
    $('.btn-delete').click(function() {
        if (confirm('Are you sure want to delete this record?')) {
            var form = $(this).siblings('.form-delete')
            $(form).submit();
        }
    })

    $('.qselect').change(function() {
        $('#form-search').submit()
    })

    var stringData = $('#jsonval').val()
    var obj = $.parseJSON(stringData)
    var data = []
    $.each(obj, function(i,row) {
        var o = {
            label: 'Tahap ' + row.level,
            data: row.val
        }

        data.push(o)
    })

    $.plot('#placeholder', data, {
        series: {
            pie: {
                show: true
            }
        },
        legend: {
            show: false
        }
    });
})
</script>
