<?php
require_once "BaseModel.php";

class JournalModel extends BaseModel
{

	// get journals list
	function getJournals($limit = 0, $offset = 0, $search = '') {

		$stmt = $this->db2->prepare('SELECT * FROM journals WHERE name LIKE :search LIMIT :limit OFFSET :offset');
		$stmt->bindValue(':search', "%$search%", PDO::PARAM_STR);
		$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
		$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
		$stmt->execute();
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

		return $rows;
	}

	function getJournalsFullList($search = '') {
		$stmt = $this->db2->prepare('SELECT * FROM journals WHERE name LIKE :search');
		$stmt->bindValue(':search', "%$search%", PDO::PARAM_STR);
		$stmt->execute();
		$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

		return $rows;
	}

	// get a journal by id
	function getJournal($id) {
		$stmt = $this->db2->prepare('SELECT * FROM journals WHERE id=?');
		$stmt->execute(array($id));
		$rows = $stmt->fetch(PDO::FETCH_ASSOC);

		return $rows;
	}

	// counting total list
	function getCount($search = '') {

		$stmt = $this->db2->prepare('SELECT * FROM journals WHERE name LIKE :search');
		$stmt->bindValue(':search', "%$search%", PDO::PARAM_STR);
		$stmt->execute();
		$rowCount = $stmt->rowCount();

		return $rowCount;
	}

