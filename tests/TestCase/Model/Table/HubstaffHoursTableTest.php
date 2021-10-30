<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\HubstaffHoursTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\HubstaffHoursTable Test Case
 */
class HubstaffHoursTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\HubstaffHoursTable
     */
    public $HubstaffHours;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.hubstaff_hours'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('HubstaffHours') ? [] : ['className' => HubstaffHoursTable::class];
        $this->HubstaffHours = TableRegistry::getTableLocator()->get('HubstaffHours', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->HubstaffHours);

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
}
