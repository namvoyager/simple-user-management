<div>
    <p>Name: {{ $user->name }}</p>
    <p>Email: {{ $user->email }}</p>
    <p>Created at: {{ $user->created_at }}</p>
    <p>Updated at: {{ $user->updated_at }}</p>
    <div>
        <a href="{{ route('users.index') }}">Back to list</a>
    </div>
</div>
