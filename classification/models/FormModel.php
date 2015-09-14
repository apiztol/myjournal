<?php
require_once "BaseModel.php";

class FormModel extends BaseModel
{
	function getForms($id = null) {

		if ($id != null) {
			//return $this->db2->category->where('id', $id)->fetch();
			$stmt3 = $this->db2->prepare("SELECT e.*,COUNT('category_id') AS counter FROM category_criteria f JOIN category e WHERE e.id = f.category_id AND e.id=? GROUP BY e.id");
			$stmt3->execute(array($id));
			return $result = $stmt3->fetchAll();
		}
		//return $this->db2->category->where('status', 'enable');
		$stmt3 = $this->db2->prepare("SELECT e.*,COUNT('category_id') AS counter FROM category_criteria f JOIN category e WHERE e.id = f.category_id AND e.status=? GROUP BY e.id");
		$stmt3->execute(array('enable'));
		return $result = $stmt3->fetchAll();
	}

	function insertData($categoryValue = null, $criteriaValues = null) {

		// $this->printr($criteriaValues);exit;
		if ($categoryValue != null) {
			//$category = $this->db2->category->insert($categoryValue);
			$stmt = $this->db2->prepare("INSERT INTO category (name) VALUES (?)");
			$stmt->execute(array($categoryValue['name']));
			$lastInsertID = $this->db2->lastInsertId();

			if ($lastInsertID != null) {
				if ($criteriaValues != null) {
					foreach ($criteriaValues as $criteriaId) {
						//$this->db2->category_criteria()->insert(array('category_id' => $category['id'], 'criteria_id' => $criteriaId));
						$stmt2 = $this->db2->prepare("INSERT INTO category_criteria (category_id,criteria_id) VALUES (?,?)");
						$stmt2->execute(array($lastInsertID, $criteriaId));
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

	function getTotalMarksForForm($categoryId) {

		// get all criterias based on selected form (category)
		$sql = 'SELECT c.id, c.criteria_type FROM criteria c
					INNER JOIN category_criteria ca ON c.id = ca.criteria_id
					INNER JOIN category cat ON cat.id = ca.category_id
					WHERE ca.category_id=?';

		$stmt = $this->db2->prepare($sql);
		$stmt->execute(array($categoryId));
		$criterias = $stmt->fetchAll(PDO::FETCH_ASSOC);
		// $this->printr($criterias);

		$totalMarks = 0;
		foreach ($criterias as $criteria) {

			$sql2 = 'SELECT * FROM choice WHERE criteria_id=?';
			$stmt2 = $this->db2->prepare($sql2);
			$stmt2->execute(array($criteria['id']));
			$choices = $stmt2->fetchAll(PDO::FETCH_ASSOC);
			// $this->printr($choices);

			// checbox need to sum, radio need to choose higher
			if ($criteria['criteria_type'] == 'checkbox') {
				$sum = 0;
				foreach ($choices as $choice) {
					$sum += $choice['marks'];
				}

				// add sume to total marks
				$totalMarks += $sum;
			}
			else if ($criteria['criteria_type'] == 'radio') {
				$max = 0;
				foreach ($choices as $choice) {
					if ($max < $choice['marks']) {
						$max = $choice['marks'];
					}
				}

				// add sum to total marks
				$totalMarks += $max;
			}
		}

		return $totalMarks;
	}
}
