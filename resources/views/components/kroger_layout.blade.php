<html lang="en">
<x-header>
  <title> Kroger Project </title>
</x-header>
<body>


  <x-navbar>
    <x-slot:title>
      Kroger Pages
    </x-slot:title>

    <li><a class="dropdown-item" href="/kroger/home">Home</a>
    <li><a class="dropdown-item" href="/kroger/products">Prices</a></li>
    <li><a class="dropdown-item" href="/kroger/search">Add Products</a></li>
  </x-navbar>


    {{$slot}}

    <x-flash_message />
</body>
</html>