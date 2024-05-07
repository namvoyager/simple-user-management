<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Http\Request;
use VoyagerInc\SimpleUserManagement\Contracts\UserRepository;

class UserController extends Controller
{
    public function __construct(
        protected UserRepository $users,
    ) {
    }

    public function index(Request $request)
    {
        return view('users.index', [
            'users' => $this->users->getWithPagination($request->query()),
        ]);
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(CreateUserRequest $request)
    {
        $user = $this->users->create($request->validated());

        if (is_null($user)) {
            return back()->with('error', __('Create failure'));
        }

        return to_route('users.index');
    }

    public function show(string $id)
    {
        $user = $this->users->find($id);

        abort_if(is_null($user), 404);

        return view('users.show', compact('user'));
    }

    public function edit(string $id)
    {
        $user = $this->users->find($id);

        abort_if(is_null($user), 404);

        return view('users.edit', compact('user'));
    }

    public function update(UpdateUserRequest $request, string $id)
    {
        $user = $this->users->update($request->validated(), $id);

        if (is_null($user)) {
            return back()->with('error', __('Update failure'));
        }

        return to_route('users.index');
    }

    public function destroy(string $id)
    {
        $result = $this->users->delete($id);

        if (! $result) {
            return back()->with('error', __('Delete failure'));
        }

        return to_route('users.index');
    }
}
