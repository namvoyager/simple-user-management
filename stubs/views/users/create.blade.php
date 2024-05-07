<div>
    @if (session('error'))
        <p>{{ session('error') }}</p>
    @endif

    <form action="{{ route('users.store') }}" method="POST">
        @csrf
        <div>
            <label for="name">Name</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}">
            @error('name')
                <p>{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label for="email">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}">
            @error('email')
                <p>{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label for="password">Password</label>
            <input type="password" name="password" id="password">
            @error('password')
                <p>{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label for="password_confirmation">Password confirmation</label>
            <input type="password" name="password_confirmation" id="password_confirmation">
        </div>
        <div>
            <button type="submit">Save</button>
        </div>
        <div>
            <a href="{{ route('users.index') }}">Back to list</a>
        </div>
    </form>
</div>
