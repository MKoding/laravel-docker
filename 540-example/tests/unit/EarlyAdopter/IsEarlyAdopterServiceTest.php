<?php

namespace Tests\Unit\Services\EarlyAdopter;

use App\DataSource\Database\EloquentUser540DataSource;
use App\Models\User540;
use App\Services\EarlyAdopter\IsEarlyAdopterService;
use PHPUnit\Framework\TestCase;
use Prophecy\Prophet;

class IsEarlyAdopterServiceTest extends TestCase
{
    /**
     * @var EloquentUser540DataSource
     */
    private $eloquentUserDataSource;

    /**
     * @var IsEarlyAdopterService
     */
    private $isEarlyAdopterService;

    /**
     * @setUp
     */
    protected function setUp(): void
    {
        parent::setUp();
        $prophet = new Prophet();
        $this->eloquentUserDataSource = $prophet->prophesize(EloquentUser540DataSource::class);

        $this->isEarlyAdopterService = new IsEarlyAdopterService($this->eloquentUserDataSource->reveal());
    }

    /**
     * @test
     */
    public function userIsNotEarlyAdopter()
    {
        $email = 'not_early_adopter@email.com';
        $user = new User540();
        $user->fill(['id' => 9999, 'email' => $email]);

        $this->eloquentUserDataSource->findByEmail($email)->shouldBeCalledOnce()->willReturn($user);

        $isUserEarlyAdopter = $this->isEarlyAdopterService->execute($email);

        $this->assertFalse($isUserEarlyAdopter);
    }

    /**
     * @test
     */
    public function userIsAnEarlyAdopter()
    {
        $email = 'not_early_adopter@email.com';
        $user = new User540();
        $user->fill(['id' => 1, 'email' => $email]);

        $this->eloquentUserDataSource->findByEmail($email)->shouldBeCalledOnce()->willReturn($user);

        $isUserEarlyAdopter = $this->isEarlyAdopterService->execute($email);

        $this->assertTrue($isUserEarlyAdopter);
    }
}
