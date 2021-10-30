<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AssignProcessesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AssignProcessesTable Test Case
 */
class AssignProcessesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\AssignProcessesTable
     */
    public $AssignProcesses;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.assign_processes',
        'app.process_documentations',
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
        $config = TableRegistry::getTableLocator()->exists('AssignProcesses') ? [] : ['className' => AssignProcessesTable::class];
        $this->AssignProcesses = TableRegistry::getTableLocator()->get('AssignProcesses', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->AssignProcesses);

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
