<?php
require_once __DIR__ . '/KontrakViewLowongan.php';

class ViewLowongan implements KontrakViewLowongan {
    private string $skinPath;
    private string $formPath;

    public function __construct(string $skinPath = '', string $formPath = '') {
        $this->skinPath = $skinPath ?: __DIR__ . '/../template/lowongan_skin.html';
        $this->formPath = $formPath ?: __DIR__ . '/../template/lowongan_form.html';
    }

    public function renderDaftar(string $tableRowsHtml, int $totalData): string {
        $template = file_get_contents($this->skinPath);

        $tokens = [
            '{{TABLE_ROWS}}' => $tableRowsHtml,
            '{{TOTAL_DATA}}' => (string)$totalData,
        ];

        return str_replace(array_keys($tokens), array_values($tokens), $template);
    }

    public function renderForm(string $title, string $action, array $formData = []): string {
        $template = file_get_contents($this->formPath);

        $tokens = [
            '{{FORM_TITLE}}' => htmlspecialchars($title),
            '{{ACTION}}'     => htmlspecialchars($action),
            '{{ID}}'         => htmlspecialchars((string)($formData['id'] ?? '')),
            '{{JUDUL}}'      => htmlspecialchars($formData['judul'] ?? ''),
            '{{DEPARTEMEN}}' => htmlspecialchars($formData['departemen'] ?? ''),
            '{{LOKASI}}'     => htmlspecialchars($formData['lokasi'] ?? ''),
            '{{JENIS}}'      => htmlspecialchars($formData['jenis'] ?? 'Full-time'),
            '{{KUOTA}}'      => htmlspecialchars((string)($formData['kuota'] ?? 1)),
            '{{STATUS}}'     => htmlspecialchars($formData['status'] ?? 'Buka'),
        ];

        return str_replace(array_keys($tokens), array_values($tokens), $template);
    }
}
?>
