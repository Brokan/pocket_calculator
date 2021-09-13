<?php

namespace Tests\Unit\App\Libraries\UsersLogsBLL;

use App\Libraries\UsersLogsBLL;

/**
 * @covers App\Libraries\UsersLogsBLL::saveLogs()
 */
class saveLogsTest extends \Tests\TestCase {

    use \Tests\TestTraits\Users\Authenticate;
    
    /**
     * Test when fail.
     * @return void
     */
    public function testFailNoAuth(): void {
        $log = UsersLogsBLL::saveLogs('test', 'logs_string');
        $this->assertNull($log->id);
    }

    /**
     * Test when success.
     * @return void
     */
    public function testSuccessAuthorised(): void {
        $this->authenticate();
        $log = UsersLogsBLL::saveLogs('test', 'logs_string');
        $this->assertEquals('test', $log->name);
        $this->assertEquals('logs_string', $log->logs);
    }
}
