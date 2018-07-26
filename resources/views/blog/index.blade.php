@extends('base')

@section('content')
<blog-index :post-list='@json($posts)' :page="{{ $page }}" :total-pages="{{ $total_pages }}"></blog-index>
@endsection