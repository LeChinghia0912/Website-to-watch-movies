<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="{{route('home')}}">Dashboard</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
    <li class="nav-item">
        <a class="nav-link" href="{{route('category.create')}}">Danh mục phim</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{route('genre.create')}}">Thể loại </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{route('country.create')}}">Quốc gia</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{route('movie.create')}}">Phim</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{route('episode.create')}}">Tập phim</a>
      </li>
      <!-- <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-expanded="false">
          Dropdown
        </a>
        <div class="dropdown-menu">
          <a class="dropdown-item" href="#">Action</a>
          <a class="dropdown-item" href="#">Another action</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">Something else here</a>
        </div>
      </li> -->
      <!-- <li class="nav-item">
        <a class="nav-link disabled">Disabled</a>
      </li> -->
    </ul>
    <form class="form-inline my-2 my-lg-0 ml-auto">
      <div class="input-group">
        <input class="form-control" type="search" placeholder="Tìm kiếm phim..." aria-label="Search">
        <div class="input-group-append mx-2">
          <button class="btn btn-outline-success" type="submit">Tìm kiếm phim</button>
        </div>
      </div>
    </form>
  </div>
</nav>