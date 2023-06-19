<?php

namespace App\Http\Controllers;

use App\Admin;
use App\AdminRole;
use App\AdminRoleFeature;
use App\Feature;
use App\FreeSubscription;
use App\FileDeleteSetting;
use App\Paymentdetail;
use App\Settings;
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

    public function time_on_disk()
    {
        $data = Settings::first();
        return view('admin.time-on-disk', compact('data'));
    }

    public function plan_and_subscription()
    {
        // $data = FreeSubscription::first();
        return view('admin.plan-and-subscription');
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

    public function update_time_on_disk(Request $request)
    {
        $fs = Settings::first();
        $fs->key = $request->key;
        $fs->value = $request->value;
        $fs->save();
        return redirect()->back()->with('success', 'Updated Successfully');
    }

    public function update_file_delete_days(Request $request)
    {
        $fds = FileDeleteSetting::first();
        $fds->days = $request->days;
        $fds->clean_files_limits = $request->clean_files_limits;
        $fds->save();
        return redirect()->back()->with('success', 'Updated Successfully');
    }


    public function users()
    {
        return view('admin.users');
    }

    public function get_users()
    {
        $data = User::withTrashed()->withCount(['uploadedFiles', 'cleanedFiles', 'paidFiles' => function ($q) {
            $q->join("paymentdetails", "paymentdetails.id", "uploads.paymentdetails_id");
        }])->orderBy('id', 'desc')->get();

        foreach ($data as $k => $v) {
            $v->sno = $k + 1;

            if ($v->trial_expiry_date) {
                $v->trial_expiry_date = date("m-d-Y", $v->trial_expiry_date);
            } else {
                $v->trial_expiry_date = "Trial Not Started";
            }

            if ($v->last_login_at) {
                $v->last_login_at = date("m-d-Y h:i A", $v->last_login_at);
            } else {
                $v->last_login_at = date("m-d-Y h:i A", strtotime($v->created_at));;
            }

            if ($v->enterprise_user) {
                $v->enterprise_user = "<button class='btn-sm btn-primary' onclick='makeRemoveEnterPriseUser($v->id,0)'>Remove</button>";
            } else {
                $v->enterprise_user = "<button class='btn-sm btn-primary' onclick='makeRemoveEnterPriseUser($v->id,1)'>Make</button>";
            }

            $updateButton = "<button class='btn btn-sm btn-primary mb-2Upload Date	' onclick='resetTrial($v->id)'>Reset Trial</button><br>";
            //view user all files button
            $viewFilesButton = "<button class='btn btn-sm btn-primary mt-2'><a style='color: #fff;' href='" . url('/admin/user-files/') . "/$v->id'>View Files</a></button><br>";
            if ($v->deleted_at) {
                // activate Button
                $deleteButton = "<button class='btn btn-sm btn-success mt-2' onclick='activateDeactivateUser($v->id,1)'>Activate</button>";
            } else {
                // Deactivate Button
                $deleteButton = "<button class='btn btn-sm btn-danger mt-2' onclick='activateDeactivateUser($v->id,0)'>Deactivate</button>";
            }

            $forcedeleteButton = "<button class='btn btn-sm btn-danger mt-2' onclick='deleteUser($v->id)'>Delete</button>";


            if (!$v->subscription) {
                $subscription_btn =  "<button class='btn btn-sm btn-primary mt-2' onclick='subscribe($v->id)'>Subscribe</button><br>";
            } else {
                $subscription_btn =  "<button class='btn btn-sm btn-primary mt-2' disabled>Subscribed</button><br>";
            }

            $action = $updateButton . " " . $deleteButton . " " . $viewFilesButton . " " . $subscription_btn . " " . $forcedeleteButton;
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

    public function reports()
    {
        return view('admin.reports');
    }

    public function get_reports()
    {
        $data = User::withTrashed()->withCount(['uploadedFiles', 'cleanedFiles', 'paidFiles' => function ($q) {
            $q->join("paymentdetails", "paymentdetails.id", "uploads.paymentdetails_id");
        }])->orderBy('id', 'desc')->get();

        foreach ($data as $k => $v) {
            $v->sno = $k + 1;
            $v->name = "<a href='" . url('/admin/view/') . "/$v->id'>$v->name</a>";

            if ($v->trial_expiry_date) {
                $v->trial_expiry_date = date("m-d-Y", $v->trial_expiry_date);
            } else {
                $v->trial_expiry_date = "Trial Not Started";
            }

            if ($v->last_login_at) {
                $v->last_login_at = date("m-d-Y h:i A", $v->last_login_at);
            } else {
                $v->last_login_at = date("m-d-Y h:i A", strtotime($v->created_at));;
            }

            $viewFilesButton = "<button class='btn btn-sm btn-primary mt-2'><a style='color: #fff;' href='" . url('/admin/view/') . "/$v->id'>View</a></button><br>";
            $v->action = $viewFilesButton;
        }

        $results = array(
            "sEcho" => 1,
            "iTotalRecords" => count($data),
            "iTotalDisplayRecords" => count($data),
            "aaData" => $data
        );
        return response()->json($results);
    }

    public function view_user_files($id)
    {
        return view('admin.view-user-files');
    }

    public function user_files($id)
    {
        return view('admin.user-files');
    }

    public function get_user_files($id)
    {
        $days = FileDeleteSetting::first()->days;
        $fifteendaysago = date_format(date_create($days . 'days ago'), 'Y-m-d 00:00:00');

        $files = Upload::select('users.name', 'uploads.file_name', 'uploads.created_at', 'uploads.id')
            ->join("users", "users.id", "uploads.user_id")
            ->where('uploads.user_id', '=', $id)
            ->orderby("id", "desc")
            ->get();

        foreach ($files as $key => $value) {
            $files[$key]->sno = $key + 1;
            $files[$key]->action = '';
            $d = date('Y-m-d h:i:s', strtotime($value->created_at));

            if ($d < $fifteendaysago) {
                $files[$key]->action = "<button class='btn btn-sm btn-danger' onclick='deleteFile($value->id)'>Delete</button>";
            }

            $value->created = date("m-d-Y h:i A", strtotime($value->created_at));

            $new_array = explode('_', $files[$key]->file_name);
            array_shift($new_array);
            $files[$key]->file_name = implode('_', $new_array);
        }

        $results = array(
            "sEcho" => 1,
            "iTotalRecords" => count($files),
            "iTotalDisplayRecords" => count($files),
            "aaData" => $files
        );
        return response()->json($results);
    }

    public function view_get_user_files($id, Request $request)
    {
        $date = $request->date;
        $keyword = $request->keyword;
        $filter_by = $request->filter_by;
        $date_filter_by = $request->date_filter_by;
        $days = FileDeleteSetting::first()->days;
        $fifteendaysago = date_format(date_create($days . 'days ago'), 'Y-m-d 00:00:00');

        DB::enableQueryLog();

        $files = Upload::select('users.name', 'uploads.file_name', 'uploads.created_at', 'uploads.id', 'uploads.cleaned', 'uploads.duration', 'uploads.cleaned_at')
            ->join("users", "users.id", "uploads.user_id")
            ->where('uploads.user_id', '=', $id);

        if ($date != 'undefined') {
            $date = explode('-', $date);
            $fromDate = date('Y-m-d', strtotime($date[0]));
            $toDate = date('Y-m-d', strtotime($date[1]));
            if ($date_filter_by != "") {
                $files = $files->whereBetween("uploads.$date_filter_by", [$fromDate, $toDate]);
            }
        }
        if ($filter_by != "") {
            $files = $files->where("cleaned", $filter_by);
        }

        if ($keyword != "") {
            $files = $files->where("users.name", "like", "%$keyword%")
                ->orwhere("uploads.file_name", "like", "%$keyword%")
                ->orwhere("uploads.duration", "like", "%$keyword%");
        }

        $files = $files->orderby("id", "desc")->get();

        foreach ($files as $key => $value) {
            $files[$key]->sno = $key + 1;
            $files[$key]->action = '';
            $d = date('Y-m-d h:i:s', strtotime($value->created_at));

            if ($d < $fifteendaysago) {
                $files[$key]->action = "<button class='btn btn-sm btn-danger' onclick='deleteUserFile($value->id)'>Delete</button>";
            }

            $files[$key]->created = date("m-d-Y h:i:s A", strtotime($value->created_at));
            if ($files[$key]->cleaned) {
                $files[$key]->cleaned = "Yes";
            } else {
                $files[$key]->cleaned = "No";
            }
            if ($files[$key]->cleaned_at) {
                $files[$key]->cleaned_at = date("m-d-Y h:i:s A", strtotime($value->created_at));
            } else {
                $files[$key]->cleaned_at = "NA";
            }

            $new_array = explode('_', $files[$key]->file_name);
            array_shift($new_array);
            $files[$key]->file_name = implode('_', $new_array);
        }
        //        return response()->json($files,200);
        $results = array(
            "sEcho" => 1,
            "iTotalRecords" => count($files),
            "iTotalDisplayRecords" => count($files),
            "aaData" => $files
        );
        return response()->json($results);
    }



    public function delete_file($id)
    {
        $upload = Upload::find($id);
        $filename = $upload->file_name;
        if (file_exists(public_path('upload/' . $filename))) {
            unlink(public_path('upload/' . $filename));
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
    public function delete_user(Request $request)
    {
        $pd = Paymentdetail::where('user_id', $request->id)->forceDelete();
        $pd = Upload::where('user_id', $request->id)->forceDelete();
        $user = User::withTrashed()->find($request->id);
        $user->forceDelete();

        return response(["status" => "success", "msg" => "User deleted successfully"], 200);
    }

    public function make_remove_enterprise_user(Request $request)
    {
        if (!$request->status) {
            $st = "Removed";
        } else {
            $st = "Made";
        }
        $user = User::find($request->id);
        $user->enterprise_user = $request->status;
        $user->save();
        return response(["status" => "success", "msg" => "User " . $st . " as enterprise user successfully"], 200);
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
    public function subscription($id)
    {
        $user = User::find($id);
        $user->subscription = 1;
        $user->save();
        return response(["status" => "success", "msg" => "Unlimited subscription done successfully"], 200);
    }

    public function admins()
    {
        //        $admins = Admin::withTrashed()->get();
        $roles = AdminRole::all();
        return view('admin.admins', compact("roles"));
    }

    public function get_admins()
    {
        $data = Admin::withTrashed()->orderBy('id', 'desc')->get();
        foreach ($data as $k => $v) {

            $v->sno = $k + 1;

            //            $v->created = date("m-d-Y h:i A",strtotime($v->created_at));
            //            $v->updated = date("m-d-Y h:i A",strtotime($v->updated_at));

            // Update Button
            $updateButton = "<button class='btn btn-sm btn-primary' onclick='getSingleAdmin($v->id)'>Edit</button>";

            if ($v->deleted_at) {
                // activate Button
                $deleteButton = "<button class='btn btn-sm btn-success' onclick='activateDeactivateAdmin($v->id,1)'>Activate</button>";
            } else {
                // Deactivate Button
                $deleteButton = "<button class='btn btn-sm btn-danger' onclick='activateDeactivateAdmin($v->id,0)'>Deactivate</button>";
            }
            $action = $updateButton . " " . $deleteButton;
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

            if ($a->role_id != 1) {
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
        return view('admin.roles', compact("features"));
    }

    public function get_roles()
    {
        $data = AdminRole::where("id", "!=", 1)->get();
        foreach ($data as $k => $v) {
            $v->sno = $k + 1;

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

    public function get_plans()
    {
        $data = \DB::table('subscription_type')->get();
        foreach ($data as $k => $v) {
            $v->sno = $k + 1;

            // Update Button
            $updateButton = "<button class='btn btn-sm btn-primary' onclick='getSinglePlan($v->id)'>Edit</button>";

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
        $role_features = AdminRoleFeature::where("role_id", $request->id)->pluck('feature_id')->toArray();
        foreach ($features as $f) {
            if (in_array($f->id, $role_features)) {
                $f->selected = true;
            } else {
                $f->selected = false;
            }
        }

        $role = AdminRole::find($request->id);
        return response(["status" => "success", "res" => $role, "features" => $features], 200);
    }

    public function get_plan(Request $request)
    {
        $plan = \DB::table('subscription_type')->find($request->id);
        return response(["status" => "success", "res" => $plan], 200);
    }

    public function update_role(Request $request)
    {
        $role_id = $request->id;
        $role = $request->role;
        $features = $request->features;
        $ar = AdminRole::find($role_id);
        $ar->role = $role;
        $ar->save();

        if (!empty($features)) {
            AdminRoleFeature::where("role_id", $role_id)->delete();
            foreach ($features as $f) {
                $arf = new AdminRoleFeature();
                $arf->role_id = $role_id;
                $arf->feature_id = $f;
                $arf->save();
            }
        }
    }

    public function update_plan(Request $request)
    {
        $ar = \DB::table('subscription_type')->where('id', $request->id)->update([
            'name' => $request->name,
            'charges' => $request->charges,
            'no_of_clean_file' => $request->no_of_clean_file,
            'text_1' => $request->text_1,
            'text_2' => $request->text_2,
            'text_3' => $request->text_3,
        ]);

        return response(["status" => "success", "msg" => "Plan updated successfully", "res" => $ar], 200);
    }

    public function unauthorize_access()
    {
        return view("admin/unauthorize-access");
    }
}
