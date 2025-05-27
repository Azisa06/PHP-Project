@extends('layout')
@section('principal')
  <h1>Bem vindo administrador! {{Auth::user()->name}} </h1>
@endsection