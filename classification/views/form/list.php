<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tbody>
      <tr>
        <td height="30">
          <a href="#">Home</a> &gt; List of Categories
        </td>
      </tr>
      <tr>
        <td height="30" background="images/tajukpanjang750.png">
          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="fontWhiteBold">List of Categories</span>
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
                      <th>Category Name</th>
                      <th width="120px">Number of Criterias</th>
                      <th width="80px">Action</th>
                    </tr>
                    <?php $i = 0  ?>
                    <?php foreach ($forms as $row): ?>
                    <tr>
                      <td><?php echo ++$i ?></td>
                      <td><a href="?id=<?php echo $row['id'] ?>"><?php echo $row['name'] ?></a></td>
                      <td><center><?php echo $row['counter'] ?></center></td>
					 <td>
                        <center>
                        <a href="classification_edit_form.php?id=<?php echo $row['id'] ?>">Edit</a> |
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
$('.btn-delete').click(function() {
    if (confirm('Are you sure want to delete this record?')) {
        var form = $(this).siblings('.form-delete')
        $(form).submit();
    }
})
</script>
