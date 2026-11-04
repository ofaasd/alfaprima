<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1,viewport-fit=cover">
<meta name="theme-color" content="#0b1220">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Alfa Prima Rent Car — Sistem Laravel</title>
<style>
:root{--bg:#0b1220;--panel:#121d30;--panel2:#18263d;--line:#2b3b55;--gold:#d8b45a;--text:#eef2f8;--muted:#9eacc1;--red:#e87979;--green:#64c69a}
*{box-sizing:border-box}body{margin:0;background:var(--bg);color:var(--text);font:14px/1.5 Arial,sans-serif}
header{padding:20px 24px;background:linear-gradient(120deg,#101b2d,#1c2c45);border-bottom:1px solid var(--line);display:flex;align-items:center;justify-content:space-between;gap:15px;flex-wrap:wrap}
.brand{font-size:20px;font-weight:800;letter-spacing:.4px}.brand span{color:var(--gold)}.sub{color:var(--muted);font-size:12px}
main{max-width:1250px;margin:auto;padding:22px;padding-bottom:calc(22px + env(safe-area-inset-bottom))}
nav{display:flex;gap:8px;flex-wrap:wrap;margin-bottom:20px}
nav button,.btn{border:1px solid var(--line);background:var(--panel2);color:var(--text);padding:10px 15px;border-radius:9px;cursor:pointer;font-weight:600;font-size:13px;transition:.2s}
nav button:hover,.btn:hover{filter:brightness(1.15)}
nav button.active,.btn.primary{background:var(--gold);border-color:var(--gold);color:#151515}
.btn.danger{color:#ffb3b3;border-color:#774747;background:rgba(119,71,71,.2)}.btn.small{padding:6px 9px;font-size:12px}
.grid{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:12px;margin-bottom:18px}
.stat,.card{background:var(--panel);border:1px solid var(--line);border-radius:13px;padding:16px}
.stat small{color:var(--muted)}.stat strong{display:block;font-size:24px;margin-top:5px;color:var(--gold)}
h2{font-size:18px;margin:0 0 14px}h3{font-size:15px;margin:0 0 12px}
.row{display:flex;gap:10px;align-items:center;flex-wrap:wrap}.row>*{flex:1}
.toolbar{display:flex;justify-content:space-between;align-items:center;gap:10px;flex-wrap:wrap;margin-bottom:14px}
input,select{width:100%;padding:10px 11px;background:#0d1728;color:var(--text);border:1px solid var(--line);border-radius:8px;outline:none;font-size:13px}
input:focus,select:focus{border-color:var(--gold)}label{display:block;color:var(--muted);font-size:12px;margin:0 0 5px}
.formgrid{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:12px}
.field{min-width:0}.actions{display:flex;gap:6px;flex-wrap:wrap}
.tablewrap{overflow:auto;border:1px solid var(--line);border-radius:10px}
table{border-collapse:collapse;width:100%;min-width:700px}th,td{text-align:left;padding:10px 12px;border-bottom:1px solid var(--line);vertical-align:middle}th{color:var(--gold);background:#17243a;font-size:12px}td{font-size:13px}tr:last-child td{border-bottom:0}
.badge{display:inline-block;border-radius:20px;padding:3px 8px;background:#263750;color:#dce6f5;font-size:11px}.badge.ok{color:#a4efc9;background:#173b32}.badge.warn{color:#ffe0a1;background:#49391d}.badge.bad{color:#ffc0c0;background:#4a252b}
.hidden{display:none!important}body.auth-required header,body.auth-required main,body.auth-required footer{display:none!important}.muted{color:var(--muted)}.notice{background:#18263d;border:1px solid var(--line);padding:11px 13px;border-radius:9px;color:var(--muted);margin:12px 0}
footer{color:var(--muted);font-size:11px;text-align:center;padding:25px}
@media(max-width:800px){.grid{grid-template-columns:repeat(2,1fr)}.formgrid{grid-template-columns:repeat(2,1fr)}main{padding:14px}}
@media(max-width:500px){.formgrid{grid-template-columns:1fr}.grid{gap:8px}.stat{padding:12px}.stat strong{font-size:20px}}
@media print{body{background:#fff;color:#111}header,nav,.no-print,footer{display:none!important}main{padding:0;max-width:none}.card,.stat{background:#fff;color:#111;border:0}.tablewrap{border:1px solid #aaa}th{background:#eee;color:#111}td,th{border-color:#ccc}}
</style>
</head>
<body class="auth-required">

<!-- Login Screen Overlay -->
<div id="authScreen" style="position:fixed;inset:0;z-index:1000;background:#0b1220;display:flex;align-items:center;justify-content:center;padding:18px">
  <div class="card" style="width:min(440px,100%);padding:24px">
    <div class="brand" style="margin-bottom:4px">ALFA <span>PRIMA</span> RENT CAR</div>
    <div class="muted" style="margin-bottom:18px">Login aman • Database Laravel & SQLite</div>
    <div id="authContent">
      <h3>Masuk ke aplikasi</h3>
      <form id="authForm">
        <div class="field"><label>Username</label><input id="authUser" required autocomplete="username" value="alfaprima"></div>
        <div class="field" style="margin-top:10px"><label>Password</label><input id="authPass" type="password" required autocomplete="current-password" value="password123"></div>
        <button class="btn primary" style="width:100%;margin-top:16px" type="submit">Login</button>
      </form>
    </div>
  </div>
</div>

<header>
  <div>
    <div class="brand">ALFA <span>PRIMA</span> RENT CAR</div>
    <div class="sub">Sistem Informasi Rental Mobil • Database Laravel & SQLite • HP & Komputer</div>
  </div>
  <div style="display:flex;align-items:center;gap:10px">
    <div class="sub" id="syncStatus">Menghubungkan ke database Laravel…</div>
    <button class="btn no-print" id="logoutBtn" style="padding:7px 10px">Keluar</button>
  </div>
</header>

<main>
  <nav class="no-print">
    <button class="active" data-tab="dashboard">Dashboard</button>
    <button data-tab="pelanggan">Pelanggan</button>
    <button data-tab="armada">Armada</button>
    <button data-tab="driver">Driver</button>
    <button data-tab="booking">Booking</button>
    <button data-tab="pembayaran">Pembayaran</button>
    <button data-tab="pengeluaran">Pengeluaran</button>
    <button data-tab="laporan">Invoice & Laporan</button>
    <button data-tab="mitra">Mitra</button>
    <button data-tab="akuntansi">Buku Besar</button>
    <button data-tab="pengguna" id="usersNav" class="hidden">Pengguna</button>
  </nav>

  <!-- DASHBOARD -->
  <section id="dashboard">
    <h2>Ringkasan</h2>
    <div class="grid">
      <div class="stat"><small>Total Pelanggan</small><strong id="sCust">0</strong></div>
      <div class="stat"><small>Total Armada</small><strong id="sCar">0</strong></div>
      <div class="stat"><small>Total Booking</small><strong id="sBook">0</strong></div>
      <div class="stat"><small>Pemasukan Tercatat</small><strong id="sPay">Rp0</strong></div>
    </div>
    <div class="card">
      <h3>Alur penggunaan</h3>
      <div class="muted">1. Masukkan data pelanggan → 2. Masukkan data armada → 3. Buat booking → 4. Catat pembayaran → 5. Cetak invoice atau lihat laporan.</div>
      <div class="notice">Penting: lakukan backup JSON secara berkala. Database utama tersimpan di Laravel SQLite dan dapat diakses dari perangkat yang diberi izin.</div>
    </div>
  </section>

  <!-- PELANGGAN -->
  <section id="pelanggan" class="hidden">
    <div class="toolbar">
      <h2>Data Pelanggan</h2>
      <input id="qCust" placeholder="Cari ID / nama / WA" style="max-width:260px">
    </div>
    <div class="card no-print">
      <h3 id="custTitle">Tambah Pelanggan</h3>
      <form id="custForm">
        <input type="hidden" id="custEdit">
        <div class="formgrid">
          <div class="field"><label>Nama</label><input id="cNama" required></div>
          <div class="field"><label>Alamat</label><input id="cAlamat"></div>
          <div class="field"><label>No. WA</label><input id="cWa"></div>
          <div class="field" id="nikField"><label>NIK</label><input id="cNik" inputmode="numeric"></div>
          <div class="field" id="simField"><label>SIM A</label><input id="cSim"></div>
          <div class="field"><label>Status Pelanggan</label>
            <select id="cStatus">
              <option value="Aktif">Aktif</option>
              <option value="Nonaktif">Nonaktif</option>
              <option value="Blacklist">Blacklist</option>
            </select>
          </div>
        </div>
        <div class="row" style="margin-top:12px">
          <button class="btn primary" type="submit">Simpan Pelanggan</button>
          <button class="btn" type="button" onclick="resetCust()">Batal</button>
        </div>
      </form>
    </div>
    <div class="card" style="margin-top:14px">
      <div class="tablewrap">
        <table>
          <thead>
            <tr><th>ID Pelanggan</th><th>Nama</th><th>Alamat</th><th>No. WA</th><th>NIK</th><th>SIM A</th><th>Status</th><th class="no-print">Aksi</th></tr>
          </thead>
          <tbody id="custRows"></tbody>
        </table>
      </div>
    </div>
  </section>

  <!-- ARMADA -->
  <section id="armada" class="hidden">
    <div class="toolbar">
      <h2>Data Armada</h2>
      <input id="qCar" placeholder="Cari ID / jenis / polisi" style="max-width:260px">
    </div>
    <div class="card no-print">
      <h3 id="carTitle">Tambah Armada</h3>
      <form id="carForm">
        <input type="hidden" id="carEdit">
        <div class="formgrid">
          <div class="field"><label>Merk Armada</label><input id="aMerk" required placeholder="Toyota"></div>
          <div class="field"><label>Jenis Armada</label><input id="aJenis" required placeholder="Innova Reborn"></div>
          <div class="field"><label>No. Polisi Armada</label><input id="aPlat" required placeholder="H 1234 AB"></div>
          <div class="field"><label>Transmisi Armada</label>
            <select id="aTrans"><option value="Matic">Matic</option><option value="Manual">Manual</option></select>
          </div>
          <div class="field"><label>Status Armada</label>
            <select id="aStatus"><option value="Tersedia">Tersedia</option><option value="Disewa">Disewa</option><option value="Servis">Servis</option><option value="Nonaktif">Nonaktif</option></select>
          </div>
          <div class="field"><label>Kepemilikan</label>
            <select id="aOwnership"><option value="sendiri">Milik Sendiri</option><option value="mitra">Milik Mitra</option></select>
          </div>
          <div class="field"><label>Pemilik / Mitra</label>
            <select id="aPartner"><option value="">Pilih mitra (jika milik mitra)</option></select>
          </div>
          <div class="field"><label>Bagian Mitra per Hari (Rp)</label><input id="aPartnerRate" type="number" min="0" value="0"></div>
        </div>
        <div class="row" style="margin-top:12px">
          <button class="btn primary" type="submit">Simpan Armada</button>
          <button class="btn" type="button" onclick="resetCar()">Batal</button>
        </div>
      </form>
    </div>
    <div class="card" style="margin-top:14px">
      <div class="tablewrap">
        <table>
          <thead>
            <tr><th>ID Armada</th><th>Merk</th><th>Jenis</th><th>No. Polisi</th><th>Transmisi</th><th>Status</th><th class="no-print">Aksi</th></tr>
          </thead>
          <tbody id="carRows"></tbody>
        </table>
      </div>
    </div>
  </section>

  <!-- DRIVER -->
  <section id="driver" class="hidden">
    <h2>Database Driver</h2>
    <div class="card no-print">
      <h3 id="driverTitle">Tambah Driver</h3>
      <form id="driverForm">
        <input type="hidden" id="driverEdit">
        <div class="formgrid">
          <div class="field"><label>Nama Driver</label><input id="dName" required></div>
          <div class="field"><label>No. WhatsApp</label><input id="dWa"></div>
          <div class="field"><label>Alamat</label><input id="dAddress"></div>
          <div class="field"><label>No. SIM</label><input id="dLicense"></div>
          <div class="field"><label>Status</label>
            <select id="dStatus"><option value="Aktif">Aktif</option><option value="Nonaktif">Nonaktif</option></select>
          </div>
        </div>
        <div class="row" style="margin-top:12px">
          <button class="btn primary" type="submit">Simpan Driver</button>
          <button class="btn" type="button" onclick="resetDriver()">Batal</button>
        </div>
      </form>
    </div>
    <div class="card" style="margin-top:14px">
      <h3>Daftar Driver</h3>
      <div class="tablewrap">
        <table>
          <thead>
            <tr><th>ID Driver</th><th>Nama</th><th>WhatsApp</th><th>Alamat</th><th>No. SIM</th><th>Status</th><th>Aksi</th></tr>
          </thead>
          <tbody id="driverRows"></tbody>
        </table>
      </div>
    </div>
  </section>

  <!-- BOOKING -->
  <section id="booking" class="hidden">
    <h2>Booking Sewa</h2>
    <div class="card no-print">
      <form id="bookForm">
        <input type="hidden" id="bookEdit">
        <div class="formgrid">
          <div class="field"><label>Pelanggan</label><select id="bCust" required></select></div>
          <div class="field"><label>Armada</label><select id="bCar" required></select></div>
          <div class="field"><label>Tanggal Awal Sewa</label><input type="date" id="bStart" required></div>
          <div class="field"><label>Tanggal Akhir Sewa</label><input type="date" id="bEnd" required></div>
          <div class="field"><label>Harga Sewa per Hari (Rp)</label><input type="number" id="bRate" min="0" required></div>
          <div class="field"><label>Lama Sewa</label><input id="bDays" readonly placeholder="Otomatis"></div>
          <div class="field"><label>Driver (opsional)</label><select id="bDriver"><option value="">Tanpa driver</option></select></div>
          <div class="field"><label>Nama Driver</label><input id="bDriverName" readonly placeholder="Otomatis dari data driver"></div>
          <div class="field"><label>Fee Driver per Hari (Rp)</label><input id="bDriverFee" type="number" min="0" value="0"></div>
          <div class="field"><label>Tujuan</label><input id="bDestination" placeholder="Contoh: Semarang - Yogyakarta"></div>
          <div class="field"><label>Biaya Tol (Rp)</label><input id="bToll" type="number" min="0" value="0"></div>
          <div class="field"><label>Biaya BBM (Rp)</label><input id="bFuel" type="number" min="0" value="0"></div>
          <div class="field"><label>Uang Makan Driver (Rp)</label><input id="bMeal" type="number" min="0" value="0"></div>
          <div class="field"><label>Biaya Inap Driver (Rp)</label><input id="bLodging" type="number" min="0" value="0"></div>
          <div class="field"><label>Total Harga Sewa + Biaya Perjalanan (Rp)</label><input id="bTotal" readonly placeholder="Otomatis"></div>
        </div>
        <div class="row" style="margin-top:12px">
          <button class="btn primary" type="submit" id="bookSubmitBtn">Simpan Booking</button>
          <button class="btn" type="button" onclick="resetBookingForm()">Batal Edit</button>
          <span class="muted" id="bookHint">Tanggal awal dan akhir dihitung sebagai hari sewa.</span>
        </div>
      </form>
    </div>
    <div class="card" style="margin-top:14px">
      <div class="toolbar">
        <h3>Daftar Booking</h3>
        <input id="qBook" placeholder="Cari ID booking / pelanggan / armada" style="max-width:290px">
      </div>
      <div class="tablewrap">
        <table>
          <thead>
            <tr><th>ID Booking</th><th>Pelanggan</th><th>Armada</th><th>Awal</th><th>Akhir</th><th>Hari</th><th>Harga/Hari</th><th>Driver</th><th>Tujuan</th><th>Biaya Driver & Perjalanan</th><th>Total</th><th>Status</th><th class="no-print">Aksi</th></tr>
          </thead>
          <tbody id="bookRows"></tbody>
        </table>
      </div>
    </div>
  </section>

  <!-- PEMBAYARAN -->
  <section id="pembayaran" class="hidden">
    <h2>Pencatatan Pembayaran</h2>
    <div class="card no-print">
      <form id="payForm">
        <div class="formgrid">
          <div class="field"><label>Booking</label><select id="pBook" required></select></div>
          <div class="field"><label>Pelanggan</label><input id="pCust" readonly></div>
          <div class="field"><label>Total Tagihan</label><input id="pBill" readonly></div>
          <div class="field"><label>Total Pembayaran Diterima (Rp)</label><input id="pAmount" type="number" min="1" required></div>
          <div class="field"><label>Status Pembayaran</label><input id="pStatus" readonly></div>
          <div class="field"><label>Sisa Tagihan</label><input id="pRemain" readonly></div>
        </div>
        <div class="row" style="margin-top:12px">
          <button class="btn primary" type="submit">Catat Pembayaran</button>
        </div>
      </form>
    </div>
    <div class="card" style="margin-top:14px">
      <h3>Riwayat Pembayaran</h3>
      <div class="tablewrap">
        <table>
          <thead>
            <tr><th>ID Pelanggan</th><th>Nama Pelanggan</th><th>ID Booking</th><th>Total Pembayaran Seluruh Booking</th><th>Status</th><th>Rincian / Edit Pembayaran</th></tr>
          </thead>
          <tbody id="payRows"></tbody>
        </table>
      </div>
    </div>
  </section>

  <!-- PENGELUARAN -->
  <section id="pengeluaran" class="hidden">
    <h2>Data Pengeluaran</h2>
    <div class="card no-print">
      <h3>Tambah Pengeluaran</h3>
      <form id="expenseForm">
        <div class="formgrid">
          <div class="field"><label>Tanggal Pengeluaran</label><input type="date" id="eDate" required></div>
          <div class="field"><label>Kategori Pengeluaran</label>
            <select id="eCategory" required>
              <option value="">Pilih kategori</option>
              <option>BBM</option>
              <option>Servis dan Perawatan</option>
              <option>Gaji Sopir</option>
              <option>Tol dan Parkir</option>
              <option>Asuransi dan Pajak</option>
              <option>Cuci Mobil</option>
              <option>Operasional</option>
              <option>Lain-lain</option>
            </select>
          </div>
          <div class="field"><label>Nominal Pengeluaran (Rp)</label><input type="number" id="eAmount" min="1" required></div>
          <div class="field"><label>Kendaraan terkait (opsional)</label><select id="eCar"><option value="">Biaya umum usaha</option></select></div>
          <div class="field" style="grid-column:span 2"><label>Keterangan</label><input id="eNote" placeholder="Contoh: ganti oli Innova Reborn"></div>
        </div>
        <div class="row" style="margin-top:12px">
          <button class="btn primary" type="submit">Simpan Pengeluaran</button>
        </div>
      </form>
    </div>
    <div class="card" style="margin-top:14px">
      <div class="toolbar">
        <h3>Riwayat Pengeluaran</h3>
        <strong id="expenseTotal" style="color:var(--gold)">Rp0</strong>
      </div>
      <div class="tablewrap">
        <table>
          <thead>
            <tr><th>ID Pengeluaran</th><th>Tanggal</th><th>Kategori</th><th>Keterangan</th><th>Nominal</th><th class="no-print">Aksi</th></tr>
          </thead>
          <tbody id="expenseRows"></tbody>
        </table>
      </div>
    </div>
  </section>

  <!-- MITRA -->
  <section id="mitra" class="hidden">
    <h2>Database Mitra Kendaraan</h2>
    <div class="card no-print">
      <form id="partnerForm">
        <div class="formgrid">
          <div class="field"><label>Nama Pemilik</label><input id="mName" required></div>
          <div class="field"><label>No. WhatsApp</label><input id="mWa"></div>
          <div class="field"><label>Alamat</label><input id="mAddress"></div>
          <div class="field"><label>Nama Bank</label><input id="mBank"></div>
          <div class="field"><label>Nomor Rekening</label><input id="mAccount"></div>
          <div class="field"><label>Atas Nama</label><input id="mAccountName"></div>
        </div>
        <div class="row" style="margin-top:12px">
          <button class="btn primary" type="submit">Simpan Mitra</button>
        </div>
      </form>
    </div>
    <div class="card" style="margin-top:14px">
      <h3>Daftar Mitra</h3>
      <div class="tablewrap">
        <table>
          <thead>
            <tr><th>ID Mitra</th><th>Nama</th><th>WA</th><th>Alamat</th><th>Bank</th><th>Rekening</th></tr>
          </thead>
          <tbody id="partnerRows"></tbody>
        </table>
      </div>
    </div>
    <div class="card" style="margin-top:14px">
      <h3>Pembayaran Bagian Mitra</h3>
      <form id="partnerPayForm">
        <div class="formgrid">
          <div class="field"><label>Booking</label><select id="mpBooking" required></select></div>
          <div class="field"><label>Mitra</label><select id="mpPartner" required></select></div>
          <div class="field"><label>Tanggal Bayar</label><input type="date" id="mpDate" required></div>
          <div class="field"><label>Nominal Dibayar</label><input type="number" id="mpAmount" min="1" required></div>
          <div class="field"><label>Keterangan</label><input id="mpNote"></div>
        </div>
        <div class="row" style="margin-top:12px">
          <button class="btn primary" type="submit">Catat Pembayaran Mitra</button>
        </div>
      </form>
      <div class="tablewrap" style="margin-top:14px">
        <table>
          <thead>
            <tr><th>ID</th><th>Booking</th><th>Mitra</th><th>Tanggal</th><th>Nominal</th><th>Status</th></tr>
          </thead>
          <tbody id="partnerPayRows"></tbody>
        </table>
      </div>
    </div>
  </section>

  <!-- AKUNTANSI / BUKU BESAR -->
  <section id="akuntansi" class="hidden">
    <h2>Buku Besar & Jurnal</h2>
    <div class="card no-print">
      <h3>Input Jurnal Manual</h3>
      <form id="journalForm">
        <div class="formgrid">
          <div class="field"><label>Tanggal</label><input type="date" id="jDate" required></div>
          <div class="field"><label>Keterangan</label><input id="jNote" required></div>
          <div class="field"><label>Akun Debit</label>
            <select id="jDebit">
              <option value="1101">1101 • Kas/Bank</option>
              <option value="2101">2101 • Utang Mitra</option>
              <option value="4101">4101 • Pendapatan Sewa</option>
              <option value="4201">4201 • Pendapatan Margin Mitra</option>
              <option value="5101">5101 • Beban Operasional</option>
            </select>
          </div>
          <div class="field"><label>Akun Kredit</label>
            <select id="jCredit">
              <option value="4101">4101 • Pendapatan Sewa</option>
              <option value="1101">1101 • Kas/Bank</option>
              <option value="2101">2101 • Utang Mitra</option>
              <option value="5101">5101 • Beban Operasional</option>
            </select>
          </div>
          <div class="field"><label>Nominal</label><input type="number" id="jAmount" min="1" required></div>
        </div>
        <div class="row" style="margin-top:12px">
          <button class="btn primary" type="submit">Simpan Jurnal</button>
        </div>
      </form>
    </div>
    <div class="grid" style="margin-top:14px">
      <div class="stat"><small>Total Debit Jurnal Manual</small><strong id="jDebitTotal">Rp0</strong></div>
      <div class="stat"><small>Total Kredit Jurnal Manual</small><strong id="jCreditTotal">Rp0</strong></div>
    </div>
    <div class="card">
      <h3>Jurnal Umum</h3>
      <div class="tablewrap">
        <table>
          <thead>
            <tr><th>ID</th><th>Tanggal</th><th>Keterangan</th><th>Debit</th><th>Kredit</th><th>Nominal</th></tr>
          </thead>
          <tbody id="journalRows"></tbody>
        </table>
      </div>
    </div>
    <div class="card" style="margin-top:14px">
      <h3>Buku Besar (mutasi otomatis + jurnal manual)</h3>
      <div class="tablewrap">
        <table>
          <thead>
            <tr><th>Tanggal</th><th>Akun</th><th>Keterangan</th><th>Debit</th><th>Kredit</th><th>Saldo</th></tr>
          </thead>
          <tbody id="ledgerRows"></tbody>
        </table>
      </div>
    </div>
    <div class="card" style="margin-top:14px">
      <h3>Laba Rugi Cash Basis per Kendaraan</h3>
      <div class="tablewrap">
        <table>
          <thead>
            <tr><th>Kendaraan</th><th>Kepemilikan</th><th>Penerimaan Kas</th><th>Bagian Mitra</th><th>Biaya Langsung</th><th>Hasil</th></tr>
          </thead>
          <tbody id="carProfitRows"></tbody>
        </table>
      </div>
      <p id="overallProfit" style="color:var(--gold);font-weight:bold"></p>
    </div>
  </section>

  <!-- PENGGUNA (ADMIN ONLY) -->
  <section id="pengguna" class="hidden">
    <h2>Manajemen Pengguna</h2>
    <div class="card no-print">
      <h3>Tambah Akun Karyawan</h3>
      <form id="userForm">
        <div class="formgrid">
          <div class="field"><label>Username Karyawan</label><input id="uName" required minlength="4" autocomplete="off"></div>
          <div class="field"><label>Password (minimal 10 karakter)</label><input id="uPass" type="password" required minlength="10" autocomplete="new-password"></div>
        </div>
        <div class="row" style="margin-top:12px">
          <button class="btn primary" type="submit">Buat Akun Karyawan</button>
        </div>
      </form>
      <div class="notice">Admin memiliki akses penuh. Karyawan dapat memasukkan dan mengubah transaksi, tetapi tidak dapat menghapus data atau membuat akun.</div>
    </div>
    <div class="card" style="margin-top:14px">
      <h3>Daftar Akun</h3>
      <div class="tablewrap">
        <table>
          <thead>
            <tr><th>Username</th><th>Peran</th><th>Status</th><th class="no-print">Aksi</th></tr>
          </thead>
          <tbody id="userRows"></tbody>
        </table>
      </div>
    </div>
  </section>

  <!-- INVOICE & LAPORAN -->
  <section id="laporan" class="hidden">
    <div class="toolbar">
      <h2>Invoice & Laporan</h2>
      <div class="actions no-print">
        <button class="btn" onclick="printReport()">Cetak Laporan</button>
        <button class="btn" onclick="backup()">Backup JSON</button>
        <label class="btn" style="cursor:pointer">Pulihkan JSON<input type="file" id="restoreFile" accept=".json,application/json" hidden></label>
      </div>
    </div>
    <div class="row no-print" style="margin-bottom:12px">
      <div class="field" style="max-width:220px">
        <label>Periode Laporan Laba Rugi</label>
        <input type="month" id="reportMonth">
      </div>
    </div>
    <div class="grid">
      <div class="stat"><small>Total Nilai Booking</small><strong id="rBooking">Rp0</strong></div>
      <div class="stat"><small>Pemasukan Bulan Terpilih</small><strong id="rIncome">Rp0</strong></div>
      <div class="stat"><small>Sisa Tagihan</small><strong id="rRemain">Rp0</strong></div>
      <div class="stat"><small>Pengeluaran Bulan Terpilih</small><strong id="rExpense">Rp0</strong></div>
      <div class="stat"><small>Laba / Rugi Bulan Terpilih</small><strong id="rNet">Rp0</strong></div>
      <div class="stat"><small>Booking Belum Lunas</small><strong id="rUnpaid">0</strong></div>
    </div>
    <div class="card">
      <h3>Invoice Bulanan — Booking Belum Bayar</h3>
      <div class="row no-print">
        <div class="field"><label>Bulan Invoice</label><input type="month" id="invoiceMonth"></div>
        <div class="field"><label>Pelanggan</label><select id="invoicePick"></select></div>
        <div class="field" style="align-self:end"><button class="btn primary" onclick="printInvoice()">Cetak Invoice Bulanan</button></div>
      </div>
      <div class="notice">Invoice menggabungkan booking dengan ID pelanggan yang sama, berdasarkan bulan tanggal awal sewa. Hanya booking berstatus Belum Bayar yang disertakan.</div>
      <div id="invoicePreview" style="margin-top:15px"></div>
    </div>
    <div class="card" style="margin-top:14px">
      <h3>Rincian Laba Rugi Bulanan</h3>
      <div class="tablewrap">
        <table>
          <thead>
            <tr><th>Tanggal</th><th>Jenis</th><th>Keterangan</th><th>Nominal</th></tr>
          </thead>
          <tbody id="plRows"></tbody>
        </table>
      </div>
    </div>
    <div class="card" style="margin-top:14px">
      <h3>Rekap Booking</h3>
      <div class="tablewrap">
        <table>
          <thead>
            <tr><th>ID Booking</th><th>Pelanggan</th><th>Armada</th><th>Total</th><th>Dibayar</th><th>Sisa</th><th>Status</th></tr>
          </thead>
          <tbody id="reportRows"></tbody>
        </table>
      </div>
    </div>
    <div class="row no-print" style="margin-top:14px">
      <button class="btn" onclick="exportCSV()">Ekspor data booking CSV</button>
      <button class="btn danger" id="clearAllBtn" onclick="clearAll()">Hapus seluruh data</button>
    </div>
  </section>
</main>

<footer>ALFA PRIMA RENT CAR • Aplikasi rental mobil berbasis Laravel & SQLite</footer>

<script>
let db = {
  customers: [],
  cars: [],
  bookings: [],
  payments: [],
  expenses: [],
  partners: [],
  partnerPayments: [],
  accounts: [],
  journals: [],
  drivers: []
};

let currentUser = null;
const $ = id => document.getElementById(id);
const money = n => 'Rp' + Number(n || 0).toLocaleString('id-ID');
const esc = s => String(s ?? '').replace(/[&<>"']/g, c => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c]));
const csrfToken = () => document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

function setSyncStatus(message, color) {
  let el = $('syncStatus');
  if (el) {
    el.textContent = message;
    if (color) el.style.color = color;
  }
}

async function apiCall(url, method = 'GET', body = null) {
  try {
    const opts = {
      method,
      credentials: 'same-origin',
      headers: {
        'Accept': 'application/json',
        'X-CSRF-TOKEN': csrfToken()
      }
    };
    if (body) {
      opts.headers['Content-Type'] = 'application/json';
      opts.body = JSON.stringify(body);
    }
    const res = await fetch(url, opts);
    const data = await res.json();
    if (!res.ok) {
      throw new Error(data.message || 'Terjadi kesalahan sistem.');
    }
    return data;
  } catch (err) {
    console.error('API Error:', err);
    throw err;
  }
}

async function loadAppData() {
  setSyncStatus('Mengambil data dari server Laravel…');
  try {
    const res = await apiCall('/api/load-data');
    if (res.user) {
      currentUser = res.user;
      db = res.db;
      document.body.classList.remove('auth-required');
      $('authScreen').style.display = 'none';

      if ($('usersNav')) $('usersNav').classList.toggle('hidden', currentUser.role !== 'admin');
      if ($('nikField')) $('nikField').classList.toggle('hidden', currentUser.role !== 'admin');
      if ($('simField')) $('simField').classList.toggle('hidden', currentUser.role !== 'admin');
      if ($('clearAllBtn')) $('clearAllBtn').classList.toggle('hidden', currentUser.role !== 'admin');

      setSyncStatus('Login: ' + currentUser.username + ' (' + currentUser.role + ') • Terhubung ke Database ✓', '#64c69a');
      render();
      if (currentUser.role === 'admin') renderUsers();
    } else {
      document.body.classList.add('auth-required');
      $('authScreen').style.display = 'flex';
      setSyncStatus('Menunggu login…', '#ffb3b3');
    }
  } catch (err) {
    setSyncStatus('Gagal memuat data: ' + err.message, '#ffb3b3');
  }
}

function cust(id) { return db.customers.find(x => x.id === id); }
function car(id) { return db.cars.find(x => x.id === id); }
function book(id) { return db.bookings.find(x => x.id === id); }
function paid(id) { return db.payments.filter(x => x.booking_id === id).reduce((s, x) => s + Number(x.amount), 0); }
function statusBook(b) {
  let p = paid(b.id);
  return p <= 0 ? 'Belum Bayar' : (p >= b.total ? 'Lunas' : 'DP');
}
function days(a, b) {
  if (!a || !b) return 0;
  let x = new Date(a + 'T00:00:00'), y = new Date(b + 'T00:00:00');
  return Math.round((y - x) / 86400000) + 1;
}
function formatDateDMY(value) {
  if (!value) return '-';
  let parts = String(value).slice(0, 10).split('-');
  return parts.length === 3 ? parts[2] + '/' + parts[1] + '/' + parts[0] : String(value);
}
function rupiahInput(n) { return Number(n || 0); }

// Tab Switching
document.querySelectorAll('nav button').forEach(btn => {
  btn.onclick = () => {
    document.querySelectorAll('nav button').forEach(x => x.classList.toggle('active', x === btn));
    document.querySelectorAll('main section').forEach(x => x.classList.add('hidden'));
    $(btn.dataset.tab).classList.remove('hidden');
    render();
  };
});

// Pelanggan
function resetCust() {
  $('custForm').reset();
  $('custEdit').value = '';
  $('custTitle').textContent = 'Tambah Pelanggan';
}

$('custForm').onsubmit = async e => {
  e.preventDefault();
  const payload = {
    id: $('custEdit').value || '',
    nama: $('cNama').value.trim(),
    alamat: $('cAlamat').value.trim(),
    wa: $('cWa').value.trim(),
    nik: $('cNik').value.trim(),
    sim: $('cSim').value.trim(),
    status: $('cStatus').value
  };
  try {
    await apiCall('/api/customers', 'POST', payload);
    resetCust();
    await loadAppData();
  } catch (err) {
    alert('Gagal menyimpan pelanggan: ' + err.message);
  }
};

function editCust(id) {
  let x = cust(id);
  if (!x) return;
  $('custEdit').value = x.id;
  $('cNama').value = x.nama;
  $('cAlamat').value = x.alamat || '';
  $('cWa').value = x.wa || '';
  $('cNik').value = x.nik || '';
  $('cSim').value = x.sim || '';
  $('cStatus').value = x.status || 'Aktif';
  $('custTitle').textContent = 'Edit ' + id;
  window.scrollTo(0, 0);
}

async function delCust(id) {
  if (currentUser?.role !== 'admin') {
    alert('Hanya admin yang dapat menghapus data.');
    return;
  }
  if (db.bookings.some(b => b.customer_id === id)) {
    alert('Pelanggan sudah memiliki booking dan tidak dapat dihapus.');
    return;
  }
  if (!confirm('Hapus pelanggan ' + id + '?')) return;
  try {
    await apiCall('/api/customers/' + id, 'DELETE');
    await loadAppData();
  } catch (err) {
    alert('Gagal menghapus: ' + err.message);
  }
}

// Armada
function resetCar() {
  $('carForm').reset();
  $('carEdit').value = '';
  $('carTitle').textContent = 'Tambah Armada';
}

$('carForm').onsubmit = async e => {
  e.preventDefault();
  const payload = {
    id: $('carEdit').value || '',
    merk: $('aMerk').value.trim(),
    jenis: $('aJenis').value.trim(),
    plat: $('aPlat').value.trim(),
    trans: $('aTrans').value,
    status: $('aStatus').value,
    ownership: $('aOwnership').value,
    partner_id: $('aPartner').value || null,
    partner_rate: rupiahInput($('aPartnerRate').value)
  };
  try {
    await apiCall('/api/cars', 'POST', payload);
    resetCar();
    await loadAppData();
  } catch (err) {
    alert('Gagal menyimpan armada: ' + err.message);
  }
};

function editCar(id) {
  let x = car(id);
  if (!x) return;
  $('carEdit').value = x.id;
  $('aMerk').value = x.merk;
  $('aJenis').value = x.jenis;
  $('aPlat').value = x.plat;
  $('aTrans').value = x.trans;
  $('aStatus').value = x.status;
  $('aOwnership').value = x.ownership || 'sendiri';
  $('aPartner').value = x.partner_id || '';
  $('aPartnerRate').value = x.partner_rate || 0;
  $('carTitle').textContent = 'Edit ' + id;
  window.scrollTo(0, 0);
}

async function delCar(id) {
  if (currentUser?.role !== 'admin') {
    alert('Hanya admin yang dapat menghapus data.');
    return;
  }
  if (db.bookings.some(b => b.car_id === id)) {
    alert('Armada sudah memiliki riwayat booking dan tidak dapat dihapus. Ubah status menjadi Nonaktif.');
    return;
  }
  if (!confirm('Hapus armada ' + id + '?')) return;
  try {
    await apiCall('/api/cars/' + id, 'DELETE');
    await loadAppData();
  } catch (err) {
    alert('Gagal menghapus: ' + err.message);
  }
}

// Driver
function resetDriver() {
  $('driverForm').reset();
  $('driverEdit').value = '';
  $('driverTitle').textContent = 'Tambah Driver';
}

$('driverForm').onsubmit = async e => {
  e.preventDefault();
  const payload = {
    id: $('driverEdit').value || '',
    name: $('dName').value.trim(),
    wa: $('dWa').value.trim(),
    address: $('dAddress').value.trim(),
    license: $('dLicense').value.trim(),
    status: $('dStatus').value
  };
  try {
    await apiCall('/api/drivers', 'POST', payload);
    resetDriver();
    await loadAppData();
  } catch (err) {
    alert('Gagal menyimpan driver: ' + err.message);
  }
};

function editDriver(id) {
  let d = db.drivers.find(x => x.id === id);
  if (!d) return;
  $('driverEdit').value = d.id;
  $('dName').value = d.name || '';
  $('dWa').value = d.wa || '';
  $('dAddress').value = d.address || '';
  $('dLicense').value = d.license || '';
  $('dStatus').value = d.status || 'Aktif';
  $('driverTitle').textContent = 'Edit Driver ' + id;
  document.querySelector('[data-tab="driver"]').click();
  window.scrollTo(0, 0);
}

async function deleteDriver(id) {
  if (currentUser?.role !== 'admin') return;
  if (db.bookings.some(b => b.driver_id === id)) {
    alert('Driver sudah terhubung dengan booking. Ubah status menjadi Nonaktif.');
    return;
  }
  if (!confirm('Hapus driver ' + id + '?')) return;
  try {
    await apiCall('/api/drivers/' + id, 'DELETE');
    await loadAppData();
  } catch (err) {
    alert('Gagal menghapus: ' + err.message);
  }
}

// Booking
function updateBookingCalc() {
  let d = days($('bStart').value, $('bEnd').value);
  let r = rupiahInput($('bRate').value);
  $('bDays').value = d > 0 ? d + ' hari' : '';
  let total = (d > 0 && r > 0 ? d * r : 0) +
              (d * rupiahInput($('bDriverFee')?.value)) +
              rupiahInput($('bFuel')?.value) +
              rupiahInput($('bToll')?.value) +
              rupiahInput($('bMeal')?.value) +
              rupiahInput($('bLodging')?.value);
  $('bTotal').value = total > 0 ? total : '';
}

['bStart', 'bEnd', 'bRate', 'bDriverFee', 'bFuel', 'bToll', 'bMeal', 'bLodging'].forEach(id => {
  $(id)?.addEventListener('input', updateBookingCalc);
});

function resetBookingForm() {
  $('bookForm').reset();
  $('bookEdit').value = '';
  $('bookSubmitBtn').textContent = 'Simpan Booking';
  ['bDriverFee', 'bToll', 'bFuel', 'bMeal', 'bLodging'].forEach(id => {
    if ($(id)) $(id).value = 0;
  });
  updateBookingCalc();
}

function editBooking(id) {
  let b = book(id);
  if (!b) return;
  document.querySelector('[data-tab="booking"]').click();
  $('bookEdit').value = b.id;
  $('bCust').value = b.customer_id;
  $('bCar').value = b.car_id;
  $('bStart').value = b.start;
  $('bEnd').value = b.end;
  $('bRate').value = b.rate;
  $('bDriver').value = b.driver_id || '';
  $('bDriverName').value = b.driver_name || '';
  $('bDriverFee').value = Number(b.driver_fee_per_day || 0);
  $('bDestination').value = b.destination || '';
  $('bToll').value = Number(b.toll_cost || 0);
  $('bFuel').value = Number(b.fuel_cost || 0);
  $('bMeal').value = Number(b.meal_cost || 0);
  $('bLodging').value = Number(b.lodging_cost || 0);
  $('bookSubmitBtn').textContent = 'Simpan Perubahan Booking';
  updateBookingCalc();
  window.scrollTo(0, 0);
}

$('bDriver').onchange = () => {
  let d = db.drivers.find(x => x.id === $('bDriver').value);
  $('bDriverName').value = d ? d.name : '';
};

$('bookForm').onsubmit = async e => {
  e.preventDefault();
  let customer_id = $('bCust').value;
  let car_id = $('bCar').value;
  let start = $('bStart').value;
  let end = $('bEnd').value;
  let rate = rupiahInput($('bRate').value);
  let d = days(start, end);
  let editId = $('bookEdit').value;

  if (!customer_id || !car_id || !d || d < 1 || rate <= 0) {
    alert('Periksa data booking.');
    return;
  }

  const payload = {
    id: editId,
    customer_id,
    car_id,
    start,
    end,
    days: d,
    rate,
    driver_id: $('bDriver').value || null,
    driver_name: $('bDriverName').value.trim(),
    driver_fee_per_day: rupiahInput($('bDriverFee').value),
    destination: $('bDestination').value.trim(),
    toll_cost: rupiahInput($('bToll').value),
    fuel_cost: rupiahInput($('bFuel').value),
    meal_cost: rupiahInput($('bMeal').value),
    lodging_cost: rupiahInput($('bLodging').value)
  };

  try {
    const res = await apiCall('/api/bookings', 'POST', payload);
    resetBookingForm();
    await loadAppData();
    alert(editId ? 'Booking berhasil diperbarui.' : 'Booking tersimpan: ' + res.data.id);
  } catch (err) {
    alert('Gagal menyimpan booking: ' + err.message);
  }
};

async function delBooking(id) {
  if (currentUser?.role !== 'admin') {
    alert('Hanya admin yang dapat menghapus booking.');
    return;
  }
  const b = book(id);
  if (!b) return;
  const linkedPayments = db.payments.filter(p => p.booking_id === id);
  let message = 'Hapus booking ' + id + '?';
  if (linkedPayments.length) {
    message += '\n\nPerhatian: ' + linkedPayments.length + ' catatan pembayaran terkait juga akan dihapus dari database.';
  }
  if (!confirm(message)) return;
  try {
    await apiCall('/api/bookings/' + id, 'DELETE');
    await loadAppData();
    alert('Booking ' + id + ' berhasil dihapus.');
  } catch (err) {
    alert('Gagal menghapus booking: ' + err.message);
  }
}

// Pembayaran
function updatePayForm() {
  let b = book($('pBook').value);
  if (!b) {
    $('pCust').value = '';
    $('pBill').value = '';
    $('pStatus').value = '';
    $('pRemain').value = '';
    return;
  }
  let p = paid(b.id), rem = Math.max(0, b.total - p);
  $('pCust').value = (cust(b.customer_id)?.nama || '') + ' (' + b.customer_id + ')';
  $('pBill').value = money(b.total);
  $('pStatus').value = statusBook(b);
  $('pRemain').value = money(rem);
  $('pAmount').max = rem || 0;
}

$('pBook').onchange = updatePayForm;
$('pAmount').oninput = () => {
  let b = book($('pBook').value);
  if (b) {
    let val = paid(b.id) + rupiahInput($('pAmount').value);
    $('pStatus').value = val <= 0 ? 'Belum Bayar' : (val >= b.total ? 'Lunas' : 'DP');
    $('pRemain').value = money(Math.max(0, b.total - val));
  }
};

$('payForm').onsubmit = async e => {
  e.preventDefault();
  let b = book($('pBook').value), amount = rupiahInput($('pAmount').value);
  if (!b || amount <= 0) {
    alert('Pilih booking dan masukkan pembayaran.');
    return;
  }
  let remain = b.total - paid(b.id);
  if (amount > remain) {
    alert('Pembayaran melebihi sisa tagihan ' + money(remain));
    return;
  }
  try {
    await apiCall('/api/payments', 'POST', {
      booking_id: b.id,
      amount
    });
    $('pAmount').value = '';
    await loadAppData();
    updatePayForm();
  } catch (err) {
    alert('Gagal mencatat pembayaran: ' + err.message);
  }
};

async function editPayment(id) {
  if (currentUser?.role !== 'admin') {
    alert('Hanya admin yang dapat mengedit pembayaran.');
    return;
  }
  const p = db.payments.find(x => x.id === id);
  if (!p) return;
  const entered = prompt('Ubah nominal pembayaran untuk ' + p.booking_id + ' (Rp):', String(p.amount));
  if (entered === null) return;
  const amount = Number(String(entered).replace(/[^0-9.-]/g, ''));
  if (!Number.isFinite(amount) || amount <= 0) {
    alert('Nominal pembayaran tidak valid.');
    return;
  }
  try {
    await apiCall('/api/payments/' + id, 'PUT', { amount });
    await loadAppData();
    alert('Pembayaran berhasil diperbarui.');
  } catch (err) {
    alert('Gagal mengedit pembayaran: ' + err.message);
  }
}

// Pengeluaran
$('eDate').value = new Date().toISOString().slice(0, 10);
$('expenseForm').onsubmit = async e => {
  e.preventDefault();
  let amount = rupiahInput($('eAmount').value);
  if (amount <= 0) return;
  try {
    await apiCall('/api/expenses', 'POST', {
      date: $('eDate').value,
      category: $('eCategory').value,
      amount,
      car_id: $('eCar').value || null,
      note: $('eNote').value.trim()
    });
    $('expenseForm').reset();
    $('eDate').value = new Date().toISOString().slice(0, 10);
    await loadAppData();
    alert('Pengeluaran berhasil dicatat.');
  } catch (err) {
    alert('Gagal mencatat pengeluaran: ' + err.message);
  }
};

async function delExpense(id) {
  if (currentUser?.role !== 'admin') {
    alert('Hanya admin yang dapat menghapus data.');
    return;
  }
  if (!confirm('Hapus catatan pengeluaran ' + id + '?')) return;
  try {
    await apiCall('/api/expenses/' + id, 'DELETE');
    await loadAppData();
  } catch (err) {
    alert('Gagal menghapus: ' + err.message);
  }
}

// Mitra
$('mpDate').value = new Date().toISOString().slice(0, 10);
$('jDate').value = new Date().toISOString().slice(0, 10);

$('partnerForm').onsubmit = async e => {
  e.preventDefault();
  try {
    await apiCall('/api/partners', 'POST', {
      name: $('mName').value.trim(),
      wa: $('mWa').value.trim(),
      address: $('mAddress').value.trim(),
      bank: $('mBank').value.trim(),
      account_no: $('mAccount').value.trim(),
      account_name: $('mAccountName').value.trim()
    });
    $('partnerForm').reset();
    await loadAppData();
    alert('Mitra berhasil disimpan.');
  } catch (err) {
    alert('Gagal menyimpan mitra: ' + err.message);
  }
};

$('partnerPayForm').onsubmit = async e => {
  e.preventDefault();
  let booking_id = $('mpBooking').value;
  let partner_id = $('mpPartner').value;
  let amount = rupiahInput($('mpAmount').value);
  if (!booking_id || !partner_id || amount <= 0) {
    alert('Lengkapi pembayaran mitra.');
    return;
  }
  try {
    await apiCall('/api/partner-payments', 'POST', {
      booking_id,
      partner_id,
      date: $('mpDate').value,
      amount,
      note: $('mpNote').value
    });
    $('partnerPayForm').reset();
    $('mpDate').value = new Date().toISOString().slice(0, 10);
    await loadAppData();
    alert('Pembayaran mitra berhasil dicatat.');
  } catch (err) {
    alert('Gagal mencatat pembayaran mitra: ' + err.message);
  }
};

// Jurnal
$('journalForm').onsubmit = async e => {
  e.preventDefault();
  let amount = rupiahInput($('jAmount').value);
  if (amount <= 0 || $('jDebit').value === $('jCredit').value) {
    alert('Nominal harus positif dan akun debit/kredit harus berbeda.');
    return;
  }
  try {
    await apiCall('/api/journals', 'POST', {
      date: $('jDate').value,
      note: $('jNote').value,
      debit_account: $('jDebit').value,
      credit_account: $('jCredit').value,
      amount
    });
    $('journalForm').reset();
    $('jDate').value = new Date().toISOString().slice(0, 10);
    await loadAppData();
    alert('Jurnal manual berhasil disimpan.');
  } catch (err) {
    alert('Gagal menyimpan jurnal: ' + err.message);
  }
};

// RENDER ALL DATA
function render() {
  // 1. Pelanggan Table
  let q = ($('qCust')?.value || '').toLowerCase();
  $('custRows').innerHTML = db.customers.filter(x => (x.id + x.nama + (x.wa || '')).toLowerCase().includes(q)).map(x => `
    <tr>
      <td>${esc(x.id)}</td>
      <td>${esc(x.nama)}</td>
      <td>${esc(x.alamat || '-')}</td>
      <td>${esc(x.wa || '-')}</td>
      <td>${esc(x.nik || '-')}</td>
      <td>${esc(x.sim || '-')}</td>
      <td><span class="badge ${x.status === 'Aktif' ? 'ok' : (x.status === 'Blacklist' ? 'bad' : 'warn')}">${esc(x.status)}</span></td>
      <td class="no-print">
        <div class="actions">
          <button class="btn small" onclick="editCust('${x.id}')">Edit</button>
          ${currentUser?.role === 'admin' ? `<button class="btn small danger" onclick="delCust('${x.id}')">Hapus</button>` : ''}
        </div>
      </td>
    </tr>
  `).join('') || '<tr><td colspan="8" class="muted">Belum ada data pelanggan.</td></tr>';

  // 2. Armada Table
  let qc = ($('qCar')?.value || '').toLowerCase();
  $('carRows').innerHTML = db.cars.filter(x => (x.id + x.jenis + x.plat).toLowerCase().includes(qc)).map(x => `
    <tr>
      <td>${esc(x.id)}</td>
      <td>${esc(x.merk)}</td>
      <td>${esc(x.jenis)}</td>
      <td>${esc(x.plat)}</td>
      <td>${esc(x.trans)}</td>
      <td><span class="badge">${esc(x.status)}</span></td>
      <td class="no-print">
        <div class="actions">
          <button class="btn small" onclick="editCar('${x.id}')">Edit</button>
          ${currentUser?.role === 'admin' ? `<button class="btn small danger" onclick="delCar('${x.id}')">Hapus</button>` : ''}
        </div>
      </td>
    </tr>
  `).join('') || '<tr><td colspan="7" class="muted">Belum ada data armada.</td></tr>';

  // Select dropdowns
  $('bCust').innerHTML = '<option value="">Pilih pelanggan</option>' + db.customers.filter(x => x.status === 'Aktif').map(x => `<option value="${x.id}">${esc(x.id)} — ${esc(x.nama)}</option>`).join('');
  $('bCar').innerHTML = '<option value="">Pilih armada</option>' + db.cars.filter(x => ['Tersedia', 'Disewa'].includes(x.status)).map(x => `<option value="${x.id}">${esc(x.id)} — ${esc(x.jenis)} (${esc(x.plat)})</option>`).join('');
  $('bDriver').innerHTML = '<option value="">Tanpa driver</option>' + db.drivers.filter(d => d.status === 'Aktif').map(d => `<option value="${d.id}">${esc(d.name)}</option>`).join('');

  // 3. Booking Table
  let qb = ($('qBook')?.value || '').toLowerCase();
  $('bookRows').innerHTML = db.bookings.filter(b => (b.id + (cust(b.customer_id)?.nama || '') + (car(b.car_id)?.jenis || '') + (b.driver_name || '') + (b.destination || '')).toLowerCase().includes(qb)).map(b => {
    let tripCost = (Number(b.driver_fee_per_day || 0) * Number(b.days || 0)) + Number(b.toll_cost || 0) + Number(b.fuel_cost || 0) + Number(b.meal_cost || 0) + Number(b.lodging_cost || 0);
    return `
      <tr>
        <td>${esc(b.id)}</td>
        <td>${esc(cust(b.customer_id)?.nama || b.customer_id)}</td>
        <td>${esc(car(b.car_id)?.jenis || b.car_id)}</td>
        <td>${formatDateDMY(b.start)}</td>
        <td>${formatDateDMY(b.end)}</td>
        <td>${b.days}</td>
        <td>${money(b.rate)}</td>
        <td>${esc(b.driver_name || '-')}</td>
        <td>${esc(b.destination || '-')}</td>
        <td>${money(tripCost)}</td>
        <td><strong>${money(b.total)}</strong></td>
        <td><span class="badge ${statusBook(b) === 'Lunas' ? 'ok' : (statusBook(b) === 'DP' ? 'warn' : 'bad')}">${statusBook(b)}</span></td>
        <td class="no-print">
          <div class="actions">
            <button class="btn small" onclick="editBooking('${b.id}')">Edit</button>
            <button class="btn small" onclick="selectInvoice('${b.id}')">Invoice</button>
            ${currentUser?.role === 'admin' ? `<button class="btn small danger" onclick="delBooking('${b.id}')">Hapus</button>` : ''}
          </div>
        </td>
      </tr>
    `;
  }).join('') || '<tr><td colspan="13" class="muted">Belum ada booking.</td></tr>';

  // 4. Pembayaran options & table
  const selectedPayBooking = $('pBook').value;
  const unpaidBookings = db.bookings.filter(b => Math.max(0, Number(b.total || 0) - paid(b.id)) > 0);
  const customerIds = [...new Set(unpaidBookings.map(b => String(b.customer_id || '')))];
  $('pBook').innerHTML = '<option value="">Pilih ID pelanggan / booking yang belum lunas</option>' + customerIds.map(cid => `
    <optgroup label="${esc(cid)} — ${esc(cust(cid)?.nama || '')}">
      ${unpaidBookings.filter(b => String(b.customer_id || '') === cid).map(b => `<option value="${esc(b.id)}">${esc(cid)} — ${esc(b.id)} (Sisa ${money(Math.max(0, Number(b.total || 0) - paid(b.id)))})</option>`).join('')}
    </optgroup>
  `).join('');
  if (unpaidBookings.some(b => b.id === selectedPayBooking)) $('pBook').value = selectedPayBooking;

  const paymentCustomerIds = [...new Set(db.payments.map(p => String(p.customer_id || '')))];
  $('payRows').innerHTML = paymentCustomerIds.map(cid => {
    let items = db.payments.filter(p => String(p.customer_id || '') === cid);
    let bookingIds = [...new Set(items.map(p => p.booking_id))];
    let totalPaid = items.reduce((sum, p) => sum + Number(p.amount || 0), 0);
    let allSettled = bookingIds.every(id => statusBook(book(id) || { id, total: 0 }) === 'Lunas');
    let details = items.map(p => `
      <div style="margin:4px 0">
        <span>${esc(p.booking_id)} • ${esc(p.id)} • ${money(p.amount)} • ${formatDateDMY(p.date)}</span>
        <button class="btn small" onclick="editPayment('${esc(p.id)}')">Edit</button>
      </div>
    `).join('');
    return `
      <tr>
        <td>${esc(cid)}</td>
        <td>${esc(cust(cid)?.nama || '')}</td>
        <td>${bookingIds.map(esc).join('<br>')}</td>
        <td><strong>${money(totalPaid)}</strong></td>
        <td><span class="badge ${allSettled ? 'ok' : 'warn'}">${allSettled ? 'Lunas' : 'Ada DP / belum lunas'}</span></td>
        <td>${details}</td>
      </tr>
    `;
  }).join('') || '<tr><td colspan="6" class="muted">Belum ada pembayaran.</td></tr>';

  // 5. Driver Table
  $('driverRows').innerHTML = db.drivers.map(d => `
    <tr>
      <td>${esc(d.id)}</td>
      <td>${esc(d.name)}</td>
      <td>${esc(d.wa || '')}</td>
      <td>${esc(d.address || '')}</td>
      <td>${esc(d.license || '')}</td>
      <td>${esc(d.status || 'Aktif')}</td>
      <td>
        <button class="btn small" onclick="editDriver('${d.id}')">Edit</button>
        ${currentUser?.role === 'admin' ? `<button class="btn small danger" onclick="deleteDriver('${d.id}')">Hapus</button>` : ''}
      </td>
    </tr>
  `).join('') || '<tr><td colspan="7">Belum ada driver.</td></tr>';

  // 6. Pengeluaran
  let allExpense = db.expenses.reduce((s, x) => s + Number(x.amount || 0), 0);
  $('expenseTotal').textContent = money(allExpense);
  $('expenseRows').innerHTML = db.expenses.slice().sort((a, b) => b.date.localeCompare(a.date)).map(x => `
    <tr>
      <td>${esc(x.id)}</td>
      <td>${esc(x.date)}</td>
      <td>${esc(x.category)}</td>
      <td>${esc(x.note || '-')}</td>
      <td>${money(x.amount)}</td>
      <td class="no-print">
        ${currentUser?.role === 'admin' ? `<button class="btn small danger" onclick="delExpense('${x.id}')">Hapus</button>` : ''}
      </td>
    </tr>
  `).join('') || '<tr><td colspan="6" class="muted">Belum ada pengeluaran.</td></tr>';
  $('eCar').innerHTML = '<option value="">Biaya umum usaha</option>' + db.cars.map(a => `<option value="${a.id}">${esc(a.jenis)} (${esc(a.plat)})</option>`).join('');

  // 7. Mitra & Pembayaran Mitra
  $('aPartner').innerHTML = '<option value="">Pilih mitra (jika milik mitra)</option>' + db.partners.map(m => `<option value="${m.id}">${esc(m.name)} (${m.id})</option>`).join('');
  $('partnerRows').innerHTML = db.partners.map(m => `
    <tr>
      <td>${esc(m.id)}</td>
      <td>${esc(m.name)}</td>
      <td>${esc(m.wa || '-')}</td>
      <td>${esc(m.address || '-')}</td>
      <td>${esc(m.bank || '-')}</td>
      <td>${esc(m.account_no || '-')}</td>
    </tr>
  `).join('') || '<tr><td colspan="6">Belum ada mitra.</td></tr>';

  $('mpBooking').innerHTML = '<option value="">Pilih booking</option>' + db.bookings.filter(b => car(b.car_id)?.ownership === 'mitra').map(b => `<option value="${b.id}">${b.id} — ${esc(car(b.car_id)?.jenis || '')}</option>`).join('');
  $('mpPartner').innerHTML = '<option value="">Pilih mitra</option>' + db.partners.map(m => `<option value="${m.id}">${esc(m.name)}</option>`).join('');
  $('partnerPayRows').innerHTML = db.partnerPayments.map(p => `
    <tr>
      <td>${esc(p.id)}</td>
      <td>${esc(p.booking_id)}</td>
      <td>${esc(db.partners.find(m => m.id === p.partner_id)?.name || p.partner_id)}</td>
      <td>${esc(p.date)}</td>
      <td>${money(p.amount)}</td>
      <td>${esc(p.status)}</td>
    </tr>
  `).join('') || '<tr><td colspan="6">Belum ada pembayaran mitra.</td></tr>';

  // 8. Jurnal & Akuntansi
  $('journalRows').innerHTML = db.journals.map(j => `
    <tr>
      <td>${esc(j.id)}</td>
      <td>${esc(j.date)}</td>
      <td>${esc(j.note)}</td>
      <td>${esc(j.debit_account)}</td>
      <td>${esc(j.credit_account)}</td>
      <td>${money(j.amount)}</td>
    </tr>
  `).join('') || '<tr><td colspan="6">Belum ada jurnal manual.</td></tr>';
  let jDebit = db.journals.reduce((s, j) => s + Number(j.amount || 0), 0);
  $('jDebitTotal').textContent = money(jDebit);
  $('jCreditTotal').textContent = money(jDebit);

  // Ledger calculation
  let ledger = [];
  db.payments.forEach(p => {
    let b = book(p.booking_id), a = b ? car(b.car_id) : null, amount = Number(p.amount || 0);
    ledger.push({ date: String(p.date || '').slice(0, 10), account: '1101 Kas/Bank', note: 'Penerimaan pelanggan ' + p.booking_id, debit: amount, credit: 0 });
    if (a?.ownership === 'mitra') {
      let shareTotal = Number(b.partner_rate ?? a.partner_rate ?? 0) * Number(b.days || 0);
      let sharePart = b.total > 0 ? Math.min(amount, amount * shareTotal / b.total) : 0;
      ledger.push({ date: String(p.date || '').slice(0, 10), account: '2101 Utang Mitra', note: 'Bagian pemilik ' + p.booking_id, debit: 0, credit: sharePart });
      ledger.push({ date: String(p.date || '').slice(0, 10), account: '4201 Pendapatan Margin Mitra', note: 'Margin ' + p.booking_id, debit: 0, credit: amount - sharePart });
    } else {
      ledger.push({ date: String(p.date || '').slice(0, 10), account: '4101 Pendapatan Sewa', note: 'Pendapatan sewa ' + p.booking_id, debit: 0, credit: amount });
    }
  });

  db.expenses.forEach(x => {
    ledger.push({ date: x.date, account: '5101 Beban Operasional', note: x.note || x.category, debit: x.amount, credit: 0 });
    ledger.push({ date: x.date, account: '1101 Kas/Bank', note: x.note || x.category, debit: 0, credit: x.amount });
  });

  db.partnerPayments.forEach(p => {
    ledger.push({ date: p.date, account: '2101 Utang Mitra', note: 'Pembayaran mitra ' + p.booking_id, debit: p.amount, credit: 0 });
    ledger.push({ date: p.date, account: '1101 Kas/Bank', note: 'Pembayaran mitra ' + p.booking_id, debit: 0, credit: p.amount });
  });

  db.journals.forEach(j => {
    ledger.push({ date: j.date, account: j.debit_account, note: j.note, debit: j.amount, credit: 0 });
    ledger.push({ date: j.date, account: j.credit_account, note: j.note, debit: 0, credit: j.amount });
  });

  ledger.sort((a, b) => a.date.localeCompare(b.date));
  let balances = {};
  $('ledgerRows').innerHTML = ledger.map(x => {
    balances[x.account] = (balances[x.account] || 0) + Number(x.debit || 0) - Number(x.credit || 0);
    return `<tr><td>${esc(x.date)}</td><td>${esc(x.account)}</td><td>${esc(x.note)}</td><td>${money(x.debit)}</td><td>${money(x.credit)}</td><td>${money(balances[x.account])}</td></tr>`;
  }).join('') || '<tr><td colspan="6">Belum ada mutasi buku besar.</td></tr>';

  // Car profit rows
  let carRows = db.cars.map(a => {
    let inc = db.payments.filter(p => book(p.booking_id)?.car_id === a.id).reduce((s, p) => s + Number(p.amount || 0), 0);
    let partnerShare = a.ownership === 'mitra' ? db.bookings.filter(b => b.car_id === a.id).reduce((s, b) => s + Number(b.partner_rate ?? a.partner_rate ?? 0) * Number(b.days || 0), 0) : 0;
    let partnerPaid = db.partnerPayments.filter(p => db.bookings.find(b => b.id === p.booking_id)?.car_id === a.id).reduce((s, p) => s + Number(p.amount || 0), 0);
    let direct = db.expenses.filter(x => x.car_id === a.id).reduce((s, x) => s + Number(x.amount || 0), 0);
    let result = a.ownership === 'mitra' ? inc - partnerPaid - direct : inc - direct;
    return `<tr><td>${esc(a.jenis)} (${esc(a.plat)})</td><td>${a.ownership === 'mitra' ? 'Mitra' : 'Sendiri'}</td><td>${money(inc)}</td><td>${money(a.ownership === 'mitra' ? partnerPaid : 0)}</td><td>${money(direct)}</td><td>${money(result)}</td></tr>`;
  }).join('');
  $('carProfitRows').innerHTML = carRows || '<tr><td colspan="6">Belum ada kendaraan.</td></tr>';

  let totalIn = db.payments.reduce((s, p) => s + Number(p.amount || 0), 0);
  let totalPartner = db.partnerPayments.reduce((s, p) => s + Number(p.amount || 0), 0);
  let totalExp = db.expenses.reduce((s, x) => s + Number(x.amount || 0), 0);
  $('overallProfit').textContent = 'Hasil kas usaha (seluruh periode): ' + money(totalIn - totalPartner - totalExp);

  // 9. Laporan & Dashboard Stats
  let total = db.bookings.reduce((s, b) => s + b.total, 0);
  let allIncome = db.payments.reduce((s, p) => Number(p.amount) + s, 0);
  let remain = db.bookings.reduce((s, b) => s + Math.max(0, b.total - paid(b.id)), 0);
  let unpaid = db.bookings.filter(b => statusBook(b) !== 'Lunas').length;

  if ($('reportMonth') && !$('reportMonth').value) $('reportMonth').value = new Date().toISOString().slice(0, 7);
  let period = $('reportMonth')?.value || new Date().toISOString().slice(0, 7);
  let monthIncome = db.payments.filter(p => String(p.date || '').slice(0, 7) === period).reduce((s, p) => s + Number(p.amount || 0), 0);
  let monthExpense = db.expenses.filter(x => String(x.date || '').slice(0, 7) === period).reduce((s, x) => s + Number(x.amount || 0), 0);

  $('sCust').textContent = db.customers.length;
  $('sCar').textContent = db.cars.length;
  $('sBook').textContent = db.bookings.length;
  $('sPay').textContent = money(allIncome);

  $('rBooking').textContent = money(total);
  $('rIncome').textContent = money(monthIncome);
  $('rRemain').textContent = money(remain);
  $('rExpense').textContent = money(monthExpense);
  $('rNet').textContent = money(monthIncome - monthExpense);
  $('rUnpaid').textContent = unpaid;

  // P&L rows
  let pl = [];
  db.payments.filter(p => String(p.date || '').slice(0, 7) === period).forEach(p => {
    pl.push({ date: String(p.date || '').slice(0, 10), kind: 'Pemasukan', note: (cust(p.customer_id)?.nama || p.customer_id) + ' • ' + p.booking_id, amount: Number(p.amount || 0) });
  });
  db.expenses.filter(x => String(x.date || '').slice(0, 7) === period).forEach(x => {
    pl.push({ date: x.date, kind: 'Pengeluaran', note: (x.category || '') + ' • ' + (x.note || ''), amount: Number(x.amount || 0) });
  });
  pl.sort((a, b) => a.date.localeCompare(b.date));
  $('plRows').innerHTML = pl.map(x => `
    <tr>
      <td>${esc(x.date)}</td>
      <td><span class="badge ${x.kind === 'Pemasukan' ? 'ok' : 'bad'}">${x.kind}</span></td>
      <td>${esc(x.note)}</td>
      <td>${money(x.amount)}</td>
    </tr>
  `).join('') || '<tr><td colspan="4" class="muted">Belum ada transaksi pada periode ini.</td></tr>';

  // Rekap Booking
  $('reportRows').innerHTML = db.bookings.map(b => `
    <tr>
      <td>${b.id}</td>
      <td>${esc(cust(b.customer_id)?.nama || '')}</td>
      <td>${esc(car(b.car_id)?.jenis || '')}</td>
      <td>${money(b.total)}</td>
      <td>${money(paid(b.id))}</td>
      <td>${money(Math.max(0, b.total - paid(b.id)))}</td>
      <td>${statusBook(b)}</td>
    </tr>
  `).join('') || '<tr><td colspan="7" class="muted">Belum ada data booking.</td></tr>';

  // Invoice Section
  if ($('invoiceMonth') && !$('invoiceMonth').value) $('invoiceMonth').value = new Date().toISOString().slice(0, 7);
  let invoicePeriod = $('invoiceMonth')?.value || new Date().toISOString().slice(0, 7);
  let invoiceBookings = db.bookings.filter(b => statusBook(b) === 'Belum Bayar' && String(b.start || '').slice(0, 7) === invoicePeriod);
  let unpaidCustomers = [...new Set(invoiceBookings.map(b => b.customer_id))];
  let selectedInvoice = $('invoicePick').value;

  $('invoicePick').innerHTML = '<option value="">Pilih pelanggan (booking belum bayar)</option>' + unpaidCustomers.map(id => {
    let c = cust(id) || {};
    let count = invoiceBookings.filter(b => b.customer_id === id).length;
    return `<option value="${id}">${esc(id)} — ${esc(c.nama || '')} (${count} booking)</option>`;
  }).join('');

  if (unpaidCustomers.includes(selectedInvoice)) $('invoicePick').value = selectedInvoice;
  else $('invoicePreview').innerHTML = '';
}

function selectInvoice(id) {
  let b = book(id);
  if (!b) return;
  $('invoiceMonth').value = String(b.start || '').slice(0, 7);
  render();
  $('invoicePick').value = b.customer_id;
  showInvoice();
  document.querySelector('[data-tab="laporan"]').click();
}

$('invoicePick').onchange = showInvoice;
function unpaidBookingsForCustomer(customerId, month) {
  return db.bookings.filter(b => b.customer_id === customerId && statusBook(b) === 'Belum Bayar' && String(b.start || '').slice(0, 7) === month);
}

function invoiceHtmlForCustomer(customerId, month) {
  let list = unpaidBookingsForCustomer(customerId, month), c = cust(customerId) || {};
  if (!list.length) return '<p style="color:#111">Tidak ada booking belum bayar untuk pelanggan ini pada bulan terpilih.</p>';
  let total = list.reduce((s, b) => s + b.total, 0);
  let rows = list.map(b => {
    let a = car(b.car_id) || {};
    return `<tr><td>${esc(b.id)}</td><td>${esc(a.jenis || '')} (${esc(a.plat || '')})</td><td>${b.start} s.d. ${b.end}</td><td>${b.days} hari</td><td>${money(b.rate)}</td><td>${money(b.total)}</td></tr>`;
  }).join('');

  return `
    <div style="max-width:850px;margin:auto;padding:20px;border:1px solid #bbb;color:#111;background:#fff">
      <div style="display:flex;justify-content:space-between;gap:15px">
        <div><h2 style="margin:0;color:#17243a">ALFA PRIMA RENT CAR</h2><small>Semarang</small></div>
        <div style="text-align:right"><h2 style="margin:0">INVOICE BULANAN</h2><b>${esc(customerId)}</b><br><small>Periode: ${esc(month)} • ${list.length} booking belum bayar</small></div>
      </div>
      <hr>
      <p><b>Nama pelanggan:</b> ${esc(c.nama || '')}<br><b>Alamat:</b> ${esc(c.alamat || '')}<br><b>No. WA:</b> ${esc(c.wa || '')}</p>
      <table style="min-width:0;color:#111">
        <thead><tr><th>ID Booking</th><th>Armada</th><th>Periode Sewa</th><th>Durasi</th><th>Harga/Hari</th><th>Total</th></tr></thead>
        <tbody>${rows}</tbody>
      </table>
      <div style="margin-left:auto;max-width:320px;margin-top:18px">
        <p>Jumlah booking: <b>${list.length}</b><br>Total tagihan belum dibayar: <b>${money(total)}</b></p>
      </div>
      <hr>
      <p style="text-align:center">Terima kasih telah menggunakan layanan Alfa Prima Rent Car.</p>
    </div>
  `;
}

function showInvoice() {
  let id = $('invoicePick').value, month = $('invoiceMonth').value;
  $('invoicePreview').innerHTML = id ? invoiceHtmlForCustomer(id, month) : '';
}

function printInvoice() {
  let customerId = $('invoicePick').value, month = $('invoiceMonth').value;
  if (!customerId) { alert('Pilih pelanggan terlebih dahulu.'); return; }
  let list = unpaidBookingsForCustomer(customerId, month);
  if (!list.length) { alert('Tidak ada booking belum bayar untuk pelanggan ini pada bulan terpilih.'); return; }
  let w = window.open('', '_blank');
  w.document.write('<html><head><title>Invoice Bulanan ' + customerId + '</title><style>body{font:14px Arial;padding:25px}table{width:100%;border-collapse:collapse}th,td{padding:10px;border:1px solid #bbb;text-align:left}th{background:#eee}</style></head><body>' + invoiceHtmlForCustomer(customerId, month) + '</body></html>');
  w.document.close();
  w.focus();
  w.print();
}

$('invoiceMonth').onchange = () => { render(); showInvoice(); };
$('reportMonth').onchange = render;
function printReport() { window.print(); }

function backup() {
  window.location.href = '/api/backup';
}

$('restoreFile').onchange = async e => {
  let f = e.target.files[0];
  if (!f) return;
  let r = new FileReader();
  r.onload = async () => {
    try {
      let x = JSON.parse(r.result);
      if (!confirm('Pulihkan backup? Data saat ini akan diganti.')) return;
      await apiCall('/api/restore', 'POST', x);
      await loadAppData();
      alert('Backup berhasil dipulihkan.');
    } catch (err) {
      alert('File backup tidak valid: ' + err.message);
    }
  };
  r.readAsText(f);
  e.target.value = '';
};

function exportCSV() {
  window.location.href = '/api/export-csv';
}

async function clearAll() {
  if (currentUser?.role !== 'admin') {
    alert('Hanya admin yang dapat menghapus seluruh data.');
    return;
  }
  if (!confirm('Yakin menghapus SELURUH data pelanggan, armada, booking, dan pembayaran? Unduh backup terlebih dahulu.')) return;
  try {
    await apiCall('/api/clear-all', 'POST');
    await loadAppData();
    alert('Seluruh data berhasil dihapus.');
  } catch (err) {
    alert('Gagal menghapus data: ' + err.message);
  }
}

// User Management
async function renderUsers() {
  if (currentUser?.role !== 'admin') return;
  try {
    const users = await apiCall('/api/users');
    $('userRows').innerHTML = users.map(u => `
      <tr>
        <td>${esc(u.username)}</td>
        <td>${esc(u.role)}</td>
        <td>${u.active ? 'Aktif' : 'Nonaktif'}</td>
        <td class="no-print">
          ${u.role === 'admin' ? '' : `<button class="btn small ${u.active ? 'danger' : ''}" onclick="toggleUser(${u.id}, ${!u.active})">${u.active ? 'Nonaktifkan' : 'Aktifkan'}</button>`}
        </td>
      </tr>
    `).join('') || '<tr><td colspan="4">Belum ada pengguna.</td></tr>';
  } catch (err) {
    console.error('Gagal memuat pengguna:', err);
  }
}

$('userForm').onsubmit = async e => {
  e.preventDefault();
  if (currentUser?.role !== 'admin') {
    alert('Hanya admin yang dapat membuat akun.');
    return;
  }
  const username = $('uName').value.trim(), password = $('uPass').value;
  try {
    await apiCall('/api/users', 'POST', { username, password });
    $('userForm').reset();
    await renderUsers();
    alert('Akun karyawan berhasil dibuat.');
  } catch (err) {
    alert('Gagal membuat akun: ' + err.message);
  }
};

async function toggleUser(userId, active) {
  if (currentUser?.role !== 'admin') return;
  if (!confirm((active ? 'Aktifkan' : 'Nonaktifkan') + ' akun karyawan?')) return;
  try {
    await apiCall('/api/users/' + userId + '/toggle', 'POST', { active });
    await renderUsers();
  } catch (err) {
    alert('Gagal mengubah status akun: ' + err.message);
  }
}

// Auth Login / Logout
$('authForm').onsubmit = async e => {
  e.preventDefault();
  const username = $('authUser').value.trim(), password = $('authPass').value;
  setSyncStatus('Memverifikasi akun…');
  try {
    const res = await apiCall('/api/login', 'POST', { username, password });
    if (res.user) {
      currentUser = res.user;
    }
    await loadAppData();
  } catch (err) {
    setSyncStatus('Login gagal: ' + err.message, '#ffb3b3');
    alert('Login gagal: ' + err.message);
  }
};

$('logoutBtn').onclick = async () => {
  try {
    await apiCall('/api/logout', 'POST');
    currentUser = null;
    document.body.classList.add('auth-required');
    $('authScreen').style.display = 'flex';
    setSyncStatus('Sesi berakhir', '#ffb3b3');
  } catch (err) {
    alert('Gagal logout: ' + err.message);
  }
};

['qCust', 'qCar', 'qBook'].forEach(id => {
  $(id)?.addEventListener('input', render);
});

// Init
loadAppData();
</script>
</body>
</html>

