<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tbody>
      <tr>
        <td height="30">
          <a href="#">Home</a> &gt; List of Criteria
        </td>
      </tr>
      <tr>
        <td height="30" background="images/tajukpanjang750.png">
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="fontWhiteBold">List of Criteria</span>
        </td>
      </tr>
      <tr>
        <td valign="top" style="padding:20px">
          <div>
            <table width="100%">
              <tr>
                <td colspan="3">
                  <table width="100%" class="table-list" style="padding-top:10px">
                    <tr>
                      <th></th>
                      <th>Criteria</th>
                      <th>Type</th>
                      <th width="30%">Answer</th>
                      <th width="80px">Action</th>
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
                      <td><?php echo $row['criteria_type'] ?></td>
                      <td>
                        <ul style="padding-left:20px">
                        <?php
						foreach ($row['choices'] as $choiceRow): ?>
                         <?php if($choiceRow['criteria_id'] == $row['id']) { ?>
						  <li><?php echo $choiceRow['choice_name'] ?></li>
						  <?php } endforeach ?>
                        </ul>
                      </td>
                      <td>
                        <center>
							<a href="#" class="edit_criteria_mandatory" id="edit_<?php echo $row['id'] ?>">Edit</a> |
                            <a class="btn-delete" href="javascript:;">Delete</a>
                            <form class="form-delete" action="" method="post">
                                <input type="hidden" name="delete" value="<?php echo $row['id'] ?>">
                            </form>
                        </center>
                      </td>
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
                      <td><?php echo $row['criteria_type'] ?></td>
                      <td>
                        <ul style="padding-left:20px">
                        <?php
						foreach ($row['choices'] as $choiceRow): ?>
                         <?php if($choiceRow['criteria_id'] == $row['id']) { ?>
						  <li><?php echo $choiceRow['choice_name'] ?></li>
						  <?php } endforeach ?>
                        </ul>
                      </td>
                      <td>
                        <center>
						<a href="#" class="edit_criteria_optional" id="edit_<?php echo $row['id'] ?>">Edit</a> |
                        <a class="btn-delete" href="javascript:;">Delete</a>
                        <form class="form-delete" action="" method="post">
                            <input type="hidden" name="delete" value="<?php echo $row['id'] ?>">
                        </form>
                        </center>
                      </td>
                    </tr>
                    <?php endforeach; ?>
                  </table>
                </td>
              </tr>
            </table>

          </div>
        </td>
      </tr>
   </tbody>
</table>
<script>

	$('.edit_criteria_mandatory').click(function(){

		var data = this.id;
		var arr = data.split('_');
		var classificationID = arr[1];

		window.location.replace("classification_add_criteria.php?e=true&id="+classificationID+"");
	});

	$('.edit_criteria_optional').click(function(){

		var data = this.id;
		var arr = data.split('_');
		var classificationID = arr[1];

		window.location.replace("classification_add_criteria.php?e=true&id="+classificationID+"");
	});

    $('.btn-delete').click(function() {
        if (confirm('Are you sure want to delete this record?')) {
            var form = $(this).siblings('.form-delete')
            $(form).submit();
        }
    })


</script>
