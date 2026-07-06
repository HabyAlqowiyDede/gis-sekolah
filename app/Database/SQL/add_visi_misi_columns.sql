-- SQL Script untuk menambahkan kolom Visi dan Misi ke tabel sekolah
-- Jalankan query ini jika migration tidak bekerja atau sebagai alternatif

ALTER TABLE tbl_sekolah ADD COLUMN IF NOT EXISTS visi TEXT NULL AFTER banyak_guru;
ALTER TABLE tbl_sekolah ADD COLUMN IF NOT EXISTS misi TEXT NULL AFTER visi;

-- Verifikasi kolom berhasil ditambahkan
DESCRIBE tbl_sekolah;
