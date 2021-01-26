<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\SquaresTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\SquaresTable Test Case
 */
class SquaresTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\SquaresTable
     */
    protected $Squares;

    /**
     * Fixtures
     *
     * @var array
     */
    protected $fixtures = [
        'app.Squares',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Squares') ? [] : ['className' => SquaresTable::class];
        $this->Squares = $this->getTableLocator()->get('Squares', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown(): void
    {
        unset($this->Squares);

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
}
