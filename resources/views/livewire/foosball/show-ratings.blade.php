<div>
    <div class="container">

        <label>SortBy:</label>
        <select wire:model="selection" wire:change="refresh">
            <option value="average">Average</option>
            <option value="offense">Offense</option>
            <option value="defense">Defense</option>
        </select>
    </div>

    <table style="width:100%;">
        <tbody>
            <tr>
                <th>Player</th>
                <th class="center-text" style="text-align:right;">Average</th>
                <th class="center-text" style="text-align:right;">Offense</th>
                <th class="center-text" style="text-align:right;">Defense</th>
            </tr>

            @foreach ($ratings as $rating)
                <tr>
                    <td>{{$rating->player}}</td>
                    <td class="center-text" style="text-align:right;">{{number_format($rating->average, 0)}}</td>
                    <td class="center-text" style="text-align:right;">{{number_format($rating->offense, 0)}}</td>
                    <td class="center-text" style="text-align:right;">{{number_format($rating->defense, 0)}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
