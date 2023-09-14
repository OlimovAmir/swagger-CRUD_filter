<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <title>swagger-filter</title>
</head>
<body>
    <header> @yield('contentHeader1')
        <nav class="navbar navbar-dark bg-dark">
            <div class="container-fluid">
              <a class="navbar-brand">Панель навигации</a>
              <form class="d-flex">
                <input class="form-control me-2" type="search" placeholder="Поиск" aria-label="Поиск">
                <button class="btn btn-outline-success" type="submit">Поиск</button>
              </form>
            </div>
          </nav>
    </header>
    <aside></aside>
    <main></main>
    <footer></footer>

    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
</body>
</html>