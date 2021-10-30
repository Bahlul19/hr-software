<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\EmployeeSkillsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\EmployeeSkillsTable Test Case
 */
class EmployeeSkillsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\EmployeeSkillsTable
     */
    public $EmployeeSkills;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.employee_skills',
        'app.employees',
        'app.skills',
        'app.skill_levels'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('EmployeeSkills') ? [] : ['className' => EmployeeSkillsTable::class];
        $this->EmployeeSkills = TableRegistry::getTableLocator()->get('EmployeeSkills', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->EmployeeSkills);

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
