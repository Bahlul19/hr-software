<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\EmployeeAttendancesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\EmployeeAttendancesTable Test Case
 */
class EmployeeAttendancesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\EmployeeAttendancesTable
     */
    public $EmployeeAttendances;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.employee_attendances',
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
        $config = TableRegistry::getTableLocator()->exists('EmployeeAttendances') ? [] : ['className' => EmployeeAttendancesTable::class];
        $this->EmployeeAttendances = TableRegistry::getTableLocator()->get('EmployeeAttendances', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->EmployeeAttendances);

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
