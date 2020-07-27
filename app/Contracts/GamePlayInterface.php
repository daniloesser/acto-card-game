<?php

namespace App\Contracts;

use Illuminate\Http\Request;

interface GamePlayInterface
{

    public function sanitize(string $value);

    public function getPlayersScore(Request $request, int $numPlayers);

    public function generateRandomCards(int $cardSequenceSize);

    public function checkWinner(array $userCardSequence, array $generatedSequence);

    public function saveGameResult(int $userId, array $resultScore);

}
