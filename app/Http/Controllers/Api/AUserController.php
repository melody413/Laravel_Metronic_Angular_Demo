<?php

namespace App\Http\Controllers\Api;

use App\Mangers\DataTableManger;
use App\Models\Permission;
use App\Models\User;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Http\Controllers\Admin\BaseController;
use Illuminate\Support\Facades\DB;

class AUserController extends BaseController
{
    use AuthenticatesUsers;

    public function init()
    {
        view()->share(['module_title' => 'User','route' => 'admin.user']);
    }

    public function index_doctors(Request $request){
        $users_count = User::search($request->q)->where("type", 2)->search($request->tel)->search($request->email)->count();
        $dr_users = User::search($request->q)->where("type", 2)->search($request->tel)->search($request->email)->orderByRaw('created_at DESC')->paginate(10)->fragment('users');
        // return view($this->getTemplatePath('index_doctors'), ['dr_users' => $dr_users, 'users_count' => $users_count]);
        return response(['dr_users' => $dr_users, 'users_count' => $users_count], 200);
    }

    public function index_users(Request $request){
        $users_count = User::search($request->q)->where("type", 1)->search($request->tel)->search($request->email)->count();
        $dr_users = User::search($request->q)->where("type", 1)->search($request->tel)->search($request->email)->orderByRaw('created_at DESC')->paginate(10)->fragment('users');
        // return view($this->getTemplatePath('index_users'), ['dr_users' => $dr_users, 'users_count' => $users_count]);
        return response( ['dr_users' => $dr_users, 'users_count' => $users_count], 200);

    }

    public function index_admin(Request $request){
        $users_count = User::search($request->q)->where("type", 4)->search($request->tel)->search($request->email)->count();
        $dr_users = User::search($request->q)->where("type", 4)->search($request->tel)->search($request->email)->orderByRaw('created_at DESC')->paginate(10)->fragment('users');
        // return view($this->getTemplatePath('index_users'), ['dr_users' => $dr_users, 'users_count' => $users_count]);
        return response(['dr_users' => $dr_users, 'users_count' => $users_count], 200);

    }

    public function index_moderator(Request $request){
        $users_count = User::search($request->q)->where("type", 3)->search($request->tel)->search($request->email)->count();
        $dr_users = User::search($request->q)->where("type", 3)->search($request->tel)->search($request->email)->orderByRaw('created_at DESC')->paginate(10)->fragment('users');
        // return view($this->getTemplatePath('index_users'), ['dr_users' => $dr_users, 'users_count' => $users_count]);
        return response(['dr_users' => $dr_users, 'users_count' => $users_count], 200);

    }

    public function index(Request $request)
    {
        // if($request->ajax())
        // {
            // $data = dataTable()
            //     ->of( User::query() )
            //     ->filterColumns(['id', 'slug'])
            //     ->each(function ($row) {
            //         $user_type= array_flip(dataForm()->userTypes())[($row->type == 0)?1:$row->type];
            //         if($user_type == "doctor")
            //         return [
            //             $row->id,
            //             $row->name,
            //             $row->email,
            //             array_flip(dataForm()->userTypes())[($row->type == 0)?1:$row->type],
            //             date('d-m-Y', strtotime($row->updated_at)),
            //             table_actions([
            //                 'edit' => ['admin.user.edit', ['id' => $row->id]],
            //                 //'copy' => ['admin.user.copy', ['id' => $row->id]],
            //                 'delete' => ['admin.user.delete', ['id' => $row->id]]
            //             ])
            //         ];
            //     })
            //     ->rows()
            // ;
            $users_count = User::search($request->q)->search($request->tel)->search($request->email)->count();
            $users = User::search($request->q)->search($request->tel)->search($request->email)->orderByRaw('created_at DESC')->paginate(10)->fragment('users');
            return response(['users' => $users, 'users_count' => $users_count], 200);
            
            // return view($this->getTemplatePath('index'), ['users' => $users, 'users_count' => $users_count]);
        // }

        // return view($this->getTemplatePath('index'));
    }

    public function create()
    {
        view()->share(['action_title' => 'Create']);
        return response(['action_title' => 'Create'], 200);

        // return view($this->getTemplatePath('create'));
    }

    public function edit($id)
    {
        view()->share(['action_title' => 'Edit']);

        $item = User::findOrFail($id);

        return response(['item' => $item], 200);

        // return view($this->getTemplatePath('edit'), ['item' => $item]);
    }

    public function store(Request $request)
    {
        $id = $request->item_id;
        $postData = $request->except('_token');
// dd($postData);
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,id,' . $id
        ]);

        if($postData['password'])
            $postData['password'] = Hash::make($postData['password']);
        else
            unset($postData['password']);


        if($id)
        {
            $row = User::findOrFail($id);
            $row->update($postData);
        }
        else
        {
            $row = User::create($postData);
        }

        if ($postData['role'])
        {
            $row->assignRoleById($postData['role']);
        }

        $redirctMsg = [
            'flash_message' => trans('admin.save_success_message') ,
            'flash_type' => 'success' ,
        ];

        if($request->input('saveNew'))
            return response(['next' => "savenew"]);
        return response(['id' => $row->id], 200);
    }

    public function delete($id)
    {
        $row = User::findOrFail($id);
        $row->delete();

        return response(['flash_message' => trans('admin.delete_success_message') ,
        'flash_type' => 'success'], 200);
    }

    public function loginAs($id)
    {
        
    }

    public function showLogin(Request $request)
    {
        return view('admin.user.login');
    }

    public function redirectPath()
    {
        return '/'.env('ADMIN_PREFIX');
    }

    public function loggedOut(Request $request)
    {
        return redirect('/'.env('ADMIN_PREFIX'));
    }

    public function getTemplateFolder()
    {
        return 'user';
    }

    public function table(Request $request){
        if($request->has("search_index")){
            $searchIndex = $request->search_index;
            $query = DB::table('users');
            $users = User::scopeSearch($query, $searchIndex)->orderByRaw('created_at DESC')->get();
            return response(['search_result' => $users], 200);
        }else{
            $pageSize = $request->params['updates'][0]['value'];
            $pageIndex = $request->params['updates'][1]['value'] + 1;
            $users = User::search($request->q)->search($request->tel)->search($request->email)
            ->orderBy('created_at', 'DESC')
            ->paginate($pageSize, ['*'], 'page', $pageIndex)
            ->fragment('users');
            
            return response(['search_result' => $users], 200);

        }
    }
}
