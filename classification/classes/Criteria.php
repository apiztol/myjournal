<?php
require 'BaseClass.php';
require dirname(__FILE__).'/../models/CriteriaModel.php';

class Criteria extends BaseClass
{
	public $criteriaModel;

    function __construct() {
    	$this->criteriaModel = new CriteriaModel();
    }

    function indexAction() {
        $data['compulsory'] = $this->criteriaModel->getCriterias();
        $data['optional'] = $this->criteriaModel->getCriterias(0);
		$data['choice'] = $this->criteriaModel->getChoice();

        $this->render('criteria/list', $data);
    }

    function createAction() {

		$data[] = null;

    	if (isset($_POST['submitButton'])) {


			$criteriaId = $_POST['criteria_id'];

			$criteriaName = $_POST['criteria_name'];
    		$compulsory = $_POST['compulsory'];
    		$criteriaType = $_POST['criteria_type'];
    		$choices = $_POST['choices'];
			$choicesId = $_POST['choice_id'];
    		$choiceMarks = $_POST['choice_marks'];

    		$criteriaValue = array(
    				'criteria_name' => $criteriaName,
    				'criteria_type' => $criteriaType,
    				'compulsory' => $compulsory,
    			);

			if($criteriaId != "")
			{
				$criteriaValue['criteria_id'] = $criteriaId;
			}

			//print_r($criteriaValue);

    		$choiceValues = [];
    		for ($i = 0; $i < count($choices); $i++) {
    			if (strlen($choices[$i]) && $choiceMarks[$i] > -1) {
    				$value = array(
    						'choice_name' => $choices[$i],
    						'marks' => $choiceMarks[$i],
    					);

					if($choicesId[$i] != "")
					{
						$value['choice_id'] = $choicesId[$i];
					}

    				array_push($choiceValues, $value);

    			}
    		}

			if(isset($_GET['e'])){
				//Disable

				if ($this->criteriaModel->updateCriteria($criteriaValue, $choiceValues)) {
					$this->redirect('classification_criterias.php');
				}

			}
			else{

				if ($this->criteriaModel->insertData($criteriaValue, $choiceValues)) {
					$this->redirect('classification_criterias.php');
				}
			}
    	}
		//CHANGE LATER
		else if(isset($_GET['e']))
		{
			$data['criteria'] = $this->criteriaModel->getCriteria($_GET['id']);
		}

		// render view
        $this->render('criteria/form',$data);
    }

	function deleteAction() {
		$this->criteriaModel->deleteCriteria();

		$_SESSION['success_msg'] = "Criteria has been successfully deleted.";
		$this->redirect('classification_criterias.php');
	}

}
