<?php

namespace Tests\Feature\Http\Controllers\HomeController;

use Tests\TestCase;

/**
 * Test log save.
 * @covers \App\Http\Controllers\HomeController::logSave
 */
class logSaveTest extends TestCase
{
    use \Tests\TestTraits\Users\Authenticate;
    
    /**
     * Test when not correct method.
     * @return void
     */
    public function testFailNoAuth() : void
    {
        $response = $this->post(action('HomeController@logSave'));

        $response->assertStatus(302);
        $response->assertSee('Redirecting to');
    }
    
    /**
     * Test when not correct method.
     * @return void
     */
    public function testFailAuthNoPost() : void
    {
        $response = $this->authenticate()->get(action('HomeController@logSave'));

        $response->assertStatus(405);
        $response->assertSee('MethodNotAllowedHttpException');
    }
    
    /**
     * Test when not correct post.
     * @return void
     */
    public function testFailAuthNoLog() : void
    {
        $response = $this->authenticate()->post(action('HomeController@logSave'), ['name' => 'test']);

        //Redirect back to form.
        $response->assertStatus(200);
        $this->assertArrayHasKey('error', $response->json());
        $this->assertTrue($response->json()['error']);
    }
    
    /**
     * Test when save success.
     * @return void
     */
    public function testSuccessAuthSaveLog() : void
    {
        $response = $this->authenticate()->post(action('HomeController@logSave'), ['name' => 'test', 'logs' => 'success']);

        //Redirect back to form.
        $response->assertStatus(200);
        
        //Test response
        $responseArray = $response->json();
        $this->assertArrayHasKey('id', $responseArray);
        $this->assertArrayHasKey('name', $responseArray);
        
        //Test do save is correct.
        $log = \App\Libraries\UsersLogsBLL::getByName($this->testUser->id, 'test');

        $this->assertEquals($log->id, $responseArray['id']);
        $this->assertEquals($log->name, $responseArray['name']);
        $this->assertEquals('test', $log->name);
        $this->assertEquals('success', $log->logs);
        
        //Clear DB.
        $log->delete();
    }
    
    /**
     * After tests delete test user.
     * @return void
     */
    protected function tearDown(): void {
        $this->deleteUserTest();
    }
}
