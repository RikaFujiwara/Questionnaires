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
<?php
	echo $this->Html->script(
	array(
	'/components/d3/d3.min.js',
	'/components/nvd3/nv.d3.min.js',
	'/components/angular-nvd3/dist/angular-nvd3.min.js',
	),
	array(
	'plugin' => false,
	'once' => true,
	'inline' => false
	)
	);
	echo $this->Html->script('Questionnaires.questionnaires_graph.js');
?>
<?php echo $this->Html->css('/components/nvd3/nv.d3.css',
	array(
	'plugin' => false,
	'once' => true,
	'inline' => false
	)
); ?>

<?php echo $this->Html->scriptStart(array('inline' => false)); ?>
NetCommonsApp.requires.push('nvd3');
<?php echo $this->Html->scriptEnd(); ?>

<?php /* FUJI: 下のdivのidがnc-questionnaires-total-xx でよいか要確認. */ ?>
<div id="nc-questionnaires-total-<?php echo (int)$frameId; ?>"
	ng-controller="QuestionnairesAnswerSummary"
	ng-init="initialize(<?php echo (int)$frameId; ?>,
	<?php echo h(json_encode($questionnaire)); ?>,
	<?php echo h(json_encode($questions)); ?>)">

<?php App::uses('Sanitize', 'Utility'); ?>

<article>
	<?php echo $this->element('Questionnaires.Answers/answer_test_mode_header'); ?>

	<?php echo $this->element('Questionnaires.Answers/answer_header'); ?>

	<?php if (!empty($questionnaire['questionnaire']['totalComment'])): ?>
		<div class="row">
			<div class="col-xs-12">
					<p>
						<?php echo Sanitize::stripAll($questionnaire['questionnaire']['totalComment']); ?>
					</p>
			</div>
		</div>
	<?php endif; ?>

	<?php foreach ($questions as $questionnaireQuestionId => $question): ?>
		<?php
			if ($question['isResultDisplay'] != QuestionnairesComponent::EXPRESSION_SHOW) {
				//集計表示をしない、なので飛ばす
				continue;
			}

			//集計表示用のelement名決定
			$elementName = '';
			$matrix = '';
			if (QuestionnairesComponent::isMatrixInputType($question['questionType'])) {
				$matrix = '_matrix';
			}
			if ($question['resultDisplayType'] == QuestionnairesComponent::RESULT_DISPLAY_TYPE_BAR_CHART) {
				$elementName = 'Questionnaires.AnswerSummaries/aggrigate' . $matrix . '_bar_chart';
			} elseif ($question['resultDisplayType'] == QuestionnairesComponent::RESULT_DISPLAY_TYPE_PIE_CHART) {
				$elementName = 'Questionnaires.AnswerSummaries/aggrigate' . $matrix . '_pie_chart';
			} elseif ($question['resultDisplayType'] == QuestionnairesComponent::RESULT_DISPLAY_TYPE_TABLE) {
				$elementName = 'Questionnaires.AnswerSummaries/aggrigate' . $matrix . '_table';
			}

			if ($elementName === '') {
				continue; //element名が決まらない場合、次へ。
			}
		?>
		<div class="row">
			<?php
			//各質問ごと集計表示の共通ヘッダー
			echo $this->element('Questionnaires.AnswerSummaries/aggrigate_common_header',
			array(
			'frameId' => $frameId,
			'questionnaireId' => $questionnaireId,
			'questionnaire' => $questionnaire,
			'question' => $question
			)
			);
			?>
			<?php echo $this->element($elementName,
					array(
						'frameId' => $frameId,
						'questionnaireId' => $questionnaireId,
						'questionnaire' => $questionnaire,
						'question' => $question,
						'questionId' => $questionnaireQuestionId
					)
				);
			?>
			<?php
			//各質問ごと集計表示の共通フッター
			echo $this->element('Questionnaires.AnswerSummaries/aggrigate_common_footer',
			array(
			'frameId' => $frameId,
			'questionnaireId' => $questionnaireId,
			'questionnaire' => $questionnaire,
			'question' => $question
			)
			);
			?>

		</div>
	<?php endforeach; ?>

	<div class="text-center">
		<?php echo $this->BackToPage->backToPageButton(__d('questionnaires', 'Back to Top'), '', 'lg'); ?>
	</div>

</article>
</div>
