<?php

namespace VoyagerInc\SimpleUserManagement\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use VoyagerInc\SimpleUserManagement\Contracts\UserRepository as UserRepositoryContract;

class UserRepository implements UserRepositoryContract
{
    public function getModelName(): string
    {
        return config('simple-user-management.model', 'App\Models\User');
    }

    public function model(array $attributes = []): Model
    {
        return app($this->getModelName(), ['attributes' => $attributes]);
    }

    /**
     * Get a list of the user with pagination.
     */
    public function getWithPagination(array $filters = [], array $columns = ['*'])
    {
        $page = Arr::get($filters, 'page', 1);
        $perPage = Arr::get($filters, 'per_page', 10);
        $query = $this->model()->query();
        $keyword = Arr::get($filters, 'keyword');
        $sortField = Arr::get($filters, 'sort_field');
        $sortDirection = Arr::get($filters, 'sort_direction', 'asc');

        if (! empty($keyword)) {
            $query->where('email', 'like', "%{$keyword}%")
                ->orWhere('name', 'like', "%{$keyword}%");
        }

        if (! empty($sortField)) {
            $query->orderBy($sortField, $sortDirection);
        }

        return $query->paginate($perPage, $columns, 'page', $page)->withQueryString();
    }

    /**
     * Get a specified user.
     */
    public function find($id, array $columns = ['*']): ?Model
    {
        return $this->model()->find($id, $columns);
    }

    /**
     * Handle create a new user.
     */
    public function create(array $data)
    {
        DB::beginTransaction();

        try {
            $user = $this->model($data);
            $user->save();

            DB::commit();

            return $user->refresh();
        } catch (\Throwable $e) {
            DB::rollBack();

            logger()->error($e->getMessage());

            return null;
        }
    }

    /**
     * Handle update a specified user.
     */
    public function update(array $data, $id)
    {
        DB::beginTransaction();

        try {
            $user = $this->resolveModel($id);

            if (is_null($user)) {
                throw new ModelNotFoundException('Cannot find the user with $id provided');
            }

            $user->fill($data);
            $user->save();

            DB::commit();

            return $user->refresh();
        } catch (\Throwable $e) {
            DB::rollBack();

            logger()->error($e->getMessage());

            return null;
        }
    }

    /**
     * Handle delete a specified user.
     */
    public function delete($id)
    {
        DB::beginTransaction();

        try {
            $user = $this->resolveModel($id);

            if (is_null($user)) {
                throw new ModelNotFoundException('Cannot find the user with $id provided');
            }

            $result = $user->delete();

            DB::commit();

            return $result;
        } catch (\Throwable $e) {
            DB::rollBack();

            logger()->error($e->getMessage());

            return null;
        }
    }

    /**
     * Check and resolve the model.
     */
    protected function resolveModel($model): ?Model
    {
        $modelName = $this->getModelName();

        if ($model instanceof $modelName || is_null($model)) {
            return $model;
        }

        return $this->model()->find($model);
    }
}
