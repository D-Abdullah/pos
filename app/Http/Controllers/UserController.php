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

    public function index(Request $request)
    {
        // try {
        $rules = [
            'name' => 'nullable|string',
            'email' => 'nullable|string',
            'phone' => 'nullable|string',
            'role' => 'nullable|string|exists:roles,id',
            'date_from' => 'nullable|date',
            'date_to' => 'nullable|date',
        ];

        $messages = [
            'name.string' => 'الاسم غير صالح.',
            'email.string' => 'البريد الإلكتروني غير صالح.',
            'phone.string' => 'رقم الهاتف غير صالح.',
            'role.exists' => 'الصلاحيه المحدد غير موجود.',
            'date_from.date' => 'تاريخ "من" غير صالح.',
            'date_to.date' => 'تاريخ "إلى" غير صالح.',
        ];
        $validatedData = $request->validate($rules, $messages);

        $users = User::query();
        if ($request->filled('name')) {
            $users->where('name', 'LIKE', '%' . $request->input('name') . '%');
        }
        if ($request->filled('email')) {
            $users->where('email', 'LIKE', '%' . $request->input('email') . '%');
        }
        if ($request->filled('phone')) {
            $users->where('phone', 'LIKE', '%' . $request->input('phone') . '%');
        }
        if ($request->filled('role')) {
            $users->role(Role::find($request->input('role'))->name);
        }

        if ($request->filled('date_from')) {
            $users->whereDate('updated_at', '>=', $request->input('date_from'));
        }

        if ($request->filled('date_to')) {
            $users->whereDate('updated_at', '<=', $request->input('date_to'));
        }

        $users = $users->with('roles')->paginate(PAGINATION);
        $roles = Role::all();

        return view('pages.users.index', compact('users', 'roles'));
        // } catch (\Exception $e) {
        //     Log::error('حدث خطأ أثناء جلب الأعضاء: ' . $e->getMessage());

        //     return redirect()->back()->with(['error' => 'حدث خطأ أثناء جلب الأعضاء. يرجى المحاولة مرة أخرى.']);
        // }
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
