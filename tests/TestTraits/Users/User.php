<?php

namespace Tests\TestTraits\Users;

use App\User as ModelUser;

/**
 * To create, get, delete test user.
 */
trait User {

    /**
     * Created test user.
     * @var ModelUser 
     */
    private $testUser;

    /**
     * Test user name.
     * @var string 
     */
    private $testUserName = 'test';

    /**
     * Test user e-mail.
     * @var string 
     */
    private $testUserEmail = 'test@test.com';

    /**
     * Test user password.
     * @var string 
     */
    private $testUserPassword = 'test';

    /**
     * Create test user.
     * @return User
     */
    private function createUserTest(): ModelUser {
        //Delete previously create test user;
        $this->deleteUserTest();
        //Create new test user.
        $this->testUser = ModelUser::create([
                    'name' => $this->testUserName,
                    'email' => $this->testUserEmail,
                    'password' => bcrypt($this->testUserPassword),
        ]);
        return $this->testUser;
    }

    /**
     * Get test user. Create if not found.
     * @return User
     */
    private function getUserTest(): User {
        $this->testUser = ModelUser::where('email', $this->testUserEmail)->first();
        if (empty($this->testUser->id)) {
            return $this->createUserTest();
        }
        return $this->testUser;
    }

    /**
     * Delete test user.
     * @return \self
     */
    private function deleteUserTest(): self {
        //Delete from DB.
        ModelUser::where('email', $this->testUserEmail)->delete();
        //Set parameter as empty user.
        $this->testUser = new ModelUser();

        return $this;
    }

}
