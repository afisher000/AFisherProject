<style>
    .filter-item {
        padding: 2px;
        height:30px;
    }
</style>

<x-foosball_layout>

    <div class="container card p-4 custom-card-container">
        <div class="container" style="padding:20px;">
            <h1>Foosball Games</h1>
        </div>

        <div class="container" style="display:flex;">
            @livewire('foosball.index-games')
        </div>
            
    </div>

</x-foosball_layout>