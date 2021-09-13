<?php

namespace Tests\Unit\App\Libraries\UsersLogsBLL;

use App\Libraries\UsersLogsBLL;

/**
 * @covers App\Libraries\UsersLogsBLL::getUserId()
 */
class getUserIdTest extends \Tests\TestCase {

    use \Tests\TestTraits\Users\Authenticate;
    
    /**
     * Test when fail.
     * @return void
     */
    public function testFailZero(): void {
        $this->assertEquals(0, UsersLogsBLL::getUserId());
    }

    /**
     * Test when success.
     * @return void
     */
    public function testSuccessAuthorised(): void {
        $this->authenticate();
        $this->assertEquals($this->testUser->id, UsersLogsBLL::getUserId());
    }
}
