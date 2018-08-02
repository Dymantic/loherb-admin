@extends('base', ['pageClasses' => 'not-contained'])

@section('content')
    <editor-page :post-id="{{ $post_id }}"></editor-page>
@endsection