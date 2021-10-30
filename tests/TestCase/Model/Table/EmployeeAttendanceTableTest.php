<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\EmployeeAttendanceTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\EmployeeAttendanceTable Test Case
 */
class EmployeeAttendanceTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\EmployeeAttendanceTable
     */
    public $EmployeeAttendance;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.employee_attendance',
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
        $config = TableRegistry::getTableLocator()->exists('EmployeeAttendance') ? [] : ['className' => EmployeeAttendanceTable::class];
        $this->EmployeeAttendance = TableRegistry::getTableLocator()->get('EmployeeAttendance', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->EmployeeAttendance);

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
