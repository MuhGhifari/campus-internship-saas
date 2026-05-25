<?php

namespace Database\Seeders;

use App\Models\Evaluation;
use App\Models\InternshipApplication;
use App\Models\InternshipOffer;
use App\Models\LogbookEntry;
use App\Models\User;
use Illuminate\Database\Seeder;

class InternshipApplicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $backendOffer = InternshipOffer::where('judul', 'Backend Developer Intern')->firstOrFail();
        $student = User::where('email', 'mahasiswa@careerbridge.test')->firstOrFail();
        $lecturer = User::where('email', 'pembimbing-kampus@careerbridge.test')->firstOrFail();
        $companySupervisor = User::where('email', 'pj-perusahaan@careerbridge.test')->firstOrFail();

        $application = InternshipApplication::factory()->accepted()->create([
            'internship_offer_id' => $backendOffer->id,
            'student_id' => $student->id,
            'company_supervisor_id' => $companySupervisor->id,
            'campus_supervisor_id' => $lecturer->id,
            'motivasi' => 'Saya ingin memperdalam pengembangan backend dan memahami praktik kerja tim produk di perusahaan teknologi.',
        ]);

        LogbookEntry::factory()->approved()->create([
            'internship_application_id' => $application->id,
            'student_id' => $student->id,
            'assigned_by_id' => $companySupervisor->id,
            'tanggal' => now()->subDay()->toDateString(),
            'due_date' => now()->addDays(3)->toDateString(),
            'judul_kegiatan' => 'Membuat endpoint daftar lowongan',
            'deskripsi' => 'Membuat endpoint API untuk menampilkan daftar lowongan internal, menambahkan validasi query, dan mencoba pagination.',
            'kendala' => 'Masih perlu memahami struktur response standar perusahaan.',
            'catatan_pembimbing' => 'Progres baik, lanjutkan dokumentasi endpoint.',
            'score' => 88,
            'score_notes' => 'Endpoint sudah berjalan dan struktur response mulai rapi.',
        ]);

        Evaluation::factory()->create([
            'internship_application_id' => $application->id,
            'evaluator_id' => $lecturer->id,
            'tipe' => 'kampus',
            'nilai_komunikasi' => 86,
            'nilai_kedisiplinan' => 90,
            'nilai_teknis' => 84,
            'nilai_kerja_sama' => 88,
            'catatan' => 'Mahasiswa aktif melaporkan progres dan mampu menghubungkan pekerjaan dengan capaian pembelajaran.',
        ]);
    }
}
