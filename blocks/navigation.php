<table border="0" valign="top">
<?php $_SESSION['journal_id'] = ($_SESSION['journal_id']!=NULL) ? $_SESSION['journal_id'] : $_SESSION['id_journal_luar'];?>
<?php
// site-wide
$short_name = "site-wide";
// $nav_role_id = getRoleIdByShortName($short_name);
?>
<?php $navigation_count = 0 ?>
<?php if ( true) : ?>
  <?php $navigation_count++; ?>
  <tr valign="top">
    <td>
      <table width="217" border="0" align="left" cellpadding="0" cellspacing="0">
        <tr>
          <td height="30" background="images/tajukkiri.jpg">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font color="#FFFFFF"><strong>Administrator</strong></font></td>
        </tr>
        <tr>
          <td height="50" align="left" bgcolor="#f1f0ee" background="../images/bg-list3.png" style="background-repeat:repeat-x">
            <table width="200"  border="0" cellpadding="3" cellspacing="1" bordercolor="#CCCCCC">
              <tr>
                <td align="left" class="bg">&#8226; <a style="text-decoration:none; " href="<?php echo $APP_URL; ?>/user.php">User and Group Management</a></td>
              </tr>
              <tr>
                <td align="left" class="bg" style="margin-left:0px;">&#8226; <a style="text-decoration:none; " href="<?php echo $APP_URL; ?>/adminpublish.php">Approve for UM Web</a></td>
              </tr>
              <?php /*
              <tr>
                <td align="left" class="bg" style="margin-left:0px;">&#8226; <a style="text-decoration:none; " href="<?php echo $APP_URL; ?>/articles_page1.php">Check References</a></td>
              </tr>
              */ ?>
              <tr>
                <td class="bg">&#8226; <a style="text-decoration:none; " href="<?php echo $APP_URL; ?>/journal-add.php">Journal Management</a></td>
              </tr>
              <tr>
                <td class="bg">&#8226; <a style="text-decoration:none; " href="<?php echo $APP_URL; ?>/indexation-add.php">Indexation </a></td>
              </tr>
              <tr>
                <td class="bg">&#8226; <a style="text-decoration:none; " href="<?php echo $APP_URL; ?>/journal-editor-add.php">Editor Management</a></td>
              </tr>
              <tr>
                <td class="bg">&#8226; <a style="text-decoration:none; " href="<?php echo $APP_URL; ?>/affiliation-maintenance.php">Affiliation Management</a></td>
              </tr>
              <tr>
                <td class="bg">&#8226; <a style="text-decoration:none; " href="<?php echo $APP_URL; ?>/author_map_management.php">Author Groups Management</a></td>
              </tr>
              <tr>
                <td class="bg">&#8226; <a style="text-decoration:none; " href="<?php echo $APP_URL; ?>/affiliation_alias_management.php">Affiliation Alias Management</a></td>
              </tr>
              <tr>
                <td class="bg">&#8226; <a style="text-decoration:none; " href="<?php echo $APP_URL; ?>/journal_alias_management.php">Journal Alias Management</a></td>
              </tr>
              <tr>
                <td class="bg">&#8226; <a style="text-decoration:none; " href="<?php echo $APP_URL; ?>/article_references.php">References Editor</a></td>
              </tr>
              <tr>
                <td class="bg">&#8226; <a style="text-decoration:none; " href="<?php echo $APP_URL; ?>/cited_articles.php">Cited Only Articles</a></td>
              </tr>
	          <tr>
                <td class="bg">&#8226; <a style="text-decoration:none; " href="<?php echo $APP_URL; ?>/citation_map.php">Citation Map</a></td>
              </tr>
              <tr>
                <td class="bg">&#8226; <a style="text-decoration:none; " href="<?php echo $APP_URL; ?>/article_html_cleaner.php">Data Cleaner</a></td>
              </tr>
              <tr>
                <td class="bg">&#8226; <a style="text-decoration:none; " href="<?php echo $APP_URL; ?>/article-check.php">Creator Report</a></td>
              </tr>
              <tr>
                <td class="bg">&#8226; <a style="text-decoration:none; " href="<?php echo $APP_URL; ?>/statistics_menu.php">Statistics</a></td>
              </tr>
              <tr>
                <td class="bg">&#8226; <a style="text-decoration:none; " target="_blank" href="<?php echo $APP_URL; ?>/file_sharing.php">File Sharing</a></td>
              </tr>
              <tr>
                <td class="bg">&#8226; <a style="text-decoration:none; " href="<?php echo $APP_URL; ?>/reports.php">Generate Reports</a></td>
              </tr>
              <tr>
                <td class="bg">
                    <div id="first">
                        &#8226; <a style="text-decoration:none;" href="#">Classification</a>
                        <ul style="margin-left:-10px;margin-top:5px;list-style-type:circle;display:none">
                          <li><a href="<?php echo $APP_URL; ?>/classification_journals.php">Evaluate Journal</a></li>
                          <li><a href="<?php echo $APP_URL; ?>/classification_evaluated_journals.php">Journals with Classification</a></li>
                          <li><a href="<?php echo $APP_URL; ?>/classification_criterias.php">List of Criteria</a></li>
                          <li><a href="<?php echo $APP_URL; ?>/classification_add_criteria.php">Add Criteria</a></li>
                          <li><a href="<?php echo $APP_URL; ?>/classification_categories.php">List of Forms</a></li>
                          <li><a href="<?php echo $APP_URL; ?>/classification_create_form.php">Add Form</a></li>
                        </ul>
                      </div>
                    </div>
                </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
    </td>
  </tr>
