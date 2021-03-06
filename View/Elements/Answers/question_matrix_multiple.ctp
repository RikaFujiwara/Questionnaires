<?php
/**
 * questionnaire page setting view template
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Allcreator <info@allcreator.net>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */
?>
<?php
	$multiAnswers = null;
	if (is_array($answer)) {
		$multiAnswers = array();
		foreach ($answer as $ans) {
			if (isset($ans['answerValues'])) {
				foreach ($ans['answerValues'] as $id => $val) {
					$multiAnswers[$ans['matrixChoiceId']][] = QuestionnairesComponent::ANSWER_DELIMITER . $id . QuestionnairesComponent::ANSWER_VALUE_DELIMITER . $val;
				}
			}
		}
	}
	if (isset($question['questionnaireChoice'])) {
		$options = array();
		$rowChoices = array();
		foreach ($question['questionnaireChoice'] as $choice) {
			if ($choice['matrixType'] == QuestionnairesComponent::MATRIX_TYPE_COLUMN) {
				$options[QuestionnairesComponent::ANSWER_DELIMITER . $choice['originId'] . QuestionnairesComponent::ANSWER_VALUE_DELIMITER . $choice['choiceLabel']] = $choice['choiceLabel'];
			} else {
				$rowChoices[] = $choice;
			}
		}
	}
?>
<?php
	if (!$readonly) {
		$addClass = ' table-striped table-hover ';
	} else {
		$addClass = '';
	}
?>
<table class="table <?php echo $addClass; ?> table-bordered text-center questionnaire-matrix-table">
	<thead>
	<tr>
		<th></th>
		<?php foreach ($options as $opt): ?>
		<th class="text-center">
			<?php echo $opt; ?>
		</th>
		<?php endforeach; ?>
	</thead>
	<tbody>
	<?php foreach ($rowChoices as $rowIndex => $row): ?>
	<tr>
		<th>
			<?php echo $row['choiceLabel']; ?>
			<?php echo $this->Form->hidden('QuestionnaireAnswer.' . $index . '.' . $rowIndex . '.questionnaire_question_origin_id', array(
			'value' => $question['originId']
			));?>
			<?php echo $this->Form->hidden('QuestionnaireAnswer.' . $index . '.' . $rowIndex . '.matrix_choice_id', array(
			'value' => $row['originId']
			));?>
			<?php echo $this->Form->hidden('QuestionnaireAnswer.' . $index . '.' . $rowIndex . '.id', array(
			'value' => isset($questionPage['questionnaireAnswer'][$question['originId']]['id']) ? $questionPage['questionnaireAnswer'][$question['originId']]['id'] : null,
			));?>
			<?php if ($row['otherChoiceType'] != QuestionnairesComponent::OTHER_CHOICE_TYPE_NO_OTHER_FILED): ?>
			<?php echo $this->Form->input('QuestionnaireAnswer.' . $index . '.' . $rowIndex . '.other_answer_value', array(
			'type' => 'text',
			'label' => false,
			'div' => false,
			'value' => $answer[$rowIndex]['otherAnswerValue'],
			'disabled' => $readonly,
			)); ?>
			<?php endif ?>
		</th>
		<?php $optCount = 0; ?>
		<?php foreach ($options as $key => $opt): ?>
		<td>
			<?php
			/* 配列をforeachでばらしつつ、かつ、options配列を要求する input(type=select,multiple=checkbox)を使うという一見無駄なことをしてます
			これには深いわけがあります
			1.単純なcheckboxメソッドで単一CheckboxをFOREACHで作るとBlackhole
			 どうやら同じFieldNameで複数のinput要素を作る処理がBlackHoleを呼ぶらしい
			2.Foreachをやめて、inputに配列をごそっと渡すと。。。TDセルに小分けに入らない。なぜかbetweenはtype=selectには効かない
			上記理由で仕方なくこのような措置を取っています
			*/
			?>
			<?php echo $this->Form->input('QuestionnaireAnswer.' . $index . '.' . $rowIndex . '.answer_value', array(
			'type' => 'select',
			'multiple' => 'checkbox',
			'options' => array($key => ''),
			'label' => false,
			'div' => false,
			'hiddenField' => ($readonly || $optCount != 0) ? false : true,
			'value' => (is_array($multiAnswers) && isset($multiAnswers[$row['originId']])) ? $multiAnswers[$row['originId']] : null,
			'disabled' => $readonly,
			));
			$optCount++;
			?>
		</td>
		<?php endforeach; ?>	</tr>
	<?php endforeach; ?>
	</tbody>
</table>
