<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EvidenceController extends Controller
{
    /**
     * Display or download the evidence file with strict authorization.
     */
    public function show(Request $request, Report $report)
    {
        $user = $request->user();

        // Only the report owner or an admin can access the evidence
        if (! $user || (! $user->isAdmin() && ! $report->isOwnedBy($user))) {
            abort(403, 'Akses bukti ditolak. Anda tidak berhak melihat file ini.');
        }

        if (! $report->evidence_path || ! Storage::disk('local')->exists($report->evidence_path)) {
            abort(404, 'File bukti tidak ditemukan di penyimpanan server.');
        }

        $mimeType = Storage::disk('local')->mimeType($report->evidence_path) ?? 'application/octet-stream';

        return Storage::disk('local')->response(
            $report->evidence_path,
            basename($report->evidence_path),
            [
                'Content-Type' => $mimeType,
                'Cache-Control' => 'private, no-cache, must-revalidate',
            ]
        );
    }
}
