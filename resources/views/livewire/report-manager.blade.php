<div class="space-y-8">
    <!-- Header Welcome Banner -->
    <div class="relative overflow-hidden bg-gradient-to-r from-purple-600 via-purple-700 to-indigo-700 rounded-3xl border-2 border-slate-900 p-6 sm:p-8 neo-shadow-static text-white">
        <div class="relative z-10 max-w-2xl">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-yellow-400 text-slate-900 font-bold text-xs border-2 border-slate-900 shadow-[2px_2px_0px_0px_rgba(15,23,42,1)] mb-3">
                ✨ Suara Anda Menentukan Perubahan
            </span>
            <h1 class="font-heading font-black text-2xl sm:text-4xl tracking-tight leading-tight">
                Halo, {{ auth()->user()->name }}! 👋
            </h1>
            <p class="mt-2 text-purple-100 text-sm sm:text-base font-medium">
                Ada jalan berlubang, lampu mati, atau fasilitas rusak? Laporkan langsung di form sebelah kiri, dan pantau respons petugas secara transparan!
            </p>
        </div>

        <!-- Floating playful stickers -->
        <div class="absolute -right-4 -bottom-6 text-7xl sm:text-9xl opacity-20 select-none pointer-events-none transform rotate-12">
            🚀
        </div>
    </div>

    <!-- Flash message on submission -->
    @if (session()->has('message'))
        <div class="p-4 rounded-3xl bg-emerald-100 border-2 border-slate-900 neo-shadow flex items-center justify-between transition-all">
            <div class="flex items-center gap-3">
                <span class="text-3xl">🎉</span>
                <p class="font-bold text-emerald-950 text-sm sm:text-base">{{ session('message') }}</p>
            </div>
            <button type="button" @click="$el.parentElement.remove()" class="text-slate-600 hover:text-slate-900 font-bold px-2 py-1 text-sm cursor-pointer">
                ✕
            </button>
        </div>
    @endif

    <!-- SPLIT VIEW LAYOUT -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        
        <!-- ============================================== -->
        <!-- KOLOM KIRI: FORM BUAT LAPORAN (LIVEWIRE REAL-TIME) -->
        <!-- ============================================== -->
        <div class="lg:col-span-5 bg-white border-2 border-slate-900 rounded-3xl p-6 sm:p-7 neo-shadow-static relative">
            
            <div class="flex items-center justify-between pb-4 border-b-2 border-slate-100 mb-5">
                <div class="flex items-center gap-2.5">
                    <div class="w-10 h-10 rounded-2xl bg-yellow-400 border-2 border-slate-900 flex items-center justify-center font-black text-lg shadow-[2px_2px_0px_0px_rgba(15,23,42,1)]">
                        ✍️
                    </div>
                    <div>
                        <h2 class="font-heading font-extrabold text-xl text-slate-900">Buat Laporan Baru</h2>
                        <p class="text-xs text-slate-500 font-medium">Isi detail keluhan Anda dengan lengkap</p>
                    </div>
                </div>
                <span class="px-2.5 py-1 rounded-full bg-purple-100 text-purple-700 border border-purple-300 text-[11px] font-extrabold">
                    Real-time
                </span>
            </div>

            <form wire:submit.prevent="submitReport" class="space-y-5">
                <!-- Judul Laporan -->
                <div>
                    <label class="block font-bold text-xs uppercase tracking-wider text-slate-800 mb-1.5">
                        Judul Laporan <span class="text-rose-500">*</span>
                    </label>
                    <input type="text" 
                           wire:model.defer="title"
                           placeholder="Contoh: Lampu taman padam di dekat pos satpam"
                           class="w-full px-4 py-2.5 rounded-2xl border-2 border-slate-900 bg-slate-50 text-slate-900 font-medium text-sm focus:outline-none focus:bg-white focus:ring-2 focus:ring-purple-500 transition shadow-[2px_2px_0px_0px_rgba(15,23,42,1)] @error('title') border-rose-500 @enderror">
                    @error('title')
                        <p class="text-xs font-bold text-rose-600 mt-1.5 flex items-center gap-1">❌ {{ $message }}</p>
                    @enderror
                </div>

                <!-- Tombol Pil Interaktif: Kategori -->
                <div>
                    <label class="block font-bold text-xs uppercase tracking-wider text-slate-800 mb-2">
                        Pilih Kategori <span class="text-rose-500">*</span>
                    </label>
                    <div class="flex flex-wrap gap-2">
                        @foreach($categories as $cat)
                            <button type="button" 
                                    wire:click="selectCategory('{{ $cat }}')"
                                    class="px-3.5 py-1.5 rounded-full text-xs font-bold border-2 transition-all cursor-pointer flex items-center gap-1.5
                                    {{ $category === $cat 
                                        ? 'bg-purple-600 text-white border-slate-900 shadow-[3px_3px_0px_0px_rgba(15,23,42,1)] -translate-y-0.5' 
                                        : 'bg-white text-slate-700 border-slate-300 hover:border-slate-900 hover:bg-slate-50' }}">
                                <span>
                                    @if($cat === 'Fasilitas') 🏢 
                                    @elseif($cat === 'Kebersihan') 🧹 
                                    @elseif($cat === 'Keamanan') 🛡️ 
                                    @elseif($cat === 'Layanan') 💁 
                                    @else 📦 @endif
                                </span>
                                {{ $cat }}
                            </button>
                        @endforeach
                    </div>
                    @error('category')
                        <p class="text-xs font-bold text-rose-600 mt-1.5 flex items-center gap-1">❌ {{ $message }}</p>
                    @enderror
                </div>

                <!-- Deskripsi Laporan -->
                <div>
                    <label class="block font-bold text-xs uppercase tracking-wider text-slate-800 mb-1.5">
                        Deskripsi Lengkap <span class="text-rose-500">*</span>
                    </label>
                    <textarea wire:model.defer="description"
                              rows="4"
                              placeholder="Ceritakan detail lokasi, waktu kejadian, atau kronologi yang jelas agar petugas cepat bertindak..."
                              class="w-full px-4 py-2.5 rounded-2xl border-2 border-slate-900 bg-slate-50 text-slate-900 font-medium text-sm focus:outline-none focus:bg-white focus:ring-2 focus:ring-purple-500 transition shadow-[2px_2px_0px_0px_rgba(15,23,42,1)] @error('description') border-rose-500 @enderror"></textarea>
                    @error('description')
                        <p class="text-xs font-bold text-rose-600 mt-1.5 flex items-center gap-1">❌ {{ $message }}</p>
                    @enderror
                </div>

                <!-- Upload Foto Bukti (Private Disk) -->
                <div>
                    <label class="block font-bold text-xs uppercase tracking-wider text-slate-800 mb-1.5">
                        Unggah Bukti Foto <span class="text-slate-400 font-normal">(Opsional, Maks 2MB)</span>
                    </label>
                    
                    <div class="relative border-2 border-dashed border-slate-400 hover:border-slate-900 rounded-2xl p-4 bg-slate-50 text-center transition">
                        <input type="file" 
                               wire:model="evidence" 
                               id="evidence" 
                               accept="image/png,image/jpeg,image/jpg,image/webp"
                               class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                        
                        <div class="flex flex-col items-center justify-center pointer-events-none">
                            <span class="text-3xl mb-1">📸</span>
                            <p class="text-xs font-bold text-slate-800">
                                @if($evidence)
                                    <span class="text-purple-600">File dipilih: {{ $evidence->getClientOriginalName() }}</span>
                                @else
                                    Klik atau seret foto bukti ke sini
                                @endif
                            </p>
                            <p class="text-[10px] text-slate-500 mt-0.5">JPG, JPEG, PNG, WEBP (Privat & Aman)</p>
                        </div>
                    </div>

                    <!-- Uploading indicator -->
                    <div wire:loading wire:target="evidence" class="text-xs font-bold text-purple-600 mt-2 flex items-center gap-1.5">
                        <span class="animate-spin text-sm">⏳</span> Mengunggah foto bukti...
                    </div>

                    <!-- Evidence Preview -->
                    @if ($evidence)
                        <div class="mt-3 p-2 border-2 border-slate-900 rounded-2xl bg-white shadow-[2px_2px_0px_0px_rgba(15,23,42,1)] flex items-center gap-3">
                            <img src="{{ $evidence->temporaryUrl() }}" class="w-16 h-16 object-cover rounded-xl border border-slate-300">
                            <div class="text-xs truncate">
                                <p class="font-bold text-slate-900 truncate">{{ $evidence->getClientOriginalName() }}</p>
                                <span class="text-[10px] text-emerald-600 font-bold">Siap diunggah ke storage privat</span>
                            </div>
                        </div>
                    @endif

                    @error('evidence')
                        <p class="text-xs font-bold text-rose-600 mt-1.5 flex items-center gap-1">❌ {{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <button type="submit" 
                        wire:loading.attr="disabled"
                        class="w-full py-3.5 rounded-2xl bg-yellow-400 hover:bg-yellow-300 font-heading font-extrabold text-base text-slate-900 border-2 border-slate-900 neo-shadow cursor-pointer transition flex items-center justify-center gap-2 disabled:opacity-50">
                    <span wire:loading.remove wire:target="submitReport">Kirim Laporan Sekarang 🚀</span>
                    <span wire:loading wire:target="submitReport" class="flex items-center gap-2">
                        <span class="animate-spin">⏳</span> Menyimpan Laporan...
                    </span>
                </button>
            </form>
        </div>


        <!-- ============================================== -->
        <!-- KOLOM KANAN: FEED & PELACAKAN LAPORAN REAL-TIME -->
        <!-- ============================================== -->
        <div class="lg:col-span-7 space-y-5">
            
            <!-- Controls Bar: Filter Status, Scope, & Search -->
            <div class="bg-white border-2 border-slate-900 rounded-3xl p-5 neo-shadow-static space-y-4">
                
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <!-- Scope Switcher: Semua vs Milik Saya -->
                    <div class="inline-flex p-1 rounded-2xl bg-slate-100 border-2 border-slate-900 shadow-[2px_2px_0px_0px_rgba(15,23,42,1)]">
                        <button type="button" 
                                wire:click="setScope('all')" 
                                class="px-3.5 py-1.5 rounded-xl text-xs font-extrabold transition-all cursor-pointer {{ $scope === 'all' ? 'bg-purple-600 text-white shadow-sm' : 'text-slate-600 hover:text-slate-900' }}">
                            🌐 Semua Laporan
                        </button>
                        <button type="button" 
                                wire:click="setScope('my')" 
                                class="px-3.5 py-1.5 rounded-xl text-xs font-extrabold transition-all cursor-pointer {{ $scope === 'my' ? 'bg-purple-600 text-white shadow-sm' : 'text-slate-600 hover:text-slate-900' }}">
                            👤 Laporan Saya
                        </button>
                    </div>

                    <!-- Search Input -->
                    <div class="relative flex-1 sm:max-w-xs">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400 text-sm">
                            🔍
                        </span>
                        <input type="text" 
                               wire:model.live.debounce.300ms="search"
                               placeholder="Cari kata kunci laporan..."
                               class="w-full pl-9 pr-4 py-2 rounded-2xl border-2 border-slate-900 bg-slate-50 text-xs font-medium focus:outline-none focus:bg-white focus:ring-2 focus:ring-purple-500 transition shadow-[2px_2px_0px_0px_rgba(15,23,42,1)]">
                    </div>
                </div>

                <!-- Status Filter Pills -->
                <div class="flex items-center gap-2 overflow-x-auto pb-1 pt-1">
                    <span class="text-xs font-bold text-slate-500 whitespace-nowrap">Filter Status:</span>
                    
                    <button type="button" 
                            wire:click="setStatusFilter('all')" 
                            class="px-3 py-1 rounded-full text-xs font-bold border-2 transition cursor-pointer {{ $statusFilter === 'all' ? 'bg-slate-900 text-white border-slate-900' : 'bg-white text-slate-700 border-slate-300 hover:border-slate-900' }}">
                        Semua
                    </button>

                    <button type="button" 
                            wire:click="setStatusFilter('Menunggu')" 
                            class="px-3 py-1 rounded-full text-xs font-bold border-2 transition cursor-pointer {{ $statusFilter === 'Menunggu' ? 'bg-[#FB7185] text-white border-slate-900 shadow-[2px_2px_0px_0px_rgba(15,23,42,1)]' : 'bg-rose-50 text-rose-700 border-rose-200 hover:border-slate-900' }}">
                        ⏳ Menunggu
                    </button>

                    <button type="button" 
                            wire:click="setStatusFilter('Diproses')" 
                            class="px-3 py-1 rounded-full text-xs font-bold border-2 transition cursor-pointer {{ $statusFilter === 'Diproses' ? 'bg-[#38BDF8] text-slate-900 border-slate-900 shadow-[2px_2px_0px_0px_rgba(15,23,42,1)]' : 'bg-sky-50 text-sky-700 border-sky-200 hover:border-slate-900' }}">
                        ⚙️ Diproses
                    </button>

                    <button type="button" 
                            wire:click="setStatusFilter('Selesai')" 
                            class="px-3 py-1 rounded-full text-xs font-bold border-2 transition cursor-pointer {{ $statusFilter === 'Selesai' ? 'bg-[#34D399] text-slate-900 border-slate-900 shadow-[2px_2px_0px_0px_rgba(15,23,42,1)]' : 'bg-emerald-50 text-emerald-700 border-emerald-200 hover:border-slate-900' }}">
                        ✅ Selesai
                    </button>
                </div>
            </div>

            <!-- Feed List of Reports -->
            <div class="space-y-4">
                @forelse($reports as $report)
                    <div class="bg-white border-2 border-slate-900 rounded-3xl p-5 neo-shadow transition-all relative overflow-hidden">
                        
                        <!-- Top Metadata Row -->
                        <div class="flex items-start justify-between gap-3 mb-3">
                            <div class="flex flex-wrap items-center gap-2">
                                <!-- Category Badge -->
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-black bg-purple-100 text-purple-800 border border-purple-300">
                                    {{ $report->category }}
                                </span>

                                <!-- User Info -->
                                <span class="text-xs font-bold text-slate-600 flex items-center gap-1">
                                    <span>👤</span> {{ $report->user->name }}
                                    @if($report->isOwnedBy(auth()->user()))
                                        <span class="text-[10px] bg-yellow-300 text-slate-900 font-extrabold px-1.5 py-0.2 rounded border border-slate-900">Anda</span>
                                    @endif
                                </span>

                                <span class="text-xs text-slate-400">• {{ $report->created_at->diffForHumans() }}</span>
                            </div>

                            <!-- Playful Status Pill -->
                            <div>
                                @if($report->status === 'Menunggu')
                                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-extrabold border-2 border-slate-900 bg-[#FB7185] text-white shadow-[2px_2px_0px_0px_rgba(15,23,42,1)]">
                                        ⏳ Menunggu
                                    </span>
                                @elseif($report->status === 'Diproses')
                                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-extrabold border-2 border-slate-900 bg-[#38BDF8] text-slate-900 shadow-[2px_2px_0px_0px_rgba(15,23,42,1)]">
                                        ⚙️ Diproses
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-extrabold border-2 border-slate-900 bg-[#34D399] text-slate-900 shadow-[2px_2px_0px_0px_rgba(15,23,42,1)]">
                                        ✅ Selesai
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Title & Description -->
                        <h3 class="font-heading font-extrabold text-lg text-slate-900 leading-snug mb-2">
                            {{ $report->title }}
                        </h3>
                        <p class="text-xs sm:text-sm font-medium text-slate-700 leading-relaxed whitespace-pre-line mb-4">
                            {{ $report->description }}
                        </p>

                        <!-- Evidence Photo (Secured & Authorized) -->
                        @if($report->evidence_path)
                            <div class="mb-4 pt-3 border-t border-slate-100">
                                @if($report->isOwnedBy(auth()->user()) || auth()->user()->isAdmin())
                                    <div class="flex items-center gap-3 bg-slate-50 p-2.5 rounded-2xl border-2 border-slate-900 shadow-[2px_2px_0px_0px_rgba(15,23,42,1)]">
                                        <a href="{{ route('evidence.show', $report) }}" target="_blank" class="block shrink-0">
                                            <img src="{{ route('evidence.show', $report) }}" 
                                                 alt="Bukti Laporan" 
                                                 class="w-16 h-16 object-cover rounded-xl border border-slate-900 hover:opacity-90 transition">
                                        </a>
                                        <div class="text-xs">
                                            <p class="font-bold text-slate-900 flex items-center gap-1">
                                                <span>🔒</span> Foto Bukti Terlampir
                                            </p>
                                            <a href="{{ route('evidence.show', $report) }}" target="_blank" class="text-purple-600 font-extrabold hover:underline text-[11px] inline-flex items-center gap-1 mt-0.5">
                                                Buka Ukuran Penuh ↗
                                            </a>
                                        </div>
                                    </div>
                                @else
                                    <div class="p-2.5 rounded-2xl bg-slate-100 border border-slate-300 text-xs text-slate-500 font-semibold flex items-center gap-2">
                                        <span>🔒</span> Foto bukti privat (hanya dapat dilihat pelapor & petugas admin).
                                    </div>
                                @endif
                            </div>
                        @endif

                        <!-- Admin Response Box (if available) -->
                        @if($report->admin_response)
                            <div class="p-3.5 rounded-2xl bg-amber-50 border-2 border-slate-900 shadow-[2px_2px_0px_0px_rgba(15,23,42,1)]">
                                <div class="flex items-center justify-between mb-1.5">
                                    <span class="text-xs font-black text-amber-900 flex items-center gap-1.5">
                                        <span>💬</span> Tanggapan Resmi Petugas:
                                    </span>
                                    <span class="text-[10px] text-amber-700 font-bold">
                                        {{ $report->responded_at ? $report->responded_at->diffForHumans() : '' }}
                                    </span>
                                </div>
                                <p class="text-xs sm:text-sm font-medium text-slate-800 leading-normal">
                                    {{ $report->admin_response }}
                                </p>
                            </div>
                        @endif

                    </div>
                @empty
                    <div class="bg-white border-2 border-slate-900 rounded-3xl p-10 text-center neo-shadow-static space-y-3">
                        <div class="w-16 h-16 rounded-full bg-yellow-200 border-2 border-slate-900 flex items-center justify-center text-3xl mx-auto shadow-[2px_2px_0px_0px_rgba(15,23,42,1)]">
                            📭
                        </div>
                        <h4 class="font-heading font-extrabold text-xl text-slate-900">Belum Ada Laporan</h4>
                        <p class="text-xs sm:text-sm text-slate-600 max-w-sm mx-auto font-medium">
                            Tidak ditemukan laporan dengan filter ini. Mulai buat laporan baru menggunakan formulir di sebelah kiri!
                        </p>
                    </div>
                @endforelse

                <!-- Pagination -->
                <div class="mt-4">
                    {{ $reports->links() }}
                </div>
            </div>

        </div>

    </div>
</div>
