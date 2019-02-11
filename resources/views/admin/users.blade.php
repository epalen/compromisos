@extends('backend', ['title' => 'Usuarios | Tablero de control público de seguimiento del PA15.'])

@section('content')
@include('backend_nav')

<div class="container">
	<div class="bs-docs-featurette bs-titles-pg">
		<h1 class="bs-docs-featurette-title">Usuarios <small><a href="{{ url('user/create') }}" class="btn btn-primary">Agregar usuario</a></small></h1>
		<p class="lead">Los responsables del cumplimiento de los compromisos son: funcionarios públicos y miembros de organizaciones de la sociedad civil (OSC)</p>
    
    @if ($message = Session::get('success'))
      <div class="alert alert-success alert-dismissible" role="alert" style="margin-bottom: 0!important;">
        <p>{{ $message }}</p>
      </div>
    @endif
  </div>
  
	<div class="row">
		<div class="col-lg-12">
<!-- users table -->
  <table class="table table-hover">
    <thead>
      <tr>
        <th>Nombre</th>
        <th>User/email</th>
        <th>Teléfono</th>
        <th>Cargo</th>
        <th>Tipo de usuario</th>
        <th>*</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($users as $user)
      <tr>
        <td>{{ $user->name }}</td>
        <td>{{ $user->email }}</td>
        <td>{{ $user->phone }}</td>
        <td>{{ $user->charge }}</td>
        <td>
          {{ $user->user_type == 'government' ? 'Funcionario público':'OSC' }} 
          {{ $user->is_admin ? '/ Administrador':'' }}
        </td>
        <td>
          @if($user->id != Auth::user()->id)
            {{Form::open(['url' => 'user/' . $user->id, 'method' => 'DELETE'])}}

              <div align="center">
                <div class="btn-group">
                  <!--<button type="button" class="btn btn-xs btn-success">
                    {{link_to('user/' . $user->id . '/edit', 'Editar')}}
                  </button>-->     
                  <a class="btn btn-xs btn-success" href="{{ route('usuarios.editar', $user->id) }}" value="Editar">Editar</a>         
                </div>

                <div class="btn-group">
                  <button type="submit" class="btn btn-xs btn-danger" value="Eliminar">Eliminar</button>
                </div>
              </div>

            {{Form::close()}}
          @endif
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
		</div>
	</div>
</div>
@stop