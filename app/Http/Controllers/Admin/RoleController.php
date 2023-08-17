<?php

namespace App\Http\Controllers\Admin;

use App\Mangers\DataTableManger;
use App\Models\Permission;
use App\Models\Role;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class RoleController extends BaseController
{
    public function init()
    {
        view()->share(['module_title' => 'Role','route' => 'admin.role']);
    }

    public function index(Request $request)
    {
        if($request->ajax())
        {
            $data = dataTable()
                ->of( Role::query() )
                ->filterColumns(['id', 'slug'])
                ->each(function ($row) {
                    return [
                        $row->id,
                        $row->name,
                        date('d-m-Y', strtotime($row->updated_at)),
                        table_actions([
                            'edit' => ['admin.role.edit', ['id' => $row->id]],
                            'copy' => ['admin.role.copy', ['id' => $row->id]],
                            'delete' => ['admin.role.delete', ['id' => $row->id]]
                        ])
                    ];
                })
                ->rows()
            ;


            return $data;
        }

        return view($this->getTemplatePath('index'));
    }

    public function create()
    {
        view()->share(['action_title' => 'Create']);

        return view($this->getTemplatePath('create'));
    }

    public function edit($id)
    {
        view()->share(['action_title' => 'Edit']);

        $item = Role::findOrFail($id);


        $permissions = $item->permissions()->pluck('name', 'id');

        if($permissions)
            $permissions = $permissions->toArray();
        else
            $permissions = [];


        return view($this->getTemplatePath('edit'), ['item' => $item, 'permissions' => $permissions]);
    }

    public function store(Request $request)
    {
        $allPremissions = Permission::all()->pluck('name', 'id');

        $id = $request->item_id;
        $postData = $request->except('_token');

        $request->validate([
            'name' => 'required|max:255',
        ]);

        if($id)
        {
            $row = Role::findOrFail($id);
            $row->update($postData);
        }
        else
        {
            $row = Role::create($postData);
        }

        // build role permissions  roles_premissions
        if(is_array($postData['roles_premissions']))
        {
            $permissionsArray = $allPremissions->toArray();
            $permRoles = [];
            foreach ( $postData['roles_premissions'] as $perm)
            {
                if( in_array($perm, $permissionsArray) )
                {
                    $permRoles[] = array_search($perm, $permissionsArray);
                    continue;
                }
            }

            $row->permissions()->sync($permRoles);
        }

        $redirctMsg = [
            'flash_message' => trans('admin.save_success_message') ,
            'flash_type' => 'success' ,
        ];

        if($request->input('saveNew'))
            return redirect(route('admin.role.create'))->with($redirctMsg);

        return redirect(route('admin.role.index'))->with($redirctMsg);
    }

    public function delete($id)
    {
        $row = Role::findOrFail($id);
        $row->delete();

        return redirect(route('admin.role.index'))->with([
            'flash_message' => trans('admin.delete_success_message') ,
            'flash_type' => 'success' ,
        ]);
    }

    public function copy($id)
    {
        $row = Role::findOrFail($id);

        $new = $row->replicate();
        $new->name = $row->name . ' Copy';
        $new->save();

        $new->permissions()->sync($row->permissions);

        return redirect(route('admin.role.index'))->with([
            'flash_message' => trans('admin.copy_success_message') ,
            'flash_type' => 'success' ,
        ]);
    }



    public function getTemplateFolder()
    {
        return 'role';
    }
}
