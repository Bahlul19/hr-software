<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\EmpLeavesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\EmpLeavesTable Test Case
 */
class EmpLeavesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\EmpLeavesTable
     */
    public $EmpLeaves;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.emp_leaves',
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
        $config = TableRegistry::getTableLocator()->exists('EmpLeaves') ? [] : ['className' => EmpLeavesTable::class];
        $this->EmpLeaves = TableRegistry::getTableLocator()->get('EmpLeaves', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->EmpLeaves);

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
