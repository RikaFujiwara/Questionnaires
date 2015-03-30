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

<section>

    <?php echo $this->element('Questionnaires.answer_test_mode_header'); ?>

    <header>
        <h3>
            <?php echo $questionnaire['QuestionnaireEntity']['title']; ?>
            <?php if (isset($questionnaire['QuestionnaireEntity']['sub_title'])): ?>
                <small><?php echo $questionnaire['QuestionnaireEntity']['sub_title'];?></small>
            <?php endif ?>
        </h3>
    </header>

<?php echo $this->Form->create('PreAnswer', array(
'name' => 'questionnaire_form_answer',
'type' => 'post',
'novalidate' => true,
)); ?>

    <?php echo $this->Form->hidden('id'); ?>
    <?php echo $this->Form->hidden('Frame.id', array('value' => $frameId)); ?>
    <?php echo $this->Form->hidden('Block.id', array('value' => $blockId,)); ?>
    <?php echo $this->Form->hidden('Questionnaire.id', array('value' => $questionnaire['Questionnaire']['id'])); ?>
    <?php if ($questionnaire['QuestionnaireEntity']['key_pass_use_flag'] == QuestionnairesComponent::USES_USE): ?>
    <p>
        <?php echo __d('questionnaires', 'This questionnaire has been guarded by the key phrase .
Please enter the first key phrase To answer .'); ?>
        </p>
        <?php echo $this->Form->input('key_phrase', array(
            'div' => 'form-group',
            'label' => 'Please input Key-Phrase',
            'class' => 'form-control'
        ));?>
        <?php if (isset($errors['PreAnswer']['key_phrase'])): ?>
        <div class="has-error">
            <?php foreach ($errors['PreAnswer']['key_phrase'] as $message): ?>
            <div class="help-block">
                <?php echo $message ?>
            </div>
            <?php endforeach ?>
        </div>
        <?php endif ?>

    <?php echo $this->element(
        'NetCommons.errors', [
        'errors' => $this->validationErrors,
        'model' => 'QuestionnaireEntity',
        'field' => 'key_phrase',
        ]) ?>
    <?php endif ?>

    <?php if ($questionnaire['QuestionnaireEntity']['image_authentication_flag'] == QuestionnairesComponent::USES_USE): ?>
        <?php echo $this->Form->input('image_auth', array(
        'div' => 'form-group',
        'label' => 'Please input number in this image.',
        'class' => 'form-control'
        ));?>
        <?php if (isset($errors['PreAnswer']['image_auth'])): ?>
        <div class="has-error">
            <?php foreach ($errors['PreAnswer']['image_auth'] as $message): ?>
            <div class="help-block">
                <?php echo $message ?>
            </div>
            <?php endforeach ?>
        </div>
        <?php endif ?>
    <?php endif ?>

    <div class="text-center">
        <a class="btn btn-default" href="/<?php echo $topUrl; ?>">
            <span class="glyphicon glyphicon-remove"></span>
            <?php echo __d('net_commons', 'Cancel'); ?>
        </a>
        <?php echo $this->Form->button(
        __d('net_commons', 'NEXT') . ' <span class="glyphicon glyphicon-chevron-right"></span>',
        array(
        'class' => 'btn btn-default',
        'name' => 'next_' . '',
        )) ?>
    </div>
<?php echo $this->Form->end(); ?>

</section>