<?php endif ?>
<?php
// editor
$short_name = "editor";
// $nav_role_id = getRoleIdByShortName($short_name);

// Hard coded global editors
// $editors = array(7, 880, 4326, 89, 4440);
// $is_global_editor = in_array($_SESSION['user_id'], $editors);
// $is_global_editor = isUserExistInRole(getRoleIdByShortName("site-wide"), $user_id);
?>
<?php
// For testing, check if current user is the global editor
/*
<tr><td>
<input type='hidden' name='userid' value='<?php echo $_SESSION['user_id'] ?>' />
<input type='hidden' name='global_editor' value='<?php echo $is_global_editor ?>' />
</td></tr>
 */
?>
<?php if ( true || $is_global_editor) : ?>
  <?php if ( true|| $is_global_editor) : ?>
    <?php $navigation_count++ ?>
    <tr valign="top">
      <td>
        <table width="217" border="0" align="left" cellpadding="0" cellspacing="0">
          <tr>
            <td height="30" background="images/tajukkiri.jpg">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font color="#FFFFFF"><strong>Editor</strong></font></td>
          </tr>
          <tr>
            <td height="50" align="left" bgcolor="#f1f0ee" background="images/bg-list3.png" style="background-repeat:repeat-x">
              <table width="200"  border="0" cellpadding="3" cellspacing="1">
                <tr>
                  <td class="bg">&#8226; <a style="text-decoration:none; " href="<?php echo $APP_URL; ?>/journal-select.php">Editor Dashboard</a></td>
                </tr>
                <tr>
                  <td class="bg">&#8226; <a style="text-decoration:none; " href="<?php echo $APP_URL; ?>/journal-edit.php">Edit Journal </a></td>
                </tr>
                <tr>
                  <td class="bg">&#8226; <a style="text-decoration:none; " href="<?php echo $APP_URL; ?>/manual-article-upload.php">Manual Article Upload</a></td>
                </tr>
                <tr>
                  <td class="bg">&#8226; <a style="text-decoration:none; " href="<?php echo $APP_URL; ?>/editor-view-article-list.php">Article Management </a></td>
                </tr>
                <tr>
                  <td class="bg">&#8226; <a style="text-decoration:none; " href="<?php echo $APP_URL; ?>/editor-reviewer-add.php">Reviewer Management</a></td>
                </tr>
                <tr>
                  <td class="bg">&#8226; <a style="text-decoration:none; " href="<?php echo $APP_URL; ?>/editor-view-checklist.php">Checklist Management</a></td>
                </tr>

                <tr>
                  <td class="bg">&#8226; <a style="text-decoration:none; " href="<?php echo $APP_URL; ?>/eg-edit.php">Editorial Group Management</a></td>
                </tr>
                <tr>
                  <td class="bg">&#8226; <a style="text-decoration:none; " href="<?php echo $APP_URL; ?>/sr-edit.php">Submission Rules Management</a></td>
                </tr>
                <tr>
                  <td class="bg">&#8226; <a style="text-decoration:none; " href="<?php echo $APP_URL; ?>/volume-add.php">Volumes &amp; Issues Management</a></td>
                </tr>
                <tr>
                  <td class="bg">&#8226; <a style="text-decoration:none; " href="<?php echo $APP_URL; ?>/reviewer-profile.php">Editor Profile</a></td>
                </tr>
                <tr>
                  <td class="bg">&#8226; <a style="text-decoration:none; " href="<?php echo $APP_URL; ?>/content.php">Web Content</a></td>
                </tr>
                <tr>
                  <td class="bg">&#8226; <a style="text-decoration:none; " href="<?php echo $APP_URL; ?>/editor-user-add.php">User Registration</a></td>
                </tr>
				<tr>
					<td class="bg">&#8226; <a style="text-decoration:none; " href="<?php echo $APP_URL; ?>/export-articles.php">Export Articles</a></td>
				</tr>
              </table>
            </td>
          </tr>
        </table>
      </td>
    </tr>
  <?php endif ?>
