<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AdminUserController extends Controller
{
    public function index()
    {
        return view('admin.crud.index', [
            'title' => 'Admin Users',
            'routeBase' => '/admin/admin-users',
            'records' => User::with(['roles', 'permissions'])->where('is_admin', true)->latest()->paginate(10),
            'columns' => [
                'id' => 'ID',
                'name' => 'Name',
                'email' => 'Email',
                'roles_list' => 'Roles',
                'permissions_list' => 'Direct Permissions',
                'created_at' => 'Created',
            ],
        ]);
    }

    public function create()
    {
        return $this->form(new User(['is_admin' => true]), 'Create Admin User');
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $roles = $data['roles'] ?? [];
        $permissions = $data['permissions'] ?? [];
        unset($data['roles'], $data['permissions']);

        $data['password'] = Hash::make($data['password']);
        $data['is_admin'] = true;

        $user = User::create($data);
        $user->syncRoles($roles);
        $user->syncPermissions($permissions);

        return redirect('/admin/admin-users')->with('success', 'Admin user created successfully.');
    }

    public function show(User $adminUser)
    {
        $adminUser->load(['roles', 'permissions']);

        return view('admin.crud.show', [
            'title' => 'Admin User Details',
            'routeBase' => '/admin/admin-users',
            'record' => $adminUser,
        ]);
    }

    public function edit(User $adminUser)
    {
        return $this->form($adminUser, 'Edit Admin User');
    }

    public function update(Request $request, User $adminUser)
    {
        $data = $this->validated($request, $adminUser);
        $roles = $data['roles'] ?? [];
        $permissions = $data['permissions'] ?? [];
        unset($data['roles'], $data['permissions']);

        if (! empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $data['is_admin'] = true;

        $adminUser->update($data);
        $adminUser->syncRoles($roles);
        $adminUser->syncPermissions($permissions);

        return redirect('/admin/admin-users')->with('success', 'Admin user updated successfully.');
    }

    public function destroy(User $adminUser)
    {
        if (auth()->id() === $adminUser->id) {
            return redirect('/admin/admin-users')->with('success', 'You cannot delete your own admin account.');
        }

        $adminUser->delete();

        return redirect('/admin/admin-users')->with('success', 'Admin user deleted successfully.');
    }

    private function form(User $record, string $title)
    {
        return view('admin.crud.form-page', [
            'title' => $title,
            'routeBase' => '/admin/admin-users',
            'record' => $record,
            'fields' => $this->fields($record),
        ]);
    }

    private function validated(Request $request, ?User $user = null): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user)],
            'password' => [$user ? 'nullable' : 'required', 'string', 'min:8'],
            'roles' => ['nullable', 'array'],
            'roles.*' => ['integer', 'exists:roles,id'],
            'permissions' => ['nullable', 'array'],
            'permissions.*' => ['integer', 'exists:permissions,id'],
        ]);
    }

    private function fields(User $record): array
    {
        return [
            ['name' => 'name', 'label' => 'Name', 'type' => 'text', 'required' => true, 'col' => 6],
            ['name' => 'email', 'label' => 'Email', 'type' => 'email', 'required' => true, 'col' => 6],
            ['name' => 'password', 'label' => $record->exists ? 'Password (leave blank to keep current)' : 'Password', 'type' => 'password', 'required' => ! $record->exists, 'col' => 6],
            [
                'name' => 'roles',
                'label' => 'Roles',
                'type' => 'multiselect',
                'options' => Role::orderBy('name')->pluck('name', 'id')->toArray(),
                'value' => $record->exists ? $record->roles()->pluck('id')->toArray() : [],
                'col' => 6,
            ],
            [
                'name' => 'permissions',
                'label' => 'Direct Permissions',
                'type' => 'multiselect',
                'options' => Permission::orderBy('name')->pluck('name', 'id')->toArray(),
                'value' => $record->exists ? $record->permissions()->pluck('id')->toArray() : [],
                'col' => 12,
            ],
        ];
    }
}
