<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TagsCategoriesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TagsCategoriesTable Test Case
 */
class TagsCategoriesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\TagsCategoriesTable
     */
    protected $TagsCategories;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.TagsCategories',
        'app.Tags',
        'app.Categories',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('TagsCategories') ? [] : ['className' => TagsCategoriesTable::class];
        $this->TagsCategories = $this->getTableLocator()->get('TagsCategories', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->TagsCategories);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
