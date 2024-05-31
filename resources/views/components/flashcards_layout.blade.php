<html lang="en">
  <x-header>
    <title>Memory Projects</title>
  </x-header>
<body>

  <x-navbar>
    <x-slot:title>
        Flashcards
    </x-slot:title>

    <li><a class="dropdown-item" href="/flashcards/home">Home</a>
    <li><a class="dropdown-item" href="/flashcards/practice">Practice</a></li>
    <li><a class="dropdown-item" href="/flashcards/upload">Upload</a></li>

  </x-navbar>

    {{$slot}}

    <x-flash_message>
    </x-flash_message>
</body>
</html>