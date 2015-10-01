<?php
namespace GintonicCMS\Test\TestCase\Shell;

use Cake\TestSuite\TestCase;
use GintonicCMS\Shell\UpdateShell;

/**
 * GintonicCMS\Shell\UpdateShell Test Case
 */
class UpdateShellTest extends TestCase
{

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->io = $this->getMock('Cake\Console\ConsoleIo');
        $this->Update = new UpdateShell($this->io);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Update);

        parent::tearDown();
    }

    /**
     * Test main method
     *
     * @return void
     */
    public function testMain()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
