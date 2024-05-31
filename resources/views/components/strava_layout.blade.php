<html lang="en">
<x-header>
  <title>Strava Project</title>
</x-header>
<body>
  @livewireScripts

  <x-navbar>
    <x-slot:title>
      Strava Pages
    </x-slot:title>

    <li><a class="dropdown-item" href="/strava/home">Home</a>
    <li><a class="dropdown-item" href="/strava/oauth">Sync</a>
    <li><a class="dropdown-item" href="/strava/activities">Activities</a></li>
    <li><a class="dropdown-item" href="/strava/analysis">Analysis</a></li>

  </x-navbar>


    {{$slot}}

    <x-flash_message />

</body>
</html>