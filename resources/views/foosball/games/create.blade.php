@php
  $name_to_label = ['WO'=> "Winner Offense", 'WD'=>"Winner Defense", 'LO'=>'Loser Offense', 'LD'=>'Loser Defense'];
@endphp

<x-foosball_layout>
    <form method="POST" action="/foosball/games/upload">
        @csrf
        <!-- Loop over player entries -->
        <div class="row">
            @foreach ($name_to_label as $name => $label)
                <div class="col">
                    <label for={{$name}}> {{$label}}</label>
                    <select class="form-control" name={{$name}}>
                        @foreach ($players as $player)
                            @if ($player == old($name))
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
              <select class="form-control" name="color" value="{{old('color')}}">
                  @foreach ($colors as $color):
                    @if ($color == old('color'))
                      <option value="{{$color}}" selected>{{$color}}</option>
                    @else
                      <option value="{{$color}}">{{$color}}</option>
                    @endif
                  @endforeach
              </select>
          </div>
          <div class='col'>
              <label for="score"> Score</label>
              <input class="form-control" type="number" name="score" value="{{old('score')}}"/>
          </div>
      </div>
      <div>
          <button class = "btn btn-primary mb-3">Create Game</button>
      </div>
    </form>
</x-foosball_layout>