<?php
include ('classification/classes/Criteria.php');
include ('include/admin-header.php');

$criteria = new Criteria();
if ($_POST['delete']) {
    // perform delete action
    $criteria->deleteAction();
}
else {
    // show list
    $criteria->indexAction();
}

include ('include/admin-footer.php');
