<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    public array $translated_permissions;

    public function __construct()
    {
        $this->translated_permissions = [
            'create target' => 'إنشاء الهدف',
            'read target' => 'قراءة الهدف',
            'update target' => 'تحديث الهدف',
            'delete target' => 'حذف الهدف',

            'create department' => 'إنشاء القسم',
            'read department' => 'قراءة القسم',
            'update department' => 'تحديث القسم',
            'delete department' => 'حذف القسم',

            'create product' => 'إنشاء المنتج',
            'read product' => 'قراءة المنتج',
            'update product' => 'تحديث المنتج',
            'delete product' => 'حذف المنتج',

            'create supplier' => 'إنشاء المورد',
            'read supplier' => 'قراءة المورد',
            'update supplier' => 'تحديث المورد',
            'delete supplier' => 'حذف المورد',

            'create purchase' => 'إنشاء عملية الشراء',
            'read purchase' => 'قراءة عملية الشراء',
            'update purchase' => 'تحديث عملية الشراء',
            'delete purchase' => 'حذف عملية الشراء',

            'create client' => 'إنشاء العميل',
            'read client' => 'قراءة العميل',
            'update client' => 'تحديث العميل',
            'delete client' => 'حذف العميل',

            'create eol' => 'إنشاء عملية التالف',
            'read eol' => 'قراءة عملية التالف',
            'update eol' => 'تحديث عملية التالف',
            'delete eol' => 'حذف عملية التالف',

            'create user' => 'إنشاء المستخدم',
            'read user' => 'قراءة المستخدم',
            'update user' => 'تحديث المستخدم',
            'delete user' => 'حذف المستخدم',

            'create role' => 'إنشاء الصلاحيات',
            'read role' => 'قراءة الصلاحيات',
            'update role' => 'تحديث الصلاحيات',
            'delete role' => 'حذف الصلاحيات',

            'create party' => 'إنشاء الحفله',
            'read party' => 'قراءة الحفله',
            'update party' => 'تحديث الحفله',
            'delete party' => 'حذف الحفله',

            'create rent' => 'إنشاء الإيجار',
            'read rent' => 'قراءة الإيجار',
            'update rent' => 'تحديث الإيجار',
            'delete rent' => 'حذف الإيجار',
        ];
    }

    public function index(Request $request)
    {
        try {
            $rules = [
                'q' => 'nullable|string',
                'date_from' => 'nullable|date',
                'date_to' => 'nullable|date',
            ];

            $messages = [
                'q.string' => 'الاسم غير صالح.',
                'date_from.date' => 'تاريخ "من" غير صالح.',
                'date_to.date' => 'تاريخ "إلى" غير صالح.',
            ];

            $validatedData = $request->validate($rules, $messages);
            $roles = Role::query();
            if ($request->filled('q')) {
                $roles->where('name', 'LIKE', '%' . $request->input('q') . '%');
            }

            if ($request->filled('date_from')) {
                $roles->whereDate('updated_at', '>=', $request->input('date_from'));
            }

            if ($request->filled('date_to')) {
                $roles->whereDate('updated_at', '<=', $request->input('date_to'));
            }
            $roles = $roles->with('permissions')->paginate(PAGINATION);
            $permissions = collect($this->translated_permissions)->map(function ($translation, $permission) {
                return [
                    'name' => $translation,
                    'org' => $permission
                ];
            })->values();

            return view('pages.roles.index', compact('roles', 'permissions'));
        } catch (\Exception $e) {
            Log::error('حدث خطأ أثناء جلب الصلاحيات: ' . $e->getMessage());

            return redirect()->back()->with(['error' => 'حدث خطأ أثناء جلب الصلاحيات. يرجى المحاولة مرة أخرى.']);
        }
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:roles,name',
            'permissions' => 'required|array',
        ], [
            'name.required' => 'حقل الاسم مطلوب.',
            'name.unique' => 'هذا الاسم مستخدم بالفعل.',
            'permissions.required' => 'يجب تحديد الصلاحيات المرتبطة.',
            'permissions.array' => 'يجب أن تكون الصلاحيات مصفوفة.',
        ]);

        if ($validator->fails()) {
            $errorMessages = $validator->errors()->messages();
            $firstError = reset($errorMessages);
            return redirect()->back()->withInput($request->all())->with(['error' => $firstError[0]]);
        }
        try {
            DB::beginTransaction();

            $role = Role::create(['name' => $request->input('name')]);
            $role->syncPermissions($request->input('permissions'));

            DB::commit();

            return redirect()->route('role.all')->with(['success' => 'تم إنشاء الصلاحية ' . $request->input('name') . ' بنجاح.']);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('حدث خطأ أثناء انشاء الصلاحية: ' . $e->getMessage());
            return redirect()->back()->withInput($request->all())->with(['error' => 'حدث خطأ أثناء انشاء الصلاحية. يرجى المحاولة مرة أخرى.']);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:roles,name,' . $id,
            'permissions' => 'required|array',
        ], [
            'name.required' => 'حقل الاسم مطلوب.',
            'name.unique' => 'هذا الاسم مستخدم بالفعل.',
            'permissions.required' => 'يجب تحديد الصلاحيات المرتبطة.',
            'permissions.array' => 'يجب أن تكون الصلاحيات مصفوفة.',
        ]);

        if ($validator->fails()) {
            $errorMessages = $validator->errors()->messages();
            $firstError = reset($errorMessages);
            return redirect()->back()->withInput($request->all())->with(['error' => $firstError[0]]);
        }

        try {
            DB::beginTransaction();

            $role = Role::findOrFail($id);
            $role->update(['name' => $request->input('name')]);
            $role->syncPermissions($request->input('permissions'));

            DB::commit();

            return redirect()->route('role.all')->with(['success' => 'تم تحديث الصلاحية بنجاح.']);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('حدث خطأ أثناء تحديث الصلاحية: ' . $e->getMessage());

            return redirect()->back()->withInput($request->all())->with(['error' => 'حدث خطأ أثناء تحديث الصلاحية. يرجى المحاولة مرة أخرى.']);
        }
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $role = Role::findOrFail($id);
            $role->delete();

            return redirect()->route('role.all')->with(['success' => 'تم حذف الصلاحية بنجاح.']);
        } catch (\Exception $e) {
            Log::error('حدث خطأ أثناء حذف الصلاحية: ' . $e->getMessage());

            return redirect()->back()->with(['error' => 'حدث خطأ أثناء حذف الصلاحية. يرجى المحاولة مرة أخرى.']);
        }
    }
}
