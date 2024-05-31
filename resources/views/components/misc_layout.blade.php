<html lang="en">
<x-header>
  <title>Misc Projects</title>
</x-header>
<body>
  @livewireScripts

  <x-navbar>
    <x-slot:title>
      Misc
    </x-slot:title>

    <li><a class="dropdown-item" href="/misc/home">Home</a>


  </x-navbar>


    {{$slot}}

    <x-flash_message />

</body>
</html>