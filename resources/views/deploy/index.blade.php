<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Alfa Prima — Deployment & Database Tool (cPanel)</title>
<style>
:root{--bg:#0b1220;--panel:#121d30;--panel2:#18263d;--line:#2b3b55;--gold:#d8b45a;--text:#eef2f8;--muted:#9eacc1;--red:#e87979;--green:#64c69a}
*{box-sizing:border-box}body{margin:0;background:var(--bg);color:var(--text);font:14px/1.5 Arial,sans-serif;padding:24px 16px}
.container{max-width:800px;margin:auto}
.card{background:var(--panel);border:1px solid var(--line);border-radius:12px;padding:22px;margin-bottom:18px}
.header{display:flex;justify-content:space-between;align-items:center;border-bottom:1px solid var(--line);padding-bottom:16px;margin-bottom:20px;flex-wrap:wrap;gap:12px}
.brand{font-size:20px;font-weight:800;letter-spacing:.4px}.brand span{color:var(--gold)}
.badge{display:inline-block;padding:3px 9px;border-radius:20px;font-size:11px;font-weight:700}
.badge.ok{background:#173b32;color:#a4efc9}.badge.warn{background:#49391d;color:#ffe0a1}
.info-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:12px;margin-bottom:18px}
.info-item{background:var(--panel2);border:1px solid var(--line);padding:12px;border-radius:8px}
.info-item small{color:var(--muted);display:block;font-size:11px}
.info-item strong{font-size:14px;color:var(--text);word-break:break-all}
.action-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(230px,1fr));gap:12px}
.action-card{background:var(--panel2);border:1px solid var(--line);border-radius:10px;padding:16px;display:flex;flex-direction:column;justify-content:space-between}
.action-card h3{margin:0 0 6px;font-size:15px;color:var(--gold)}
.action-card p{margin:0 0 14px;font-size:12px;color:var(--muted);flex:1}
.btn{display:inline-block;text-align:center;text-decoration:none;border:1px solid var(--line);background:#101a2c;color:var(--text);padding:9px 15px;border-radius:8px;font-weight:700;font-size:13px;cursor:pointer;transition:.15s}
.btn:hover{filter:brightness(1.2)}
.btn.primary{background:var(--gold);border-color:var(--gold);color:#151515}
.btn.danger{background:rgba(232,121,121,.15);border-color:#e87979;color:#ffb3b3}
.notice{background:rgba(216,180,90,.1);border:1px solid rgba(216,180,90,.3);padding:12px 16px;border-radius:8px;font-size:12px;color:var(--gold);margin-bottom:18px}
.back-link{margin-top:16px;display:inline-block;color:var(--gold);text-decoration:none;font-size:13px}
</style>
</head>
<body>
<div class="container">
  <div class="card">
    <div class="header">
      <div>
        <div class="brand">ALFA <span>PRIMA</span> DEPLOY HELPER</div>
        <small style="color:var(--muted)">Database Migration &amp; Setup Tool untuk cPanel / Shared Hosting</small>
      </div>
      <div>
        <span class="badge ok">Authorized ✓</span>
      </div>
    </div>

    <div class="info-grid">
      <div class="info-item">
        <small>APP_ENV</small>
        <strong>{{ $appEnv }}</strong>
      </div>
      <div class="info-item">
        <small>DATABASE HOST</small>
        <strong>{{ $dbHost }}</strong>
      </div>
      <div class="info-item">
        <small>DATABASE NAME</small>
        <strong>{{ $dbDatabase }}</strong>
      </div>
    </div>

    <div class="notice">
      <b>Informasi:</b> Tool ini memungkinkan eksekusi perintah <code>php artisan</code> langsung dari browser tanpa perlu akses Terminal / SSH di cPanel. Pastikan konfigurasi database di file <code>.env</code> hosting Anda sudah benar sebelum menjalankan aksi di bawah.
    </div>

    <h2 style="font-size:16px;margin:0 0 14px">Pilihan Eksekusi Database</h2>
    <div class="action-grid">
      
      <div class="action-card">
        <div>
          <h3>1. Migrate Saja</h3>
          <p>Menjalankan migrasi tabel yang belum pernah dibuat (<code>php artisan migrate --force</code>). Aman untuk database yang sudah berisi data.</p>
        </div>
        <a class="btn" href="{{ route('deploy.run', ['action' => 'migrate', 'token' => $token]) }}" onclick="return confirm('Jalankan migrasi database?')">Jalankan Migrate</a>
      </div>

      <div class="action-card">
        <div>
          <h3>2. Seed Saja</h3>
          <p>Mengisi data awal master & akun ke dalam tabel yang ada (<code>php artisan db:seed --force</code>).</p>
        </div>
        <a class="btn" href="{{ route('deploy.run', ['action' => 'seed', 'token' => $token]) }}" onclick="return confirm('Jalankan seeder data?')">Jalankan Seed</a>
      </div>

      <div class="action-card" style="border-color:var(--gold)">
        <div>
          <h3 style="color:#f2d58a">3. Migrate &amp; Seed (Rekomendasi Pertama)</h3>
          <p>Membuat seluruh struktur tabel dan langsung mengisi data awal default rental mobil Alfa Prima.</p>
        </div>
        <a class="btn primary" href="{{ route('deploy.run', ['action' => 'migrate-seed', 'token' => $token]) }}" onclick="return confirm('Jalankan migrate dan seeder sekarang?')">Jalankan Migrate + Seed</a>
      </div>

      <div class="action-card">
        <div>
          <h3 style="color:#e87979">4. Migrate Fresh &amp; Seed</h3>
          <p><b>Perhatian:</b> Menghapus SELURUH tabel dan membuat ulang dari nol + seeder (<code>migrate:fresh --seed --force</code>).</p>
        </div>
        <a class="btn danger" href="{{ route('deploy.run', ['action' => 'migrate-fresh-seed', 'token' => $token]) }}" onclick="return confirm('PERINGATAN: Semua data tabel di database akan DIHAPUS dan dibuat ulang dari awal! Lanjutkan?')">Migrate Fresh + Seed</a>
      </div>

      <div class="action-card">
        <div>
          <h3>5. Bersihkan &amp; Cache Ulang</h3>
          <p>Membersihkan cache view, route, dan config lalu membuat cache performa produksi (<code>optimize:clear</code> &amp; cache).</p>
        </div>
        <a class="btn" href="{{ route('deploy.run', ['action' => 'optimize', 'token' => $token]) }}">Optimize Cache</a>
      </div>

      <div class="action-card">
        <div>
          <h3>6. Storage Link</h3>
          <p>Membuat tautan simbolik folder storage publik (<code>php artisan storage:link</code>) untuk file upload.</p>
        </div>
        <a class="btn" href="{{ route('deploy.run', ['action' => 'storage-link', 'token' => $token]) }}">Buat Storage Link</a>
      </div>

    </div>

    <div style="margin-top:22px;border-top:1px solid var(--line);padding-top:14px;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:10px">
      <a class="back-link" href="{{ url('/') }}">← Buka Aplikasi Alfa Prima Rent Car</a>
      <small style="color:var(--muted)">Security Token: <code>{{ substr($token, 0, 4) . '••••' }}</code></small>
    </div>
  </div>
</div>
</body>
</html>

