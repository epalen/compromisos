<div class="navbar navbar-default navbar-static-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Tablero de control público de seguimiento del PA15 </a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li {{ Request::is( 'admin') ? 'class="active"' : '' }}>{{link_to('admin', 'admin')}}</li>
            <li {{ Request::is( 'commitment') ? 'class="active"' : '' }}>{{link_to('commitment', 'compromisos')}}</li>
            <li {{ Request::is( 'user') ? 'class="active"' : '' }}>{{link_to('user', 'usuarios')}}</li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li></li>
            <li ><a>Hola Arturo</a></li>
            <li class="active">{{link_to('logout', 'salir')}}</li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
</div>