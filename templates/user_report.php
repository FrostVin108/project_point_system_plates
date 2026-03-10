<?php
$th  = 'border:1px solid #000000;padding:4px;text-align:center;font-weight:bold;font-family:Arial;font-size:9pt;vertical-align:middle;';
$td  = 'border:1px solid #000000;padding:4px;font-family:Arial;font-size:9pt;vertical-align:middle;';
$tdc = 'border:1px solid #000000;padding:4px;text-align:center;font-family:Arial;font-size:9pt;vertical-align:middle;';

$jenisList   = ['A', 'B', 'C', 'D', 'E'];
$jumlahJenis = count($jenisList);
?>
<p style="font-family:Arial;font-size:13pt;font-weight:bold;text-align:center;">User Report</p>
<p style="font-family:Arial;font-size:10pt;font-style:italic;text-align:center;">Report Date: <?= $reportDate ?></p>

<table style="border-collapse:collapse;width:700px;">
    <tr style="height: fit-content;">
        <td rowspan="2" style="<?= $th ?>width:80px;">TGL</td>
        <td rowspan="2" style="<?= $th ?>width:250px;">NAMA</td>
        <td rowspan="2" style="<?= $th ?>width:110px;">KELAS</td>
        <td colspan="<?= $jumlahJenis ?>" style="<?= $th ?>">JENIS PELANGGARAN</td>
        <td rowspan="2" style="<?= $th ?>width:170px;">KETERANGAN</td>
    </tr>
    <tr style="height: fit-content;">
        <td style="<?= $th ?>width:30px;"></td>
        <td style="<?= $th ?>width:30px;"></td>
        <td style="<?= $th ?>width:30px;"></td>
        <?php foreach ($jenisList as $j): ?>
            <td style="<?= $th ?>width:30px;"><?= $j ?></td>
        <?php endforeach; ?>
    </tr>
    <tr>
        <td style="<?= $tdc ?>"><?= date('d/m/Y') ?></td>
        <td style="<?= $td ?>"><?= $this->e($user->name) ?></td>
        <td style="<?= $tdc ?>"><?= $this->e($user->role) ?></td>
        <td style="<?= $tdc ?>">&#10003;</td>
        <td style="<?= $tdc ?>"></td>
        <td style="<?= $tdc ?>"></td>
        <td style="<?= $tdc ?>"></td>
        <td style="<?= $tdc ?>"></td>
        <td style="<?= $td ?>">Test keterangan user ID <?= $this->e($user->id) ?></td>
    </tr>
</table>

<p style="font-family:Arial;font-size:9pt;text-align:right;">Total: <strong>1</strong> data</p>