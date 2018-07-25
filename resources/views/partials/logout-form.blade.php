<form action="/logout" method="POST" class="my-3">
    {!! csrf_field() !!}
    <button type="submit" class="text-grey-darker hover:text-green">Logout</button>
</form>