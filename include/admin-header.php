<?php

// read system configuration
include("config.php");

// set page properties
$pageGroup = "backend";

// check session
include("include/session.checker.php");
$user_id = $_SESSION["user_id"];
$username = $_SESSION["username"];
$group = $_SESSION["group"];

// instantiate db
// include("include/db.start.php");
// call user functions
// include("include/users.php");
// include("include/roles.php");
// include("include/blocks.php");
// include("include/portals.php");
// include("include/journals.php");
// include("include/date.php");
// include("include/articles.php");
// include('include/authors.php');
// include('include/categories.php');
// include("include/editors.php");
// include("include/editorial-group.php");
// include("include/reviewers.php");
// include("include/FCKeditor/fckeditor.php");
// include("include/ipt.php");
include("include/SqlPaginator.php");
// include_once 'include/html_processor.php';
// include_once 'include/JournalAliasModel.php';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>e-publication universiti malaya</title>
<script type="text/javascript" language="javascript" src="js/jquery-1.6.2.min.js"></script>
<script type="text/javascript" language="javascript" src="js/jquery.collapsible.min.js"></script>
<script type="text/javascript" language="javascript" src="js/jquery.colorbox-min.js"></script>
<script type="text/javascript" language="javascript" src="js/author_group_picker.js"></script>
<script type="text/javascript" language="javascript" src="js/criteria-add-dynamic.js"></script>
<script type="text/javascript" language="javascript" src="js/evaluate-form.js"></script>
<script type="text/javascript" language="javascript" src="js/jquery.flot.min.js"></script>
<script type="text/javascript" language="javascript" src="js/jquery.flot.pie.min.js"></script>
<link href="css/admin_main.css" rel="stylesheet" type="text/css" media="screen" />
<link href="lib/style.css" rel="stylesheet" type="text/css" media="screen" />
<link href="css/colorbox.css" rel="stylesheet" type="text/css" media="screen" />
</head>
<body leftmargin="0" topmargin="0" rightmargin="0" bottommargin="0">
<?php include("blocks/main-menu-be.php"); ?>
<?php include "header.php"; ?>
<table width="979" border="0" align="center" cellpadding="0" cellspacing="0">
  <tbody>
	  <tr>
	    <td width="219" valign="top"><?php include("blocks/menu.php"); ?> </td>
	    <td width="750" valign="top" height="25" colspan="2">
	    <?php if (isset($_SESSION['success_msg'])): ?>
	    <div class="alert_success">
		    <i><?php echo $_SESSION['success_msg']; unset($_SESSION['success_msg']) ?></i>
		</div>
		<?php endif ?>
		<?php if (isset($_SESSION['error_msg'])): ?>
	    <div class="alert_error">
		    <i><?php echo $_SESSION['error_msg']; unset($_SESSION['error_msg']) ?></i>
		</div>
		<?php endif ?>
