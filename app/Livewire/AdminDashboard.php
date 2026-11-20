<?php

namespace App\Livewire;

use App\Models\Report;
use Livewire\Component;
use Livewire\WithPagination;

class AdminDashboard extends Component
{
    use WithPagination;

    public string $search = '';

    public string $statusFilter = 'all';

    public string $categoryFilter = 'all';

    // Response modal/inline state
    public ?int $selectedReportId = null;

    public string $adminResponseText = '';

    public string $adminResponseStatus = 'Diproses';

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingStatusFilter(): void
    {
        $this->resetPage();
    }

    public function updatingCategoryFilter(): void
    {
        $this->resetPage();
    }

    public function updateStatus(int $reportId, string $newStatus): void
    {
        if (! in_array($newStatus, ['Menunggu', 'Diproses', 'Selesai'], true)) {
            return;
        }

        $report = Report::find($reportId);
        if ($report) {
            $report->update(['status' => $newStatus]);
            session()->flash('admin_message', "✅ Status laporan #{$report->id} berhasil diubah menjadi: {$newStatus}");
        }
    }

    public function openResponseModal(int $reportId): void
    {
        $report = Report::find($reportId);
        if ($report) {
            $this->selectedReportId = $reportId;
            $this->adminResponseText = $report->admin_response ?? '';
            $this->adminResponseStatus = $report->status;
        }
    }

    public function closeResponseModal(): void
    {
        $this->reset(['selectedReportId', 'adminResponseText', 'adminResponseStatus']);
    }

    public function saveResponse(): void
    {
        $this->validate([
            'adminResponseText' => 'required|string|min:5|max:2000',
            'adminResponseStatus' => 'required|in:Menunggu,Diproses,Selesai',
        ], [
            'adminResponseText.required' => 'Tanggapan resmi wajib diisi.',
            'adminResponseText.min' => 'Tanggapan resmi minimal 5 karakter.',
        ]);

        $report = Report::find($this->selectedReportId);
        if ($report) {
            $report->update([
                'admin_response' => $this->adminResponseText,
                'status' => $this->adminResponseStatus,
                'responded_at' => now(),
            ]);

            session()->flash('admin_message', "🎉 Tanggapan untuk laporan #{$report->id} telah disimpan!");
            $this->closeResponseModal();
        }
    }

    public function deleteReport(int $reportId): void
    {
        $report = Report::find($reportId);
        if ($report) {
            $report->delete();
            session()->flash('admin_message', "🗑️ Laporan #{$reportId} berhasil dihapus dari sistem.");
        }
    }

    public function render()
    {
        $totalCount = Report::count();
        $pendingCount = Report::where('status', 'Menunggu')->count();
        $processingCount = Report::where('status', 'Diproses')->count();
        $completedCount = Report::where('status', 'Selesai')->count();

        $query = Report::with('user')->latest();

        if ($this->statusFilter !== 'all') {
            $query->where('status', $this->statusFilter);
        }

        if ($this->categoryFilter !== 'all') {
            $query->where('category', $this->categoryFilter);
        }

        if (! empty(trim($this->search))) {
            $term = '%'.trim($this->search).'%';
            $query->where(function ($q) use ($term) {
                $q->where('title', 'like', $term)
                    ->orWhere('description', 'like', $term)
                    ->orWhereHas('user', function ($uq) use ($term) {
                        $uq->where('name', 'like', $term)
                            ->orWhere('email', 'like', $term);
                    });
            });
        }

        $reports = $query->paginate(10);

        return view('livewire.admin-dashboard', [
            'reports' => $reports,
            'totalCount' => $totalCount,
            'pendingCount' => $pendingCount,
            'processingCount' => $processingCount,
            'completedCount' => $completedCount,
        ]);
    }
}
