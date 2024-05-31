<x-foosball_layout> 
    @foreach($games as $game)
        <p>{{$game['WO']}} and {{$game['WD']}} beat {{$game['LO']}} and {{$game['LD']}}</p>
    @endforeach
</x-foosball_layout>