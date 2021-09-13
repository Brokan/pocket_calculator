<?php

namespace Tests\TestTraits\Users;

use Tests\TestTraits\Users\User;

/**
 * To Authenticate user.
 */
trait Authenticate {

    use User;

    /**
     * Make user authentication. Create test user if need.
     * @return \self
     */
    private function authenticate() : self {
        //Create test user if need.
        if(empty($this->testUser->id)){
            $this->createUserTest();
        }
        return $this->actingAs($this->testUser);
        
    }
}
