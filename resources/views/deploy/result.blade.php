<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Hasil Eksekusi — Deployment Tool</title>
<style>
:root{--bg:#0b1220;--panel:#121d30;--panel2:#18263d;--line:#2b3b55;--gold:#d8b45a;--text:#eef2f8;--muted:#9eacc1;--red:#e87979;--green:#64c69a}
*{box-sizing:border-box}body{margin:0;background:var(--bg);color:var(--text);font:14px/1.5 Arial,sans-serif;padding:24px 16px}
.container{max-width:800px;margin:auto}
.card{background:var(--panel);border:1px solid var(--line);border-radius:12px;padding:22px}
.header{display:flex;justify-content:space-between;align-items:center;border-bottom:1px solid var(--line);padding-bottom:14px;margin-bottom:18px;flex-wrap:wrap;gap:10px}
.brand{font-size:18px;font-weight:800}.brand span{color:var(--gold)}
.badge{display:inline-block;padding:4px 10px;border-radius:20px;font-size:12px;font-weight:700}
.badge.ok{background:#173b32;color:#a4efc9}
.badge.err{background:#4a252b;color:#ffc0c0}
pre{background:#080e18;border:1px solid var(--line);padding:14px;border-radius:8px;color:#a3e635;font-family:Consolas,monospace;font-size:12px;overflow-x:auto;white-space:pre-wrap;word-break:break-all;line-height:1.45;max-height:450px}
.actions{display:flex;gap:10px;margin-top:20px;flex-wrap:wrap}
.btn{display:inline-block;text-align:center;text-decoration:none;border:1px solid var(--line);background:#101a2c;color:var(--text);padding:9px 16px;border-radius:8px;font-weight:700;font-size:13px}
.btn.primary{background:var(--gold);border-color:var(--gold);color:#151515}
.btn:hover{filter:brightness(1.2)}
</style>
</head>
<body>
<div class="container">
  <div class="card">
    <div class="header">
      <div>
        <div class="brand">ALFA <span>PRIMA</span> DEPLOY HELPER</div>
        <small style="color:var(--muted)">Perintah: <code>{{ $commandName }}</code></small>
      </div>
      <div>
        @if($success)
          <span class="badge ok">Berhasil ✓</span>
        @else
          <span class="badge err">Gagal / Error ✗</span>
        @endif
      </div>
    </div>

    <h3 style="font-size:14px;margin:0 0 8px;color:var(--muted)">Output Terminal Konsol:</h3>
    <pre>{{ $output }}</pre>

    <div class="actions">
      <a class="btn primary" href="{{ route('deploy.index', ['token' => $token]) }}">← Kembali ke Dashboard Deploy</a>
      <a class="btn" href="{{ url('/') }}">Buka Aplikasi Utama →</a>
    </div>
  </div>
</div>
</body>
</html>

