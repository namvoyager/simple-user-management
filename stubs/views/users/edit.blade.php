<div>
    @if (session('error'))
        <p>{{ session('error') }}</p>
    @endif

    <form action="{{ route('users.update', ['id' => $user->id]) }}" method="POST">
        @csrf
        @method('put')
        <div>
            <label for="name">Name</label>
            <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}">
            @error('name')
                <p>{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}">
            @error('email')
                <p>{{ $message }}</p>
            @enderror
        </div>
        <div>
            <button type="submit">Save</button>
        </div>
        <div>
            <a href="{{ route('users.index') }}">Back to list</a>
        </div>
    </form>
</div>
