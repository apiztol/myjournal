<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tbody>
      <tr>
        <td height="30">
          <a href="#">Home</a> &gt; List of Journals
        </td>
      </tr>
      <tr>
        <td height="30" background="images/tajukpanjang750.png">
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="fontWhiteBold">List of Journals</span>
        </td>
      </tr>
      <tr>
        <td valign="top" style="padding:20px">
          <div style="width:100%;margin-bottom:30px">

            <div style="float:left;width:50%;">
              <form method="get" action="">
                <input type="text" name="search" placeholder=" Search Journal" size="40" value="<?php echo $_GET['search'] ?>">
                <input type="submit" class="btn-submit" value="Search">
              </form>
            </div>
          </div>
          <div>
            <div class="pagination"><?php echo $pagination ?></div>
            <table width="100%" class="table-list" style="padding-top:10px">
              <tr>
                <th>No.</th>
                <th>Journal Title</th>
                <th>Action</th>
              </tr>
              <?php $i = $offset ?>
              <?php foreach ($journals as $journal): ?>
              <tr>
                <td><?php echo ++$i ?></td>
                <td><?php echo $journal['name'] ?></td>
                <td>
                  <center>
                    <a href="classification_evaluate.php?id=<?php echo $journal['id'] ?>">Evaluate</a>
                  </center>
                </td>
              </tr>
              <?php endforeach; ?>
            </table>
          </div>
        </td>
      </tr>
   </tbody>
</table>