<?php endif ?>
<?php
// reviewer
$short_name = "reviewer";
// $nav_role_id = getRoleIdByShortName($short_name);
?>
<?php if ( true) : ?>
  <?php if ( true) : ?>
    <?php $navigation_count++ ?>
    <tr valign="top">
      <td>
        <table width="217" border="0" align="left" cellpadding="0" cellspacing="0">
          <tr>
            <td height="30" background="images/tajukkiri.jpg">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font color="#FFFFFF"><strong>Reviewer</strong></font></td>
          </tr>
          <tr>
            <td height="50" align="left" bgcolor="#f1f0ee" background="images/bg-list3.png" style="background-repeat:repeat-x">
              <table width="200"  border="0" cellpadding="3" cellspacing="1" bordercolor="#CCCCCC">
                <tr>
                  <td class="bg">&#8226; <a style="text-decoration:none; " href="<?php echo $APP_URL; ?>/reviewer-list-article.php">Review Dashboard</a></td>
                </tr>
                <tr>
                  <td class="bg">&#8226; <a style="text-decoration:none; " href="<?php echo $APP_URL; ?>/reviewer-profile.php">Reviewer Profile</a></td>
                </tr>
              </table>
            </td>
          </tr>
      </table>
    </td>
  </tr>
  <?php endif ?>
<?php endif ?>
<?php
$short_name = "editorial-board-member";
// $nav_role_id = getRoleIdByShortName($short_name);
?>
<?php if ( true) : ?>
  <?php if ( true) : ?>
    <?php $navigation_count++ ?>
    <tr valign="top">
      <td>
        <table width="217" border="0" align="left" cellpadding="0" cellspacing="0">
          <tr>
            <td height="30" background="images/tajukkiri.jpg">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font color="#FFFFFF"><strong>Editorial Board Member</strong></font></td>
          </tr>
          <tr>
            <td height="50" align="left" bgcolor="#f1f0ee" background="images/bg-list3.png" style="background-repeat:repeat-x">
              <table width="200"  border="0" cellpadding="3" cellspacing="1" bordercolor="#CCCCCC">
                <tr>
                  <td class="bg">&#8226; <a style="text-decoration:none; " href="<?php echo $APP_URL; ?>/editorial-list-article.php">Editorial Dashboard</a></td>
                </tr>
                <tr>
                  <td class="bg">&#8226; <a style="text-decoration:none; " href="<?php echo $APP_URL; ?>/editorial-profile.php">Board Member Profile</a></td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
      </td>
    </tr>
  <?php endif ?>
