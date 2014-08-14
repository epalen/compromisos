@extends('backend')

@section('content')
@include('backend_nav')

<div class="container">
<h1>Usuarios <small>{{link_to('user/create', 'agregar usuario')}}</small></h1>

<!-- users table -->
  <table class="table">
    <thead>
      <tr>
        <th>user/email</th>
        <th>nombre</th>
        <th>teléfono</th>
        <th>cargo</th>
        <th>es de gobierno</th>
        <th>es administrador</th>
        <th>*</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($users as $user)
      <tr>
        <td>{{$user->username}}</td>
        <td>{{$user->name}}</td>
        <td>{{$user->phone}}</td>
        <td>{{$user->charge}}</td>
        <td>{{$user->user_type == 'government' ? 'Sí':'No'}}</td>
        <td>{{$user->is_admin ? 'Sí':'No'}}</td>
        <td>
          <!-- update link -->
          {{link_to('user/' . $user->id . '/edit', 'editar')}}

          <!-- delete form -->
          @if($user->id != Auth::user()->id)
            {{Form::open([
              'url' => 'user/' . $user->id, 
              'method' => 'DELETE'
            ])}}

            <input type="submit" value="eliminar">

            {{Form::close()}}
          @endif
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>
@stop