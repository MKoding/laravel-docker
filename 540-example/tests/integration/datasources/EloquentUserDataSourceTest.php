<?php

namespace Tests\Integration\DataSources;

use App\DataSource\Database\EloquentUser540DataSource;
use App\Models\User540;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EloquentUserDataSourceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function findsUserByEmail()
    {
        User540::factory(User540::class)->create();
        $eloquentUserDataSource = new EloquentUser540DataSource();

        $user = $eloquentUserDataSource->findByEmail('email@email.com');

        $this->assertInstanceOf(User::class, $user);
    }

    /**
     * @test
     */
    public function noUserIsFoundForTheGivenEmailI()
    {
        $eloquentUserDataSource = new EloquentUser540DataSource();

        $this->expectException(Exception::class);

        $eloquentUserDataSource->findByEmail('email@email.com');
    }

    /**
     * @test
     */
    public function noUserIsFoundForTheGivenEmailII()
    {
        User540::factory(User540::class)->create();
        $eloquentUserDataSource = new EloquentUser540DataSource();

        try {
            $eloquentUserDataSource->findByEmail('not_known@email.com');
        } catch (Exception $exception) {
            $this->assertEquals('User not found', $exception->getMessage());
        }
    }
}
