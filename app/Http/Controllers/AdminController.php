<?php

namespace App\Http\Controllers;

use App\Admin;
use App\AdminRole;
use App\AdminRoleFeature;
use App\Feature;
use App\FreeSubscription;
use App\FileDeleteSetting;
use App\User;
use App\UserCard;
use Illuminate\Http\Request;
use App\Upload;
use DB;
use FFMpeg;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Omnipay\Omnipay;
use Omnipay\Common\CreditCard;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function login()
    {
        return view('admin.login');
    }

    public function admin_login(Request $request)
    {

        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect('/admin/dashboard');
        } else {
            return redirect(url('/admin'))->with('error', 'Invalid Credentials');
        }
    }

    public function index()
    {
        return view('admin.index');
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect('/admin');
    }

    public function free_subscription()
    {
        $data = FreeSubscription::first();
        return view('admin.free-subscription', compact('data'));
    }

    public function file_delete_setting()
    {
        $data = FileDeleteSetting::first();
        return view('admin.file-delete-setting', compact('data'));
    }

    public function update_free_subscription_days(Request $request)
    {
        $fs = FreeSubscription::first();
        $fs->days = $request->days;
        $fs->save();
        return redirect()->back()->with('success', 'Updated Successfully');

    }

    public function update_file_delete_days(Request $request)
    {
        $fds = FileDeleteSetting::first();
        $fds->days = $request->days;
        $fds->save();
        return redirect()->back()->with('success', 'Updated Successfully');

    }


    public function users()
    {

        return view('admin.users');
    }

    public function get_users(){
        $data = User::withTrashed()->withCount(['uploadedFiles','cleanedFiles','paidFiles'=>function($q){
            $q->join("paymentdetails","paymentdetails.id","uploads.paymentdetails_id");
        }])->orderBy('id','desc')->get();

        foreach ($data as $k=>$v){
            $v->sno = $k+1;

            if($v->trial_expiry_date){
                $v->trial_expiry_date = date("d-m-Y",$v->trial_expiry_date);
            }else{
                $v->trial_expiry_date = "Trial Not Started";
            }

            if($v->last_login_at){
                $v->last_login_at = date("d-m-Y h:i A",$v->last_login_at);
            }else {
                $v->last_login_at = date("d-m-Y h:i A",strtotime($v->created_at));;
            }

            $updateButton = "<button class='btn btn-sm btn-primary mb-2' onclick='resetTrial($v->id)'>Reset Trial</button><br>";
            //view user all files button
            $viewFilesButton = "<button class='btn btn-sm btn-primary mt-2'><a style='color: #fff;' href='".url('/admin/user-files/')."/$v->id'>View Files</a></button><br>";
            if($v->deleted_at){
                // activate Button
                $deleteButton = "<button class='btn btn-sm btn-success' onclick='activateDeactivateUser($v->id,1)'>Activate</button>";

            }else{
                // Deactivate Button
                $deleteButton = "<button class='btn btn-sm btn-danger' onclick='activateDeactivateUser($v->id,0)'>Deactivate</button>";
            }

            $action = $updateButton." ".$deleteButton." ".$viewFilesButton;
            $v->action = $action;

        }

        $results = array(
            "sEcho" => 1,
            "iTotalRecords" => count($data),
            "iTotalDisplayRecords" => count($data),
            "aaData" => $data
        );
        return response()->json($results);
    }

    public function user_files($id){
        return view('admin.user-files');
    }

    public function get_user_files($id) {
        $days = FileDeleteSetting::first()->days;
        $fifteendaysago = date_format(date_create($days.'days ago'), 'Y-m-d 00:00:00');

        $files = Upload::select('users.name', 'uploads.file_name', 'uploads.created_at', 'uploads.id')
            ->join("users","users.id","uploads.user_id")
            ->where('uploads.user_id', '=', $id)
            ->get();

        foreach ($files as $key => $value) {
            $files[$key]->sno = $key+1;
            $files[$key]->action = '';
            $d = date('Y-m-d h:i:s', strtotime($value->created_at));

            if($d < $fifteendaysago){
                $files[$key]->action = "<button class='btn btn-sm btn-danger' onclick='deleteFile($value->id)'>Delete</button>";
            }
        }

        $results = array (
            "sEcho" => 1,
            "iTotalRecords" => count($files),
            "iTotalDisplayRecords" => count($files),
            "aaData" => $files
        );
        return response()->json($results);
    }

    public function delete_file($id) {
        $upload = Upload::find($id);
        $filename = $upload->file_name;
        if(file_exists(public_path('upload/'.$filename))){
            unlink(public_path('upload/'.$filename));
        }
        $upload->delete();
        return response(["status" => "success", "msg" => "File deleted successfully"], 200);
    }

    public function activate_deactivate_user(Request $request)
    {
        if (!$request->status) {
            $st = "Deactivated";
            $user = User::find($request->id)->delete();
        } else {
            $st = "Activated";
            $user = User::withTrashed()->find($request->id)->restore();
        }
        return response(["status" => "success", "msg" => "User " . $st . " successfully"], 200);
    }

    public function reset_trial($id)
    {
        $user = User::find($id);
        $days = FreeSubscription::first()->days;
        $trial_expiry_date = strtotime("+$days days ", time());
        $user->trial_expiry_date = $trial_expiry_date;
        $user->save();
        return response(["status" => "success", "msg" => "Free Trial reset successfully"], 200);
    }

    public function admins()
    {
//        $admins = Admin::withTrashed()->get();
        $roles = AdminRole::all();
        return view('admin.admins', compact( "roles"));
    }

    public function get_admins(){
        $data = Admin::withTrashed()->orderBy('id','desc')->get();
        foreach ($data as $k=>$v){

            $v->sno = $k+1;

//            $v->created = date("d-m-Y h:i A",strtotime($v->created_at));
//            $v->updated = date("d-m-Y h:i A",strtotime($v->updated_at));

            // Update Button
            $updateButton = "<button class='btn btn-sm btn-primary' onclick='getSingleAdmin($v->id)'>Edit</button>";

            if($v->deleted_at){
                // activate Button
                $deleteButton = "<button class='btn btn-sm btn-success' onclick='activateDeactivateAdmin($v->id,1)'>Activate</button>";

            }else{
                // Deactivate Button
                $deleteButton = "<button class='btn btn-sm btn-danger' onclick='activateDeactivateAdmin($v->id,0)'>Deactivate</button>";
            }
            $action = $updateButton." ".$deleteButton;
            $v->action = $action;

        }

        $results = array(
            "sEcho" => 1,
            "iTotalRecords" => count($data),
            "iTotalDisplayRecords" => count($data),
            "aaData" => $data
        );
        return response()->json($results);
    }

    public function add_admin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'max:255'],
            'email' => ['required', 'email', 'unique:admins', 'unique:users'],
            'password' => ['required', 'min:8'],
            'role' => ['required'],
        ]);
        if ($validator->fails()) {
            $error = $validator->getMessageBag()->first();
            return response()->json(["status" => "error", "msg" => $error], 400);
        } else {
            $a = new Admin();
            $a->name = $request->name;
            $a->email = $request->email;
            $a->password = Hash::make($request->password);
            $a->role_id = $request->role;
            $a->save();

            $u = new User();
            $u->name = $request->name;
            $u->email = $request->email;
            $u->password = Hash::make($request->password);
            $u->user = 1;
            $u->is_admin = 1;
            $u->save();

            return response()->json(["status" => "success", "msg" => "Admin Added Successfully"], 200);

        }
    }

    public function activate_deactivate_admin(Request $request)
    {
        if (!$request->status) {
            $st = "Deactivated";
            $user = Admin::find($request->id)->delete();
        } else {
            $st = "Activated";
            $user = Admin::withTrashed()->find($request->id)->restore();
        }
        return response(["status" => "success", "msg" => "Admin " . $st . " successfully"], 200);
    }

    public function get_admin(Request $request)
    {

        $user = Admin::find($request->id);

        return response(["status" => "success", "res" => $user], 200);
    }

    public function update_admin(Request $request)
    {
        if ($request->password) {
            $validator = Validator::make($request->all(), [
                'name' => ['required', 'max:255'],
                'password' => 'required|string|min:8',
                'role' => ['required'],
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                'name' => ['required', 'max:255'],
                'role' => ['required'],
            ]);
        }
        if ($validator->fails()) {
            $error = $validator->getMessageBag()->first();
            return response()->json(["status" => "error", "msg" => $error], 400);
        } else {
            $a = Admin::find($request->id);
            $a->name = $request->name;
            $a->email = $request->email;
            if ($request->password) {
                $a->password = Hash::make($request->password);
            }
            $a->role_id = $request->role;
            $a->save();

            if($a->role_id!=1) {
                $u = User::where("email", $request->email)->first();
                if (!$u) {
                    $u = new User();
                }
                $u->name = $request->name;
                $u->email = $request->email;
                if ($request->password) {
                    $u->password = Hash::make($request->password);
                }
                $u->user = 1;
                $u->is_admin = 1;
                $u->save();
            }
            return response()->json(["status" => "success", "msg" => "Admin Updated Successfully"], 200);

        }
    }

    public function roles()
    {
//        $roles = AdminRole::where("id","!=",1)->get();
        $features = Feature::all();
        return view('admin.roles', compact( "features"));
    }

    public function get_roles(){
        $data = AdminRole::where("id","!=",1)->get();
        foreach ($data as $k=>$v){
            $v->sno = $k+1;

            // Update Button
            $updateButton = "<button class='btn btn-sm btn-primary' onclick='getSingleRole($v->id)'>Edit</button>";

            $action = $updateButton;
            $v->action = $action;

        }

        $results = array(
            "sEcho" => 1,
            "iTotalRecords" => count($data),
            "iTotalDisplayRecords" => count($data),
            "aaData" => $data
        );
        return response()->json($results);
    }

    public function get_role(Request $request)
    {
        $features = Feature::all();
        $role_features = AdminRoleFeature::where("role_id",$request->id)->pluck('feature_id')->toArray();
        foreach ($features as $f){
            if(in_array($f->id,$role_features)){
                $f->selected = true;
            }else{
                $f->selected = false;
            }
        }

        $role = AdminRole::find($request->id);
        return response(["status" => "success", "res" => $role,"features"=>$features], 200);
    }

    public function update_role(Request $request){
        $role_id = $request->id;
        $role = $request->role;
        $features = $request->features;
        $ar = AdminRole::find($role_id);
        $ar->role = $role;
        $ar->save();

        if(!empty($features)){
            AdminRoleFeature::where("role_id",$role_id)->delete();
            foreach ($features as $f){
                $arf = new AdminRoleFeature();
                $arf->role_id = $role_id;
                $arf->feature_id = $f;
                $arf->save();
            }
        }

        return response(["status" => "success","msg"=>"Role updated successfully", "res" => $ar], 200);

    }

    public function unauthorize_access(){
        return view("admin/unauthorize-access");
    }

}
