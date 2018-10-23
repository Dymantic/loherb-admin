@extends('base', ['pageClasses' => 'not-contained'])

@section('content')
    <editor-page :post-id="{{ $post_id }}" :categories='@json($categories)'></editor-page>
@endsection