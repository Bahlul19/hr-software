<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MinWeekHoursTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MinWeekHoursTable Test Case
 */
class MinWeekHoursTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\MinWeekHoursTable
     */
    public $MinWeekHours;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.min_week_hours'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('MinWeekHours') ? [] : ['className' => MinWeekHoursTable::class];
        $this->MinWeekHours = TableRegistry::getTableLocator()->get('MinWeekHours', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->MinWeekHours);

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
