<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AnnouncementsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AnnouncementsTable Test Case
 */
class AnnouncementsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\AnnouncementsTable
     */
    public $Announcements;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.announcements'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Announcements') ? [] : ['className' => AnnouncementsTable::class];
        $this->Announcements = TableRegistry::getTableLocator()->get('Announcements', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Announcements);

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
