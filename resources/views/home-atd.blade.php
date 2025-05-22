@extends('layout')
@section('principal')
  <h1>Bem vindo atendente! {{Auth::user()->name}} </h1>
@endsection