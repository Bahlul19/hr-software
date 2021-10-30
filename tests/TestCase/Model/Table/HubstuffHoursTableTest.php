<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\HubstuffHoursTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\HubstuffHoursTable Test Case
 */
class HubstuffHoursTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\HubstuffHoursTable
     */
    public $HubstuffHours;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.hubstuff_hours'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('HubstuffHours') ? [] : ['className' => HubstuffHoursTable::class];
        $this->HubstuffHours = TableRegistry::getTableLocator()->get('HubstuffHours', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->HubstuffHours);

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
