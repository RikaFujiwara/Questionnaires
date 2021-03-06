<?php
/**
 * Questionnaire Test Case
 *
 * @author Noriko Arai <arai@nii.ac.jp>
 * @author Allcreator <info@allcreator.net>
 * @link http://www.netcommons.org NetCommons Project
 * @license http://www.netcommons.org/license.txt NetCommons License
 * @copyright Copyright 2014, NetCommons Project
 */

App::uses('QuestionnaireTestBase', 'Questionnaires.Test/Case/Model');

/**
 * Summary for Questionnaire Test Case
 */
class QuestionnaireTest extends QuestionnaireTestBase {

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		parent::tearDown();
	}

/**
 * afterFind method
 *
 * @return void
 */
	public function testafterFind() {
		//初期処理
		$this->setUp();

		//データの生成
		$primary = false;

		$results = $this->Questionnaire->find('all');
		$results[0]['Questionnaire']['all_answer_count'] = 0;

		// 処理実行
		$result = $this->Questionnaire->afterFind($results, $primary);

		// テスト実施('all_answer_count'が1に更新されていること)
		$this->assertEquals($result[0]['Questionnaire']['all_answer_count'], 1);

		//終了処理
		$this->tearDown();
	}

}
