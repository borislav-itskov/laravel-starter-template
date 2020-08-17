<?php

namespace Tests\Integration;

use App\Repositories\RoleRepository;
use Tests\IntegrationTestCase;

class RoleRepositoryTest extends IntegrationTestCase
{
    /**
     * @var App\Repositories\RoleRepository
     */
    private $roleRepository;

    /**
     * Setup the test cases
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->roleRepository = app(RoleRepository::class);
    }

    public function test_finding_the_admin_role()
    {
        $roleAdmin = $this->roleRepository->findAdminRole();
        $this->assertNotEmpty($roleAdmin);
        $this->assertEquals('Admin', $roleAdmin->name);
    }
}
