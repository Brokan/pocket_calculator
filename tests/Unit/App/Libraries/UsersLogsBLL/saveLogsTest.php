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
    public function testSuccessCreateAuthorised(): void {
        $this->authenticate();
        $log = UsersLogsBLL::saveLogs('test', 'logs_string');
        $this->assertEquals('test', $log->name);
        $this->assertEquals('logs_string', $log->logs);
        
        $log->delete();
    }
    
    /**
     * Test when success.
     * @return void
     */
    public function testSuccessUpdateAuthorised(): void {
        $this->authenticate();
        $log = UsersLogsBLL::saveLogs('test', 'logs_string');
        $this->assertEquals('test', $log->name);
        $this->assertEquals('logs_string', $log->logs);
        
        $logUpdated = UsersLogsBLL::saveLogs('test', 'logs_string_updated');
        $this->assertEquals('test', $logUpdated->name);
        $this->assertEquals('logs_string_updated', $logUpdated->logs);
        $this->assertEquals($log->id, $logUpdated->id);
        
        $logUpdated->delete();
    }
    
    /**
     * After tests delete test user.
     * @return void
     */
    protected function tearDown(): void {
        $this->deleteUserTest();
    }
}
