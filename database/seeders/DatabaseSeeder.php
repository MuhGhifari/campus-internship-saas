<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\CompanyPartnership;
use App\Models\Evaluation;
use App\Models\InternshipApplication;
use App\Models\InternshipOffer;
use App\Models\InternshipOfferUniversity;
use App\Models\LogbookEntry;
use App\Models\University;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $university = University::create([
            'nama' => 'Universitas Nusantara Digital',
            'kode' => 'UND',
            'alamat' => 'Jl. Pendidikan No. 10, Jakarta',
            'email' => 'karier@und.ac.id',
            'telepon' => '021-555-0101',
        ]);

        $company = Company::create([
            'nama' => 'PT Awan Karya Teknologi',
            'industri' => 'Teknologi Informasi',
            'alamat' => 'Jl. Cloud Raya No. 8, Jakarta',
            'website' => 'https://awan-karya.test',
            'kontak_email' => 'hr@awan-karya.test',
            'kontak_telepon' => '021-555-0202',
            'status' => 'aktif',
        ]);

        $staff = User::create([
            'university_id' => $university->id,
            'name' => 'Sinta Career Center',
            'email' => 'staf@careerbridge.test',
            'role' => 'staf',
            'telepon' => '081200000001',
            'password' => 'password',
        ]);

        $lecturer = User::create([
            'university_id' => $university->id,
            'name' => 'Prof. Bima Prakoso',
            'email' => 'dosen@careerbridge.test',
            'role' => 'dosen',
            'nomor_induk' => 'DSN-001',
            'program_studi' => 'Sistem Informasi',
            'telepon' => '081200000002',
            'password' => 'password',
        ]);

        $student = User::create([
            'university_id' => $university->id,
            'name' => 'Nadia Putri',
            'email' => 'mahasiswa@careerbridge.test',
            'role' => 'mahasiswa',
            'nomor_induk' => '2204010101',
            'program_studi' => 'Teknik Informatika',
            'telepon' => '081200000003',
            'password' => 'password',
        ]);

        $companyRepresentative = User::create([
            'university_id' => $university->id,
            'company_id' => $company->id,
            'name' => 'Raka HR Partner',
            'email' => 'hr@careerbridge.test',
            'role' => 'perusahaan',
            'telepon' => '081200000004',
            'password' => 'password',
        ]);

        $backendOffer = InternshipOffer::create([
            'company_id' => $company->id,
            'created_by' => $companyRepresentative->id,
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
            'status' => 'terbit',
        ]);

        CompanyPartnership::create([
            'company_id' => $company->id,
            'university_id' => $university->id,
            'requested_by' => $companyRepresentative->id,
            'reviewed_by' => $staff->id,
            'status' => 'diterima',
            'pesan' => 'Kami ingin membuka program magang teknologi untuk mahasiswa UND.',
            'catatan_review' => 'Disetujui untuk periode magang semester ini.',
            'reviewed_at' => now()->subMonth(),
        ]);

        InternshipOfferUniversity::create([
            'internship_offer_id' => $backendOffer->id,
            'university_id' => $university->id,
            'requested_by' => $companyRepresentative->id,
            'reviewed_by' => $staff->id,
            'status' => 'diterima',
            'catatan_review' => 'Posisi sesuai dengan kompetensi mahasiswa Teknik Informatika.',
            'reviewed_at' => now()->subWeeks(3),
        ]);

        $designOffer = InternshipOffer::create([
            'company_id' => $company->id,
            'created_by' => $staff->id,
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
            'status' => 'terbit',
        ]);

        InternshipOfferUniversity::create([
            'internship_offer_id' => $designOffer->id,
            'university_id' => $university->id,
            'requested_by' => $staff->id,
            'reviewed_by' => $staff->id,
            'status' => 'diterima',
            'catatan_review' => 'Diterima untuk mahasiswa peminatan desain produk.',
            'reviewed_at' => now()->subWeek(),
        ]);

        $application = InternshipApplication::create([
            'internship_offer_id' => $backendOffer->id,
            'student_id' => $student->id,
            'company_supervisor_id' => $companyRepresentative->id,
            'campus_supervisor_id' => $lecturer->id,
            'status' => 'berjalan',
            'motivasi' => 'Saya ingin memperdalam pengembangan backend dan memahami praktik kerja tim produk di perusahaan teknologi.',
            'tanggal_mulai' => now()->subWeeks(2)->toDateString(),
            'tanggal_selesai' => now()->addMonths(4)->toDateString(),
            'diterima_pada' => now()->subWeeks(3),
        ]);

        LogbookEntry::create([
            'internship_application_id' => $application->id,
            'student_id' => $student->id,
            'tanggal' => now()->subDay()->toDateString(),
            'judul_kegiatan' => 'Membuat endpoint daftar lowongan',
            'deskripsi' => 'Membuat endpoint API untuk menampilkan daftar lowongan internal, menambahkan validasi query, dan mencoba pagination.',
            'kendala' => 'Masih perlu memahami struktur response standar perusahaan.',
            'status' => 'disetujui',
            'catatan_pembimbing' => 'Progres baik, lanjutkan dokumentasi endpoint.',
        ]);

        Evaluation::create([
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
