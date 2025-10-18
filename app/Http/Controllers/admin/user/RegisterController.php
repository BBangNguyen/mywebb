<?php

namespace App\Http\Controllers\admin\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;

class RegisterController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;
    
    public function index(){
        return view('admin.user.register', [
            'title' => 'Đăng ký tài khoản'
        ]); 
    }

    public function store(Request $request){
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ], [
            'name.required' => 'Vui lòng nhập họ và tên',
            'email.required' => 'Vui lòng nhập email',
            'email.email' => 'Email không đúng định dạng',
            'email.unique' => 'Email đã được sử dụng',
            'password.required' => 'Vui lòng nhập mật khẩu',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự',
            'password.confirmed' => 'Xác nhận mật khẩu không khớp',
        ]);

        try {
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            return redirect()->route('login')->with('success', 'Đăng ký thành công! Vui lòng đăng nhập.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Đăng ký thất bại: ' . $e->getMessage())
                ->withInput();
        }
    }
}
