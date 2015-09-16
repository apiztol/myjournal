<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tbody>
      <tr>
        <td height="30">
          <a href="#">Home</a> &gt; <a href="classification_categories.php">List of Form</a> &gt; Details
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
            <table>
              <tr>
                <td><b>Form Name</b></td>
                <td><?php echo $form['name']; ?></td>
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
                    <?php $i = 0 ?>
                    <?php foreach ($compulsory as $row): ?>
						<tr>
						  <td width="20px"><?php echo ++$i ?></td>
						  <td><?php echo $row['criteria_name'] ?></td>
						</tr>

                    <?php endforeach; ?>

                  </table>
                  <br>
                  <b>Optional</b>
                  <table width="100%" class="table-list" style="padding-top:10px">
                    <?php foreach ($optional as $row): ?>
                    <tr>
                      <td width="20px"><?php echo ++$i ?></td>
                      <td><?php echo $row['criteria_name'] ?></td>
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
