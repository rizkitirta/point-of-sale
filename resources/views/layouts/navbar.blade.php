<nav class="main-header navbar navbar-expand navbar-purple navbar-dark">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="index3.html" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li>
    </ul>

    <!-- SEARCH FORM -->
    <form class="form-inline ml-3">
      <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-navbar" type="submit">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </form>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
            <img src="{{ asset('AdminLTE/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2"
            alt="User Image" width="40px" style="position: relative; margin-top: -7px">
            <b>{{ Auth::user()->name }}</b>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right bg-purple">
            <img src="{{ asset('AdminLTE/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2 mt-3 mb-2 d-block"
            alt="User Image" width="100px" style="margin-left: 90px">
            <h5 class="text-bold text-center">{{ Auth::user()->name }}</h5>
            <p class="text-center mb-2" style="margin-top: -10px">{{ Auth::user()->email }}</p>
          <div class="dropdown-divider"></div>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-user mr-2"></i>Profile
          </a>
          <a href="#" class="dropdown-item" onclick="$('#logout').submit()">
            <i class="fas fa-sign-out-alt"></i>
            Logout
          </a>
          <form action="{{ route('logout') }}" method="POST" id="logout" style="display: none">@csrf</form>
          <div class="dropdown-divider"></div>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">&copy;2021</a>
        </div>
      </li>
    </ul>
  </nav>
