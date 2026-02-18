<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Otp;
use App\Mail\OtpMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;

class AuthController extends Controller
{
    public function showRegister(Request $request)
    {
        $ref = $request->query('ref');
        return view('auth.register', compact('ref'));
    }

    public function register(Request $request)
    {
        $request->validate([
            'phone' => 'required|string|unique:users',
            'email' => 'required|email|unique:users',
            'username' => 'required|string|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'referral_code' => 'nullable|string|exists:users,referral_code',
        ]);

        $referred_by = null;
        if ($request->referral_code) {
            $referrer = User::where('referral_code', $request->referral_code)->first();
            if ($referrer) {
                $referred_by = $referrer->id;
            }
        }

        $user = User::create([
            'name' => $request->username, // Using username as name for simplicity
            'email' => $request->email,
            'phone' => $request->phone,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'referral_code' => strtoupper(Str::random(8)),
            'referred_by' => $referred_by,
            'is_verified' => false,
        ]);

        $this->sendOtp($user);

        return redirect()->route('verify.show', ['email' => $user->email]);
    }

    public function showVerify(Request $request)
    {
        $email = $request->query('email');
        return view('auth.verify', compact('email'));
    }

    public function verify(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'otp' => 'required|string|size:6',
        ]);

        $user = User::where('email', $request->email)->first();
        $otpRecord = Otp::where('user_id', $user->id)
            ->where('expires_at', '>', Carbon::now())
            ->latest()
            ->first();

        if (!$otpRecord || !Hash::check($request->otp, $otpRecord->code)) {
            if ($otpRecord) {
                $otpRecord->increment('attempts');
            }
            return back()->withErrors(['otp' => 'Invalid or expired OTP.']);
        }

        if ($otpRecord->attempts >= 5) {
             return back()->withErrors(['otp' => 'Too many failed attempts. Please request a new OTP.']);
        }

        $user->is_verified = true;
        $user->save();

        // Invalidate OTP
        $otpRecord->delete();

        // Send Welcome Email (TBD)

        Auth::login($user);

        return redirect()->route('dashboard');
    }

    public function resendOtp(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);
        $user = User::where('email', $request->email)->first();

        $lastOtp = Otp::where('user_id', $user->id)->latest()->first();
        if ($lastOtp && $lastOtp->last_sent_at && $lastOtp->last_sent_at->addSeconds(60)->isFuture()) {
            return back()->withErrors(['otp' => 'Please wait before requesting another OTP.']);
        }

        if ($lastOtp && $lastOtp->resend_attempts >= 5) {
             return back()->withErrors(['otp' => 'Maximum resend attempts reached.']);
        }

        $this->sendOtp($user, $lastOtp ? $lastOtp->resend_attempts + 1 : 0);

        return back()->with('success', 'OTP sent to your email.');
    }

    protected function sendOtp($user, $resendAttempts = 0)
    {
        $otp = sprintf("%06d", mt_rand(1, 999999));

        Otp::create([
            'user_id' => $user->id,
            'code' => Hash::make($otp),
            'expires_at' => Carbon::now()->addMinutes(10),
            'last_sent_at' => Carbon::now(),
            'resend_attempts' => $resendAttempts,
        ]);

        Mail::to($user->email)->send(new OtpMail($otp));
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'login' => 'required|string', // can be email or phone or username
            'password' => 'required|string',
        ]);

        $loginType = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : (is_numeric($request->login) ? 'phone' : 'username');

        if (Auth::attempt([$loginType => $request->login, 'password' => $request->password])) {
            $user = Auth::user();
            if (!$user->is_verified) {
                Auth::logout();
                return redirect()->route('verify.show', ['email' => $user->email])->withErrors(['otp' => 'Account not verified. Please enter OTP.']);
            }
            if ($user->status === 'suspended') {
                Auth::logout();
                return back()->withErrors(['login' => 'Your account has been suspended.']);
            }
            $request->session()->regenerate();
            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'login' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
