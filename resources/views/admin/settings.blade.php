@extends('layouts.app')

@section('title', 'Site Settings')

@section('content')
<div class="space-y-6">
    <div class="app-card p-6">
        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-xl text-sm font-bold">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('admin.settings.update') }}" method="POST" class="space-y-6" enctype="multipart/form-data">
            @csrf

            <div class="border-b border-gray-100 pb-4">
                <h3 class="text-sm font-black uppercase tracking-widest text-gray-800">General Settings</h3>
            </div>

            <div class="mb-6 flex items-center space-x-4">
                <div class="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center overflow-hidden border border-gray-100">
                    @if($logo = \App\Models\Setting::get('logo'))
                        <img src="{{ asset('storage/' . $logo) }}" class="w-full h-full object-contain" alt="Logo">
                    @else
                        <i class="fas fa-image text-gray-300"></i>
                    @endif
                </div>
                <div class="flex-1">
                    <label class="block text-gray-400 text-xs font-bold mb-2 uppercase tracking-widest">Site Logo</label>
                    <input type="file" name="logo" class="text-xs text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-black file:text-white hover:file:bg-gray-800">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-400 text-xs font-bold mb-2 uppercase tracking-widest">Site Name</label>
                    <input type="text" name="site_name" value="{{ \App\Models\Setting::get('site_name', 'Recruitment Platform') }}" class="w-full p-4 bg-gray-50 rounded-2xl focus:outline-none focus:ring-2 focus:ring-black">
                </div>
                <div>
                    <label class="block text-gray-400 text-xs font-bold mb-2 uppercase tracking-widest">Currency Symbol</label>
                    <input type="text" name="currency" value="{{ \App\Models\Setting::get('currency', '$') }}" class="w-full p-4 bg-gray-50 rounded-2xl focus:outline-none focus:ring-2 focus:ring-black">
                </div>
            </div>

            <div class="border-b border-gray-100 pb-4 pt-4">
                <h3 class="text-sm font-black uppercase tracking-widest text-gray-800">Financial Settings</h3>
            </div>

            <div>
                <label class="block text-gray-400 text-xs font-bold mb-2 uppercase tracking-widest">Referral Commission (%)</label>
                <input type="number" name="commission_percentage" value="{{ \App\Models\Setting::get('commission_percentage', 10) }}" class="w-full p-4 bg-gray-50 rounded-2xl focus:outline-none focus:ring-2 focus:ring-black" step="0.01">
            </div>

            <div class="border-b border-gray-100 pb-4 pt-4">
                <h3 class="text-sm font-black uppercase tracking-widest text-gray-800">SMTP Configuration</h3>
                <p class="text-[10px] text-gray-400 mt-1">Changes here will update your .env file</p>
            </div>

            <div class="space-y-4">
                <div>
                    <label class="block text-gray-400 text-xs font-bold mb-2 uppercase tracking-widest">SMTP Host</label>
                    <input type="text" name="smtp_host" value="{{ config('mail.mailers.smtp.host') }}" class="w-full p-4 bg-gray-50 rounded-2xl focus:outline-none focus:ring-2 focus:ring-black">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-400 text-xs font-bold mb-2 uppercase tracking-widest">SMTP Port</label>
                        <input type="text" name="smtp_port" value="{{ config('mail.mailers.smtp.port') }}" class="w-full p-4 bg-gray-50 rounded-2xl focus:outline-none focus:ring-2 focus:ring-black">
                    </div>
                    <div>
                        <label class="block text-gray-400 text-xs font-bold mb-2 uppercase tracking-widest">Encryption</label>
                        <input type="text" name="smtp_encryption" value="{{ config('mail.mailers.smtp.encryption') }}" class="w-full p-4 bg-gray-50 rounded-2xl focus:outline-none focus:ring-2 focus:ring-black">
                    </div>
                </div>
                <div>
                    <label class="block text-gray-400 text-xs font-bold mb-2 uppercase tracking-widest">SMTP Username</label>
                    <input type="text" name="smtp_username" value="{{ config('mail.mailers.smtp.username') }}" class="w-full p-4 bg-gray-50 rounded-2xl focus:outline-none focus:ring-2 focus:ring-black">
                </div>
                <div>
                    <label class="block text-gray-400 text-xs font-bold mb-2 uppercase tracking-widest">SMTP Password</label>
                    <input type="password" name="smtp_password" value="********" class="w-full p-4 bg-gray-50 rounded-2xl focus:outline-none focus:ring-2 focus:ring-black">
                </div>
            </div>

            <button type="submit" class="w-full bg-black text-white py-4 rounded-2xl font-bold flex justify-between items-center px-8 group">
                <span>Save Settings</span>
                <i class="fas fa-save transition-transform group-hover:scale-110"></i>
            </button>
        </form>
    </div>
</div>
@endsection
