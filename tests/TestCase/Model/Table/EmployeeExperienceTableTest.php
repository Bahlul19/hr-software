<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\EmployeeExperienceTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\EmployeeExperienceTable Test Case
 */
class EmployeeExperienceTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\EmployeeExperienceTable
     */
    public $EmployeeExperience;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.employee_experience',
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
        $config = TableRegistry::getTableLocator()->exists('EmployeeExperience') ? [] : ['className' => EmployeeExperienceTable::class];
        $this->EmployeeExperience = TableRegistry::getTableLocator()->get('EmployeeExperience', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->EmployeeExperience);

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
