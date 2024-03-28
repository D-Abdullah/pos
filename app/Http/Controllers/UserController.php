<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        try {
            $users = User::with('roles')->paginate(PAGINATION);
            $roles = Role::all();

            return view('pages.users.index', compact('users', 'roles'));
        } catch (\Exception $e) {
            Log::error('حدث خطأ أثناء جلب الأعضاء: ' . $e->getMessage());

            return redirect()->back()->with(['error' => 'حدث خطأ أثناء جلب الأعضاء. يرجى المحاولة مرة أخرى.']);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $validator = Validator::make($request->all(), $request->rules(), $request->messages());

        if ($validator->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($validator);
        }

        try {
            $user = User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('123456789'),
                'phone' => $request->input('phone'),
                'added_by' => auth()->user()->getAuthIdentifier(),
                'remember_token' => Str::random(50)
            ]);
            $user->save();

            $user->assignRole($request->input('role'));

            return redirect()->route('user.all')->with(['success' => 'تم إنشاء المستخدم ' . $request->input('name') . ' بنجاح.']);
        } catch (\Exception $e) {
            Log::error('حدث خطأ أثناء إنشاء المستخدم: ' . $e->getMessage());

            return redirect()->back()->withInput($request->all())->with(['error' => 'حدث خطأ أثناء إنشاء المستخدم. يرجى المحاولة مرة أخرى.']);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, $id)
    {
        try {
            $user = User::findOrFail($id);
            $user->update([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'phone' => $request->input('phone'),
            ]);

            $user->syncRoles([$request->input('role')]);

            return redirect()->route('user.all')->with(['success' => 'تم تحديث المستخدم ' . $request->input('name') . ' بنجاح.']);
        } catch (\Exception $e) {
            Log::error('حدث خطأ أثناء تحديث المستخدم: ' . $e->getMessage());

            return redirect()->back()->withInput($request->all())->with(['error' => 'حدث خطأ أثناء تحديث المستخدم. يرجى المحاولة مرة أخرى.']);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();

            return redirect()->route('user.all')->with(['success' => 'تم حذف المستخدم بنجاح.']);
        } catch (\Exception $e) {
            Log::error('حدث خطأ أثناء حذف المستخدم: ' . $e->getMessage());

            return redirect()->back()->with(['error' => 'حدث خطأ أثناء حذف المستخدم. يرجى المحاولة مرة أخرى.']);
        }
    }
}
