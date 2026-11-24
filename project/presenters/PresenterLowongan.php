<?php
require_once __DIR__ . '/KontrakPresenterLowongan.php';
require_once __DIR__ . '/../models/KontrakModelLowongan.php';
require_once __DIR__ . '/../models/Lowongan.php';
require_once __DIR__ . '/../views/KontrakViewLowongan.php';

class PresenterLowongan implements KontrakPresenterLowongan {
    private KontrakModelLowongan $model;
    private KontrakViewLowongan $view;

    public function __construct(KontrakModelLowongan $model, KontrakViewLowongan $view) {
        $this->model = $model;
        $this->view = $view;
    }

    /**
     * Helper untuk merakit 1 baris HTML tabel lowongan.
     */
    private function buildRowHtml(int $no, Lowongan $lowongan): string {
        $id = (int)$lowongan->getId();
        $judul = htmlspecialchars($lowongan->getJudul());
        $departemen = htmlspecialchars($lowongan->getDepartemen());
        $lokasi = htmlspecialchars($lowongan->getLokasi());
        $jenis = htmlspecialchars($lowongan->getJenis());
        $kuota = number_format($lowongan->getKuota()) . ' orang';
        $status = htmlspecialchars($lowongan->getStatus());
        $statusClass = $status === 'Buka' ? 'status-buka' : 'status-tutup';

        return "<tr>
            <td class='col-id'>{$no}</td>
            <td><strong>{$judul}</strong></td>
            <td>{$departemen}</td>
            <td>{$lokasi}</td>
            <td>{$jenis}</td>
            <td>{$kuota}</td>
            <td><span class='status {$statusClass}'>{$status}</span></td>
            <td class='col-actions'>
                <a href='lowongan.php?screen=edit&id={$id}' class='btn btn-edit'>Edit</a>
                <form method='post' action='lowongan.php' style='display:inline;' onsubmit=\"return confirm('Hapus lowongan ini?')\">
                    <input type='hidden' name='action' value='hapus'>
                    <input type='hidden' name='id' value='{$id}'>
                    <button type='submit' class='btn btn-delete'>Hapus</button>
                </form>
            </td>
        </tr>";
    }

    public function tampilkanLowongan(): string {
        $listLowongan = $this->model->getAllLowongan();
        $totalLowongan = count($listLowongan);

        $rowsHtml = '';
        if (empty($listLowongan)) {
            $rowsHtml = '<tr><td colspan="8"
style="text-align:center;color:#6b7280;padding:24px;">Belum ada data
lowongan.</td></tr>';
        } else {
            $no = 1;
            foreach ($listLowongan as $lowongan) {
                $rowsHtml .= $this->buildRowHtml($no, $lowongan);
                $no++;
            }
        }

        return $this->view->renderDaftar($rowsHtml, $totalLowongan);
    }

    public function tampilkanFormLowongan(?int $id = null): string {
        if ($id !== null) {
            $lowongan = $this->model->getLowonganById($id);
            if ($lowongan === null) {
                header("Location: lowongan.php");
                exit();
            }

            $formData = [
                'id'         => $lowongan->getId(),
                'judul'      => $lowongan->getJudul(),
                'departemen' => $lowongan->getDepartemen(),
                'lokasi'     => $lowongan->getLokasi(),
                'jenis'      => $lowongan->getJenis(),
                'kuota'      => $lowongan->getKuota(),
                'status'     => $lowongan->getStatus(),
            ];
            return $this->view->renderForm("Ubah Data Lowongan", "ubah", $formData);
        }

        return $this->view->renderForm("Tambah Lowongan Baru", "tambah", []);
    }

    public function tambahLowongan(
        string $judul,
        string $departemen,
        string $lokasi,
        string $jenis,
        int $kuota,
        string $status
    ): void {
        $this->model->addLowongan($judul, $departemen, $lokasi, $jenis, $kuota, $status);
        header("Location: lowongan.php");
        exit();
    }

    public function ubahLowongan(
        int $id,
        string $judul,
        string $departemen,
        string $lokasi,
        string $jenis,
        int $kuota,
        string $status
    ): void {
        $this->model->updateLowongan($id, $judul, $departemen, $lokasi, $jenis, $kuota, $status);
        header("Location: lowongan.php");
        exit();
    }

    public function hapusLowongan(int $id): void {
        $this->model->deleteLowongan($id);
        header("Location: lowongan.php");
        exit();
    }
}
?>
