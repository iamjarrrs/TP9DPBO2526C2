<?php
require_once __DIR__ . '/models/TabelLowongan.php';
require_once __DIR__ . '/views/ViewLowongan.php';
require_once __DIR__ . '/presenters/PresenterLowongan.php';

$model = new TabelLowongan('localhost', 'mvp_kandidat_db', 'root', '');
$view = new ViewLowongan();
$presenter = new PresenterLowongan($model, $view);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    $judul = trim((string)($_POST['judul'] ?? ''));
    $departemen = trim((string)($_POST['departemen'] ?? ''));
    $lokasi = trim((string)($_POST['lokasi'] ?? ''));
    $jenis = trim((string)($_POST['jenis'] ?? 'Full-time'));
    $kuota = max(1, (int)($_POST['kuota'] ?? 1));

    $status = trim((string)($_POST['status'] ?? 'Buka'));
    if (!in_array($status, ['Buka', 'Ditutup'], true)) {
        $status = 'Buka';
    }

    if (($action === 'tambah' || $action === 'ubah') &&
        ($judul === '' || $departemen === '' || $lokasi === '' || $jenis === '')) {
        header("Location: lowongan.php");
        exit();
    }

    if ($action === 'tambah') {
        $presenter->tambahLowongan($judul, $departemen, $lokasi, $jenis, $kuota, $status);
    } elseif ($action === 'ubah') {
        $presenter->ubahLowongan(
            (int)($_POST['id'] ?? 0),
            $judul,
            $departemen,
            $lokasi,
            $jenis,
            $kuota,
            $status
        );
    } elseif ($action === 'hapus') {
        $presenter->hapusLowongan((int)($_POST['id'] ?? 0));
    }

    header("Location: lowongan.php");
    exit();
} else {
    $screen = $_GET['screen'] ?? 'list';
    if ($screen === 'add') {
        echo $presenter->tampilkanFormLowongan();
    } elseif ($screen === 'edit' && isset($_GET['id'])) {
        echo $presenter->tampilkanFormLowongan((int)$_GET['id']);
    } else {
        echo $presenter->tampilkanLowongan();
    }
}
?>
