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
<?php echo $this->element('Questionnaires.scripts'); ?>


<?php echo $this->element('Questionnaires.Answers/answer_test_mode_header'); ?>

<article>
	<?php echo $this->element('Questionnaires.Answers/answer_header'); ?>

	<?php echo $this->Form->create('QuestionnaireAnswer', array(
	'name' => 'questionnaire_form_answer',
	'type' => 'post',
	'novalidate' => true,
	)); ?>
	<?php echo $this->Form->hidden('Frame.id', array('value' => $frameId)); ?>
	<?php echo $this->Form->hidden('Block.id', array('value' => $blockId)); ?>
	<?php echo $this->Form->hidden('Questionnaire.id', array('value' => $questionnaire['questionnaire']['id'])); ?>

	<p>
		<?php echo $questionnaire['questionnaire']['thanksContent']; ?>
	</p>
	<hr>
	<div class="text-center">
		<?php echo $this->BackToPage->backToPageButton(__d('questionnaires', 'Back to page'), 'menu-up', 'lg'); ?>
		<?php
			/* この画面へ来るときはAnswerCountは取得してないSQLで来ている */
			/* 集計ボタン表示Helperは回答数が１つはないと表示されない */
			/* 今回答したのだから必ず回答は１つはある */
			/* 強制的に一つ増やしておく */
			$questionnaire['countAnswerSummary'] = array('answerSummaryCount' => 1);
			echo $this->QuestionnaireUtil->getAggregateButtons($frameId, $questionnaire,
				array('title' => __d('questionnaires', 'Aggregate'),
						'class' => 'btn-primary btn-lg'));
		?>
	</div>
</article>