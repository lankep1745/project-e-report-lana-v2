@component('layouts.app', ['title' => 'Masuk - LaporinYuk!'])
<div class="max-w-md mx-auto my-8">
    <div class="bg-white border-2 border-slate-900 rounded-3xl p-6 sm:p-8 neo-shadow-static relative overflow-hidden">
        
        <!-- Playful Badge Decoration -->
        <div class="absolute -right-8 -top-8 w-24 h-24 bg-yellow-300 rounded-full border-2 border-slate-900 flex items-end justify-start p-3 -rotate-12 opacity-80">
            <span class="text-xl">✨</span>
        </div>

        <div class="text-center mb-6">
            <div class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-purple-100 border-2 border-slate-900 mb-3 shadow-[2px_2px_0px_0px_rgba(15,23,42,1)]">
                <span class="text-2xl">🔐</span>
            </div>
            <h1 class="font-heading font-extrabold text-2xl sm:text-3xl text-slate-900">Masuk Akun</h1>
            <p class="text-xs sm:text-sm font-semibold text-slate-600 mt-1">Sampaikan laporan dan pantau tindak lanjut secara real-time</p>
        </div>

        <!-- Quick Demo Credentials Box -->
        <div class="mb-6 p-3 rounded-2xl bg-amber-50 border-2 border-slate-900 text-xs text-slate-700 space-y-1">
            <p class="font-extrabold text-amber-950 flex items-center gap-1">
                <span>💡</span> Akun Demo Cepat:
            </p>
            <div class="flex justify-between items-center bg-white p-1.5 rounded-xl border border-slate-300">
                <span>👤 <strong>User:</strong> user@ereport.test</span>
                <span class="text-slate-500 font-mono">password</span>
            </div>
            <div class="flex justify-between items-center bg-white p-1.5 rounded-xl border border-slate-300">
                <span>⚡ <strong>Admin:</strong> admin@ereport.test</span>
                <span class="text-slate-500 font-mono">password</span>
            </div>
        </div>

        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf

            <!-- Email -->
            <div>
                <label for="email" class="block font-bold text-xs uppercase tracking-wider text-slate-800 mb-1">
                    Email Pengguna
                </label>
                <input type="email" 
                       id="email" 
                       name="email" 
                       value="{{ old('email') }}"
                       required 
                       placeholder="nama@email.com"
                       class="w-full px-4 py-2.5 rounded-2xl border-2 border-slate-900 bg-slate-50 text-slate-900 font-medium focus:outline-none focus:bg-white focus:ring-2 focus:ring-purple-500 transition shadow-[2px_2px_0px_0px_rgba(15,23,42,1)] @error('email') border-rose-500 @enderror">
                @error('email')
                    <p class="text-xs font-bold text-rose-600 mt-1.5 flex items-center gap-1">❌ {{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block font-bold text-xs uppercase tracking-wider text-slate-800 mb-1">
                    Kata Sandi
                </label>
                <input type="password" 
                       id="password" 
                       name="password" 
                       required 
                       placeholder="••••••••"
                       class="w-full px-4 py-2.5 rounded-2xl border-2 border-slate-900 bg-slate-50 text-slate-900 font-medium focus:outline-none focus:bg-white focus:ring-2 focus:ring-purple-500 transition shadow-[2px_2px_0px_0px_rgba(15,23,42,1)] @error('password') border-rose-500 @enderror">
                @error('password')
                    <p class="text-xs font-bold text-rose-600 mt-1.5 flex items-center gap-1">❌ {{ $message }}</p>
                @enderror
            </div>

            <!-- Remember Me -->
            <div class="flex items-center justify-between text-xs font-bold text-slate-700">
                <label class="flex items-center gap-2 cursor-pointer select-none">
                    <input type="checkbox" name="remember" class="w-4 h-4 rounded border-2 border-slate-900 text-purple-600 focus:ring-0">
                    Ingat Saya
                </label>
            </div>

            <!-- Submit Button -->
            <button type="submit" 
                    class="w-full py-3 rounded-2xl bg-yellow-400 hover:bg-yellow-300 font-heading font-bold text-base text-slate-900 border-2 border-slate-900 neo-shadow cursor-pointer transition">
                Masuk Sekarang 🚀
            </button>
        </form>

        <div class="mt-6 text-center text-xs font-semibold text-slate-600">
            Belum punya akun pelapor? 
            <a href="{{ route('register') }}" class="font-bold text-purple-600 underline hover:text-purple-800">
                Daftar Akun Baru
            </a>
        </div>
    </div>
</div>
@endcomponent
