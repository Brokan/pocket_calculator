<?php

namespace Tests\Feature\Http\Controllers\HomeController;

use Tests\TestCase;

/**
 * Test home page.
 * @covers \App\Http\Controllers\HomeController::index
 */
class indexTest extends TestCase
{
    use \Tests\TestTraits\Users\Authenticate;
    
    /**
     * Test when no authenticate.
     */
    public function testNoAuth() : void
    {
        $response = $this->get(action('HomeController@index'));

        $response->assertStatus(200);
    }
    
    /**
     * Test when authenticated.
     * @return void
     */
    public function testAuth() : void
    {
        $response = $this->authenticate()->get(action('HomeController@index'));

        $response->assertStatus(200);
        $response->assertSee('Select saved');
        $response->assertSee('urlLogSave');
    }
    
    /**
     * After tests delete test user.
     * @return void
     */
    protected function tearDown(): void {
        $this->deleteUserTest();
    }
}
