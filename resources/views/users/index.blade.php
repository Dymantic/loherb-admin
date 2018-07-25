@extends('base')

@section('content')
    <users-index :users-list='@json($users)'></users-index>
@endsection