<div>
    <div style="display:flex;">
        <div style="flex-direction:column; padding:5px">
            <div class="filter-item"> 
                {{-- Winner1 --}}
                <label for="W1">W1:</label>
                <select wire:model="W1" wire:change="refresh" name="W1" id="W1">
                    <option value="">All</option>
                    @foreach ($players as $player)
                        <option value={{$player['id']}} >{{$player['alias']}}</option>
                    @endforeach
                </select>
            </div>

            <div class="filter-item"> 
                {{-- Winner2 --}}
                <label for="W2">W2:</label>
                <select wire:model="W2" wire:change="refresh" name="W2" id="W2">
                    <option value="">All</option>
                    @foreach ($players as $player)
                    <option value={{$player['id']}} > {{$player['alias']}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div style="flex-direction:column; padding:5px">
            <div class="filter-item"> 
                {{-- Loser1 --}}
                <label for="L1">L1:</label>
                <select wire:model="L1" wire:change="refresh" name="L1" id="L1">
                    <option value="">All</option>
                    @foreach ($players as $player)
                        <option value={{$player['id']}} > {{$player['alias']}}</option>
                    @endforeach
                </select>
            </div>

            <div class="filter-item"> 
                {{-- Loser2 --}}
                <label for="L2">L2:</label>
                <select wire:model="L2" wire:change="refresh" name="L2" id="L2">
                    <option value="">All</option>
                    @foreach ($players as $player)
                    <option value={{$player['id']}}> {{$player['alias']}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div style="flex-direction:column; padding:5px">
            <div class="filter-item"> 
                {{-- Min Score --}}
                <label for="min_score">Min Score:</label>
                <select wire:model="min_score" wire:change="refresh" name="min_score" id="min_score">
                    <option value="">All</option>
                    @foreach ([0,1,2,3,4,5,6,7,8,9] as $number)
                        <option value={{$number}} > {{$number}}</option>
                    @endforeach
                </select>
            </div>

            <div class="filter-item"> 
                {{-- Min Score --}}
                <label for="max_score">Max Score:</label>
                <select wire:model="max_score" wire:change="refresh" name="max_score" id="max_score">
                    <option value="">All</option>
                    @foreach ([0,1,2,3,4,5,6,7,8,9] as $number)
                        <option value={{$number}} > {{$number}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        {{-- Dates --}}
        <div style="flex-direction:column; padding:5px">
            <div class="filter-item"> 
                <label for="start_date">Start Date:</label>
                <input wire:model="start_date" wire:change="refresh" type="date" name="start_date" id="start_date">
            </div>
            <div class="filter-item"> 
                <label for="end_date">End Date:</label>
                <input wire:model="end_date" wire:change="refresh" type="date" name="end_date" id="end_date">
            </div>
        </div>
    </div>

    @foreach($games as $game)
    <p>
        @php
            if ($game['rating_change']>=0) {
                $rating_change = 'Winners gain '.number_format($game['rating_change'], 1);
            } else {
                $rating_change = 'Losers gain '.number_format(-1*$game['rating_change'], 1);
            }
        @endphp
        <a class="btn btn-danger">Game {{$game['id']}}</a> 
        {{$game['WO']}} and {{$game['WD']}} beat {{$game['LO']}} and {{$game['LD']}} 10-{{$game['score']}} with {{ $game['score'] === 'r' ? 'Red' :  'Blue'}} on {{$game['date']}}, ({{$rating_change}}).
    </p>
    @endforeach

    <div class="container", style="padding:20px;">
        <div>
            {{ $games->links()}}
        </div>
    </div>  
</div>
