<?php
require_once "BaseModel.php";

class CriteriaModel extends BaseModel
{

	function getCriterias($compulsory = 1) {

		$stmt3 = $this->db2->prepare('SELECT * FROM criteria WHERE compulsory=? AND status="enable"');
		$stmt3->execute(array($compulsory));
		$rows = $stmt3->fetchAll(PDO::FETCH_ASSOC);

		foreach ($rows as &$row) {
			$row['choices'] = $this->getChoice($row['id']);
		}

		return $rows;
	}

	function getChoice($criteriaId) {
		$stmt = $this->db2->prepare('SELECT * FROM choice WHERE criteria_id=? AND status="enable"');
		$stmt->execute(array($criteriaId));
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

		return $rows;
	}

	function getCriteria($id) {
		$stmt3 = $this->db2->prepare('SELECT * FROM criteria WHERE id=? AND status="enable"');
		$stmt3->execute(array($id));
		$result = $stmt3->fetchAll();

		foreach ($result as &$row) {
			$row['choices'] = $this->getChoice($row['id']);
		}
		return $result;
	}

	function deleteCriteria() {
		$id = $_POST['delete'];
		// delete old answers and add new
		$stmt = $this->db2->prepare('UPDATE criteria SET status="disable" WHERE id=?');
		$stmt->execute(array($id));
	}

	function insertData($criteriaValue = null, $choiceValues = null) {
		if ($criteriaValue != null) {

			$stmt3 = $this->db2->prepare("INSERT INTO criteria (criteria_name,compulsory,criteria_type) VALUES (?,?,?)");
			$stmt3->execute(array($criteriaValue['criteria_name'],$criteriaValue['compulsory'],$criteriaValue['criteria_type']));
			$lastInsertID = $this->db2->lastInsertId();

			if ($lastInsertID != null) {
				if ($choiceValues != null) {
					foreach ($choiceValues as $choiceValue) {
						$stmt3 = $this->db2->prepare("INSERT INTO choice (choice_name,marks,status,criteria_id) VALUES (?,?,?,?)");
						$stmt3->execute(array($choiceValue['choice_name'],$choiceValue['marks'],"enable",$lastInsertID));
					}
				}
			}
			else {
				return false;
			}
		}
		else {
			return false;
		}

		return true;
	}

	function updateCriteria($criteriaValue = null, $choiceValues = null) {

		$criteria_id = $criteriaValue['criteria_id'];

		$update1 = $this->db2->prepare("UPDATE criteria SET criteria_name = ? , compulsory=?,criteria_type =? WHERE id = ?");
		$update1->execute(array($criteriaValue['criteria_name'],$criteriaValue['compulsory'],$criteriaValue['criteria_type'],$criteriaValue['criteria_id']));

		if ($choiceValues != null) {

			$stmt = $this->db2->prepare("UPDATE choice SET status = ? WHERE criteria_id = ?");
			$stmt->execute(array("disable",$criteria_id));

			foreach ($choiceValues as $choiceValue) {

				$choice_id = $choiceValue['choice_id'];

				if($choice_id != ""){

					$stmt2 = $this->db2->prepare("UPDATE choice SET choice_name=?,marks=?,status=? WHERE id = ?");
					$stmt2->execute(array($choiceValue['choice_name'],$choiceValue['marks'],"enable",$choice_id));

				}

				else{

					$stmt3 = $this->db2->prepare("INSERT INTO choice (choice_name,marks,status,criteria_id) VALUES (?,?,?,?)");
					$stmt3->execute(array($choiceValue['choice_name'],$choiceValue['marks'],"enable",$criteria_id));

				}
			}
		}

		return true;
	}


}
