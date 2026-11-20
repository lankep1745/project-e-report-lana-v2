<?php

namespace Tests\Feature;

use App\Livewire\AdminDashboard;
use App\Livewire\ReportManager;
use App\Models\Report;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class EReportSystemTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_login(): void
    {
        $response = $this->get('/');
        $response->assertRedirect('/login');

        $responseReport = $this->get('/laporan');
        $responseReport->assertRedirect('/login');

        $responseAdmin = $this->get('/admin/dashboard');
        $responseAdmin->assertRedirect('/login');
    }

    public function test_user_can_login_and_access_reports_page(): void
    {
        $user = User::factory()->create([
            'email' => 'user@ereport.test',
            'role' => 'user',
        ]);

        $response = $this->post('/login', [
            'email' => 'user@ereport.test',
            'password' => 'password',
        ]);

        $response->assertRedirect('/laporan');
        $this->assertAuthenticatedAs($user);
    }

    public function test_regular_user_cannot_access_admin_dashboard(): void
    {
        $user = User::factory()->create(['role' => 'user']);

        $response = $this->actingAs($user)->get('/admin/dashboard');
        $response->assertStatus(403);
    }

    public function test_admin_can_access_admin_dashboard(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->get('/admin/dashboard');
        $response->assertStatus(200);
        $response->assertSee('Dashboard Manajemen Admin');
    }

    public function test_user_can_submit_report_via_livewire(): void
    {
        Storage::fake('local');
        $user = User::factory()->create(['role' => 'user']);

        $file = UploadedFile::fake()->image('bukti-jalan.jpg');

        Livewire::actingAs($user)
            ->test(ReportManager::class)
            ->set('title', 'Lampu Jalan Padam di RW 04')
            ->set('category', 'Fasilitas')
            ->set('description', 'Sudah 5 hari lampu padam total di tikungan RW 04.')
            ->set('evidence', $file)
            ->call('submitReport')
            ->assertHasNoErrors()
            ->assertSee('Laporan Anda berhasil dikirim');

        $this->assertDatabaseHas('reports', [
            'title' => 'Lampu Jalan Padam di RW 04',
            'category' => 'Fasilitas',
            'status' => 'Menunggu',
            'user_id' => $user->id,
        ]);

        $report = Report::where('title', 'Lampu Jalan Padam di RW 04')->first();
        $this->assertNotNull($report->evidence_path);
        Storage::disk('local')->assertExists($report->evidence_path);
    }

    public function test_evidence_file_retrieval_authorization(): void
    {
        Storage::fake('local');

        $owner = User::factory()->create(['role' => 'user']);
        $stranger = User::factory()->create(['role' => 'user']);
        $admin = User::factory()->create(['role' => 'admin']);

        $filePath = 'evidence/test-evidence.png';
        Storage::disk('local')->put($filePath, 'fake image content');

        $report = Report::create([
            'user_id' => $owner->id,
            'title' => 'Saluran Air Mampet',
            'category' => 'Kebersihan',
            'description' => 'Saluran air tersumbat sampah.',
            'evidence_path' => $filePath,
            'status' => 'Menunggu',
        ]);

        // 1. Stranger gets 403 Forbidden
        $responseStranger = $this->actingAs($stranger)->get(route('evidence.show', $report));
        $responseStranger->assertStatus(403);

        // 2. Owner can view evidence (200 OK)
        $responseOwner = $this->actingAs($owner)->get(route('evidence.show', $report));
        $responseOwner->assertStatus(200);

        // 3. Admin can view evidence (200 OK)
        $responseAdmin = $this->actingAs($admin)->get(route('evidence.show', $report));
        $responseAdmin->assertStatus(200);
    }

    public function test_admin_can_update_status_and_respond(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $user = User::factory()->create(['role' => 'user']);

        $report = Report::create([
            'user_id' => $user->id,
            'title' => 'Pohon Tumbang',
            'category' => 'Keamanan',
            'description' => 'Pohon menutup separuh badan jalan.',
            'status' => 'Menunggu',
        ]);

        Livewire::actingAs($admin)
            ->test(AdminDashboard::class)
            ->call('updateStatus', $report->id, 'Diproses')
            ->assertSee('Status laporan #'.$report->id.' berhasil diubah menjadi: Diproses');

        $this->assertEquals('Diproses', $report->fresh()->status);

        Livewire::actingAs($admin)
            ->test(AdminDashboard::class)
            ->call('openResponseModal', $report->id)
            ->set('adminResponseText', 'Tim kebersihan sedang dalam perjalanan dengan chainsaw.')
            ->set('adminResponseStatus', 'Diproses')
            ->call('saveResponse')
            ->assertHasNoErrors();

        $this->assertEquals('Tim kebersihan sedang dalam perjalanan dengan chainsaw.', $report->fresh()->admin_response);
    }
}
