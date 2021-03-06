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
<?php if ($readonly): ?>
	<?php echo nl2br($answer[0]['answerValue']); ?>
<?php else: ?>
	<?php echo $this->Form->textarea('QuestionnaireAnswer.' . $index . '.answer_value', array(
		'div' => 'form-inline',
		'label' => false,
		'class' => 'form-control',
		'value' => $answer[0]['answerValue'],
		'disabled' => $readonly,
		'rows' => 5
		));?>
	<?php echo $this->Form->hidden('QuestionnaireAnswer.' . $index . '.matrix_choice_id', array(
		'value' => null
		)); ?>
<?php endif;