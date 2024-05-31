<html lang="en">
<x-header>
  <title>aFisherProject</title>
</x-header>
<body>
  <x-navbar>
    <x-slot:title>
        Home
    </x-slot:title>

    <!-- Login/Register or Logout based on login status -->
    @auth
      <li><a class="dropdown-item" href="/users/confirmlogout">Logout</a></li>
    @else
      <li><a class="dropdown-item" href="/users/login">Login/Register</a></li> 
    @endauth
    <li><a class="dropdown-item" href="/about-the-website">About the Website</a></li> 
  </x-navbar>


    {{$slot}}

</div>
<x-flash_message />
</body>
</html>