@extends('base')

@section('content')
    <user-page :user-attributes='@json($user)'></user-page>
@endsection