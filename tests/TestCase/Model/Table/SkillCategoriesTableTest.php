<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\SkillCategoriesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\SkillCategoriesTable Test Case
 */
class SkillCategoriesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\SkillCategoriesTable
     */
    public $SkillCategories;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.skill_categories',
        'app.skills'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('SkillCategories') ? [] : ['className' => SkillCategoriesTable::class];
        $this->SkillCategories = TableRegistry::getTableLocator()->get('SkillCategories', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->SkillCategories);

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
