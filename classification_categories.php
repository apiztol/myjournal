<?php
include ('classification/classes/Form.php');
include ('include/admin-header.php');

$form = new Form();

if (isset($_GET['id'])) {
	$form->showAction($_GET['id']);
}
else if ($_POST['delete']) {
    // perform delete action
    $form->deleteAction();
}
else {
	$form->indexAction();
}

include ('include/admin-footer.php');
