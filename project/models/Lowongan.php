<?php
class Lowongan {
    private ?int $id;
    private string $judul;
    private string $departemen;
    private string $lokasi;
    private string $jenis;
    private int $kuota;
    private string $status;

    public function __construct(
        ?int $id,
        string $judul,
        string $departemen,
        string $lokasi,
        string $jenis,
        int $kuota,
        string $status
    ) {
        $this->id = $id;
        $this->judul = $judul;
        $this->departemen = $departemen;
        $this->lokasi = $lokasi;
        $this->jenis = $jenis;
        $this->kuota = $kuota;
        $this->status = $status;
    }

    public function getId(): ?int { return $this->id; }
    public function getJudul(): string { return $this->judul; }
    public function getDepartemen(): string { return $this->departemen; }
    public function getLokasi(): string { return $this->lokasi; }
    public function getJenis(): string { return $this->jenis; }
    public function getKuota(): int { return $this->kuota; }
    public function getStatus(): string { return $this->status; }
}
?>
