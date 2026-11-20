<div class="space-y-8">
    
    <!-- Top Bento Stats Overview -->
    <div>
        <div class="flex items-center justify-between mb-4">
            <div>
                <h1 class="font-heading font-black text-2xl sm:text-3xl text-slate-900 tracking-tight flex items-center gap-2">
                    ⚡ Dashboard Manajemen Admin
                </h1>
                <p class="text-xs sm:text-sm font-semibold text-slate-600">Pantau, proses, dan berikan tanggapan resmi secara langsung</p>
            </div>
            <span class="hidden sm:inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-yellow-300 text-slate-900 border-2 border-slate-900 text-xs font-black shadow-[2px_2px_0px_0px_rgba(15,23,42,1)]">
                🛡️ Akses Administrator
            </span>
        </div>

        <!-- BENTO STATS CARDS -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
            <!-- Total Laporan -->
            <div class="bg-white border-2 border-slate-900 rounded-3xl p-5 neo-shadow relative overflow-hidden">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-600">Total Pengaduan</span>
                    <span class="text-2xl">📊</span>
                </div>
                <p class="font-heading font-black text-3xl sm:text-4xl text-slate-900 mt-2">{{ $totalCount }}</p>
                <div class="mt-2 text-[11px] font-bold text-slate-500">Semua laporan masuk</div>
                <div class="absolute -right-3 -bottom-3 w-12 h-12 bg-slate-100 rounded-full border border-slate-200 -z-0"></div>
            </div>

            <!-- Menunggu (Coral/Pink #FB7185) -->
            <div class="bg-rose-50 border-2 border-slate-900 rounded-3xl p-5 neo-shadow relative overflow-hidden">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold uppercase tracking-wider text-rose-800">Menunggu</span>
                    <span class="text-2xl">⏳</span>
                </div>
                <p class="font-heading font-black text-3xl sm:text-4xl text-rose-600 mt-2">{{ $pendingCount }}</p>
                <div class="mt-2 text-[11px] font-bold text-rose-700">Perlu ditindaklanjuti</div>
                <div class="absolute -right-3 -bottom-3 w-12 h-12 bg-rose-200/50 rounded-full border border-rose-300"></div>
            </div>

            <!-- Diproses (Sky Blue #38BDF8) -->
            <div class="bg-sky-50 border-2 border-slate-900 rounded-3xl p-5 neo-shadow relative overflow-hidden">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold uppercase tracking-wider text-sky-800">Diproses</span>
                    <span class="text-2xl">⚙️</span>
                </div>
                <p class="font-heading font-black text-3xl sm:text-4xl text-sky-600 mt-2">{{ $processingCount }}</p>
                <div class="mt-2 text-[11px] font-bold text-sky-700">Sedang ditangani tim</div>
                <div class="absolute -right-3 -bottom-3 w-12 h-12 bg-sky-200/50 rounded-full border border-sky-300"></div>
            </div>

            <!-- Selesai (Mint Green #34D399) -->
            <div class="bg-emerald-50 border-2 border-slate-900 rounded-3xl p-5 neo-shadow relative overflow-hidden">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold uppercase tracking-wider text-emerald-800">Selesai</span>
                    <span class="text-2xl">✅</span>
                </div>
                <p class="font-heading font-black text-3xl sm:text-4xl text-emerald-600 mt-2">{{ $completedCount }}</p>
                <div class="mt-2 text-[11px] font-bold text-emerald-700">Tuntas diselesaikan</div>
                <div class="absolute -right-3 -bottom-3 w-12 h-12 bg-emerald-200/50 rounded-full border border-emerald-300"></div>
            </div>
        </div>
    </div>

    <!-- Notification Alert -->
    @if (session()->has('admin_message'))
        <div class="p-4 rounded-3xl bg-emerald-100 border-2 border-slate-900 neo-shadow flex items-center justify-between">
            <div class="flex items-center gap-3">
                <span class="text-2xl">💡</span>
                <p class="font-bold text-emerald-950 text-sm sm:text-base">{{ session('admin_message') }}</p>
            </div>
            <button type="button" @click="$el.parentElement.remove()" class="text-slate-600 hover:text-slate-900 font-bold px-2 py-1 text-sm cursor-pointer">
                ✕
            </button>
        </div>
    @endif

    <!-- MAIN DATA TABLE & FILTER CARD -->
    <div class="bg-white border-2 border-slate-900 rounded-3xl p-6 sm:p-7 neo-shadow-static space-y-6">
        
        <!-- Filter and Search Row -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            
            <div class="flex flex-wrap items-center gap-3">
                <!-- Search -->
                <div class="relative min-w-[240px]">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400 text-sm">
                        🔍
                    </span>
                    <input type="text" 
                           wire:model.live.debounce.300ms="search" 
                           placeholder="Cari judul, isi, atau nama pelapor..."
                           class="w-full pl-9 pr-4 py-2 rounded-2xl border-2 border-slate-900 bg-slate-50 text-xs font-medium focus:outline-none focus:bg-white focus:ring-2 focus:ring-purple-500 transition shadow-[2px_2px_0px_0px_rgba(15,23,42,1)]">
                </div>

                <!-- Category Filter -->
                <select wire:model.live="categoryFilter" 
                        class="px-3 py-2 rounded-2xl border-2 border-slate-900 bg-slate-50 text-xs font-bold focus:outline-none focus:ring-2 focus:ring-purple-500 shadow-[2px_2px_0px_0px_rgba(15,23,42,1)]">
                    <option value="all">Semua Kategori</option>
                    <option value="Fasilitas">Fasilitas</option>
                    <option value="Kebersihan">Kebersihan</option>
                    <option value="Keamanan">Keamanan</option>
                    <option value="Layanan">Layanan</option>
                    <option value="Lainnya">Lainnya</option>
                </select>
            </div>

            <!-- Status Quick Pills Filter -->
            <div class="flex items-center gap-1.5 overflow-x-auto pb-1">
                <button type="button" 
                        wire:click="$set('statusFilter', 'all')" 
                        class="px-3 py-1 rounded-full text-xs font-bold border-2 transition cursor-pointer {{ $statusFilter === 'all' ? 'bg-slate-900 text-white border-slate-900' : 'bg-white text-slate-700 border-slate-300 hover:border-slate-900' }}">
                    Semua
                </button>
                <button type="button" 
                        wire:click="$set('statusFilter', 'Menunggu')" 
                        class="px-3 py-1 rounded-full text-xs font-bold border-2 transition cursor-pointer {{ $statusFilter === 'Menunggu' ? 'bg-[#FB7185] text-white border-slate-900 shadow-[2px_2px_0px_0px_rgba(15,23,42,1)]' : 'bg-rose-50 text-rose-700 border-rose-200 hover:border-slate-900' }}">
                    Menunggu
                </button>
                <button type="button" 
                        wire:click="$set('statusFilter', 'Diproses')" 
                        class="px-3 py-1 rounded-full text-xs font-bold border-2 transition cursor-pointer {{ $statusFilter === 'Diproses' ? 'bg-[#38BDF8] text-slate-900 border-slate-900 shadow-[2px_2px_0px_0px_rgba(15,23,42,1)]' : 'bg-sky-50 text-sky-700 border-sky-200 hover:border-slate-900' }}">
                    Diproses
                </button>
                <button type="button" 
                        wire:click="$set('statusFilter', 'Selesai')" 
                        class="px-3 py-1 rounded-full text-xs font-bold border-2 transition cursor-pointer {{ $statusFilter === 'Selesai' ? 'bg-[#34D399] text-slate-900 border-slate-900 shadow-[2px_2px_0px_0px_rgba(15,23,42,1)]' : 'bg-emerald-50 text-emerald-700 border-emerald-200 hover:border-slate-900' }}">
                    Selesai
                </button>
            </div>

        </div>

        <!-- REPORTS LIST -->
        <div class="space-y-4">
            @forelse($reports as $report)
                <div class="border-2 border-slate-900 rounded-3xl p-5 bg-white neo-shadow-sm hover:border-purple-600 transition-colors">
                    <div class="flex flex-col lg:flex-row lg:items-start justify-between gap-4">
                        
                        <!-- Details Left Side -->
                        <div class="space-y-2 flex-1">
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="font-mono text-xs font-bold px-2 py-0.5 rounded-lg bg-slate-100 border border-slate-300">
                                    #{{ $report->id }}
                                </span>
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-black bg-purple-100 text-purple-800 border border-purple-300">
                                    {{ $report->category }}
                                </span>
                                <span class="text-xs font-bold text-slate-700">
                                    👤 {{ $report->user->name }} ({{ $report->user->email }})
                                </span>
                                <span class="text-xs text-slate-400">• {{ $report->created_at->format('d M Y, H:i') }}</span>
                            </div>

                            <h3 class="font-heading font-black text-lg text-slate-900">
                                {{ $report->title }}
                            </h3>

                            <p class="text-xs sm:text-sm font-medium text-slate-700 leading-relaxed whitespace-pre-line">
                                {{ $report->description }}
                            </p>

                            <!-- Evidence Thumbnail if exists (Private disk, authorized link) -->
                            @if($report->evidence_path)
                                <div class="pt-2 flex items-center gap-3">
                                    <a href="{{ route('evidence.show', $report) }}" target="_blank" class="block shrink-0">
                                        <img src="{{ route('evidence.show', $report) }}" 
                                             alt="Bukti Foto" 
                                             class="w-14 h-14 object-cover rounded-xl border-2 border-slate-900 shadow-[2px_2px_0px_0px_rgba(15,23,42,1)]">
                                    </a>
                                    <div class="text-xs">
                                        <span class="font-bold text-slate-800">📸 Bukti Laporan Terlampir</span>
                                        <br>
                                        <a href="{{ route('evidence.show', $report) }}" target="_blank" class="text-purple-600 font-extrabold hover:underline">
                                            Buka Dokumen Asli ↗
                                        </a>
                                    </div>
                                </div>
                            @endif

                            <!-- Official Response Info if exists -->
                            @if($report->admin_response)
                                <div class="mt-2 p-3 rounded-2xl bg-amber-50 border-2 border-amber-300 text-xs">
                                    <div class="flex items-center justify-between font-bold text-amber-900 mb-1">
                                        <span>💬 Tanggapan Saat Ini:</span>
                                        <span class="text-[10px]">{{ $report->responded_at ? $report->responded_at->diffForHumans() : '' }}</span>
                                    </div>
                                    <p class="text-slate-800 font-medium">{{ $report->admin_response }}</p>
                                </div>
                            @endif
                        </div>

                        <!-- Actions Right Side -->
                        <div class="flex flex-col sm:flex-row lg:flex-col gap-2 shrink-0 lg:w-48 pt-2 lg:pt-0 border-t lg:border-t-0 border-slate-100">
                            
                            <!-- Current Status Badge -->
                            <div class="text-center mb-1">
                                @if($report->status === 'Menunggu')
                                    <span class="inline-block w-full py-1 px-3 rounded-2xl text-xs font-extrabold border-2 border-slate-900 bg-[#FB7185] text-white shadow-[2px_2px_0px_0px_rgba(15,23,42,1)]">
                                        ⏳ Menunggu
                                    </span>
                                @elseif($report->status === 'Diproses')
                                    <span class="inline-block w-full py-1 px-3 rounded-2xl text-xs font-extrabold border-2 border-slate-900 bg-[#38BDF8] text-slate-900 shadow-[2px_2px_0px_0px_rgba(15,23,42,1)]">
                                        ⚙️ Diproses
                                    </span>
                                @else
                                    <span class="inline-block w-full py-1 px-3 rounded-2xl text-xs font-extrabold border-2 border-slate-900 bg-[#34D399] text-slate-900 shadow-[2px_2px_0px_0px_rgba(15,23,42,1)]">
                                        ✅ Selesai
                                    </span>
                                @endif
                            </div>

                            <!-- Quick Status Change Buttons -->
                            <div class="grid grid-cols-3 gap-1">
                                <button type="button" 
                                        wire:click="updateStatus({{ $report->id }}, 'Menunggu')"
                                        title="Ubah jadi Menunggu"
                                        class="p-1 rounded-xl text-center text-xs border border-slate-900 bg-rose-100 hover:bg-rose-200 transition cursor-pointer">
                                    ⏳
                                </button>
                                <button type="button" 
                                        wire:click="updateStatus({{ $report->id }}, 'Diproses')"
                                        title="Ubah jadi Diproses"
                                        class="p-1 rounded-xl text-center text-xs border border-slate-900 bg-sky-100 hover:bg-sky-200 transition cursor-pointer">
                                    ⚙️
                                </button>
                                <button type="button" 
                                        wire:click="updateStatus({{ $report->id }}, 'Selesai')"
                                        title="Ubah jadi Selesai"
                                        class="p-1 rounded-xl text-center text-xs border border-slate-900 bg-emerald-100 hover:bg-emerald-200 transition cursor-pointer">
                                    ✅
                                </button>
                            </div>

                            <!-- Tanggapi Button -->
                            <button type="button" 
                                    wire:click="openResponseModal({{ $report->id }})"
                                    class="w-full py-2 px-3 rounded-2xl text-xs font-bold border-2 border-slate-900 bg-yellow-400 hover:bg-yellow-300 text-slate-900 shadow-[2px_2px_0px_0px_rgba(15,23,42,1)] transition cursor-pointer flex items-center justify-center gap-1.5">
                                <span>✍️</span> Beri Tanggapan
                            </button>

                            <!-- Delete Button -->
                            <button type="button" 
                                    wire:click="deleteReport({{ $report->id }})"
                                    wire:confirm="Yakin ingin menghapus laporan ini secara permanen?"
                                    class="w-full py-1.5 px-3 rounded-2xl text-xs font-bold border-2 border-slate-900 bg-rose-100 text-rose-700 hover:bg-rose-200 transition cursor-pointer flex items-center justify-center gap-1">
                                <span>🗑️</span> Hapus
                            </button>

                        </div>

                    </div>
                </div>
            @empty
                <div class="border-2 border-slate-900 rounded-3xl p-10 text-center bg-slate-50">
                    <p class="font-heading font-bold text-slate-700 text-lg">Tidak ada data laporan yang cocok.</p>
                </div>
            @endforelse

            <div class="mt-4">
                {{ $reports->links() }}
            </div>
        </div>

    </div>

    <!-- RESPONSE MODAL (PLAYFUL NEO-BRUTALISM) -->
    @if ($selectedReportId)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60 backdrop-blur-xs p-4">
            <div class="bg-white border-3 border-slate-900 rounded-3xl p-6 sm:p-7 max-w-lg w-full neo-shadow-static relative animate-in fade-in zoom-in-95 duration-150">
                
                <div class="flex items-center justify-between pb-3 border-b-2 border-slate-100 mb-4">
                    <div class="flex items-center gap-2">
                        <span class="text-2xl">✍️</span>
                        <h3 class="font-heading font-extrabold text-xl text-slate-900">
                            Tanggapan Resmi Admin
                        </h3>
                    </div>
                    <button type="button" 
                            wire:click="closeResponseModal" 
                            class="w-8 h-8 rounded-full border-2 border-slate-900 bg-rose-100 hover:bg-rose-200 font-bold flex items-center justify-center cursor-pointer">
                        ✕
                    </button>
                </div>

                <div class="space-y-4">
                    <!-- Update Status on Response -->
                    <div>
                        <label class="block font-bold text-xs uppercase tracking-wider text-slate-800 mb-1.5">
                            Status Terkini Laporan
                        </label>
                        <select wire:model.defer="adminResponseStatus" 
                                class="w-full px-4 py-2.5 rounded-2xl border-2 border-slate-900 bg-slate-50 font-bold text-xs focus:ring-2 focus:ring-purple-500 shadow-[2px_2px_0px_0px_rgba(15,23,42,1)]">
                            <option value="Menunggu">⏳ Menunggu</option>
                            <option value="Diproses">⚙️ Diproses</option>
                            <option value="Selesai">✅ Selesai</option>
                        </select>
                    </div>

                    <!-- Response Textarea -->
                    <div>
                        <label class="block font-bold text-xs uppercase tracking-wider text-slate-800 mb-1.5">
                            Pesan Tanggapan untuk Pelapor <span class="text-rose-500">*</span>
                        </label>
                        <textarea wire:model.defer="adminResponseText" 
                                  rows="4" 
                                  placeholder="Tuliskan tindakan yang telah diambil atau estimasi penyelesaian masalah..."
                                  class="w-full px-4 py-2.5 rounded-2xl border-2 border-slate-900 bg-slate-50 text-xs font-medium focus:bg-white focus:ring-2 focus:ring-purple-500 shadow-[2px_2px_0px_0px_rgba(15,23,42,1)] @error('adminResponseText') border-rose-500 @enderror"></textarea>
                        @error('adminResponseText')
                            <p class="text-xs font-bold text-rose-600 mt-1">❌ {{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Modal Actions -->
                    <div class="flex items-center justify-end gap-3 pt-2">
                        <button type="button" 
                                wire:click="closeResponseModal"
                                class="px-4 py-2 rounded-2xl text-xs font-bold border-2 border-slate-900 bg-slate-100 hover:bg-slate-200 transition cursor-pointer">
                            Batal
                        </button>
                        <button type="button" 
                                wire:click="saveResponse"
                                class="px-5 py-2.5 rounded-2xl text-xs font-heading font-extrabold border-2 border-slate-900 bg-yellow-400 hover:bg-yellow-300 text-slate-900 neo-shadow transition cursor-pointer">
                            Simpan & Publikasikan Tanggapan 🚀
                        </button>
                    </div>
                </div>

            </div>
        </div>
    @endif

</div>
