<html lang="en">
<x-header>
  <title>ML Blog</title>
</x-header>
<body>
  @livewireScripts

  <x-navbar>
    <x-slot:title>
      Blog Pages
    </x-slot:title>

    <li><a class="dropdown-item" href="/machine-learning/posts/feature_engineering">Feature Engineering</a>
      <li><a class="dropdown-item" href="/machine-learning/posts/validation">Validation</a>

  </x-navbar>


    {{$slot}}

    <x-flash_message />

</body>
</html>