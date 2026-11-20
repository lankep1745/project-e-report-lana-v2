<?php

namespace App\Livewire;

use App\Models\Report;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class ReportManager extends Component
{
    use WithFileUploads;

    // Form fields
    public string $title = '';

    public string $category = 'Fasilitas';

    public string $description = '';

    public $evidence;

    // Filter & Search fields
    public string $search = '';

    public string $statusFilter = 'all';

    public string $scope = 'all'; // 'all' (semua laporan) or 'my' (laporan saya)

    public array $categories = [
        'Fasilitas',
        'Kebersihan',
        'Keamanan',
        'Layanan',
        'Lainnya',
    ];

    protected function rules(): array
    {
        return [
            'title' => 'required|string|min:5|max:150',
            'category' => 'required|in:Fasilitas,Kebersihan,Keamanan,Layanan,Lainnya',
            'description' => 'required|string|min:10|max:2000',
            'evidence' => 'nullable|file|mimes:jpg,jpeg,png,webp|max:2048', // 2MB max
        ];
    }

    protected array $messages = [
        'title.required' => 'Judul laporan wajib diisi.',
        'title.min' => 'Judul laporan minimal 5 karakter.',
        'category.required' => 'Silakan pilih kategori laporan.',
        'description.required' => 'Deskripsi laporan wajib diisi.',
        'description.min' => 'Deskripsi laporan minimal 10 karakter.',
        'evidence.file' => 'File bukti harus berupa dokumen gambar yang valid.',
        'evidence.mimes' => 'Format file yang diperbolehkan hanya JPG, JPEG, PNG, atau WEBP.',
        'evidence.max' => 'Ukuran file bukti maksimal 2MB.',
    ];

    public function selectCategory(string $cat): void
    {
        if (in_array($cat, $this->categories, true)) {
            $this->category = $cat;
        }
    }

    public function setStatusFilter(string $status): void
    {
        $this->statusFilter = $status;
    }

    public function setScope(string $scope): void
    {
        $this->scope = $scope;
    }

    public function submitReport(): void
    {
        $this->validate();

        $evidencePath = null;
        if ($this->evidence) {
            // Private Storage: stored inside storage/app/private/evidence via disk 'local'
            $evidencePath = $this->evidence->store('evidence', 'local');
        }

        Report::create([
            'user_id' => Auth::id(),
            'title' => $this->title,
            'category' => $this->category,
            'description' => $this->description,
            'evidence_path' => $evidencePath,
            'status' => 'Menunggu',
        ]);

        $this->reset(['title', 'description', 'evidence']);
        $this->category = 'Fasilitas';

        session()->flash('message', '🎉 Laporan Anda berhasil dikirim! Tim terkait akan segera meninjaunya.');
    }

    public function render()
    {
        $query = Report::with('user')->latest();

        if ($this->scope === 'my') {
            $query->where('user_id', Auth::id());
        }

        if ($this->statusFilter !== 'all') {
            $query->where('status', $this->statusFilter);
        }

        if (! empty(trim($this->search))) {
            $term = '%'.trim($this->search).'%';
            $query->where(function ($q) use ($term) {
                $q->where('title', 'like', $term)
                    ->orWhere('description', 'like', $term)
                    ->orWhere('category', 'like', $term);
            });
        }

        $reports = $query->paginate(8);

        return view('livewire.report-manager', [
            'reports' => $reports,
        ]);
    }
}
