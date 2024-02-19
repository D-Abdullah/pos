<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function loginView()
    {
        if (Auth::check())
            redirect(RouteServiceProvider::HOME);
        return view('auth.login');
    }

    public function login(LoginRequest $request)
    {
        try {
            DB::beginTransaction();
            $remember = $request->has('remember');
            $credentials = $request->only('email', 'password');
            if (Auth::attempt($credentials, $remember)) {
                DB::commit();
                Log::info('تم تسجيل الدخول: ' . $credentials['email']);
                $request->session()->regenerate();
                return redirect()->intended(RouteServiceProvider::HOME)
                    ->with(['success' => 'تم تسجيل الدخول بنجاح']);
            } else {
                DB::rollBack();
                Log::warning('فشل تسجيل الدخول: ' . $credentials['email']);
                return redirect()->back()->with(['error' => 'بيانات الدخول غير صحيحة']);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('فشل عملية الدخول: ' . $e->getMessage());
            return redirect()->back()->with(['error' => 'حدث خطأ ما. يرجى المحاولة مرة أخرى.']);
        }
    }

    public function logout()
    {
        try {
            $user = Auth::user();

            Auth::logout();

            Log::info('تم تسجيل الخروج: ' . ($user ? $user['email'] : 'Unknown User'));

            return redirect()->route('login')->with(['success' => 'تم تسجيل الخروج بنجاح']);
        } catch (\Exception $e) {
            Log::error('فشل تسجيل الخروج: ' . $e->getMessage());

            return redirect()->back()->with(['error' => 'حدث خطأ أثناء تسجيل الخروج.']);
        }
    }

    public function profileView()
    {
        return view('auth.profile');
    }

    public function profileUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email',
            'phone' => ['required', 'regex:/^[0-9+\-]+$/'],
        ], [
            'name.required' => 'حقل الاسم مطلوب.',
            'name.string' => 'يجب أن يكون الاسم نصًا.',
            'email.required' => 'حقل البريد الإلكتروني مطلوب.',
            'email.email' => 'يجب أن يكون البريد الإلكتروني صالحًا.',
            'phone.required' => 'حقل رقم الهاتف مطلوب.',
            'phone.regex' => 'يجب أن يكون رقم الهاتف صالحًا.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($validator)->with(['error'=> 'تحقق من بياناتك اولا ثم قم بإعاده المحاوله مره اخرى']);
        }
        try {
            DB::beginTransaction();

            auth()->user()->update([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'phone' => $request->input('phone'),
            ]);

            DB::commit();

            return redirect()->route('profile')->with('success', 'تم تحديث الملف الشخصي بنجاح.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating profile: ' . $e->getMessage());

            return redirect()->back()->withInput()->with('error', 'حدث خطأ أثناء تحديث الملف الشخصي. يرجى المحاولة مرة أخرى.');
        }
    }

    public function profilePasswordUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' =>  ['required', function ($attribute, $value, $fail) {
                if (!Hash::check($value, auth()->user()->password)) {
                    return $fail(__('كلمه المرور الحاليه غير صحيحه يرجى المحاوله مره اخرى'));
                }
            }],
            'password' => ['required', 'confirmed', 'min:8'],
        ], [
            'current_password.required' => 'حقل كلمة المرور الحالية مطلوب.',
            'current_password.password' => 'كلمة المرور الحالية غير صحيحة.',
            'password.required' => 'حقل كلمة المرور الجديدة مطلوب.',
            'password.confirmed' => 'تأكيد كلمة المرور غير متطابق.',
            'password.min' => 'يجب أن تكون كلمة المرور الجديدة على الأقل 8 أحرف.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput($request->all())->withErrors($validator)->with(['error'=> 'تحقق من بياناتك اولا ثم قم بإعاده المحاوله مره اخرى']);
        }
        try {
            DB::beginTransaction();

            auth()->user()->update([
                'password' => Hash::make($request->input('password')),
            ]);

            DB::commit();

        return redirect()->route('profile')->with('success', 'تم تحديث كلمة المرور بنجاح.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating password: ' . $e->getMessage());

            return redirect()->back()->withInput()->with('error', 'حدث خطأ أثناء تحديث كلمة المرور. يرجى المحاولة مرة أخرى.');
        }
    }

}
