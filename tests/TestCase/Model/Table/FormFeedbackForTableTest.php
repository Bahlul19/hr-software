<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\FormFeedbackForTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\FormFeedbackForTable Test Case
 */
class FormFeedbackForTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\FormFeedbackForTable
     */
    public $FormFeedbackFor;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.form_feedback_for',
        'app.forms',
        'app.roles',
        'app.employees'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('FormFeedbackFor') ? [] : ['className' => FormFeedbackForTable::class];
        $this->FormFeedbackFor = TableRegistry::getTableLocator()->get('FormFeedbackFor', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->FormFeedbackFor);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
