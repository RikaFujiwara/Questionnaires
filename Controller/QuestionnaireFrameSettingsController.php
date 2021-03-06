<?php
/**
 * Questionnaires FrameSettingsController
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Allcreator <info@allcreator.net>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('QuestionnaireBlocksController', 'Questionnaires.Controller');

/**
 * QuestionnaireFrameSettingsController
 *
 * @author Allcreator <info@allcreator.net>
 * @package NetCommons\Questionnaires\Controller
 */
class QuestionnaireFrameSettingsController extends QuestionnaireBlocksController {

/**
 * layout
 *
 * @var array
 */
	public $layout = 'NetCommons.setting';

/**
 * use model
 *
 * @var array
 */
	public $uses = array(
		'Blocks.Block',
		'Frames.Frame',
		'Questionnaires.Questionnaire',
		'Questionnaires.QuestionnaireFrameSetting',
		'Questionnaires.QuestionnaireFrameDisplayQuestionnaire',
	);

/**
 * use components
 *
 * @var array
 */
	public $components = array(
		'Security',
		'NetCommons.NetCommonsBlock', //Use Questionnaire model
		'NetCommons.NetCommonsFrame',
		'NetCommons.NetCommonsRoomRole' => array(
			//コンテンツの権限設定
			'allowedActions' => array(
				'pageEditable' => array('edit')
			),
		),
		'Questionnaires.Questionnaires',
		'Paginator',
	);

/**
 * use helpers
 *
 * @var array
 */
	public $helpers = array(
		'NetCommons.Date',
		'NetCommons.Token',
		'Questionnaires.QuestionnaireUtil'
	);

/**
 * beforeFilter
 *
 * @return void
 */
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->deny('index');

		$results = $this->camelizeKeyRecursive($this->NetCommonsFrame->data);
		$this->set($results);

		//タブの設定
		$this->initTabs('frame_settings');
	}

/**
 * edit method
 *
 * @return void
 */
	public function edit() {
		// Postデータ登録
		if ($this->request->isPost()) {
			$this->QuestionnaireFrameSetting->saveFrameSettings($this->viewVars['frameKey'], $this->data);
			if ($this->handleValidationError($this->QuestionnaireFrameSetting->validationErrors)) {
				if (! $this->request->is('ajax')) {
					$this->redirect('/questionnaires/questionnaire_blocks/index/' . $this->viewVars['frameId']);
				}
				return;
			}
		}

		$conditions = array(
			'block_id' => $this->viewVars['blockId'],
			'is_latest' => true,
		);
		try {
			$this->paginate = array(
				'conditions' => $conditions,
				'page' => 1,
				'sort' => QuestionnairesComponent::DISPLAY_SORT_TYPE_NEW_ARRIVALS,
				'limit' => 1000,
				'direction' => 'desc',
				'recursive' => -1,
			);
			$questionnaires = $this->paginate('Questionnaire');
		} catch (NotFoundException $e) {
			// NotFoundの例外
			// アンケートデータが存在しないこととする
			$questionnaires = array();
		}

		$frame = $this->QuestionnaireFrameSetting->find('first', array(
			'conditions' => array(
				'frame_key' => $this->viewVars['frameKey'],
			),
			'order' => 'QuestionnaireFrameSetting.id DESC'
		));
		if (!$frame) {
			$frame = $this->QuestionnaireFrameSetting->getDefaultFrameSetting();
		}

		$displayQuestionnaire = $this->QuestionnaireFrameDisplayQuestionnaire->find('list', array(
			'fields' => array(
				'questionnaire_origin_id', 'questionnaire_origin_id'
			),
			'conditions' => array(
				'frame_key' => $this->viewVars['frameKey'],
			),
		));
		$this->set('questionnaires', $questionnaires);
		$this->set('questionnaireFrameSettings', $frame['QuestionnaireFrameSetting']);
		$this->set('displayQuestionnaire', $displayQuestionnaire);
	}
}