<?php

namespace App\Transformers;

use App\Models\GameModel;
use League\Fractal\TransformerAbstract;

/**
 * Class LeaderboardTransformer
 * @package App\Transformers
 */
class LeaderboardTransformer extends TransformerAbstract
{
    /**
     * Transform method
     *
     * @param GameModel $gameModel
     * @return array
     */
    public function transform(GameModel $gameModel)
    {
        return [
            'username' => $gameModel->name,
            'played' => $gameModel->total_games,
            'won' => $gameModel->total_wins,
        ];
    }
}
