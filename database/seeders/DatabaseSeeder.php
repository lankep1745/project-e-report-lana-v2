<?php

namespace Database\Seeders;

use App\Models\Report;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Admin User
        $admin = User::firstOrCreate(
            ['email' => 'admin@ereport.test'],
            [
                'name' => 'Admin LaporinYuk',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        // 2. Regular User
        $user = User::firstOrCreate(
            ['email' => 'user@ereport.test'],
            [
                'name' => 'Budi Santoso',
                'password' => Hash::make('password'),
                'role' => 'user',
            ]
        );

        // 3. Additional demo user
        $user2 = User::firstOrCreate(
            ['email' => 'siti@ereport.test'],
            [
                'name' => 'Siti Nurhaliza',
                'password' => Hash::make('password'),
                'role' => 'user',
            ]
        );

        // 4. Sample Reports
        $samples = [
            [
                'user_id' => $user->id,
                'title' => 'Lampu Penerangan Jalan Rusak di Blok B7',
                'category' => 'Fasilitas',
                'description' => 'Lampu tiang nomor 14 di tikungan Blok B7 sudah padam sejak 3 hari lalu. Lokasi menjadi sangat gelap di malam hari dan rawan bagi pejalan kaki.',
                'evidence_path' => null,
                'status' => 'Menunggu',
                'admin_response' => null,
                'responded_at' => null,
            ],
            [
                'user_id' => $user->id,
                'title' => 'Penumpukan Sampah Liar di Pinggir Taman Kota',
                'category' => 'Kebersihan',
                'description' => 'Ada oknum yang membuang sampah sisa material dan kantong plastik besar di trotoar sebelah barat taman kota. Mengeluarkan bau menyengat.',
                'evidence_path' => null,
                'status' => 'Diproses',
                'admin_response' => 'Laporan telah diverifikasi oleh tim kebersihan. Armada truk pengangkut sedang dijadwalkan meluncur sore ini ke lokasi.',
                'responded_at' => now()->subHours(2),
            ],
            [
                'user_id' => $user2->id,
                'title' => 'Lubang Dalam di Jalur Utama Sepeda',
                'category' => 'Keamanan',
                'description' => 'Terdapat aspal amblas sedalam sekitar 15cm tepat di tengah jalur sepeda jl. Pemuda. Berbahaya sekali saat hujan tergenang.',
                'evidence_path' => null,
                'status' => 'Selesai',
                'admin_response' => 'Terima kasih atas laporannya! Petugas dinas PU telah melakukan penambalan aspal darurat dan area sudah aman dilintasi.',
                'responded_at' => now()->subDay(),
            ],
            [
                'user_id' => $user->id,
                'title' => 'Antrean Loket Pelayanan KTP Sangat Lambat',
                'category' => 'Layanan',
                'description' => 'Hanya satu loket verifikasi dokumen yang dibuka pada jam sibuk pukul 10:00 pagi sehingga warga menumpuk sampai luar ruangan.',
                'evidence_path' => null,
                'status' => 'Diproses',
                'admin_response' => 'Kasie Pelayanan sudah menginstruksikan pembukaan 2 loket tambahan untuk mengurai antrean.',
                'responded_at' => now()->subMinutes(45),
            ],
        ];

        foreach ($samples as $sample) {
            Report::create($sample);
        }
    }
}
