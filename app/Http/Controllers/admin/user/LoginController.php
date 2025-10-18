<?php

namespace App\Http\Controllers\admin\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;

class LoginController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;
    public function index(){
        return view('admin.user.login', [
            'title' => 'Đăng nhập hệ thống'
        ]); 
    }
    public function store(Request $request){
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if(Auth::attempt([
            'email' => $request->email,
            'password' => $request->password,
        ], $request->remember)){
            $request->session()->regenerate();
            
            // Kiểm tra role và điều hướng
            if(Auth::user()->role === 'admin'){
                return redirect()->route('admin')->with('success', 'Chào mừng Admin!');
            }
            
            // User thường → trang sản phẩm
            return redirect()->route('products.index')->with('success', 'Đăng nhập thành công!');
        }
        return redirect()->back()->with('error', 'Email hoặc mật khẩu không đúng!');
    }

    public function logout(Request $request){
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('login')->with('success', 'Đã đăng xuất thành công!');
    }
}
