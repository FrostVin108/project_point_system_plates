<?php
/**
 * surat_sp.php
 * Template HTML surat pernyataan siswa.
 * File ini murni template — tidak boleh diakses langsung.
 * Dipanggil oleh export_sp.php yang menyediakan semua variabel.
 *
 * Variabel yang harus tersedia saat di-include:
 *   $logoTag        string  — tag <img> logo, atau '' jika tidak ada
 *   $spLabel        string  — "SP1", "SP2", dst.
 *   $tglCetak       string  — tanggal cetak format Indonesia
 *   $nama           string  — nama siswa (sudah di-escape)
 *   $nis            string  — NIS siswa
 *   $kelas          string  — kelas lengkap
 *   $jurusan        string  — program keahlian / jurusan
 *   $namaOrtu       string  — nama orang tua
 *   $pekerjaanOrtu  string  — pekerjaan orang tua
 *   $alamatOrtu     string  — alamat orang tua
 *   $telpOrtu       string  — no. hp/telp orang tua
 */
if (!defined('EXPORT_SP_ENTRY')) {
    http_response_code(403);
    die('Akses langsung tidak diizinkan.');
}

$dots = str_repeat('.', 80);

// ── Style helper ──────────────────────────────────────────────────────────
$fBase  = 'font-family:Arial,sans-serif;font-size:11pt;';
$fTitle = 'font-family:Arial,sans-serif;font-size:14pt;font-weight:bold;text-align:center;margin:0 0 0 0;padding:0;';
$fBody  = 'font-family:Arial,sans-serif;font-size:11pt;text-align:justify;line-height:1.8;margin:0 0 10px 0;';
$fLabel = 'font-family:Arial,sans-serif;font-size:11pt;vertical-align:top;white-space:nowrap;padding:0 0 5px 0;';
$fColon = 'font-family:Arial,sans-serif;font-size:11pt;vertical-align:top;padding:0 8px 5px 8px;';
$fVal   = 'font-family:Arial,sans-serif;font-size:11pt;vertical-align:top;padding:0 0 5px 0;width:100%;';
$fTTD   = 'font-family:Arial,sans-serif;font-size:11pt;text-align:center;vertical-align:top;padding:0 10px;';

// ── Helper: baris field satu baris ────────────────────────────────────────
function spFieldRow(string $label, string $value, string $dots,
                    string $fLabel, string $fColon, string $fVal): string {
    $display = $value !== '' ? $value : $dots;
    return "<tr>
        <td style=\"{$fLabel}\">{$label}</td>
        <td style=\"{$fColon}\">:</td>
        <td style=\"{$fVal}\">{$display}</td>
    </tr>\n";
}
?>
<html xmlns:o="urn:schemas-microsoft-com:office:office"
      xmlns:w="urn:schemas-microsoft-com:office:word"
      xmlns="http://www.w3.org/TR/REC-html40">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="ProgId"      content="Word.Document">
    <meta name="Generator"   content="Microsoft Word 15">
    <meta name="Originator"  content="Microsoft Word 15">
    <!--[if gte mso 9]><xml>
     <w:WordDocument>
      <w:View>Print</w:View>
      <w:Zoom>100</w:Zoom>
      <w:DoNotOptimizeForBrowser/>
     </w:WordDocument>
    </xml><![endif]-->
    <style>
        @page { size:A4; margin:2.5cm 2.5cm 2.5cm 2.5cm; }
        body  { font-family:Arial,sans-serif; font-size:11pt; margin:0; padding:0; }
        p     { margin:0; padding:0; }
        table { border-collapse:collapse; }
    </style>
</head>
<body>

<!-- ══════════════════════════════════════════
     LOGO SEKOLAH
══════════════════════════════════════════ -->
<?php if ($logoTag): ?>
<p style="text-align:center;margin:0 0 8px 0;"><?= $logoTag ?></p>
<?php endif; ?>

<!-- ══════════════════════════════════════════
     JUDUL
══════════════════════════════════════════ -->
<p style="<?= $fTitle ?>">SURAT PERNYATAAN SISWA</p>
<p style="font-family:Arial,sans-serif;font-size:11pt;text-align:center;margin:0 0 4px 0;">(<?= $spLabel ?>)</p>
<p style="margin:0 0 16px 0;">&nbsp;</p>

