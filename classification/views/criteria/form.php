<?php $action = "Add"; ?>
<?php if(isset($_GET['e'])){ ?>
<?php $action = "Edit";	?>
<?php foreach ($criteria as $row): ?>
<?php endforeach; }?>

<form action="" method="post">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tbody>
      <tr>
        <td height="30">
          <a href="#">Home</a> &gt; <?php echo $action; ?> Criteria
        </td>
      </tr>
      <tr>
        <td height="30" background="images/tajukpanjang750.png">
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="fontWhiteBold"><?php echo $action; ?> Criteria</span>
		</td>
      </tr>
      <tr>
        <td valign="top" style="padding:20px">
          <div>
            <table>
              <tr>
                <td>
                  <b>Type</b>
                </td>
                <td>
                  <input type="radio" value="1" name="compulsory" <?php if($row['compulsory'] == "1") echo "checked"; ?>> Wajib
                  &nbsp;
                  &nbsp;
                  &nbsp;
                  <input type="radio" value="0" name="compulsory" <?php if($row['compulsory'] == "0") echo "checked"; ?>> Optional
                </td>
              </tr>
              <tr>
                <td>
                  <b>Criteria Name</b>
                </td>
                <td>
                  <input type="text" size="50" name="criteria_name" value="<?php echo $row['criteria_name'] ?>">
                </td>
              </tr>
              <tr>
                <td>
                  <b>Criteria Type</b>
                </td>
                <td>


                  <input type="radio" value="radio" class="criteria_type" name="criteria_type" <?php if($row['criteria_type'] == "radio") echo "checked"; ?>> Radio
                  &nbsp;
                  &nbsp;
                  &nbsp;
                  <input type="radio" value="checkbox" class="criteria_type"  name="criteria_type" <?php if($row['criteria_type'] == "checkbox") echo "checked"; ?>> Checkbox
                </td>
              </tr>
              <tr>
                <td style="vertical-align:top;padding-top:5px"><b>Options</b></td>
                <td>
                  <div class="row" style="padding-top:5px">
                    <div style="width:80%;float:left">
                      Sub-criteria
                    </div>
                    <div style="width:15%;float:left">
                      Score
                    </div>
                    <div style="width:5%;float:left;text-align:center">
                      <img id="add-btn" src="img/plus-btn.png" width="16px">
                    </div>
                  </div>


				<?php if(isset($_GET['e'])){ ?>
				<?php foreach ($row['choices'] as $choice): ?>

				<?php if($choice['status'] == "enable") { ?>
				<?php $i++; ?>

					<div class="row">
						<div style="width:80%;float:left">
						  <input type="text" size="36px" name="choices[]" required value="<?php echo $choice['choice_name'] ?>">
						</div>
						<div style="width:15%;float:left">
						  <input type="text" size="5" name="choice_marks[]" required value="<?php echo $choice['marks'] ?>">
						</div>
						<input type="hidden" name="choice_id[]" value="<?php echo $choice['id'] ?>">


					<?php if($i > 2){ ?>

						<div style="width:5%;float:left;text-align:center">
						  <img class="minus-btn" src="img/minus-btn.png" width="16px">
						</div>
					<?php } ?>
					 </div>
				<?php } ?>

                <?php endforeach ?>
				 <div id="additional-fields"></div>
				<?php }else { ?>

					<div class="row">
                    <div style="width:80%;float:left">
                      <input type="text" size="36px" name="choices[]" required>
                    </div>
                    <div style="width:20%;float:left">
                      <input type="text" size="5" name="choice_marks[]" required>
                    </div>
                  </div>
                  <div class="row">
                    <div style="width:80%;float:left">
                      <input type="text" size="36px" name="choices[]" required>
                    </div>
                    <div style="width:20%;float:left">
                      <input type="text" size="5" name="choice_marks[]" required>
                    </div>
                  </div>
                  <div id="additional-fields"></div>

				<?php } ?>

				  <div style="padding-top:20px">
					<input type="hidden" name="criteria_id" value="<?php echo $row['id'] ?>">
                    <input class="btn-submit" type="submit" name="submitButton" class="statusBtn" value="Save">&nbsp;&nbsp;
                    <input type="reset" class="statusBtn" value="Reset">
                  </div>
                </td>
              </tr>
            </table>

          </div>
        </td>
      </tr>
   </tbody>
</table>
</form>
<div id="choice-field" style="display:none">
  <div class="row">
    <div style="width:80%;float:left">
      <input type="text" size="36px" name="choices[]" required>
    </div>
    <div style="width:15%;float:left">
      <input type="text" size="5" name="choice_marks[]" required>
    </div>
	<input type="hidden" name="choice_id[]" value="">

    <div style="width:5%;float:left;text-align:center">
      <img class="minus-btn" src="img/minus-btn.png" width="16px">
    </div>
  </div>
</div>
