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
}
