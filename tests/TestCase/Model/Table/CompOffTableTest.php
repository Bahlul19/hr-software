<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CompOffTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CompOffTable Test Case
 */
class CompOffTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\CompOffTable
     */
    public $CompOff;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.comp_off'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('CompOff') ? [] : ['className' => CompOffTable::class];
        $this->CompOff = TableRegistry::getTableLocator()->get('CompOff', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->CompOff);

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
