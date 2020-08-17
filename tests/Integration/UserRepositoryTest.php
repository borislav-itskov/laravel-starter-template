<?php

namespace Tests\Integration;

use App\Repositories\RoleRepository;
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
        $roleRepo = app(RoleRepository::class);
        $adminRole = $roleRepo->findAdminRole();
        $users = $this->userRepository->findByRole($adminRole);
        $this->assertNotEmpty($users);

        // load the roles
        foreach ($users as $user) {
            $this->assertTrue($user->roles()->get()->contains($adminRole->id));
        }
    }
}
