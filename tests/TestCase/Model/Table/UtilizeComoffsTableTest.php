<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\UtilizeComoffsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\UtilizeComoffsTable Test Case
 */
class UtilizeComoffsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\UtilizeComoffsTable
     */
    public $UtilizeComoffs;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.utilize_comoffs',
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
        $config = TableRegistry::getTableLocator()->exists('UtilizeComoffs') ? [] : ['className' => UtilizeComoffsTable::class];
        $this->UtilizeComoffs = TableRegistry::getTableLocator()->get('UtilizeComoffs', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->UtilizeComoffs);

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
