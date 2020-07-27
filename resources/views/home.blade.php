@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <game-component user_id="{{auth()->user()->id}}"></game-component>
            </div>
            <div class="col-md-8">
                <leaderboard-component></leaderboard-component>
            </div>
        </div>
    </div>
@endsection
