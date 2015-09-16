<?php
include ('classification/classes/Journal.php');
include ('include/admin-header.php');

$journal = new Journal();

if ($_POST['delete']) {
    // perform delete action
    $journal->deleteEvaluationAction();
}
else {
    // show list
    $journal->evaluatedJournalsAction();
}



include ('include/admin-footer.php');
