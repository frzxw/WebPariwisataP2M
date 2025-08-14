<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    private AuthService $authService;

    public function __construct(AuthService $authService) 
    {
        $this->authService = $authService;
    }

    /**
     * Show login form
     */
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->intended('/');
        }
        
        return view('auth.login');
    }

    /**
     * Handle login form submission
     */
    public function login(LoginRequest $request)
    {
        try {
            $credentials = $request->only('email', 'password');
            
            if (Auth::attempt($credentials, $request->boolean('remember'))) {
                $request->session()->regenerate();
                
                return redirect()
                    ->intended('/')
                    ->with('success', 'Berhasil masuk! Selamat datang kembali.');
            }

            throw ValidationException::withMessages([
                'email' => 'Email atau password yang Anda masukkan salah.',
            ]);

        } catch (ValidationException $e) {
            return back()
                ->withErrors($e->errors())
                ->withInput($request->except('password'));
        } catch (\Exception $e) {
            return back()
                ->withErrors(['email' => 'Terjadi kesalahan saat login. Silakan coba lagi.'])
                ->withInput($request->except('password'));
        }
    }

    /**
     * Show registration form
     */
    public function showRegisterForm()
    {
        if (Auth::check()) {
            return redirect()->intended('/');
        }
        
        return view('auth.register');
    }

    /**
     * Handle registration form submission
     */
    public function register(RegisterRequest $request)
    {
        try {
            $user = $this->authService->register($request->validated());
            
            Auth::login($user);
            
            return redirect('/')
                ->with('success', 'Pendaftaran berhasil! Selamat datang di Web Pariwisata.');
                
        } catch (\Exception $e) {
            return back()
                ->withErrors(['email' => 'Terjadi kesalahan saat mendaftar. ' . $e->getMessage()])
                ->withInput($request->except('password', 'password_confirmation'));
        }
    }

    /**
     * Handle logout
     */
    public function logout(Request $request)
    {
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/')
            ->with('success', 'Anda telah berhasil keluar.');
    }
}
