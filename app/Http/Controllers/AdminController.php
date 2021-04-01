<?php

namespace App\Http\Controllers;

use App\Admin;
use App\AdminRole;
use App\AdminRoleFeature;
use App\Feature;
use App\FreeSubscription;
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

    public function update_free_subscription_days(Request $request)
    {
        $fs = FreeSubscription::first();
        $fs->days = $request->days;
        $fs->save();
        return redirect()->back()->with('success', 'Updated Successfully');

    }

    public function users()
    {
        $users = User::withTrashed()->withCount(['uploadedFiles','cleanedFiles','paidFiles'=>function($q){
            $q->join("paymentdetails","paymentdetails.id","uploads.paymentdetails_id");
        }])->get();
        return view('admin.users', compact("users"));
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
        $admins = Admin::withTrashed()->get();
        $roles = AdminRole::all();
        return view('admin.admins', compact("admins", "roles"));
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
            return response()->json(["status" => "error", "message" => $error], 400);
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

            return response()->json(["status" => "success", "message" => "Admin Added Successfully"], 200);

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
        return response(["status" => "success", "msg" => "User " . $st . " successfully"], 200);
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
            return response()->json(["status" => "error", "message" => $error], 400);
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
            return response()->json(["status" => "success", "message" => "Admin Added Successfully"], 200);

        }
    }

    public function roles()
    {
        $roles = AdminRole::where("id","!=",1)->get();
        $features = Feature::all();
        return view('admin.roles', compact("roles", "features"));
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

        return response(["status" => "success", "res" => $ar], 200);

    }

    public function unauthorize_access(){
        return view("admin/unauthorize-access");
    }

}
