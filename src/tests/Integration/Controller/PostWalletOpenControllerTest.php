<?php

namespace Tests\Integration\Controller;

use App\Models\Coin;
use App\Models\User;
use App\Models\Wallet;
use App\Models\WalletCoin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class PostWalletOpenControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @setUp
     */
    protected function setUp(): void
    {
        parent::setUp();
        User::factory(User::class)->create();
        Wallet::factory(Wallet::class)->create();
        Coin::factory(Coin::class)->create();
        WalletCoin::factory(WalletCoin::class)->create();
    }

    /**
     * @test
     */
    public function postWalletOpenUserNotFound()
    {
        $response = $this->postJson('/api/wallet/open', ['user_id' => 'error-user']);

        $response->assertStatus(Response::HTTP_NOT_FOUND)->assertExactJson([
            'status' => 'User with the specified ID was not found',
            'message' => 'User not found'
        ]);
    }

    /**
     * @test
     */
    public function postWalletOpenInsufficientArguments()
    {
        $response = $this->postJson('/api/wallet/open', []);

        $response->assertStatus(Response::HTTP_BAD_REQUEST)->assertExactJson([
            'status' => 'Bad Request Error',
            'message' => 'Insufficient arguments in the POST'
        ]);
    }

    /**
     * @test
     */
    public function postWalletOpen()
    {
        $response = $this->postJson('/api/wallet/open', ['user_id' => 'factory-user']);

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                "wallet_id"
            ]);
    }
}