<?php endif ?>
<?php
$short_name = "editor-in-chief";
// $nav_role_id = getRoleIdByShortName($short_name);
?>
<?php if ( true) : ?>
  <?php if ( true) : ?>
    <?php $navigation_count++; ?>
    <tr valign="top">
      <td>
        <table width="217" border="0" align="left" cellpadding="0" cellspacing="0">
          <tr>
            <td height="30" background="images/tajukkiri.jpg">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font color="#FFFFFF"><strong>Editorial In Chief</strong></font></td>
          </tr>
          <tr>
            <td height="50" align="left" bgcolor="#f1f0ee" background="images/bg-list3.png" style="background-repeat:repeat-x">
              <table width="200"  border="0" cellpadding="3" cellspacing="1" bordercolor="#CCCCCC">
                <tr>
                  <td class="bg">&#8226; <a style="text-decoration:none; " href="<?php echo $APP_URL; ?>/chief-list-article.php">Chief Dashboard</a></td>
                </tr>
                <tr>
                  <td class="bg">&#8226; <a style="text-decoration:none; " href="<?php echo $APP_URL; ?>/chief-profile.php">Chief Profile</a></td>
                </tr>
              </table>
            </td>
          </tr>
        </table>
      </td>
    </tr>
  <?php endif ?>
<?php endif ?>
<?php
// author
$short_name = "author";
// $nav_role_id = getRoleIdByShortName($short_name);
?>
<?php if ( true) : ?>
  <?php $navigation_count++; ?>
  <tr valign="top">
    <td>
      <table width="217" border="0" align="left" cellpadding="0" cellspacing="0">
        <tr>
          <td height="30" background="images/tajukkiri.jpg">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font color="#FFFFFF"><strong>Author</strong></font></td>
        </tr>
        <tr>
          <td height="50" align="left" bgcolor="#f1f0ee" background="images/bg-list3.png" style="background-repeat:repeat-x">
            <table width="200"  border="0" cellpadding="3" cellspacing="1" bordercolor="#CCCCCC">
			  <tr>
                <td class="bg">&#8226; <a style="text-decoration:none; " href="<?php echo $APP_URL; ?>/author-dashboard.php">Author Dashboard </a></td>
              </tr>
              <tr>
                <td class="bg">&#8226; <a style="text-decoration:none; " href="<?php echo $APP_URL; ?>/author-article-add.php">Add Article </a></td>
              </tr>
              <tr>
                <td class="bg">&#8226; <a style="text-decoration:none; " href="<?php echo $APP_URL; ?>/coauthor-add.php">Add Authors</a></td>
              </tr>
              <tr>
                <td class="bg">&#8226; <a style="text-decoration:none; " href="<?php echo $APP_URL; ?>/attach-add.php">Add Files</a></td>
              </tr>
              <tr>
                <td class="bg">&#8226; <a style="text-decoration:none; " href="<?php echo $APP_URL; ?>/confirm-add.php">Confirm Submission</a></td>
              </tr>
              <tr>
                <td class="bg">&#8226; <a style="text-decoration:none; " href="<?php echo $APP_URL; ?>/author-view-add.php">Article View</a></td>
              </tr>
              <tr>
                <td class="bg">&#8226; <a style="text-decoration:none; " href="<?php echo $APP_URL; ?>/reviewer-profile.php">Author Profile</a></td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
    </td>
  </tr>
<?php endif ?>
<?php
// author
$short_name = "part-timer";
// $nav_role_id = getRoleIdByShortName($short_name);
?>
<?php if ( true) : ?>
  <?php $navigation_count++; ?>
  <tr  valign="top">
    <td>
      <table width="217" border="0" align="left" cellpadding="0" cellspacing="0" >
        <tr>
          <td height="30" background="images/tajukkiri.jpg">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<font color="#FFFFFF"><strong>Part-Timer</strong></font></td>
        </tr>
        <tr>
          <td height="50" align="left" bgcolor="#f1f0ee" background="images/bg-list3.png" style="background-repeat:repeat-x">
            <table width="200"  border="0" cellpadding="3" cellspacing="1" bordercolor="#CCCCCC">
			  <tr>
                <td class="bg">&#8226; <a style="text-decoration:none; " href="<?php echo $APP_URL; ?>/manual-article-upload.php">Manual Article Upload</a></td>
              </tr>
              <tr>
                <td class="bg">&#8226; <a style="text-decoration:none; " href="<?php echo $APP_URL; ?>/article_references.php">References Editor</a></td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
    </td>
  </tr>
<?php endif ?>
</table>
<script>
$('#first').collapsible()
</script>