<!-- ══════════════════════════════════════════
     PEMBUKA
══════════════════════════════════════════ -->
<p style="<?= $fBase ?>margin:0 0 6px 0;">Yang bertandatangan dibawah ini:</p>
<p style="margin:0 0 10px 0;">&nbsp;</p>

<!-- ══════════════════════════════════════════
     TABEL DATA
══════════════════════════════════════════ -->
<table style="width:100%;border-collapse:collapse;margin-bottom:4px;">

    <?= spFieldRow('Nama',             $nama,          $dots, $fLabel, $fColon, $fVal) ?>
    <?= spFieldRow('NIS',              $nis,           $dots, $fLabel, $fColon, $fVal) ?>
    <?= spFieldRow('Kelas',            $kelas,         $dots, $fLabel, $fColon, $fVal) ?>
    <?= spFieldRow('Program Keahlian', $jurusan,       $dots, $fLabel, $fColon, $fVal) ?>

    <!-- Masalah: label + titik-titik 3 baris -->
    <tr>
        <td style="<?= $fLabel ?>">Masalah</td>
        <td style="<?= $fColon ?>">:</td>
        <td style="<?= $fVal ?>"><?= $dots ?></td>
    </tr>
    <tr>
        <td colspan="2"></td>
        <td style="<?= $fVal ?>"><?= $dots ?></td>
    </tr>
    <tr>
        <td colspan="2"></td>
        <td style="<?= $fVal ?>padding-bottom:8px;"><?= $dots ?></td>
    </tr>

    <?= spFieldRow('Nama Orang Tua',   $namaOrtu,      $dots, $fLabel, $fColon, $fVal) ?>
    <?= spFieldRow('Pekerjaan',        $pekerjaanOrtu, $dots, $fLabel, $fColon, $fVal) ?>
    <?= spFieldRow('Alamat Orang Tua', $alamatOrtu,    $dots, $fLabel, $fColon, $fVal) ?>
    <?= spFieldRow('No. Hp / Telp',    $telpOrtu,      $dots, $fLabel, $fColon, $fVal) ?>

</table>

<p style="margin:0 0 16px 0;">&nbsp;</p>

<!-- ══════════════════════════════════════════
     ISI PERNYATAAN
══════════════════════════════════════════ -->
<p style="<?= $fBody ?>">
Menyatakan dan berjanji akan bersungguh-sungguh berubah dan bersedia mentaati aturan dan tata tertib
sekolah. Apabila selama masa pembinaan tidak mengalami perubahan, maka siswa yang bersangkutan
dikembalikan kepada orang tua/wali.
</p>
<p style="<?= $fBody ?>margin:0 0 28px 0;">
Demikian surat pernyataan ini saya buat dengan sesungguhnya tanpa ada tekanan dari siapapun.
</p>

<!-- ══════════════════════════════════════════
     TANDA TANGAN
══════════════════════════════════════════ -->
<table style="width:100%;border-collapse:collapse;">
    <tr>
        <!-- Orang Tua / Wali -->
        <td style="<?= $fTTD ?>width:33%;">
            <p style="margin:0 0 4px 0;">Orang Tua / Wali,</p>
            <br><br><br><br><br>
            <p style="margin:0;">(________________________________)</p>
            <p style="margin:0;"><?= $namaOrtu !== '' ? $namaOrtu : '......................................' ?></p>
        </td>

        <!-- Siswa -->
        <td style="<?= $fTTD ?>width:34%;">
            <p style="margin:0 0 4px 0;">Siswa yang bersangkutan,</p>
            <br><br><br><br><br>
            <p style="margin:0;">(________________________________)</p>
            <p style="margin:0;"><?= $nama !== '' ? $nama : '......................................' ?></p>
        </td>

        <!-- Wali Kelas / BK -->
        <td style="<?= $fTTD ?>width:33%;">
            <p style="margin:0 0 0 0;"><?= $tglCetak ?></p>
            <p style="margin:0 0 4px 0;">Wali Kelas / BK,</p>
            <br><br><br><br><br>
            <p style="margin:0;">(________________________________)</p>
            <p style="margin:0;">NIP. ......................................</p>
        </td>
    </tr>
</table>

</body>
</html>