<html lang="en">
  <x-header>
    <title>Foosball Project</title>
  </x-header>
<body>

  @livewireScripts

  <x-navbar>
    <x-slot:title>
      Foosball Pages
    </x-slot:title>

    <li><a class="dropdown-item" href="/foosball/home">Home</a></li>
    <li><a class="dropdown-item" href="/foosball/games">Games</a></li>
    {{-- <li><a class="dropdown-item" href="/foosball/games/create">Create Game</a></li> --}}
    <li><a class="dropdown-item" href="/foosball/players">Players</a></li>
    <li><a class="dropdown-item" href="/foosball/ratings">Ratings</a></li>
    {{-- <li><a class="dropdown-item" href="/foosball/players/create">Add Player</a></li> --}}
  </x-navbar>

    {{$slot}}

    <x-flash_message>
    </x-flash_message>
</body>
</html>