	// get discipline by journal_id
	function getDiscipline($id = '') {
		if ($id != '') {
			$stmt = $this->db2->prepare('SELECT dis_desc FROM disciplines WHERE dis_id=?');
			$stmt->execute(array($id));
			$row = $stmt->fetch(PDO::FETCH_ASSOC);

			return $row['dis_desc'];
		}

		$stmt = $this->db2->prepare('SELECT dis_id as id, dis_desc FROM disciplines');
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	function getEvaluatedJournals($limit = 0, $offset = 0, $search = '', $form, $year, $discipline = '') {

		// get evaluations
		$sql = 'SELECT e.id, j.name as journal_name, e.journal_id FROM evaluation e
					INNER JOIN journals j on e.journal_id = j.id
					WHERE e.status = "enable"
					AND e.year=:year
					AND name LIKE :search
					AND discipline_id LIKE :discipline
					LIMIT :limit
					OFFSET :offset';

		$stmt = $this->db2->prepare($sql);
		$stmt->bindValue(':year', $year, PDO::PARAM_STR);
		$stmt->bindValue(':search', "%$search%", PDO::PARAM_STR);
		$stmt->bindValue(':discipline', "%$discipline%", PDO::PARAM_STR);
		$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
		$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
		$stmt->execute();
		$evaluations = $stmt->fetchAll(PDO::FETCH_ASSOC);

		// get all criterias based on selected form (category)
		$sql2 = 'SELECT criteria_id FROM category_criteria WHERE category_id=?';
		$stmt2 = $this->db2->prepare($sql2);
		$stmt2->execute(array($form));
		$criterias = $stmt2->fetchAll(PDO::FETCH_ASSOC);
		// put all criterias' id in array
		$criteriaIds = [];
		foreach ($criterias as $row) {
		 	array_push($criteriaIds, $row['criteria_id']);
		}

		$evaluatedJournals = [];
		// get evaluation marks
		foreach ($evaluations as $evaluation) {

			// get all answers
			$sql3 = 'SELECT criteria_name, marks, compulsory FROM evaluation_answer ea
						INNER JOIN criteria c on c.id = ea.criteria_id
						INNER JOIN choice ch on ch.id = ea.choice_id
						WHERE c.status = "enable"
						AND ea.evaluation_id=?
						AND ea.criteria_id IN('.implode(',', $criteriaIds).')';

			$stmt3 = $this->db2->prepare($sql3);
			$stmt3->execute(array($evaluation['id']));
			$answers = $stmt3->fetchAll(PDO::FETCH_ASSOC);

			// $this->printr($answers);
			$totalCompulsory = 0;
			$totalMarks = 0;
			$totalOptional = 0;

			// get marks of each answers and sum up its mark
			foreach ($answers as $answer) {
				// get marks of answer
				$marks = $answer['marks'];

				// add to total
				$totalMarks = $totalMarks + $marks;

				if ($answer['compulsory'] == 1) {
					$totalCompulsory += $marks;
				}
				else {
					$totalOptional += $marks;
				}
			}

			// create array with all values needed
			$ev = array(
				'evaluation_id' => $evaluation['id'],
				'name' => $evaluation['journal_name'],
				'journalId' => $evaluation['journal_id'],
				'totalMarks' => $totalMarks,
				'compulsory' => $totalCompulsory,
				'optional' => $totalOptional,
			);
			// push to list
			array_push($evaluatedJournals, $ev);
		}

		// sort based on totalmarks - detail in function cmp
		usort($evaluatedJournals, function($a, $b) {
			return $b['totalMarks'] - $a['totalMarks'];
		});

		return $evaluatedJournals;
	}

	function deleteEvaluation() {
		$id = $_POST['delete'];
		// delete old answers and add new
		$stmt = $this->db2->prepare('UPDATE evaluation SET status="disable" WHERE id=?');
		$stmt->execute(array($id));
	}

	// counting total evaluated
	function getEvaluatedCount($search = '') {

		$sql = 'SELECT j.name FROM evaluation e
					INNER JOIN journals j on e.journal_id = j.id
					WHERE e.year=:year
					AND name LIKE :search';

		$stmt = $this->db2->prepare($sql);
		$stmt->bindValue(':year', $year, PDO::PARAM_STR);
		$stmt->bindValue(':search', "%$search%", PDO::PARAM_STR);
		$stmt->execute();

		return $stmt->rowCount();
	}

	function getEvaluationDetail($evaluation_id, $form) {
		$sql = 'SELECT j.name as journal_name, e.journal_id, e.created_at, e.updated_at, u.name as created_name, us.name as updated_name, j.discipline_id, j.publisher, e.year
					FROM evaluation e
					INNER JOIN journals j on e.journal_id = j.id
					LEFT JOIN users u on e.created_by = u.id
					LEFT JOIN users us on e.updated_by = us.id
					WHERE e.id = ?';

		$stmt = $this->db2->prepare($sql);
		$stmt->execute(array($evaluation_id));
		$evaluation = $stmt->fetch(PDO::FETCH_ASSOC);

		// get all criterias based on selected form (category)
		$sql2 = 'SELECT criteria_id FROM category_criteria WHERE category_id=?';
		$stmt2 = $this->db2->prepare($sql2);
		$stmt2->execute(array($form));
		$criterias = $stmt2->fetchAll(PDO::FETCH_ASSOC);
		// put all criterias' id in array
		$criteriaIds = [];
		foreach ($criterias as $row) {
		 	array_push($criteriaIds, $row['criteria_id']);
		}

		// get all criteria with answers
		$sql3 = 'SELECT ea.criteria_id, criteria_name, choice_name, marks, compulsory, remarks FROM evaluation_answer ea
					INNER JOIN criteria c on c.id = ea.criteria_id
					INNER JOIN choice ch on ch.id = ea.choice_id
					WHERE ea.evaluation_id=?
					AND ea.criteria_id IN('.implode(',', $criteriaIds).')';

		$stmt3 = $this->db2->prepare($sql3);
		$stmt3->execute(array($evaluation_id));
		$resultsList = $stmt3->fetchAll(PDO::FETCH_ASSOC);

		$totalMarks = 0;
		// get marks of each answers and sum up its mark
		$currentCriteria = '';
		$currentAnswer = '';
		$currentMarks = 0;
		$i = 0;
		foreach ($resultsList as &$answer) {
			// get marks of answer
			$marks = $answer['marks'];

			// add to total
			$totalMarks = $totalMarks + $marks;
			$answer['totalCriteriaMarks'] = $this->getTotalCriteriaMarks($answer['criteria_id']);

			// if same name as previous criteria, sum the previous marks and remove provious record
			if ($answer['criteria_name'] == $currentCriteria) {
				$answer['marks'] += $currentMarks;
				$answer['choice_name'] = $answer['choice_name'] . ',<br>' . $currentAnswer;
				unset($resultsList[($i - 1)]);
			}

			// later to check if same criteria, need to sum marks and show in one row
			$currentCriteria = $answer['criteria_name'];
			$currentMarks = $answer['marks'];
			$currentAnswer = $answer['choice_name'];

			$i++;
		}

		// create array with all values needed
		$evaluation['totalMarks'] = $totalMarks;
		$evaluation['resultList'] = $resultsList;

		return $evaluation;
	}

	function getTotalCriteriaMarks($criteriaId) {
		$sql = 'SELECT * FROM choice
				INNER JOIN criteria ON criteria.id = choice.criteria_id
				WHERE criteria_id=? AND choice.status="enable"';

		$stmt = $this->db2->prepare($sql);
		$stmt->execute(array($criteriaId));
		$choices = $stmt->fetchAll(PDO::FETCH_ASSOC);

		if ($choices[0]['criteria_type'] == 'checkbox') {
			$sum = 0;
			foreach ($choices as $choice) {
				$sum += $choice['marks'];
			}

			return $sum;
		}
		else if ($choices[0]['criteria_type'] == 'radio') {
			$max = 0;
			foreach ($choices as $choice) {
				if ($max < $choice['marks']) {
					$max = $choice['marks'];
				}
			}

			return $max;
		}
	}

	function getEvaluation($evaluation_id) {
		$sql = 'SELECT j.name as journal_name, e.journal_id, j.discipline_id, j.publisher, e.year FROM evaluation e
					INNER JOIN journals j on e.journal_id = j.id
					WHERE e.id = ?';

		$stmt = $this->db2->prepare($sql);
		$stmt->execute(array($evaluation_id));
		$evaluation = $stmt->fetch(PDO::FETCH_ASSOC);

		// get all criteria with answers
		$sql3 = 'SELECT ea.choice_id, ea.criteria_id, criteria_type, remarks, marks FROM evaluation_answer ea
					INNER JOIN criteria c on c.id = ea.criteria_id
					INNER JOIN choice ch on ch.id = ea.choice_id
					WHERE ea.evaluation_id=?
					ORDER BY compulsory DESC';

		$stmt3 = $this->db2->prepare($sql3);
		$stmt3->execute(array($evaluation_id));
		$resultsList = $stmt3->fetchAll(PDO::FETCH_ASSOC);

		// create array with all values needed
		$evaluation['resultList'] = $resultsList;

		return $evaluation;
	}

	function insertEvaluate($journalId, $year, $criteriaChoices, $remarks) {

		// insert evaluation and return inserted id
		$stmt = $this->db2->prepare("INSERT INTO evaluation (journal_id,year,created_by, created_at) VALUES (?,?,?,now())");
		$stmt->execute(array($journalId, $year, $_SESSION['user_id']));
		$evaluationId = $this->db2->lastInsertId();

		// insert answer choosen
		foreach ($criteriaChoices as $criteriaId => $choices) {
			foreach ($choices as $choiceId) {
				$stmt2 = $this->db2->prepare("INSERT INTO evaluation_answer (evaluation_id,criteria_id,choice_id,remarks) VALUES (?,?,?,?)");
				$stmt2->execute(array($evaluationId, $criteriaId, $choiceId, $remarks[$criteriaId]));
			}
		}
	}

	function updateEvaluate($evaluation_id, $year, $criteriaChoices, $remarks) {
		// update evaluation based on evaluation id
		$stmt = $this->db2->prepare("UPDATE evaluation SET year=?,updated_by=?,updated_at=now() WHERE id=?");
		$stmt->execute(array($year, $_SESSION['user_id'], $evaluation_id));

		// delete old answers and add new
		$stmt3 = $this->db2->prepare("DELETE FROM evaluation_answer WHERE evaluation_id=?");
		$stmt3->execute(array($evaluation_id));

		// insert new answer choosen
		foreach ($criteriaChoices as $criteriaId => $choices) {
			foreach ($choices as $choiceId) {
				$stmt2 = $this->db2->prepare("INSERT INTO evaluation_answer (evaluation_id,criteria_id,choice_id,remarks) VALUES (?,?,?,?)");
				$stmt2->execute(array($evaluation_id, $criteriaId, $choiceId, $remarks[$criteriaId]));
			}
		}
	}
}
