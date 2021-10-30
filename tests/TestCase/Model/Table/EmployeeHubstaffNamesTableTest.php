<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\EmployeeHubstaffNamesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\EmployeeHubstaffNamesTable Test Case
 */
class EmployeeHubstaffNamesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\EmployeeHubstaffNamesTable
     */
    public $EmployeeHubstaffNames;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.employee_hubstaff_names',
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
        $config = TableRegistry::getTableLocator()->exists('EmployeeHubstaffNames') ? [] : ['className' => EmployeeHubstaffNamesTable::class];
        $this->EmployeeHubstaffNames = TableRegistry::getTableLocator()->get('EmployeeHubstaffNames', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->EmployeeHubstaffNames);

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
