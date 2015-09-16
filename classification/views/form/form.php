<?php 
if($_GET['id'] != ""){
foreach ($forms as $row):
endforeach; 
}
?>



<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tbody>
      <tr>
        <td height="30">
          <a href="#">Home</a> &gt; Create Form
        </td>                                             
      </tr>
      <tr>
        <td height="30" background="images/tajukpanjang750.png">
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="fontWhiteBold">Create Form</span>
        </td>
      </tr>
      <tr>
        <td valign="top" style="padding:20px">
          <div>
            <form action="" method="post">
            <table>
              <tr>
                <td>
                  <b>Form Name</b>
                </td>
                <td><input name="category_name" type="text" size="50" value="<?php echo $row['name']; ?>"></td>
				<input name="category_id" type="hidden" value="<?php echo $row['id']; ?>">

              </tr>
              <tr>
                <td style="vertical-align:top">
                  <br>
                  <b>Choose Criteria</b>
                </td>
                <td>
                  <br>
                  <b>Wajib</b>
                  <table width="100%" class="table-list" style="padding-top:10px">
                    <?php foreach ($compulsory as $row): ?>
                    <?php $selected = ""; 
					
					if($_GET['id'] != ""){
						?>
						
						<?php foreach ($categoryCriteria as $catData): ?>
						<?php if($catData['criteria_id'] == $row['id']){
							$selected = "checked";
						} ?>
					<?php endforeach; } ?>
						
						<tr>
						  <td width="20px"><input type="checkbox" name="criteriaIds[]" value="<?php echo $row['id'] ?>" <?php echo $selected ?>></td>
						  <td><?php echo $row['criteria_name'] ?></td>
						</tr>
						
                    <?php endforeach; ?>
					
                  </table>
                  <br>
                  <b>Optional</b>
                  <table width="100%" class="table-list" style="padding-top:10px">
                    <?php foreach ($optional as $row): ?>
					 <?php $selectedO = ""; 
					 if($_GET['id'] != ""){ ?>
						
						<?php foreach ($categoryCriteria as $catData): ?>
						<?php if($catData['criteria_id'] == $row['id']){
							$selectedO = "checked";
						} ?>
					 <?php endforeach; } ?>
						
                    <tr>
                      <td width="20px"><input type="checkbox" name="criteriaIds[]" value="<?php echo $row['id'] ?>"<?php echo $selectedO ?>></td>
                      <td><?php echo $row['criteria_name'] ?></td>
                    </tr>
                    <?php endforeach; ?>
                  </table>
                  <div style="padding-top:10px">
                    <input type="submit" class="statusBtn" value="Save" name="submitButton">&nbsp;&nbsp;
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