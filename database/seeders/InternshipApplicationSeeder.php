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
        $lecturer = User::where('email', 'dosen@careerbridge.test')->firstOrFail();
        $companyRepresentative = User::where('email', 'hr@careerbridge.test')->firstOrFail();

        $application = InternshipApplication::factory()->accepted()->create([
            'internship_offer_id' => $backendOffer->id,
            'student_id' => $student->id,
            'company_supervisor_id' => $companyRepresentative->id,
            'campus_supervisor_id' => $lecturer->id,
            'motivasi' => 'Saya ingin memperdalam pengembangan backend dan memahami praktik kerja tim produk di perusahaan teknologi.',
        ]);

        LogbookEntry::factory()->approved()->create([
            'internship_application_id' => $application->id,
            'student_id' => $student->id,
            'tanggal' => now()->subDay()->toDateString(),
            'judul_kegiatan' => 'Membuat endpoint daftar lowongan',
            'deskripsi' => 'Membuat endpoint API untuk menampilkan daftar lowongan internal, menambahkan validasi query, dan mencoba pagination.',
            'kendala' => 'Masih perlu memahami struktur response standar perusahaan.',
            'catatan_pembimbing' => 'Progres baik, lanjutkan dokumentasi endpoint.',
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
