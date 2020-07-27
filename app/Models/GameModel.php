<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GameModel extends Model
{
    protected $table = "games";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_score',
        'cpu_score',
        'has_won',
        'user_id'
    ];

    /**
     * Get the User that played the game.
     */
    public function user()
    {
        return $this->belongsTo('App\Models\UserModel', 'user_id', 'id');
    }


    public function getPlayersScore($numPlayers)
    {
        return self::join('users', 'users.id', 'games.user_id')
            ->select(
                ['users.name'],
                ['games.id']
            )
            ->selectRaw('count("user_id") as total_games')
            ->selectRaw('SUM(IF(has_won=1, 1, 0)) AS total_wins')
            ->groupBy('users.name')
            ->orderBy('total_wins', 'desc')
            ->take($numPlayers)
            ->paginate($numPlayers);
    }
}
