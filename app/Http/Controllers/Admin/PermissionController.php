<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function index()
    {
        return view('admin.crud.index', [
            'title' => 'Permissions',
            'routeBase' => '/admin/permissions',
            'records' => Permission::latest()->paginate(10),
            'columns' => [
                'id' => 'ID',
                'name' => 'Name',
                'guard_name' => 'Guard',
                'created_at' => 'Created',
            ],
        ]);
    }

    public function create()
    {
        return $this->form(new Permission(['guard_name' => 'web']), 'Create Permission');
    }

    public function store(Request $request)
    {
        Permission::create($this->validated($request));

        return redirect('/admin/permissions')->with('success', 'Permission created successfully.');
    }

    public function show(Permission $permission)
    {
        return view('admin.crud.show', [
            'title' => 'Permission Details',
            'routeBase' => '/admin/permissions',
            'record' => $permission,
        ]);
    }

    public function edit(Permission $permission)
    {
        return $this->form($permission, 'Edit Permission');
    }

    public function update(Request $request, Permission $permission)
    {
        $permission->update($this->validated($request, $permission));

        return redirect('/admin/permissions')->with('success', 'Permission updated successfully.');
    }

    public function destroy(Permission $permission)
    {
        $permission->delete();

        return redirect('/admin/permissions')->with('success', 'Permission deleted successfully.');
    }

    private function form(Permission $record, string $title)
    {
        return view('admin.crud.form-page', [
            'title' => $title,
            'routeBase' => '/admin/permissions',
            'record' => $record,
            'fields' => $this->fields(),
        ]);
    }

    private function validated(Request $request, ?Permission $permission = null): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('permissions')->where('guard_name', $request->input('guard_name', 'web'))->ignore($permission)],
            'guard_name' => ['required', 'string', 'max:255'],
        ]);
    }

    private function fields(): array
    {
        return [
            ['name' => 'name', 'label' => 'Name', 'type' => 'text', 'required' => true, 'col' => 6],
            ['name' => 'guard_name', 'label' => 'Guard', 'type' => 'text', 'required' => true, 'col' => 6],
        ];
    }
}
