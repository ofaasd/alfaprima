<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Akses Ditolak — Deployment Tool</title>
<style>
:root{--bg:#0b1220;--panel:#121d30;--line:#2b3b55;--gold:#d8b45a;--text:#eef2f8;--muted:#9eacc1;--red:#e87979}
*{box-sizing:border-box}body{margin:0;background:var(--bg);color:var(--text);font:14px/1.5 Arial,sans-serif;padding:40px 16px;display:flex;align-items:center;justify-content:center;min-height:100vh}
.card{background:var(--panel);border:1px solid var(--line);border-radius:12px;padding:28px;max-width:520px;width:100%}
.brand{font-size:20px;font-weight:800;margin-bottom:8px}.brand span{color:var(--gold)}
h2{color:var(--red);margin:14px 0 10px;font-size:18px}
p{color:var(--muted);font-size:13px;line-height:1.6}
code{background:#080e18;border:1px solid var(--line);padding:3px 7px;border-radius:5px;color:#f2d58a;font-size:12px}
.form{margin-top:18px}
input{width:100%;padding:10px 12px;background:#080e18;border:1px solid var(--line);border-radius:8px;color:#fff;outline:none;font-size:13px;margin-bottom:12px}
.btn{display:block;width:100%;text-align:center;text-decoration:none;background:var(--gold);color:#151515;padding:10px;border-radius:8px;font-weight:700;border:0;cursor:pointer}
</style>
</head>
<body>
<div class="card">
  <div class="brand">ALFA <span>PRIMA</span> DEPLOY HELPER</div>
  <h2>403 — Akses Ditolak</h2>
  <p>Halaman deployment helper dilindungi demi keamanan database Anda. Untuk mengakses halaman ini, Anda harus memasukkan parameter security token atau login sebagai admin.</p>
  
  <form class="form" method="GET" action="{{ route('deploy.index') }}">
    <label style="display:block;font-size:12px;color:var(--muted);margin-bottom:6px">Masukkan Security Token:</label>
    <input type="text" name="token" placeholder="Masukkan token (default: alfaprima-deploy)" required autocomplete="off">
    <button class="btn" type="submit">Buka Deployment Tool</button>
  </form>

  <p style="margin-top:16px;font-size:11px">
    <b>Tips:</b> Token default adalah <code>alfaprima-deploy</code>. Anda dapat mengubah token rahasia ini di file <code>.env</code> hosting Anda dengan menambahkan:
    <br><code style="display:inline-block;margin-top:5px">DEPLOY_SECRET=token_rahasia_anda</code>
  </p>
  <div style="margin-top:16px;border-top:1px solid var(--line);padding-top:12px">
    <a href="{{ url('/') }}" style="color:var(--gold);text-decoration:none;font-size:12px">← Kembali ke Halaman Utama</a>
  </div>
</div>
</body>
</html>

