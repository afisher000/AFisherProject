@php
    $name_to_label = ['WO'=> "Winner Offense", 'WD'=>"Winner Defense", 'LO'=>'Loser Offense', 'LD'=>'Loser Defense'];
@endphp

<x-foosball_layout>
    <form method="POST" action="/foosball/games/{{$game->id}}">
        @method('PUT')
        @csrf
        <h2> Update Game </h2>

        <div class="row">
            @foreach ($name_to_label as $name => $label)
                <div class="col">
                    <label for={{$name}}> {{$label}}</label>
                    <select class="form-control" name={{$name}}>
                        @foreach ($players as $player)
                            @if ($player == $game->$name)
                                <option value="{{$player}}" selected>{{$player}}</option>   
                            @else
                                <option value="{{$player}}">{{$player}}</option>   
                            @endif
                        @endforeach
                    </select>
                </div>
            @endforeach
        </div>

        <div class="row">
            <div class='col'>
                <label for="color"> Color</label>
                <select class="form-control" name="color" value="{{$game->color}}">
                    @foreach ($colors as $color):
                    <option value="{{$color}}">{{$color}}</option>
                    @endforeach
                </select>
            </div>
            <div class='col'>
                <label for="score"> Score</label>
                <input class="form-control" type="number" name="score" value="{{$game->score}}"/>
            </div>
        </div>
        <div>
            <button class = "btn btn-primary mb-3">Update Game</button>
        </div>
    </form>
</x-foosball_layout>