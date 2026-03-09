

<p style="font-family:Arial;font-size:13pt;font-weight:bold;text-align:center;margin:10px 0 0 0;">
    LAPORAN DATA PELANGGARAN SISWA
</p>
<p style="font-family:Arial;font-size:10pt;font-style:italic;text-align:center;margin:2px 0 12px 0;">
    Periode : <?= htmlspecialchars($periode) ?>
</p>



<table style="width:100%;border-collapse:collapse;font-family:Arial;font-size:10pt;">
    <tr style="background-color:#2e75b6;">
        <td style="border:1px solid #999999;padding:5px 4px;text-align:center;font-weight:bold;color:#ffffff;width:5%;">
            No</td>
        <td style="border:1px solid #999999;padding:5px 4px;font-weight:bold;color:#ffffff;width:20%;">Nama Siswa</td>
        <td
            style="border:1px solid #999999;padding:5px 4px;text-align:center;font-weight:bold;color:#ffffff;width:10%;">
            NIS</td>
        <td
            style="border:1px solid #999999;padding:5px 4px;text-align:center;font-weight:bold;color:#ffffff;width:13%;">
            Kelas</td>
        <td style="border:1px solid #999999;padding:5px 4px;font-weight:bold;color:#ffffff;width:20%;">Jenis Pelanggaran
        </td>
        <td style="border:1px solid #999999;padding:5px 4px;font-weight:bold;color:#ffffff;width:22%;">Alasan
            Pelanggaran</td>
        <td
            style="border:1px solid #999999;padding:5px 4px;text-align:center;font-weight:bold;color:#ffffff;width:10%;">
            Tanggal</td>
    </tr>

    <?php if (empty($rows)): ?>
        <tr>
            <td colspan="7"
                style="border:1px solid #999999;padding:14px 4px;text-align:center;color:#777777;font-style:italic;">
                Tidak ada data pelanggaran pada periode ini.
            </td>
        </tr>
    <?php else: ?>
        <?php foreach ($rows as $i => $r): ?>
            <tr style="background-color:<?= $i % 2 === 0 ? '#ffffff' : '#eaf3fb' ?>;">
                <td style="border:1px solid #999999;padding:4px;text-align:center;vertical-align:top;"><?= $i + 1 ?></td>
                <td style="border:1px solid #999999;padding:4px;vertical-align:top;">
                    <strong><?= htmlspecialchars($r['siswa_name']) ?></strong></td>
                <td style="border:1px solid #999999;padding:4px;text-align:center;vertical-align:top;">
                    <?= htmlspecialchars($r['siswa_nis']) ?></td>
                <td style="border:1px solid #999999;padding:4px;text-align:center;vertical-align:top;">
                    <?= htmlspecialchars($r['kelas']) ?></td>
                <td style="border:1px solid #999999;padding:4px;vertical-align:top;"><?= htmlspecialchars($r['jenis_name']) ?>
                </td>
                <td style="border:1px solid #999999;padding:4px;vertical-align:top;">
                    <?= htmlspecialchars($r['alasan_detail']) ?></td>
                <td style="border:1px solid #999999;padding:4px;text-align:center;vertical-align:top;">
                    <?= htmlspecialchars($r['date_fmt']) ?></td>
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>
</table>

<p style="font-family:Arial;font-size:9pt;text-align:right;margin:4px 0 20px 0;">
    Total: <strong><?= (int) $total_data ?></strong> pelanggaran
</p>

<table style="width:100%;border-collapse:collapse;">
    <tr>
        <td style="width:55%;border:none;"></td>
        <td style="width:45%;border:none;text-align:center;">
            <p style="font-family:Arial;font-size:10pt;text-align:center;margin:0 0 2px 0;">Kota,
                <?= htmlspecialchars($cetak_pada) ?></p>
            <p style="font-family:Arial;font-size:10pt;text-align:center;margin:0 0 2px 0;">Kepala Sekolah,</p>
            <p style="font-family:Arial;font-size:10pt;margin:0;">&nbsp;</p>
            <p style="font-family:Arial;font-size:10pt;margin:0;">&nbsp;</p>
            <p style="font-family:Arial;font-size:10pt;margin:0;">&nbsp;</p>
            <p style="font-family:Arial;font-size:10pt;margin:0;">&nbsp;</p>
            <p style="font-family:Arial;font-size:10pt;font-weight:bold;text-align:center;margin:0 0 1px 0;">
                (________________________________)</p>
            <p style="font-family:Arial;font-size:10pt;text-align:center;margin:0;">NIP.
                ........................................</p>
        </td>
    </tr>
</table>