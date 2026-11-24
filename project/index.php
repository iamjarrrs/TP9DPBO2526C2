<?php
require_once __DIR__ . '/models/TabelKandidat.php';
require_once __DIR__ . '/views/ViewKandidat.php';
require_once __DIR__ . '/presenters/PresenterKandidat.php';

$model = new TabelKandidat('localhost', 'mvp_kandidat_db', 'root', '');
$view = new ViewKandidat();
$presenter = new PresenterKandidat($model, $view);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    $nama = trim((string)($_POST['nama'] ?? ''));
    $posisi = trim((string)($_POST['posisi'] ?? ''));
    $domisili = trim((string)($_POST['domisili'] ?? ''));
    $skorTes = max(0, min(100, (int)($_POST['skorTes'] ?? 0)));
    $pengalamanTahun = max(0, (int)($_POST['pengalamanTahun'] ?? 0));

    if (($action === 'tambah' || $action === 'ubah') &&
        ($nama === '' || $posisi === '' || $domisili === '')) {
        header("Location: index.php");
        exit();
    }

    if ($action === 'tambah') {
        $presenter->tambahKandidat($nama, $posisi, $domisili, $skorTes, $pengalamanTahun);
    } elseif ($action === 'ubah') {
        $presenter->ubahKandidat(
            (int)($_POST['id'] ?? 0),
            $nama,
            $posisi,
            $domisili,
            $skorTes,
            $pengalamanTahun
        );
    } elseif ($action === 'hapus') {
        $presenter->hapusKandidat((int)($_POST['id'] ?? 0));
    }

    header("Location: index.php");
    exit();
} else {
    $screen = $_GET['screen'] ?? 'list';
    if ($screen === 'add') {
        echo $presenter->tampilkanFormKandidat();
    } elseif ($screen === 'edit' && isset($_GET['id'])) {
        echo $presenter->tampilkanFormKandidat((int)$_GET['id']);
    } else {
        echo $presenter->tampilkanKandidat();
    }
}
?>

