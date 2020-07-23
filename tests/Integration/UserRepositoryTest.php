<?php

namespace Tests\Integration;

use App\Repositories\UserRepository;
use Tests\IntegrationTestCase;

class UserRepositoryTest extends IntegrationTestCase
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * Setup the test cases
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->userRepository = app(UserRepository::class);
    }

    public function test_finding_all_users()
    {
        $users = $this->userRepository->findAll()->toArray();

        $this->assertNotEmpty($users);
    }

    public function test_finding_the_admin_users_successfully()
    {
        $users = $this->userRepository->findAdmins()->toArray();

        $this->assertNotEmpty($users);
        foreach ($users as $user) {
            $this->assertEquals(1, $user['is_admin']);
        }
    }
}
