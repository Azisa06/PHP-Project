@extends('layout')
@section('principal')
  <h1>Bem vindo técnico! {{Auth::user()->name}} </h1>
@endsection