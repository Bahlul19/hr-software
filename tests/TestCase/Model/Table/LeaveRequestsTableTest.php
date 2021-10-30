<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\LeaveRequestsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\LeaveRequestsTable Test Case
 */
class LeaveRequestsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\LeaveRequestsTable
     */
    public $LeaveRequests;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.leave_requests',
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
        $config = TableRegistry::getTableLocator()->exists('LeaveRequests') ? [] : ['className' => LeaveRequestsTable::class];
        $this->LeaveRequests = TableRegistry::getTableLocator()->get('LeaveRequests', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->LeaveRequests);

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
