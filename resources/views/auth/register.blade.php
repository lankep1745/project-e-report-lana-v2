@component('layouts.app', ['title' => 'Daftar Akun - LaporinYuk!'])
<div class="max-w-md mx-auto my-8">
    <div class="bg-white border-2 border-slate-900 rounded-3xl p-6 sm:p-8 neo-shadow-static relative overflow-hidden">
        
        <!-- Decoration -->
        <div class="absolute -right-8 -top-8 w-24 h-24 bg-purple-200 rounded-full border-2 border-slate-900 flex items-end justify-start p-3 -rotate-12 opacity-80">
            <span class="text-xl">🌟</span>
        </div>

        <div class="text-center mb-6">
            <div class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-yellow-200 border-2 border-slate-900 mb-3 shadow-[2px_2px_0px_0px_rgba(15,23,42,1)]">
                <span class="text-2xl">📝</span>
            </div>
            <h1 class="font-heading font-extrabold text-2xl sm:text-3xl text-slate-900">Daftar Akun</h1>
            <p class="text-xs sm:text-sm font-semibold text-slate-600 mt-1">Bergabung bersama warga cerdas, laporkan demi perubahan!</p>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf

            <!-- Name -->
            <div>
                <label for="name" class="block font-bold text-xs uppercase tracking-wider text-slate-800 mb-1">
                    Nama Lengkap
                </label>
                <input type="text" 
                       id="name" 
                       name="name" 
                       value="{{ old('name') }}"
                       required 
                       placeholder="Contoh: Budi Santoso"
                       class="w-full px-4 py-2.5 rounded-2xl border-2 border-slate-900 bg-slate-50 text-slate-900 font-medium focus:outline-none focus:bg-white focus:ring-2 focus:ring-purple-500 transition shadow-[2px_2px_0px_0px_rgba(15,23,42,1)] @error('name') border-rose-500 @enderror">
                @error('name')
                    <p class="text-xs font-bold text-rose-600 mt-1.5 flex items-center gap-1">❌ {{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block font-bold text-xs uppercase tracking-wider text-slate-800 mb-1">
                    Alamat Email
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
                    Kata Sandi (Minimal 6 Karakter)
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

            <!-- Password Confirmation -->
            <div>
                <label for="password_confirmation" class="block font-bold text-xs uppercase tracking-wider text-slate-800 mb-1">
                    Ulangi Kata Sandi
                </label>
                <input type="password" 
                       id="password_confirmation" 
                       name="password_confirmation" 
                       required 
                       placeholder="••••••••"
                       class="w-full px-4 py-2.5 rounded-2xl border-2 border-slate-900 bg-slate-50 text-slate-900 font-medium focus:outline-none focus:bg-white focus:ring-2 focus:ring-purple-500 transition shadow-[2px_2px_0px_0px_rgba(15,23,42,1)]">
            </div>

            <!-- Submit Button -->
            <button type="submit" 
                    class="w-full py-3 rounded-2xl bg-purple-600 hover:bg-purple-700 font-heading font-bold text-base text-white border-2 border-slate-900 neo-shadow cursor-pointer transition">
                Daftar & Mulai Lapor! 🎉
            </button>
        </form>

        <div class="mt-6 text-center text-xs font-semibold text-slate-600">
            Sudah memiliki akun? 
            <a href="{{ route('login') }}" class="font-bold text-purple-600 underline hover:text-purple-800">
                Masuk di sini
            </a>
        </div>
    </div>
</div>
@endcomponent
