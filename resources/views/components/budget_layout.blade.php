<html lang="en">
<x-header>
  <title>Budget Project</title>
</x-header>
<body>
  @livewireScripts

  <x-navbar>
    <x-slot:title>
      Budget
    </x-slot:title>

    <li><a class="dropdown-item" href="/budget/home">Home</a>


  </x-navbar>


    {{$slot}}

    <x-flash_message />

</body>
</html>