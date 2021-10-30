<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ProcessDocumentationsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ProcessDocumentationsTable Test Case
 */
class ProcessDocumentationsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ProcessDocumentationsTable
     */
    public $ProcessDocumentations;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.process_documentations',
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
        $config = TableRegistry::getTableLocator()->exists('ProcessDocumentations') ? [] : ['className' => ProcessDocumentationsTable::class];
        $this->ProcessDocumentations = TableRegistry::getTableLocator()->get('ProcessDocumentations', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ProcessDocumentations);

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
