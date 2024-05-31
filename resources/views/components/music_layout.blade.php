<html lang="en">
  <x-header>
    <title>Music Project</title>
  </x-header>
<body>

  <x-navbar>
    <x-slot:title>
        Music Pages
    </x-slot:title>

    <li><a class="dropdown-item" href="/music/home">Home</a>
    <li><a class="dropdown-item" href="/music/tracks">Queue</a></li>
    <li><a class="dropdown-item" href="/music/search">Search</a>
    <li><a class="dropdown-item" href="/music/tracks/create">Submit</a></li>

  </x-navbar>

    {{$slot}}

    <x-flash_message>
    </x-flash_message>
</body>
</html>