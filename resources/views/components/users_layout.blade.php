<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="icon" href="images/favicon.ico" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
          integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
          crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
        <script src="//unpkg.com/alpinejs" defer></script>
        <script>
          tailwind.config = {
              theme: {
                extend: {
                  colors: {
                    laravel: '#ef3b2d',
                  },
                },
              },
            }
        </script>
        <title>AFisher Project</title>
      </head>
<body>

    <x-navbar>
        <li class="nav-item">
            <a class="nav-link active" href="/about">About Me</a>
          </li>
          @auth
          <li class="nav-item">
            <form class='inline nav-link' method='POST' action='users/logout'>
              @csrf
              <button class='nav-link'>Logout</button>
            </form>
          </li>
          @else
          <li class="nav-item">
            <a class="nav-link" href="/users/register">Register</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/users/login">Login</a>
          </li>
          @endauth
    </x-navbar>

    {{$slot}}

    <x-flash_message />
</body>
</html>