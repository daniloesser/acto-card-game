<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Rules\ValidCardSequence;
use App\Services\GamePlayService;
use App\Transformers\LeaderboardTransformer;
use App\Transformers\NoDataArraySerializer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use League\Fractal\Manager;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;

/**
 * Class GamePlayController
 * @package App\Http\Controllers
 */
class GamePlayController extends Controller
{
    /**
     * Holds GamePlayService Instance
     * @var GamePlayService
     */
    protected GamePlayService $gamePlayService;

    /**
     * Holds Fractal Manager Instance
     * @var Manager
     */
    protected Manager $fractalManager;

    /**
     * GamePlayController constructor.
     * @param GamePlayService $gamePlayService
     */
    public function __construct(GamePlayService $gamePlayService)
    {
        $this->gamePlayService = $gamePlayService;
        $this->fractalManager = new Manager();
    }

    /**
     * Retrieve the leaderboard data.
     * By default, the top 10 players will be returned.
     */
    public function getLeaderboard(Request $request)
    {
        $paginator = $this->gamePlayService->getPlayersScore($request, 10);
        $leaderboardData = $paginator->getCollection();

        $formatted = new Collection($leaderboardData, new LeaderboardTransformer());
        $formatted->setPaginator(new IlluminatePaginatorAdapter($paginator));

        // Use fractal to create a transformation layer for data output, allowing pagination
        // and easing the subtle complexities of outputting data in a non-trivial API
        return response(
            collect($this->fractalManager->setSerializer(
                new NoDataArraySerializer())->createData($formatted)->toArray()),
            Response::HTTP_OK);
    }

    /**
     * Handle a new game, validate the user input and return the score data.
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function newGame(Request $request)
    {
        // Validate the cards sequence using a Custom Rule Validator.
        $request->validate([
            'userCardSequence' => [new ValidCardSequence()],
            'userId' => "integer|required"
        ]);

        // Separate each card, apply uppercase and convert to collection
        $userCardSequence = $this->gamePlayService->sanitize($request->userCardSequence);

        // Generate random cards considering the player's card sequence size.
        $generatedSequence = $this->gamePlayService->generateRandomCards(count($userCardSequence));

        // Compare both Player and randomly generated cards to check if the player has won
        $resultScore = $this->gamePlayService->checkWinner($userCardSequence, $generatedSequence);

        // Store the game result in the database
        $this->gamePlayService->saveGameResult($request->userId, $resultScore);

        //converts the current data Array to Collection and return it to the service
        return response()->json(
            [
                'data' => [
                    'userCardSequence' => $userCardSequence,
                    'generatedCards' => $generatedSequence,
                    'gameScore' => $resultScore
                ]
            ],
            Response::HTTP_CREATED
        );
    }

}
