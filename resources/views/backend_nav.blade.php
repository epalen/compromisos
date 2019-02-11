<div class="navbar navbar-default navbar-static-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <ul class="nav navbar-nav">
            <li>
              <a href="{{ url('dashboard')}}">Tablero de control público de seguimiento del PA15</a>
            </li>
          </ul>
          
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
          <li {{ Request::is( 'dashboard') ? 'class="active"' : '' }}><a href="{{ url('dashboard')}}">Tablero de Seguimiento</a></li>
            <li {{ Request::is( 'commitment') ? 'class="active"' : '' }}><a href="{{ url('commitment') }}">Compromisos</a></li>
            <li {{ Request::is( 'user') ? 'class="active"' : '' }}>
            @if(Auth::user()->is_admin)
              <a href="{{ url('user') }}">Usuarios</a> 
            @else
              <a href="{{ url('user/' . Auth::user()->id . '/edit') }}">Mi perfil</a> 
            @endif
            </li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li></li>
            <li ><a>Hola! {{Auth::user()->name}}</a></li>
            <li class="active">
              <a class="dropdown-item" href="{{ route('logout') }}"
                onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">
                {{ __('Salir') }}
              </a>

              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                  @csrf
              </form>
            </li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
</div>
<div id="alianza"></div>

<!-- Sweet Alert -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.0/sweetalert.min.js"></script>

@include('sweet::alert')