<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\InternshipOffer;
use App\Models\InternshipOfferUniversity;
use App\Models\University;
use App\Models\User;
use Illuminate\Database\Seeder;

class InternshipOfferSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $und = University::where('kode', 'UND')->firstOrFail();
        $its = University::where('kode', 'ITS')->firstOrFail();
        $awanKarya = Company::where('nama', 'PT Awan Karya Teknologi')->firstOrFail();
        $raka = User::where('email', 'hr@careerbridge.test')->firstOrFail();
        $sinta = User::where('email', 'staf@careerbridge.test')->firstOrFail();

        $backendOffer = InternshipOffer::factory()->published()->create([
            'company_id' => $awanKarya->id,
            'created_by' => $raka->id,
            'judul' => 'Backend Developer Intern',
            'bidang' => 'Software Engineering',
            'lokasi' => 'Jakarta Selatan',
            'tipe_kerja' => 'hybrid',
            'kuota' => 3,
            'tanggal_mulai' => now()->addWeeks(3)->toDateString(),
            'tanggal_selesai' => now()->addMonths(5)->toDateString(),
            'batas_lamaran' => now()->addDays(14)->toDateString(),
            'deskripsi' => 'Membantu tim produk membangun API, integrasi database, dan fitur internal menggunakan Laravel.',
            'persyaratan' => 'Memahami dasar PHP, Laravel, Git, REST API, dan database relasional.',
            'benefit' => 'Mentoring mingguan, sertifikat, uang transport, dan kesempatan proyek nyata.',
        ]);

        InternshipOfferUniversity::factory()->accepted()->create([
            'internship_offer_id' => $backendOffer->id,
            'university_id' => $und->id,
            'requested_by' => $raka->id,
            'reviewed_by' => $sinta->id,
            'catatan_review' => 'Posisi sesuai dengan kompetensi mahasiswa Teknik Informatika.',
            'reviewed_at' => now()->subWeeks(3),
        ]);

        InternshipOfferUniversity::factory()->create([
            'internship_offer_id' => $backendOffer->id,
            'university_id' => $its->id,
            'requested_by' => $raka->id,
            'status' => 'menunggu',
        ]);

        $designOffer = InternshipOffer::factory()->published()->create([
            'company_id' => $awanKarya->id,
            'created_by' => $raka->id,
            'judul' => 'UI/UX Research Intern',
            'bidang' => 'Product Design',
            'lokasi' => 'Remote',
            'tipe_kerja' => 'remote',
            'kuota' => 2,
            'tanggal_mulai' => now()->addMonth()->toDateString(),
            'tanggal_selesai' => now()->addMonths(4)->toDateString(),
            'batas_lamaran' => now()->addDays(21)->toDateString(),
            'deskripsi' => 'Melakukan riset pengguna, membuat wireframe, dan menyusun insight untuk pengembangan produk.',
            'persyaratan' => 'Mampu membuat persona, user journey, dan prototype dasar.',
            'benefit' => 'Portfolio case study, sesi review desain, dan sertifikat magang.',
        ]);

        InternshipOfferUniversity::factory()->accepted()->create([
            'internship_offer_id' => $designOffer->id,
            'university_id' => $und->id,
            'requested_by' => $raka->id,
            'reviewed_by' => $sinta->id,
            'catatan_review' => 'Diterima untuk mahasiswa peminatan desain produk.',
            'reviewed_at' => now()->subWeek(),
        ]);
    }
}
