<?php
include 'koneksi.php';

$stmt = $pdo->query("SELECT * FROM barang");
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

$totalBarang = count($data);
$totalStok   = array_sum(array_column($data, 'jumlah'));
$totalNilai  = array_sum(array_map(fn($r) => $r['harga'] * $r['jumlah'], $data));
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Inventaris Barang</title>

<!-- HUBUNGKAN CSS -->
<link rel="stylesheet" href="style.css">

</head>
<body>

<div class="container">

  <div class="topbar">
    <div class="brand">
      <div class="brand-icon">📦</div>
      <div class="brand-text">
        <h1>Inventaris Barang</h1>
        <p>Sistem Manajemen Stok & Gudang</p>
      </div>
    </div>

    <a href="tambah.php" class="btn-add">
      Tambah Barang
    </a>
  </div>


  <div class="stats">
    <div class="stat">
      <div class="stat-label">Jenis Barang</div>
      <div class="stat-value"><?= $totalBarang ?></div>
      <div class="stat-sub">item terdaftar</div>
    </div>

    <div class="stat">
      <div class="stat-label">Total Stok</div>
      <div class="stat-value"><?= number_format($totalStok,0,',','.') ?></div>
      <div class="stat-sub">unit tersedia</div>
    </div>

    <div class="stat">
      <div class="stat-label">Total Nilai</div>
      <div class="stat-value">
        Rp <?= number_format($totalNilai,0,',','.') ?>
      </div>
      <div class="stat-sub">nilai inventaris</div>
    </div>
  </div>


  <div class="card">

    <div class="card-head">
      <div class="card-title">
        <span class="dot"></span>
        Daftar Inventaris
      </div>
      <span class="badge"><?= $totalBarang ?> data</span>
    </div>

<?php if(empty($data)): ?>

<div class="empty">
📭 Belum ada data barang
</div>

<?php else: ?>

<table>
<thead>
<tr>
<th>ID</th>
<th>Nama Barang</th>
<th>Jumlah</th>
<th>Harga</th>
<th>Tanggal</th>
<th>Aksi</th>
</tr>
</thead>

<tbody>

<?php foreach($data as $row): ?>

<tr>
<td>#<?= $row['id'] ?></td>

<td><?= htmlspecialchars($row['nama_barang']) ?></td>

<td><?= number_format($row['jumlah']) ?></td>

<td>Rp <?= number_format($row['harga']) ?></td>

<td><?= date('d M Y',strtotime($row['tanggal_masuk'])) ?></td>

<td>
<a href="edit.php?id=<?= $row['id'] ?>" class="btn-edit">Edit</a>
<a href="hapus.php?id=<?= $row['id'] ?>" class="btn-del"
onclick="return confirm('Yakin hapus data?')">
Hapus
</a>
</td>

</tr>

<?php endforeach; ?>

</tbody>
</table>

<?php endif; ?>

</div>

<div class="footer">

</div>

</div>

</body>
</html>