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

<div class="row">

	<div class="col-sm-6">
		<h5><?php echo __d('questionnaires', 'Line choices'); ?></h5>
		<ul class="list-group ">
			<li class="list-group-item" ng-repeat="(cIndex, choice) in matrixRows = (question.QuestionnaireChoice | filter: {matrix_type:<?php echo QuestionnairesComponent::MATRIX_TYPE_ROW_OR_NO_MATRIX; ?>})" >
				<div class="form-inline">
					<?php echo $this->element('Questionnaires.Questions/edit/question_setting_choice_element', array('pageIndex' => $pageIndex, 'qIndex' => $qIndex, 'isPublished' => $isPublished)); ?>
				</div>
			</li>
		</ul>
	</div>

	<div class="col-sm-6">
		<h5><?php echo __d('questionnaires', 'Column choices'); ?></h5>
		<ul class="list-group">
			<li class="list-group-item" ng-repeat="(cIndex, choice) in matrixColumns = (question.QuestionnaireChoice | filter: {matrix_type:<?php echo QuestionnairesComponent::MATRIX_TYPE_COLUMN; ?>})" >
				<div class="form-inline">
					<?php echo $this->element('Questionnaires.Questions/edit/question_setting_choice_element', array('pageIndex' => $pageIndex, 'qIndex' => $qIndex, 'isPublished' => $isPublished)); ?>
				</div>
			</li>
		</ul>
	</div><!-- col-sm-6 -->

</div>
