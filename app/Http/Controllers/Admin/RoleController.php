<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        return view('admin.crud.index', [
            'title' => 'Roles',
            'routeBase' => '/admin/roles',
            'records' => Role::withCount('permissions')->latest()->paginate(10),
            'columns' => [
                'id' => 'ID',
                'name' => 'Name',
                'guard_name' => 'Guard',
                'permissions_count' => 'Permissions',
                'created_at' => 'Created',
            ],
        ]);
    }

    public function create()
    {
        return $this->form(new Role(['guard_name' => 'web']), 'Create Role');
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $permissions = $data['permissions'] ?? [];
        unset($data['permissions']);

        $role = Role::create($data);
        $role->syncPermissions($permissions);

        return redirect('/admin/roles')->with('success', 'Role created successfully.');
    }

    public function show(Role $role)
    {
        $role->load('permissions');

        return view('admin.crud.show', [
            'title' => 'Role Details',
            'routeBase' => '/admin/roles',
            'record' => $role,
        ]);
    }

    public function edit(Role $role)
    {
        return $this->form($role, 'Edit Role');
    }

    public function update(Request $request, Role $role)
    {
        $data = $this->validated($request, $role);
        $permissions = $data['permissions'] ?? [];
        unset($data['permissions']);

        $role->update($data);
        $role->syncPermissions($permissions);

        return redirect('/admin/roles')->with('success', 'Role updated successfully.');
    }

    public function destroy(Role $role)
    {
        $role->delete();

        return redirect('/admin/roles')->with('success', 'Role deleted successfully.');
    }

    private function form(Role $record, string $title)
    {
        return view('admin.crud.form-page', [
            'title' => $title,
            'routeBase' => '/admin/roles',
            'record' => $record,
            'fields' => $this->fields($record),
        ]);
    }

    private function validated(Request $request, ?Role $role = null): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('roles')->where('guard_name', $request->input('guard_name', 'web'))->ignore($role)],
            'guard_name' => ['required', 'string', 'max:255'],
            'permissions' => ['nullable', 'array'],
            'permissions.*' => ['integer', 'exists:permissions,id'],
        ]);
    }

    private function fields(Role $record): array
    {
        return [
            ['name' => 'name', 'label' => 'Name', 'type' => 'text', 'required' => true, 'col' => 6],
            ['name' => 'guard_name', 'label' => 'Guard', 'type' => 'text', 'required' => true, 'col' => 6],
            [
                'name' => 'permissions',
                'label' => 'Permissions',
                'type' => 'multiselect',
                'options' => Permission::orderBy('name')->pluck('name', 'id')->toArray(),
                'value' => $record->exists ? $record->permissions()->pluck('id')->toArray() : [],
                'col' => 12,
            ],
        ];
    }
}
