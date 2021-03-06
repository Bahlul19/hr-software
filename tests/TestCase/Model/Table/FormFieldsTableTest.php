<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\FormFieldsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\FormFieldsTable Test Case
 */
class FormFieldsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\FormFieldsTable
     */
    public $FormFields;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.form_fields',
        'app.forms'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('FormFields') ? [] : ['className' => FormFieldsTable::class];
        $this->FormFields = TableRegistry::getTableLocator()->get('FormFields', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->FormFields);

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
