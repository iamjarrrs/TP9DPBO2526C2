<?php
interface KontrakModelLowongan {
    /**
     * @return Lowongan[]
     */
    public function getAllLowongan(): array;

    public function getLowonganById(int $id): ?Lowongan;

    public function addLowongan(
        string $judul,
        string $departemen,
        string $lokasi,
        string $jenis,
        int $kuota,
        string $status
    ): void;

    public function updateLowongan(
        int $id,
        string $judul,
        string $departemen,
        string $lokasi,
        string $jenis,
        int $kuota,
        string $status
    ): void;

    public function deleteLowongan(int $id): void;
}
?>
