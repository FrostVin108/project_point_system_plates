<?php
// CARA 1 — Header flat, tanpa rowspan/colspan
$th = 'border:1px solid #000000;padding:5px 4px;text-align:center;font-weight:bold;font-family:Arial;font-size:9pt;';
$td = 'border:1px solid #000000;padding:4px;font-family:Arial;font-size:9pt;';
$tdc = $td . 'text-align:center;';
?>
<p style="font-family:Arial;font-size:13pt;font-weight:bold;text-align:center;">LAPORAN DATA PELANGGARAN SISWA</p>
<p style="font-family:Arial;font-size:10pt;font-style:italic;text-align:center;">Periode : <?= htmlspecialchars($periode) ?></p>

<table style="width:100%;border-collapse:collapse;">
  <tr>
    <td style="<?= $th ?>width:8%;">TGL</td>
    <td style="<?= $th ?>width:18%;">NAMA</td>
    <td style="<?= $th ?>width:10%;">KELAS</td>
    <?php foreach ($allJenis as $j): ?>
    <td style="<?= $th ?>"><?= htmlspecialchars($jenisMap[$j['id']]['singkatan']) ?></td>
    <?php endforeach; ?>
    <td style="<?= $th ?>width:20%;">KETERANGAN</td>
  </tr>
  <?php if (empty($rows)): ?>
  <tr>
    <td colspan="<?= 4 + count($allJenis) ?>" style="<?= $tdc ?>font-style:italic;">Tidak ada data.</td>
  </tr>
  <?php else: ?>
  <?php foreach ($rows as $r): ?>
  <tr>
    <td style="<?= $tdc ?>"><?= htmlspecialchars($r['date_fmt']) ?></td>
    <td style="<?= $td ?>"><?= htmlspecialchars($r['siswa_name']) ?></td>
    <td style="<?= $tdc ?>"><?= htmlspecialchars($r['kelas']) ?></td>
    <?php foreach ($allJenis as $j): ?>
    <td style="<?= $tdc ?>"><?= ((string)$r['id_jenis'] === (string)$j['id']) ? '&#10003;' : '' ?></td>
    <?php endforeach; ?>
    <td style="<?= $td ?>"><?= htmlspecialchars($r['alasan_detail']) ?></td>
  </tr>
  <?php endforeach; ?>
  <?php endif; ?>
</table>

<p style="font-family:Arial;font-size:9pt;text-align:right;">Total: <strong><?= (int)$total_data ?></strong> pelanggaran</p>

<table style="width:100%;border-collapse:collapse;">
  <tr>
    <td style="width:55%;border:none;"></td>
    <td style="width:45%;border:none;text-align:center;">
      <p style="font-family:Arial;font-size:10pt;text-align:center;">Kota, <?= htmlspecialchars($cetak_pada) ?></p>
      <p style="font-family:Arial;font-size:10pt;text-align:center;">Kepala Sekolah,</p>
      <p style="font-family:Arial;font-size:10pt;">&nbsp;</p>
      <p style="font-family:Arial;font-size:10pt;">&nbsp;</p>
      <p style="font-family:Arial;font-size:10pt;">&nbsp;</p>
      <p style="font-family:Arial;font-size:10pt;">&nbsp;</p>
      <p style="font-family:Arial;font-size:10pt;font-weight:bold;text-align:center;">(________________________________)</p>
      <p style="font-family:Arial;font-size:10pt;text-align:center;">NIP. ........................................</p>
    </td>
  </tr>
</table>