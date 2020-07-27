<?php

namespace App\Services;


use App\Contracts\GamePlayInterface;
use App\Models\GameModel;
use Auth;
use Illuminate\Http\Request;

/**
 * Class GamePlayService
 * Handle the game rules requirements and orchestrate model interactions.
 * @package App\Services
 */
class GamePlayService implements GamePlayInterface
{
    /**
     * @var GameModel
     */
    private GameModel $gameModel;

    /**
     * GamePlayService constructor.
     */
    public function __construct()
    {
        $this->gameModel = new GameModel();
    }

    /**
     * Valid Cards according to the game rules requirements.
     */
    const CARDS = [
        1 => 1,
        2 => 2,
        3 => 3,
        4 => 4,
        5 => 5,
        6 => 6,
        7 => 7,
        8 => 8,
        9 => 9,
        10 => 10,
        'J' => 11,
        'Q' => 12,
        'K' => 13,
        'A' => 14
    ];

    /**
     * Separate each card, apply uppercase, remove unnecessary spaces and convert it to a collection
     * @param $value
     * @return \Illuminate\Support\Collection
     */
    public function sanitize($value)
    {
        $value = trim(strtoupper($value));
        $toArray = explode(" ", $value);
        return collect($toArray);
    }

    /**
     * Retrieve leaderboard data from GameModel considering the number of players to display. Also, it transforms the
     * model's returned data easing the front-end consumption.
     * @param Request $request
     * @param int $numPlayers
     * @return mixed
     */
    public function getPlayersScore(Request $request, $numPlayers = 10)
    {
        return $leaderboardData = $this->gameModel->getPlayersScore($numPlayers);
    }

    /**
     * Generate random cards considering the player's card sequence size.
     * @param $cardSequenceSize
     * @return array
     */
    public function generateRandomCards($cardSequenceSize)
    {
        $result = array();
        for ($i = 0; $i < $cardSequenceSize; $i++) {
            $result[$i] = array_rand(self::CARDS, 1);
        }
        return $result;
    }

    /**
     * Compare both Player and randomly generated cards considering the card position. Highest value card wins
     * @param $userCardSequence
     * @param $generatedSequence
     * @return array
     */
    public function checkWinner($userCardSequence, $generatedSequence)
    {
        $userScore = 0;
        $cpuScore = 0;

        $validCards = self::CARDS;
        foreach ($userCardSequence as $index => $userCard) {
            if ($validCards[$userCard[0]] > $validCards[$generatedSequence[$index]]) {
                $userScore++;
            }
            if ($validCards[$userCard[0]] <= $validCards[$generatedSequence[$index]]) {
                $cpuScore++;
            }
        }
        return ['user' => $userScore, 'cpu' => $cpuScore, 'userIsWinner' => ($userScore > $cpuScore)];
    }

    /**
     * Save the game's result score to the database using the Game Model and assign it to the current user ID.
     * @param $userId
     * @param $resultScore
     * @return string
     */
    public function saveGameResult($userId, $resultScore)
    {
        try {
            $game = new GameModel();
            $game->user_id = $userId;
            $game->user_score = $resultScore['user'];
            $game->cpu_score = $resultScore['cpu'];
            $game->has_won = $resultScore['userIsWinner'];
            $game->saveOrFail();
        } catch (\Throwable $e) {
            return $e->getMessage();
        }
    }


}
