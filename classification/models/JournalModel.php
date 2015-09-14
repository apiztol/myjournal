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
					WHERE e.year=:year
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
						WHERE ea.evaluation_id=?
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
		// exit;
		return $evaluatedJournals;

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
		$sql = 'SELECT j.name as journal_name, e.journal_id, j.discipline_id, j.publisher, e.year FROM evaluation e
					INNER JOIN journals j on e.journal_id = j.id
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
		$sql3 = 'SELECT criteria_name, choice_name, marks, compulsory, remarks FROM evaluation_answer ea
					INNER JOIN criteria c on c.id = ea.criteria_id
					INNER JOIN choice ch on ch.id = ea.choice_id
					WHERE ea.evaluation_id=?
					AND ea.criteria_id IN('.implode(',', $criteriaIds).')';

		$stmt3 = $this->db2->prepare($sql3);
		$stmt3->execute(array($evaluation_id));
		$resultsList = $stmt3->fetchAll(PDO::FETCH_ASSOC);

		$totalMarks = 0;
		// get marks of each answers and sum up its mark
		foreach ($resultsList as $answer) {
			// get marks of answer
			$marks = $answer['marks'];

			// add to total
			$totalMarks = $totalMarks + $marks;
		}

		// create array with all values needed
		$evaluation['totalMarks'] = $totalMarks;
		$evaluation['resultList'] = $resultsList;

		return $evaluation;
	}

	function insertEvaluate($journalId, $year, $criteriaChoices, $remarks) {

		// insert evaluation and return inserted id
		$stmt = $this->db2->prepare("INSERT INTO evaluation (journal_id,year) VALUES (?,?)");
		$stmt->execute(array($journalId, $year));
		$evaluationId = $this->db2->lastInsertId();

		// insert answer choosen
		foreach ($criteriaChoices as $criteriaId => $choices) {
			foreach ($choices as $choiceId) {
				$stmt2 = $this->db2->prepare("INSERT INTO evaluation_answer (evaluation_id,criteria_id,choice_id,remarks) VALUES (?,?,?,?)");
				$stmt2->execute(array($evaluationId, $criteriaId, $choiceId, $remarks[$criteriaId]));
			}
		}
	}
}
