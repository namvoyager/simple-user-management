<div>
    <form action="" method="GET">
        <input type="search" name="keyword" placeholder="Search by name or email" value="{{ request()->query('keyword') }}">
        <button type="submit">Search</button>
    </form>
    <div>
        <a href="{{ route('users.create') }}">Create a new user</a>
    </div>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <a href="{{ route('users.show', ['id' => $user->id]) }}">Detail</a>
                        <a href="{{ route('users.edit', ['id' => $user->id]) }}">Edit</a>
                        <form action="{{ route('users.destroy', ['id' => $user->id]) }}" method="POST">
                            @method('delete')
                            @csrf
                            <button type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">No data found</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $users->links() }}
</div>
