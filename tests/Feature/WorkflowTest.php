<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\CompanyPartnership;
use App\Models\Evaluation;
use App\Models\InternshipApplication;
use App\Models\InternshipOffer;
use App\Models\InternshipOfferUniversity;
use App\Models\LogbookEntry;
use App\Notifications\PlatformUpdateNotification;
use App\Models\University;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class WorkflowTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_login_and_role_dashboards_work(): void
    {
        $university = University::factory()->create(['nama' => 'Universitas Demo']);

        $this->get(route('dashboard'))->assertRedirect(route('login'));
        $this->get(route('login'))->assertOk()->assertSee('Masuk');
        $this->get(route('register'))->assertOk()->assertSee('Mulai dari peran yang tepat');

        $this->post(route('register.store'), [
            'account_type' => 'universitas',
            'name' => 'Staf Kampus Baru',
            'email' => 'staf-baru@example.test',
            'telepon' => '08123456789',
            'university_name' => 'Universitas Baru',
            'university_code' => 'UBR',
            'password' => 'password',
            'password_confirmation' => 'password',
        ])->assertRedirect(route('dashboard'));

        $this->assertAuthenticated();
        $this->assertDatabaseHas('universities', ['kode' => 'UBR']);
        $this->assertDatabaseHas('users', ['email' => 'staf-baru@example.test', 'role' => 'staf']);

        $this->post(route('logout'))->assertRedirect(route('home'));

        $this->post(route('register.store'), [
            'account_type' => 'perusahaan',
            'name' => 'HR Baru',
            'email' => 'hr-baru@example.test',
            'telepon' => '089999999',
            'company_name' => 'PT Talenta Baru',
            'industry' => 'Teknologi',
            'website' => 'https://talenta.example.test',
            'password' => 'password',
            'password_confirmation' => 'password',
        ])->assertRedirect(route('dashboard'));

        $this->assertDatabaseHas('companies', ['nama' => 'PT Talenta Baru']);
        $this->assertDatabaseHas('users', ['email' => 'hr-baru@example.test', 'role' => 'perusahaan']);

        $this->post(route('logout'))->assertRedirect(route('home'));

        $this->post(route('register.store'), [
            'account_type' => 'mahasiswa',
            'university_id' => $university->id,
            'name' => 'Mahasiswa Baru',
            'email' => 'mahasiswa-baru@example.test',
            'nomor_induk' => '2211001',
            'program_studi' => 'Sistem Informasi',
            'telepon' => '087777777',
            'password' => 'password',
            'password_confirmation' => 'password',
        ])->assertRedirect(route('dashboard'));

        $this->assertDatabaseHas('users', [
            'email' => 'mahasiswa-baru@example.test',
            'role' => 'mahasiswa',
            'university_id' => $university->id,
        ]);

        $this->post(route('logout'))->assertRedirect(route('home'));

        $student = User::where('email', 'mahasiswa-baru@example.test')->firstOrFail();
        $this->post(route('login.store'), [
            'email' => $student->email,
            'password' => 'password',
        ])->assertRedirect(route('dashboard'));

        $this->assertAuthenticatedAs($student);
        $this->get(route('dashboard'))->assertOk()->assertSee('Ruang Mahasiswa');
    }

    public function test_internship_workflow_and_access_rules_are_enforced(): void
    {
        Notification::fake();

        $university = University::factory()->create(['nama' => 'Universitas Utama']);
        $otherUniversity = University::factory()->create(['nama' => 'Universitas Lain']);
        $company = Company::factory()->create(['nama' => 'PT Mitra Industri']);
        $otherCompany = Company::factory()->create(['nama' => 'PT Lain']);

        $staff = User::factory()->staff($university)->create(['name' => 'Staf Utama']);
        $otherStaff = User::factory()->staff($otherUniversity)->create(['name' => 'Staf Lain']);
        $hr = User::factory()->companyRepresentative($company)->create(['name' => 'HR Mitra']);
        $otherHr = User::factory()->companyRepresentative($otherCompany)->create(['name' => 'HR Lain']);
        $companySupervisor = User::factory()->companySupervisor($company)->create(['name' => 'PJ Mitra']);
        $otherCompanySupervisor = User::factory()->companySupervisor($otherCompany)->create(['name' => 'PJ Lain']);
        $student = User::factory()->student($university)->create(['name' => 'Mahasiswa Utama']);
        $otherStudent = User::factory()->student($otherUniversity)->create(['name' => 'Mahasiswa Lain']);
        $lecturer = User::factory()->lecturer($university)->create(['name' => 'Dosen Pembimbing']);

        $this->actingAs($staff)->get(route('directories.companies'))
            ->assertOk()
            ->assertSee($company->nama);

        $this->actingAs($hr)->get(route('directories.universities'))
            ->assertOk()
            ->assertSee($university->nama);

        $this->actingAs($staff)->post(route('supervisors.store'), [
            'name' => 'Dosen Baru',
            'email' => 'dosen-baru@example.test',
            'nomor_induk' => 'DSN-NEW',
            'program_studi' => 'Sistem Informasi',
            'password' => 'password',
            'password_confirmation' => 'password',
        ])->assertRedirect(route('supervisors.index'));

        $this->assertDatabaseHas('users', [
            'email' => 'dosen-baru@example.test',
            'role' => 'university_supervisor',
            'university_id' => $university->id,
        ]);

        $this->actingAs($hr)->post(route('supervisors.store'), [
            'name' => 'PJ Baru',
            'email' => 'pj-baru@example.test',
            'nomor_induk' => 'SPV-NEW',
            'password' => 'password',
            'password_confirmation' => 'password',
        ])->assertRedirect(route('supervisors.index'));

        $this->assertDatabaseHas('users', [
            'email' => 'pj-baru@example.test',
            'role' => 'company_supervisor',
            'company_id' => $company->id,
        ]);

        $this->actingAs($companySupervisor)->get(route('partnerships.index'))->assertForbidden();
        $this->actingAs($lecturer)->get(route('partnerships.index'))->assertForbidden();

        $this->actingAs($hr)->post(route('partnerships.store'), [
            'university_id' => $university->id,
            'pesan' => 'Kami ingin membuka program magang resmi.',
        ])->assertRedirect();

        $partnership = CompanyPartnership::firstOrFail();
        $this->assertSame('menunggu', $partnership->status);

        $this->actingAs($otherStaff)->patch(route('partnerships.update', $partnership), [
            'status' => 'diterima',
        ])->assertForbidden();

        $this->actingAs($staff)->patch(route('partnerships.update', $partnership), [
            'status' => 'diterima',
            'catatan_review' => 'Disetujui untuk semester ini.',
        ])->assertRedirect();

        $this->assertDatabaseHas('company_partnerships', [
            'company_id' => $company->id,
            'university_id' => $university->id,
            'status' => 'diterima',
            'reviewed_by' => $staff->id,
        ]);

        $this->actingAs($staff)->get(route('offers.create'))->assertForbidden();
        $this->actingAs($staff)->post(route('offers.store'), $this->validOfferPayload($company, [$university->id]))
            ->assertForbidden();

        $this->actingAs($hr)->post(route('offers.store'), $this->validOfferPayload($company, [$university->id]))
            ->assertRedirect();

        $offer = InternshipOffer::firstOrFail();
        $offerRequest = InternshipOfferUniversity::firstOrFail();

        $this->assertSame('menunggu', $offer->status);
        $this->assertSame('menunggu', $offerRequest->status);

        $this->actingAs($student)->get(route('offers.index'))
            ->assertOk()
            ->assertDontSee($offer->judul);

        $this->actingAs($otherStaff)->patch(route('offers.review', $offerRequest), [
            'status' => 'diterima',
        ])->assertForbidden();

        $this->actingAs($staff)->patch(route('offers.review', $offerRequest), [
            'status' => 'diterima',
            'catatan_review' => 'Lowongan sesuai kebutuhan kampus.',
        ])->assertRedirect();

        $offer->refresh();
        $this->assertSame('terbit', $offer->status);

        $this->actingAs($otherStaff)->get(route('offers.edit', $offer))->assertForbidden();

        $this->actingAs($student)->get(route('offers.index'))
            ->assertOk()
            ->assertSee($offer->judul);

        $this->actingAs($student)->post(route('applications.store', $offer), [
            'motivasi' => 'Saya ingin mengikuti program magang ini karena sesuai dengan rencana karier saya.',
        ])->assertRedirect(route('applications.index'));

        Notification::assertSentTo($hr, PlatformUpdateNotification::class);

        $application = InternshipApplication::firstOrFail();
        $this->assertSame('diajukan', $application->status);

        $this->actingAs($student)->post(route('applications.store', $offer), [
            'motivasi' => 'Saya mencoba melamar dua kali untuk memastikan validasi berjalan dengan benar.',
        ])->assertSessionHasErrors('offer');

        $this->assertSame(1, InternshipApplication::count());

        $this->actingAs($otherStaff)->patch(route('applications.update', $application), [
            'status' => 'diterima',
        ])->assertForbidden();

        $this->actingAs($otherHr)->patch(route('applications.update', $application), [
            'status' => 'diterima',
        ])->assertForbidden();

        $this->actingAs($hr)->patch(route('applications.update', $application), [
            'status' => 'diterima',
            'campus_supervisor_id' => $lecturer->id,
            'company_supervisor_id' => $companySupervisor->id,
            'tanggal_mulai' => now()->addWeek()->toDateString(),
            'tanggal_selesai' => now()->addMonths(4)->toDateString(),
        ])->assertRedirect();

        $application->refresh();
        $this->assertSame('diterima', $application->status);
        $this->assertNotNull($application->diterima_pada);

        $pendingOffer = InternshipOffer::factory()->published()->for($company)->create([
            'judul' => 'Pending Logbook Test Offer',
        ]);
        InternshipOfferUniversity::factory()->accepted()->for($pendingOffer, 'offer')->for($university)->create();
        $pendingApplication = InternshipApplication::factory()->create([
            'internship_offer_id' => $pendingOffer->id,
            'student_id' => $student->id,
            'status' => 'diajukan',
        ]);

        $this->actingAs($hr)->post(route('logbooks.store'), [
            'internship_application_id' => $pendingApplication->id,
            'judul_kegiatan' => 'Tugas belum diterima',
            'deskripsi' => 'Tugas ini seharusnya tidak boleh masuk karena lamaran belum diterima.',
        ])->assertForbidden();

        $this->actingAs($otherCompanySupervisor)->post(route('logbooks.store'), [
            'internship_application_id' => $application->id,
            'judul_kegiatan' => 'Tugas lintas perusahaan',
            'deskripsi' => 'Pembimbing perusahaan lain tidak boleh memberi tugas mahasiswa ini.',
        ])->assertForbidden();

        $this->actingAs($student)->post(route('logbooks.store'), [
            'internship_application_id' => $application->id,
            'judul_kegiatan' => 'Mahasiswa mencoba membuat tugas sendiri',
            'deskripsi' => 'Tugas harus dibuat oleh penanggung jawab perusahaan.',
        ])->assertForbidden();

        $this->actingAs($companySupervisor)->post(route('logbooks.store'), [
            'internship_application_id' => $application->id,
            'judul_kegiatan' => 'Setup lingkungan kerja',
            'deskripsi' => 'Pelajari repositori, alur kerja tim, dan dokumentasi internal.',
            'due_date' => now()->addWeek()->toDateString(),
        ])->assertRedirect();

        $logbook = LogbookEntry::firstOrFail();
        $this->assertSame('todo', $logbook->status);
        $this->assertSame($companySupervisor->id, $logbook->assigned_by_id);
        Notification::assertSentTo($student, PlatformUpdateNotification::class);

        $this->actingAs($otherCompanySupervisor)->patch(route('logbooks.update', $logbook), [
            'score' => 90,
        ])->assertForbidden();

        $this->actingAs($student)->patch(route('logbooks.update', $logbook), [
            'status' => 'in_progress',
            'kendala' => 'Sedang mempelajari struktur repositori.',
        ])->assertRedirect();

        $this->assertDatabaseHas('logbook_entries', [
            'id' => $logbook->id,
            'status' => 'in_progress',
            'kendala' => 'Sedang mempelajari struktur repositori.',
        ]);

        $this->actingAs($student)->patch(route('logbooks.update', $logbook), [
            'status' => 'done',
            'kendala' => 'Setup selesai dan dokumentasi awal sudah dibaca.',
        ])->assertRedirect();

        $logbook->refresh();
        $this->assertSame('done', $logbook->status);
        $this->assertNotNull($logbook->completed_at);

        $this->actingAs($companySupervisor)->patch(route('logbooks.update', $logbook), [
            'score' => 91,
            'score_notes' => 'Pengerjaan rapi dan cepat.',
            'catatan_pembimbing' => 'Lanjutkan ke task integrasi.',
        ])->assertRedirect();

        $this->assertDatabaseHas('logbook_entries', [
            'id' => $logbook->id,
            'score' => 91,
            'score_notes' => 'Pengerjaan rapi dan cepat.',
        ]);

        $this->actingAs($lecturer)->post(route('evaluations.store', $application), $this->evaluationPayload('Evaluasi kampus baik.'))
            ->assertRedirect();

        $this->actingAs($companySupervisor)->post(route('evaluations.store', $application), $this->evaluationPayload('Evaluasi perusahaan baik.'))
            ->assertRedirect();

        $this->assertSame(2, Evaluation::count());

        $otherOffer = InternshipOffer::factory()->published()->for($otherCompany)->create(['judul' => 'Lowongan Rahasia Kampus Lain']);
        InternshipOfferUniversity::factory()->accepted()->for($otherOffer, 'offer')->for($otherUniversity)->create();
        InternshipApplication::factory()->accepted()->create([
            'internship_offer_id' => $otherOffer->id,
            'student_id' => $otherStudent->id,
        ]);

        $this->actingAs($student)->get(route('evaluations.index'))
            ->assertOk()
            ->assertSee($offer->judul)
            ->assertDontSee('Lowongan Rahasia Kampus Lain');
    }

    private function validOfferPayload(Company $company, array $universityIds): array
    {
        return [
            'company_id' => $company->id,
            'university_ids' => $universityIds,
            'judul' => 'Backend Developer Intern',
            'bidang' => 'Software Engineering',
            'lokasi' => 'Jakarta',
            'tipe_kerja' => 'hybrid',
            'kuota' => 2,
            'tanggal_mulai' => now()->addWeeks(2)->toDateString(),
            'tanggal_selesai' => now()->addMonths(5)->toDateString(),
            'batas_lamaran' => now()->addWeek()->toDateString(),
            'deskripsi' => 'Mahasiswa membantu pengembangan layanan internal perusahaan.',
            'persyaratan' => 'Memahami dasar pemrograman web.',
            'benefit' => 'Mentoring dan sertifikat.',
            'status' => 'menunggu',
        ];
    }

    private function evaluationPayload(string $catatan): array
    {
        return [
            'nilai_komunikasi' => 86,
            'nilai_kedisiplinan' => 88,
            'nilai_teknis' => 90,
            'nilai_kerja_sama' => 87,
            'catatan' => $catatan,
        ];
    }
}
