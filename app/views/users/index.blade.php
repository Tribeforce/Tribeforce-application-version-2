@extends('layouts.offcanvas')

@section('sidebar')
  Navigation bar
@endsection

@section('main')
<div id="user-index">
  <table>
    <thead>
      <th></th>
      <th>{{trans('forms.id')}}</th>
      <th>{{trans('forms.first_name')}}</th>
      <th>{{trans('forms.last_name')}}</th>
      <th>{{trans('forms.email')}}</th>
      <th>{{trans('forms.activated')}}</th>
      <th>{{trans('forms.last_login')}}</th>
    </thead>
    <tbody>
    @foreach($d as $user)
    <tr class="user-{{$user->id}}">
      <td class="edit">
        <?php // TODO: use link_to_route.  Seems buggy at this moment ?>
        {{ link_to(route('users.edit', array('users' => $user->id)), trans('forms.edit')) }}
      </td>
      <td class="id">{{$user->id}}</td>
      <td class="first-name">{{$user->first_name}}</td>
      <td class="last-name">{{$user->last_name}}</td>
      <td class="email">{{$user->email}}</td>
      <td class="activated">{{$user->activated ? trans('forms.activated_on') : trans('forms.activated_off')}}</td>
      <td class="last-login">{{$user->last_login}}</td>
    </div>
    @endforeach
    </tbody>
  </table>
</div>
@endsection
