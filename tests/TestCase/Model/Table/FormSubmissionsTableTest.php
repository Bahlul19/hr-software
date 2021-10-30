<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\FormSubmissionsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\FormSubmissionsTable Test Case
 */
class FormSubmissionsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\FormSubmissionsTable
     */
    public $FormSubmissions;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.form_submissions',
        'app.forms',
        'app.employees_a',
        'app.employees_b'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('FormSubmissions') ? [] : ['className' => FormSubmissionsTable::class];
        $this->FormSubmissions = TableRegistry::getTableLocator()->get('FormSubmissions', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->FormSubmissions);

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
