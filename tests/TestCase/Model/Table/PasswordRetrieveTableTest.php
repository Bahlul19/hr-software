<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PasswordRetrieveTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PasswordRetrieveTable Test Case
 */
class PasswordRetrieveTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\PasswordRetrieveTable
     */
    public $PasswordRetrieve;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.password_retrieve',
        'app.users'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('PasswordRetrieve') ? [] : ['className' => PasswordRetrieveTable::class];
        $this->PasswordRetrieve = TableRegistry::getTableLocator()->get('PasswordRetrieve', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->PasswordRetrieve);

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
