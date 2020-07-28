<?php

namespace Tests\Feature;

use App\Models\UserModel;
use App\Services\GamePlayService;
use Tests\TestCase;

class ApiTest extends TestCase
{
    /**
     * Test Welcome page
     *
     * @return void
     */
    public function testWelcomePage()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /**
     * Test a New game with a valid card sequence
     *
     * @return void
     */
    public function testNewGameSuccess()
    {
        $user = factory(UserModel::class)->create();

        $generator = new GamePlayService();
        $generatedHand = $generator->generateRandomCards(rand(1, 14));


        $response = $this->postJson('/api/v1/newgame',
            ['userId' => $user->id, 'userCardSequence' => implode(' ', $generatedHand)]);

        $response
            ->assertStatus(201)
            ->assertJsonStructure([
                'data' => [
                    'userCardSequence',
                    'generatedCards',
                    'gameScore'
                ]
            ]);
    }

    /**
     * Test a New game with invalid card sequence
     *
     * @return void
     */
    public function testNewGameError()
    {
        $user = factory(UserModel::class)->create();

        $generatedHand = "b c d e f";


        $response = $this->postJson('/api/v1/newgame', ['userId' => $user->id, 'userCardSequence' => $generatedHand]);

        $response
            ->assertStatus(422)
            ->assertJsonStructure([
                'message',
                'errors'
            ]);
    }

    /**
     * Test the leaderboard data retrieval
     *
     * @return void
     */
    public function testLeaderboardData()
    {
        $response = $this->get('/api/v1/leaderboard');
        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    [
                        'username',
                        'played',
                        'won'
                    ],
                ],
            ]);
    }
}
