<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1,viewport-fit=cover"><meta name="theme-color" content="#0b1220">
<meta name="apple-mobile-web-app-capable" content="yes"><meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
<meta name="application-name" content="Alfa Prima"><meta name="apple-mobile-web-app-title" content="Alfa Prima">
<link rel="manifest" href="/manifest.json">
<link rel="icon" type="image/png" sizes="192x192" href="/icons/icon-192.png">
<link rel="apple-touch-icon" href="/icons/icon-192.png">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>Alfa Prima Rent Car — Sistem Laravel & MySQL</title>
<style>
:root{--bg:#0b1220;--panel:#121d30;--panel2:#18263d;--line:#2b3b55;--gold:#d8b45a;--text:#eef2f8;--muted:#9eacc1;--red:#e87979;--green:#64c69a}
*{box-sizing:border-box}body{margin:0;background:var(--bg);color:var(--text);font:14px/1.5 Arial,sans-serif}
header{padding:max(16px,env(safe-area-inset-top)) 24px 16px;background:linear-gradient(120deg,#101b2d,#1c2c45);border-bottom:1px solid var(--line);display:flex;align-items:center;justify-content:space-between;gap:15px;flex-wrap:wrap}
.header-brand-wrap{display:flex;align-items:center;gap:12px}
.header-logo{height:46px;width:auto;max-width:130px;object-fit:contain;border-radius:6px;filter:drop-shadow(0 2px 5px rgba(0,0,0,0.35))}
@media (max-width:600px){
  .header-logo{height:36px;max-width:90px}
  .header-brand-wrap{gap:9px}
  .brand{font-size:17px}
}
.brand{font-size:20px;font-weight:800;letter-spacing:.4px}.brand span{color:var(--gold)}.sub{color:var(--muted);font-size:12px}
main{max-width:1250px;margin:auto;padding:22px;padding-bottom:calc(22px + env(safe-area-inset-bottom))}
nav{display:flex;gap:8px;flex-wrap:wrap;margin-bottom:20px}
nav button,.btn{border:1px solid var(--line);background:var(--panel2);color:var(--text);padding:10px 15px;border-radius:9px;cursor:pointer;font-weight:600}
nav button.active,.btn.primary{background:var(--gold);border-color:var(--gold);color:#151515}
.btn.danger{color:#ffb3b3;border-color:#774747}.btn.small{padding:6px 9px;font-size:12px}
.grid{display:grid;grid-template-columns:repeat(4,minmax(0,1fr));gap:12px;margin-bottom:18px}
/* Ringkasan Daftar Booking: kartu lebih ringkas dan sejajar */
#daftarBooking > .grid{
  grid-template-columns:repeat(5,minmax(0,1fr));
  gap:5px;
  margin:0 0 8px;
  align-items:stretch;
  max-width:100%;
}
#daftarBooking > .grid .stat{
  min-width:0;
  min-height:54px;
  padding:6px 9px;
  display:flex;
  flex-direction:column;
  justify-content:center;
  gap:1px;
}
#daftarBooking > .grid .stat small{
  display:block;
  font-size:9px;
  line-height:1.15;
  white-space:normal;
}
#daftarBooking > .grid .stat strong{
  font-size:15px;
  line-height:1.15;
  margin-top:0;
  overflow-wrap:anywhere;
}
@media(max-width:1000px){
  #daftarBooking > .grid{grid-template-columns:repeat(3,minmax(0,1fr));gap:5px}
  #daftarBooking > .grid .stat{min-height:52px;padding:6px 8px}
  #daftarBooking > .grid .stat strong{font-size:14px}
}
@media(max-width:650px){
  #daftarBooking > .grid{grid-template-columns:repeat(2,minmax(0,1fr));gap:5px}
  #daftarBooking > .grid .stat{min-height:50px;padding:6px 8px}
  #daftarBooking > .grid .stat strong{font-size:13px}
}
.stat,.card{background:var(--panel);border:1px solid var(--line);border-radius:13px;padding:16px}
.stat small{color:var(--muted)}.stat strong{display:block;font-size:24px;margin-top:5px;color:var(--gold)}
h2{font-size:18px;margin:0 0 14px}h3{font-size:15px;margin:0 0 12px}
.row{display:flex;gap:10px;align-items:center;flex-wrap:wrap}.row>*{flex:1}
.toolbar{display:flex;justify-content:space-between;align-items:center;gap:10px;flex-wrap:wrap;margin-bottom:14px}
input,select{width:100%;padding:10px 11px;background:#0d1728;color:var(--text);border:1px solid var(--line);border-radius:8px;outline:none}
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
/* Toolbar Daftar Booking: kontrol ringkas, seragam, dan sejajar */
#daftarBooking .card > .toolbar{
  display:grid;
  grid-template-columns:minmax(220px,1fr) minmax(0,2.2fr);
  align-items:end;
  gap:10px;
  margin-bottom:10px;
}
#daftarBooking .card > .toolbar > div:first-child{
  min-width:0;
  align-self:center;
}
#daftarBooking .card > .toolbar > div:first-child h3{
  margin:0 0 5px;
  font-size:14px;
}
#daftarBooking .card > .toolbar .actions{
  display:grid;
  grid-template-columns:repeat(6,minmax(0,1fr));
  gap:6px;
  align-items:end;
  min-width:0;
}
#daftarBooking .card > .toolbar .actions .field{
  min-width:0;
}
#daftarBooking .card > .toolbar .actions label{
  font-size:10px;
  margin-bottom:3px;
}
#daftarBooking .card > .toolbar .actions select,
#daftarBooking .card > .toolbar .actions .btn{
  width:100%;
  min-width:0;
  height:36px;
  padding:6px 8px;
  font-size:11px;
  white-space:nowrap;
}
#daftarBooking .card > .toolbar > input#qBook{
  grid-column:1/-1;
  width:100%;
  max-width:none !important;
  height:34px;
  padding:7px 10px;
  font-size:11px;
}
@media(max-width:1050px){
  #daftarBooking .card > .toolbar{grid-template-columns:1fr}
  #daftarBooking .card > .toolbar .actions{grid-template-columns:repeat(6,minmax(0,1fr))}
}
@media(max-width:700px){
  #daftarBooking .card > .toolbar .actions{grid-template-columns:repeat(3,minmax(0,1fr))}
}
@media(max-width:420px){
  #daftarBooking .card > .toolbar .actions{grid-template-columns:repeat(2,minmax(0,1fr))}
}


/* Detail booking disembunyikan sampai nama pelanggan diklik */
#daftarBooking .booking-customer-toggle{display:inline-flex;align-items:center;gap:7px;padding:3px 7px;border:0;border-radius:6px;background:transparent;color:#f2d58a;font:inherit;font-weight:700;cursor:pointer;text-align:left}
#daftarBooking .booking-customer-toggle:hover{background:rgba(218,181,91,.12)}
#daftarBooking .booking-toggle-indicator{display:inline-flex;align-items:center;justify-content:center;width:19px;height:19px;border:1px solid rgba(218,181,91,.55);border-radius:50%;font-size:14px;line-height:1}


/* Tabel booking: kontainer rapi, kolom proporsional, isi "-" bila kosong */
#daftarBooking .tablewrap{width:100%;max-width:100%;overflow:auto;border-radius:10px}
#daftarBooking #bookRows{font-size:12px}
#daftarBooking .tablewrap table{width:100%;table-layout:auto;border-collapse:separate;border-spacing:0}
#daftarBooking .tablewrap th,#daftarBooking .tablewrap td{padding:9px 8px;vertical-align:middle;line-height:1.4;overflow-wrap:anywhere}
#daftarBooking .tablewrap th{white-space:normal;font-size:11px}
#daftarBooking #bookRows td{min-width:58px}
#daftarBooking #bookRows td:nth-child(1){min-width:28px;width:34px}
#daftarBooking #bookRows td:nth-child(2){min-width:110px}
#daftarBooking #bookRows td:nth-child(3){min-width:125px}
#daftarBooking #bookRows td:nth-child(4),#daftarBooking #bookRows td:nth-child(5){min-width:76px}
#daftarBooking #bookRows td:nth-child(6){min-width:48px}
#daftarBooking #bookRows td:last-child{min-width:120px}
#daftarBooking #bookRows .actions{display:flex;flex-wrap:wrap;gap:4px}
#daftarBooking #bookRows .btn.small{padding:5px 7px;font-size:10px}


/* Tipografi dan lebar kolom daftar booking: teks dibungkus per kata */
#daftarBooking .tablewrap{overflow-x:auto}
#daftarBooking .tablewrap table{width:100%;min-width:1180px;table-layout:fixed;border-collapse:collapse}
#daftarBooking .tablewrap th,
#daftarBooking .tablewrap td{
  box-sizing:border-box;
  padding:9px 7px;
  font-size:11px;
  line-height:1.35;
  vertical-align:middle;
  white-space:normal;
  word-break:normal;
  overflow-wrap:break-word;
  hyphens:auto;
}
#daftarBooking .tablewrap th{font-size:10px;line-height:1.3;text-align:left}
#daftarBooking #bookRows td{min-width:0}
#daftarBooking #bookRows td:nth-child(1){width:3%;text-align:center}
#daftarBooking #bookRows td:nth-child(2){width:11%;font-size:11px}
#daftarBooking #bookRows td:nth-child(3){width:12%}
#daftarBooking #bookRows td:nth-child(4),
#daftarBooking #bookRows td:nth-child(5){width:7%;white-space:nowrap}
#daftarBooking #bookRows td:nth-child(6){width:4%;text-align:center}
#daftarBooking #bookRows td:nth-child(7){width:8%}
#daftarBooking #bookRows td:nth-child(8){width:6%}
#daftarBooking #bookRows td:nth-child(9){width:7%}
#daftarBooking #bookRows td:nth-child(10){width:9%}
#daftarBooking #bookRows td:nth-child(11){width:7%}
#daftarBooking #bookRows td:nth-child(12){width:9%}
#daftarBooking #bookRows td:nth-child(13){width:7%}
#daftarBooking #bookRows td:nth-child(14){width:5%;text-align:center}
#daftarBooking #bookRows td:nth-child(15){width:8%}
#daftarBooking #bookRows td:nth-child(12) div,
#daftarBooking #bookRows td:nth-child(10) div,
#daftarBooking #bookRows td:nth-child(11) div,
#daftarBooking #bookRows td:nth-child(13) div{overflow-wrap:break-word;word-break:normal}
#daftarBooking #bookRows .actions{display:flex;flex-wrap:wrap;gap:3px}
#daftarBooking #bookRows .btn.small{font-size:10px;padding:5px 6px;white-space:nowrap}


/* Daftar Booking: header kolom dan checkbox hanya tampil saat grup pelanggan dibuka */
#daftarBooking .tablewrap table thead{display:none}
#daftarBooking .booking-customer-group td{
  display:flex;
  align-items:center;
  gap:9px;
  min-height:42px;
  text-align:right;
}
#daftarBooking .booking-customer-group label{
  display:none !important;
  margin-right:auto;
  flex:0 0 auto;
}
#daftarBooking .booking-customer-group.is-expanded label{
  display:inline-flex !important;
}
#daftarBooking .booking-customer-toggle{
  margin-left:auto;
  float:none !important;
  text-align:right;
  justify-content:flex-end;
  order:2;
}
#daftarBooking .booking-customer-group > td > span{
  margin-left:10px;
  float:none !important;
  order:3;
  white-space:nowrap;
  font-size:11px;
}
#daftarBooking .booking-customer-group label{order:1}
@media(max-width:650px){
  #daftarBooking .booking-customer-group td{gap:5px;padding:8px}
  #daftarBooking .booking-customer-toggle{font-size:11px}
  #daftarBooking .booking-customer-group > td > span{font-size:10px}
}


/* Nama pelanggan pada baris grup: satu baris, rata kanan, tanpa pecah kata */
#daftarBooking .booking-customer-group td{
  display:flex;
  flex-direction:row;
  align-items:center;
  justify-content:flex-end;
  flex-wrap:nowrap;
  gap:12px;
  min-height:42px;
  white-space:nowrap;
}
#daftarBooking .booking-customer-group label{
  margin:0 auto 0 0 !important;
  flex:0 0 auto;
  white-space:nowrap;
}
#daftarBooking .booking-customer-toggle{
  display:inline-flex;
  flex:0 1 auto;
  min-width:0;
  max-width:calc(100% - 170px);
  margin:0 !important;
  padding:4px 7px;
  white-space:nowrap;
  overflow:hidden;
  text-overflow:ellipsis;
  word-break:keep-all;
  overflow-wrap:normal;
  text-align:left;
  justify-content:flex-start;
}
#daftarBooking .booking-customer-toggle .booking-toggle-indicator{
  flex:0 0 19px;
}
#daftarBooking .booking-customer-group > td > span{
  flex:0 0 auto;
  margin:0 0 0 8px !important;
  white-space:nowrap;
}
@media(max-width:650px){
  #daftarBooking .booking-customer-group td{gap:6px;padding:8px}
  #daftarBooking .booking-customer-toggle{max-width:calc(100% - 125px);font-size:11px}
  #daftarBooking .booking-customer-group > td > span{font-size:10px}
}


/* Perbaikan baris grup pelanggan: jangan warisi lebar kolom checkbox tabel detail */
#daftarBooking #bookRows tr.booking-customer-group > td{
  display:flex !important;
  width:auto !important;
  min-width:0 !important;
  max-width:none !important;
  box-sizing:border-box;
  flex-direction:row;
  align-items:center;
  justify-content:flex-start;
  flex-wrap:nowrap;
  gap:10px;
  padding:9px 12px !important;
  text-align:left !important;
  white-space:nowrap;
}
#daftarBooking #bookRows tr.booking-customer-group .booking-customer-toggle{
  display:inline-flex !important;
  visibility:visible !important;
  opacity:1 !important;
  flex:0 1 auto;
  width:auto !important;
  max-width:calc(100% - 150px);
  min-width:0;
  margin:0 !important;
  color:#f2d58a !important;
  text-align:left !important;
  justify-content:flex-start !important;
  white-space:nowrap;
  overflow:hidden;
  text-overflow:ellipsis;
}
#daftarBooking #bookRows tr.booking-customer-group > td > span{
  display:inline-block;
  flex:0 0 auto;
  margin-left:auto !important;
  order:3;
  white-space:nowrap;
}
#daftarBooking #bookRows tr.booking-customer-group label{
  display:none !important;
  flex:0 0 auto;
  margin:0 !important;
}
#daftarBooking #bookRows tr.booking-customer-group.is-expanded label{
  display:inline-flex !important;
}


/* Nama pelanggan tampil utuh: sediakan ruang fleksibel dan jangan ellipsis */
#daftarBooking #bookRows tr.booking-customer-group > td{
  width:100% !important;
  min-width:0 !important;
  display:flex !important;
  flex-direction:row;
  align-items:center;
  justify-content:flex-start;
  flex-wrap:nowrap;
  gap:10px;
  box-sizing:border-box;
}
#daftarBooking #bookRows tr.booking-customer-group .booking-customer-toggle{
  flex:0 1 auto !important;
  width:auto !important;
  max-width:none !important;
  min-width:max-content;
  overflow:visible !important;
  text-overflow:clip !important;
  white-space:nowrap !important;
  word-break:normal !important;
  overflow-wrap:normal !important;
  padding:4px 7px;
}
#daftarBooking #bookRows tr.booking-customer-group .booking-customer-toggle .booking-toggle-indicator{
  flex:0 0 19px;
}
#daftarBooking #bookRows tr.booking-customer-group > td > span{
  margin-left:auto !important;
  flex:0 0 auto;
  white-space:nowrap;
}
#daftarBooking .tablewrap{overflow-x:auto}


#pembayaran #payForm > .row{display:flex;gap:8px;align-items:stretch}
#pembayaran #payForm > .row > button{min-height:36px;padding:8px 14px;font-size:12px}
#pembayaran #payForm > .row > button[type="submit"]{flex:1.4}
#pembayaran #payForm > .row > button[onclick="cancelPaymentEntry()"]{flex:.7}
#pembayaran #payForm > .row > button[onclick="printLatestPaymentForSelectedBooking()"]{flex:1.4}
@media(max-width:650px){
 #pembayaran #payForm > .row{flex-wrap:wrap}
 #pembayaran #payForm > .row > button{flex:1 1 30% !important}
}


/* Dashboard Ringkasan: kartu kecil dan tipografi setara ringkasan Daftar Booking */
#dashboard > .grid{
  grid-template-columns:repeat(4,minmax(0,1fr));
  gap:7px;
  margin:0 0 10px;
  align-items:stretch;
}
#dashboard > .grid .stat{
  min-width:0;
  min-height:62px;
  padding:8px 11px;
  display:flex;
  flex-direction:column;
  justify-content:center;
  gap:2px;
}
#dashboard > .grid .stat small{
  display:block;
  font-size:10px;
  line-height:1.2;
  white-space:normal;
}
#dashboard > .grid .stat strong{
  font-size:17px;
  line-height:1.2;
  margin-top:1px;
  overflow-wrap:anywhere;
}
@media(max-width:1000px){
  #dashboard > .grid{grid-template-columns:repeat(2,minmax(0,1fr));gap:6px}
  #dashboard > .grid .stat{min-height:56px;padding:7px 9px}
  #dashboard > .grid .stat strong{font-size:15px}
}
@media(max-width:520px){
  #dashboard > .grid{grid-template-columns:repeat(2,minmax(0,1fr));gap:5px}
  #dashboard > .grid .stat{min-height:50px;padding:6px 8px}
  #dashboard > .grid .stat small{font-size:9px}
  #dashboard > .grid .stat strong{font-size:14px}
}


/* Dashboard Ringkasan: compact cards sized closely to their text */
#dashboard > .grid{
  grid-template-columns:repeat(4,minmax(0,1fr));
  gap:5px;
  margin:0 0 8px;
  align-items:stretch;
}
#dashboard > .grid .stat{
  min-width:0;
  min-height:46px;
  padding:5px 8px;
  display:flex;
  flex-direction:column;
  justify-content:center;
  gap:1px;
  border-radius:10px;
}
#dashboard > .grid .stat small{
  display:block;
  font-size:8px;
  line-height:1.15;
  white-space:normal;
}
#dashboard > .grid .stat strong{
  font-size:14px;
  line-height:1.15;
  margin:0;
  overflow-wrap:anywhere;
}
@media(max-width:1000px){
  #dashboard > .grid{grid-template-columns:repeat(2,minmax(0,1fr));gap:5px}
  #dashboard > .grid .stat{min-height:43px;padding:5px 7px}
  #dashboard > .grid .stat strong{font-size:13px}
}
@media(max-width:520px){
  #dashboard > .grid{grid-template-columns:repeat(2,minmax(0,1fr));gap:4px}
  #dashboard > .grid .stat{min-height:40px;padding:4px 6px}
  #dashboard > .grid .stat small{font-size:8px}
  #dashboard > .grid .stat strong{font-size:12px}
}


/* Besarkan teks ringkasan tanpa mengubah dimensi kartu mini */
#dashboard > .grid .stat{
  min-height:46px !important;
  height:46px !important;
  padding:5px 8px !important;
  gap:1px !important;
}
#dashboard > .grid .stat small{
  font-size:10px !important;
  line-height:1.15 !important;
}
#dashboard > .grid .stat strong{
  font-size:16px !important;
  line-height:1.15 !important;
  margin:0 !important;
}
@media(max-width:1000px){
  #dashboard > .grid .stat{min-height:43px !important;height:43px !important;padding:5px 7px !important}
  #dashboard > .grid .stat small{font-size:9px !important}
  #dashboard > .grid .stat strong{font-size:15px !important}
}
@media(max-width:520px){
  #dashboard > .grid .stat{min-height:40px !important;height:40px !important;padding:4px 6px !important}
  #dashboard > .grid .stat small{font-size:9px !important}
  #dashboard > .grid .stat strong{font-size:13px !important}
}


/* Kartu Total Pelanggan dapat diklik untuk membuka tindakan cepat */
#dashboard .dashboard-customer-card{cursor:pointer;transition:border-color .15s,transform .15s}
#dashboard .dashboard-customer-card:hover{border-color:var(--gold);transform:translateY(-1px)}
#dashboard .dashboard-customer-card:focus-visible{outline:2px solid var(--gold);outline-offset:2px}
#customerQuickActions .btn{min-height:32px}


/* Semua kartu statistik dashboard membuka menu terkait */
#dashboard .dashboard-nav-card,
#dashboard .dashboard-customer-card{cursor:pointer;transition:border-color .15s,transform .15s}
#dashboard .dashboard-nav-card:hover,
#dashboard .dashboard-customer-card:hover{border-color:var(--gold);transform:translateY(-1px)}
#dashboard .dashboard-nav-card:focus-visible,
#dashboard .dashboard-customer-card:focus-visible{outline:2px solid var(--gold);outline-offset:2px}


/* Kartu Total Booking memberi petunjuk tambah booking saat diarahkan */
#dashboard .dashboard-booking-card{position:relative}
#dashboard .dashboard-booking-card:hover::after{
  content:"Klik untuk melakukan Booking";
  position:absolute;
  top:-29px;
  left:50%;
  transform:translateX(-50%);
  z-index:20;
  padding:5px 9px;
  border:1px solid var(--gold);
  border-radius:6px;
  background:#172338;
  color:var(--gold);
  font-size:11px;
  font-weight:700;
  white-space:nowrap;
  pointer-events:none;
}


/* Tabel Daftar Armada Tersedia dibuat lebih rapat dan tidak merenggang memenuhi kontainer */
.available-fleet-wrap{overflow-x:auto}
#availableFleetTable{
  width:auto !important;
  min-width:0 !important;
  max-width:100%;
  table-layout:auto;
}
#availableFleetTable th,
#availableFleetTable td{
  padding:8px 12px !important;
  white-space:nowrap;
}
#availableFleetTable th:nth-child(1),
#availableFleetTable td:nth-child(1){min-width:210px}
#availableFleetTable th:nth-child(2),
#availableFleetTable td:nth-child(2){min-width:115px}
#availableFleetTable th:nth-child(3),
#availableFleetTable td:nth-child(3){min-width:145px}
#availableFleetTable th:nth-child(4),
#availableFleetTable td:nth-child(4){min-width:95px}


/* Ringkasan: lebar kartu mengikuti isi, dengan jarak lebih rapat */
#dashboard > .grid{
  display:grid;
  grid-template-columns:repeat(4,max-content);
  width:max-content;
  max-width:100%;
  gap:6px;
  margin:0 0 8px;
  align-items:stretch;
}
#dashboard > .grid .stat{
  width:max-content;
  min-width:142px;
  max-width:190px;
  min-height:46px !important;
  height:46px !important;
  box-sizing:border-box;
  padding:5px 9px !important;
  gap:1px !important;
}
#dashboard > .grid .stat small{
  white-space:nowrap !important;
  font-size:10px !important;
  line-height:1.15 !important;
}
#dashboard > .grid .stat strong{
  white-space:nowrap;
  font-size:16px !important;
  line-height:1.15 !important;
  margin:0 !important;
  overflow-wrap:normal !important;
}
@media(max-width:1000px){
  #dashboard > .grid{
    width:100%;
    grid-template-columns:repeat(2,minmax(0,max-content));
    gap:5px;
  }
  #dashboard > .grid .stat{min-width:140px;max-width:100%}
}
@media(max-width:520px){
  #dashboard > .grid{
    width:100%;
    grid-template-columns:repeat(2,minmax(0,1fr));
    gap:5px;
  }
  #dashboard > .grid .stat{
    width:100%;
    min-width:0;
    max-width:none;
    height:40px !important;
    min-height:40px !important;
    padding:4px 7px !important;
  }
  #dashboard > .grid .stat small{font-size:9px !important}
  #dashboard > .grid .stat strong{font-size:13px !important}
}


/* Dashboard: tanggal di bawah judul, dan lebar kontainer mengikuti tabel */
#dashboard .dashboard-fleet-card,
#dashboard .dashboard-flow-card{
  width:max-content;
  max-width:100%;
  box-sizing:border-box;
}
#dashboard .dashboard-fleet-card{
  padding:14px 16px;
}
#dashboard .availability-date-field{
  width:160px;
  max-width:100%;
  margin:0 0 8px;
}
#dashboard .availability-date-field label{
  font-size:11px;
  margin-bottom:4px;
}
#dashboard .availability-date-field input{
  width:100%;
}
#dashboard .dashboard-fleet-card .available-fleet-wrap{
  width:max-content;
  max-width:100%;
}
#dashboard #availableFleetTable{
  width:max-content !important;
  max-width:100%;
}
#dashboard .dashboard-flow-card{
  padding:12px 16px;
  font-size:12px;
}
#dashboard .dashboard-flow-card h3{
  font-size:14px;
  margin:0 0 8px;
}
#dashboard .dashboard-flow-card .flow-copy,
#dashboard .dashboard-flow-card .flow-notice{
  font-size:11px;
  line-height:1.45;
}
#dashboard .dashboard-flow-card .flow-notice{
  padding:8px 10px;
  margin-top:8px;
}
@media(max-width:700px){
  #dashboard .dashboard-fleet-card,
  #dashboard .dashboard-flow-card{width:100%}
  #dashboard .dashboard-fleet-card .available-fleet-wrap{width:100%}
}


/* Navigasi ringkas: tombol Home dan dropdown master data */
nav{align-items:flex-start;gap:7px}
nav .home-nav-button{
  width:42px;height:38px;padding:0;display:inline-flex;align-items:center;justify-content:center;
}
nav .home-nav-button svg{display:block}
nav .nav-dropdown{position:relative;display:inline-block}
nav .nav-dropdown summary{
  list-style:none;cursor:pointer;border:1px solid var(--line);
  background:var(--panel2);color:var(--text);padding:10px 14px;
  border-radius:9px;font-weight:600;white-space:nowrap;height:38px;
  box-sizing:border-box;display:flex;align-items:center;
}
nav .nav-dropdown summary::-webkit-details-marker{display:none}
nav .nav-dropdown[open] summary{border-color:var(--gold);color:var(--gold)}
nav .nav-dropdown-menu{
  position:absolute;top:calc(100% + 6px);left:0;z-index:100;
  min-width:190px;padding:6px;display:flex;flex-direction:column;gap:5px;
  background:var(--panel);border:1px solid var(--line);border-radius:10px;
  box-shadow:0 10px 28px #0006;
}
nav .nav-dropdown-menu button{width:100%;text-align:left;white-space:nowrap}
nav .nav-dropdown-menu button.active{background:var(--gold);border-color:var(--gold);color:#151515}


/* Dashboard side-by-side availability and monthly fleet schedule */
#dashboard .dashboard-fleet-layout{
 display:grid;grid-template-columns:minmax(280px,max-content) minmax(480px,1fr);
 gap:12px;align-items:start;width:100%;max-width:100%;
}
#dashboard .dashboard-fleet-layout>.card{margin-top:14px;min-width:0}
#dashboard .dashboard-fleet-card{width:max-content;max-width:100%}
#dashboard .dashboard-timeline-card{overflow:hidden}
#dashboard .timeline-head{display:flex;align-items:flex-end;justify-content:space-between;gap:10px;flex-wrap:wrap;margin-bottom:8px}
#dashboard .timeline-month-field{width:150px;margin:0}
#dashboard .timeline-month-field label{font-size:11px}
#dashboard .timeline-summary{font-size:11px;margin-bottom:8px}
#dashboard .timeline-table-wrap{max-width:100%;overflow:auto}
#dashboard .fleet-timeline-table{border-collapse:separate;border-spacing:0;min-width:650px;width:100%;font-size:10px}
#dashboard .fleet-timeline-table th,#dashboard .fleet-timeline-table td{padding:5px 3px;text-align:center;white-space:nowrap}
#dashboard .fleet-timeline-table .timeline-car-col{position:sticky;left:0;z-index:2;background:var(--panel);text-align:left;min-width:185px;max-width:185px}
#dashboard .fleet-timeline-table .timeline-day{min-width:19px;font-size:9px;color:var(--muted)}
#dashboard .timeline-track-cell{padding:6px 4px!important}
#dashboard .fleet-timeline-track{height:24px;position:relative;background:var(--panel2);border-radius:5px;min-width:100%}
#dashboard .fleet-timeline-bar{position:absolute;top:3px;height:18px;border-radius:4px;background:var(--gold);color:#171717;font-size:9px;font-weight:700;line-height:18px;overflow:hidden;padding:0 3px;box-sizing:border-box;white-space:nowrap;text-align:left}
#dashboard .timeline-car-col strong{font-size:9px;font-weight:400}#dashboard .timeline-car-col small{display:block;color:var(--muted);font-size:9px}#dashboard .timeline-car-meta{display:flex;align-items:center;gap:7px;white-space:nowrap}#dashboard .timeline-car-owner{font-size:9px;color:var(--gold);font-weight:600;overflow:hidden;text-overflow:ellipsis;max-width:100px}
@media(max-width:900px){
 #dashboard .dashboard-fleet-layout{grid-template-columns:1fr}
 #dashboard .dashboard-fleet-card{width:100%}
}


/* Dashboard: rapatkan kolom rincian pembayaran bulanan */
#dashboardIncomeDetails .tablewrap{overflow-x:auto}
#dashboardIncomeDetails table{width:auto;min-width:0;table-layout:auto}
#dashboardIncomeDetails th,#dashboardIncomeDetails td{padding:9px 12px;white-space:nowrap}
#dashboardIncomeDetails th:nth-child(1),#dashboardIncomeDetails td:nth-child(1){min-width:150px}
#dashboardIncomeDetails th:nth-child(2),#dashboardIncomeDetails td:nth-child(2){min-width:170px}
#dashboardIncomeDetails th:nth-child(3),#dashboardIncomeDetails td:nth-child(3){min-width:110px}
#dashboardIncomeDetails th:nth-child(4),#dashboardIncomeDetails td:nth-child(4){min-width:150px}


/* Kontainer rincian pembayaran mengikuti lebar tabel, bukan memenuhi baris */
#dashboardIncomeDetails{
  display:table;
  width:max-content;
  max-width:100%;
  box-sizing:border-box;
}
#dashboardIncomeDetails .tablewrap{
  display:inline-block;
  width:max-content;
  max-width:100%;
  box-sizing:border-box;
}
#dashboardIncomeDetails table{
  width:max-content;
  max-width:100%;
  min-width:0;
}
@media(max-width:700px){
  #dashboardIncomeDetails{display:block;width:100%}
  #dashboardIncomeDetails .tablewrap{display:block;width:100%;overflow-x:auto}
  #dashboardIncomeDetails table{width:max-content;max-width:none}
}


/* Peringatan tunggakan: ringkas, dikelompokkan per pelanggan, dropdown */
#dashboardOverdueWarnings{display:table;width:max-content;max-width:100%;box-sizing:border-box;padding:12px}
#dashboardOverdueWarnings .dashboard-overdue-groups{display:flex;flex-direction:column;gap:6px;width:max-content;max-width:100%}
#dashboardOverdueWarnings .dashboard-overdue-customer{border:1px solid var(--border);border-radius:8px;overflow:hidden;width:max-content;max-width:100%;background:rgba(255,255,255,.02)}
#dashboardOverdueWarnings .dashboard-overdue-customer summary{display:flex;align-items:center;gap:18px;justify-content:space-between;cursor:pointer;list-style:none;padding:9px 11px;font-size:12px}
#dashboardOverdueWarnings .dashboard-overdue-customer summary::-webkit-details-marker{display:none}
#dashboardOverdueWarnings .dashboard-overdue-customer summary:after{content:"▾";color:var(--muted);margin-left:8px}
#dashboardOverdueWarnings .dashboard-overdue-customer[open] summary:after{content:"▴"}
#dashboardOverdueWarnings .dashboard-overdue-customer-name{font-weight:700}
#dashboardOverdueWarnings .dashboard-overdue-customer-meta{font-size:11px;color:var(--muted);white-space:nowrap}
#dashboardOverdueWarnings .dashboard-overdue-table-wrap{max-width:100%;overflow-x:auto;border-top:1px solid var(--border)}
#dashboardOverdueWarnings .dashboard-overdue-table{width:max-content;min-width:0;table-layout:auto;font-size:11px}
#dashboardOverdueWarnings .dashboard-overdue-table th,#dashboardOverdueWarnings .dashboard-overdue-table td{padding:7px 10px;white-space:nowrap}
#dashboardOverdueWarnings .dashboard-overdue-table th:nth-child(1){min-width:95px}
#dashboardOverdueWarnings .dashboard-overdue-table th:nth-child(2){min-width:105px}
#dashboardOverdueWarnings .dashboard-overdue-table th:nth-child(3){min-width:75px}
#dashboardOverdueWarnings .dashboard-overdue-table th:nth-child(4){min-width:115px}
@media(max-width:700px){
 #dashboardOverdueWarnings{display:block;width:100%}
 #dashboardOverdueWarnings .dashboard-overdue-groups,#dashboardOverdueWarnings .dashboard-overdue-customer{width:100%}
 #dashboardOverdueWarnings .dashboard-overdue-customer summary{gap:8px;flex-wrap:wrap}
 #dashboardOverdueWarnings .dashboard-overdue-table-wrap{max-width:100%;overflow-x:auto}
}


/* Dropdown utama peringatan tunggakan */
#dashboardOverdueWarnings{display:block;width:max-content;max-width:100%;box-sizing:border-box;padding:0}
#dashboardOverdueWarnings .dashboard-overdue-main-dropdown>summary{display:flex;align-items:center;gap:14px;cursor:pointer;list-style:none;padding:12px 14px}
#dashboardOverdueWarnings .dashboard-overdue-main-dropdown>summary::-webkit-details-marker{display:none}
#dashboardOverdueWarnings .dashboard-overdue-main-title{font-size:13px;font-weight:700;color:#fbbf24}
#dashboardOverdueWarnings #dashboardOverdueCount{font-size:12px;white-space:nowrap}
#dashboardOverdueWarnings .dashboard-overdue-main-chevron{font-size:13px;color:var(--muted);margin-left:auto}
#dashboardOverdueWarnings .dashboard-overdue-main-dropdown[open] .dashboard-overdue-main-chevron{transform:rotate(180deg)}
#dashboardOverdueWarnings .dashboard-overdue-main-content{padding:0 12px 12px;border-top:1px solid rgba(180,83,9,.35)}
@media(max-width:700px){
 #dashboardOverdueWarnings{width:100%}
 #dashboardOverdueWarnings .dashboard-overdue-main-dropdown>summary{gap:8px;flex-wrap:wrap}
}


/* Efek berkedip pada tombol peringatan tunggakan di Dashboard */
@keyframes overdueWarningTextBlink {
  0%, 100% { opacity: 1; }
  50% { opacity: .12; }
}
#dashboardOverdueWarnings:not(.hidden) .dashboard-overdue-main-title {
  animation: overdueWarningTextBlink .7s steps(2, end) infinite;
}
@media (prefers-reduced-motion: reduce) {
  #dashboardOverdueWarnings:not(.hidden) .dashboard-overdue-main-dropdown > summary {
    animation: none;
  }
}

/* Dashboard: kartu ringkas mengikuti lebar konten teks */
#dashboard .grid{display:flex;flex-wrap:wrap;gap:8px;align-items:stretch}
#dashboard .grid>.stat,
#dashboard .timeline-stats-row>.stat,
#dashboard .availability-stats-row>.stat{
  flex:0 1 auto;width:max-content;max-width:100%;min-width:0;
  padding:8px 11px;gap:3px;
}
#dashboard .stat small{font-size:11px;line-height:1.25;white-space:nowrap}
#dashboard .stat strong{font-size:16px;line-height:1.25;white-space:nowrap}
#dashboard .timeline-stats-row,#dashboard .availability-stats-row{align-items:flex-start;gap:7px}
#dashboard .timeline-stats-row .stat,#dashboard .availability-stats-row .stat{flex:0 1 auto}
#dashboard .dashboard-booking-stat{
  display:flex;align-items:center;gap:10px;cursor:default!important;
  width:max-content;max-width:100%;
}
#dashboard .dashboard-booking-stat:hover{transform:none!important;border-color:var(--line)!important}
#dashboard .dashboard-booking-stat .dashboard-booking-stat-main{display:flex;flex-direction:column;gap:3px}
#dashboard .dashboard-booking-stat .dashboard-booking-add{
  width:27px;height:27px;min-height:27px;padding:0;border-radius:50%;
  font-size:19px;line-height:1;flex:0 0 27px;
}
#dashboard .dashboard-overdue-main-dropdown>summary{display:flex;align-items:center;gap:10px;flex-wrap:wrap}
#dashboard .dashboard-overdue-total{font-size:12px;color:#fbbf24;white-space:nowrap}
@media(max-width:700px){
  #dashboard .grid>.stat,#dashboard .timeline-stats-row>.stat,#dashboard .availability-stats-row>.stat{padding:7px 9px}
  #dashboard .stat strong{font-size:15px}
}

/* Navigasi utama berupa toolbar kartu vertikal di sisi kanan */
#rightToolbar{
 position:fixed;left:16px;right:auto;top:50%;transform:translateY(-50%);
 z-index:1000;display:flex;flex-direction:column;gap:9px;
 width:142px;padding:10px;border:1px solid var(--line);
 border-radius:14px;background:rgba(17,29,48,.97);
 box-shadow:0 12px 32px rgba(0,0,0,.28);
}
#rightToolbar .toolbar-card{
 display:flex;flex-direction:column;align-items:center;justify-content:center;
 gap:5px;min-height:68px;width:100%;padding:9px 6px;
 border:1px solid var(--line);border-radius:10px;background:var(--panel);
 color:var(--text);font-size:11px;font-weight:700;cursor:pointer;
}
#rightToolbar .toolbar-card:hover,#rightToolbar .toolbar-card.active{
 border-color:var(--gold);background:#24334b;color:var(--gold)
}
#rightToolbar .toolbar-icon{font-size:22px;line-height:1;color:var(--gold)}
main{padding-left:178px!important;padding-right:14px!important}
#dashboard .top-fleet-stats-row{display:inline-flex;vertical-align:top;margin:0}
#dashboard .top-fleet-stats-row .stat{min-width:0!important;width:max-content}
@media(max-width:760px){
 #rightToolbar{left:6px;right:auto;top:auto;bottom:8px;transform:none;width:auto;flex-direction:row;padding:5px;gap:4px}
 #rightToolbar .toolbar-card{min-width:54px;min-height:50px;padding:5px;font-size:9px}
 #rightToolbar .toolbar-icon{font-size:17px}
 main{padding-left:14px!important;padding-right:14px!important;padding-bottom:78px!important}
}

#dashboard .timeline-car-name{display:inline-block;cursor:pointer;text-decoration:underline;text-decoration-style:dotted;text-underline-offset:3px}
#dashboard .timeline-car-name.is-busy-today{color:#ff6262!important}
#dashboard .timeline-car-name.is-free-today{color:#39d98a!important}
#dashboard .fleet-return-warning{margin:8px 0 10px;border:1px solid #9b6b23;border-radius:8px;background:rgba(155,107,35,.10);font-size:11px}
#dashboard .fleet-return-warning>summary{display:flex;align-items:center;gap:12px;padding:8px 10px;cursor:pointer;color:#f0c36a}
#dashboard .fleet-return-warning>summary strong{color:#ffd166}
#dashboard .fleet-return-rows{padding:0 10px 10px;display:grid;gap:6px}
#dashboard .fleet-return-item{display:flex;align-items:center;gap:10px;flex-wrap:wrap;padding:7px;border-top:1px solid var(--line)}
#dashboard .fleet-return-item span{color:var(--muted)}
#dashboard .fleet-return-item .btn{margin-left:auto}
@media(max-width:760px){#dashboard .fleet-return-item .btn{margin-left:0}}

#rightToolbar{position:fixed}
#rightToolbar .toolbar-edit-menu{
 position:absolute;left:calc(100% + 10px);right:auto;top:78px;width:150px;
 display:flex;flex-direction:column;gap:5px;padding:8px;
 border:1px solid var(--line);border-radius:12px;background:rgba(17,29,48,.98);
 box-shadow:0 12px 32px rgba(0,0,0,.3)
}
#rightToolbar .toolbar-edit-menu.hidden{display:none}
#rightToolbar .toolbar-edit-menu button{
 width:100%;padding:9px 10px;text-align:left;border:1px solid var(--line);
 border-radius:8px;background:var(--panel);color:var(--text);font-size:11px
}
#rightToolbar .toolbar-edit-menu button:hover{border-color:var(--gold);color:var(--gold)}
@media(max-width:760px){
 #rightToolbar .toolbar-edit-menu{right:auto;left:0;top:auto;bottom:calc(100% + 8px)}
}

/* Dashboard compact split: fleet schedule left, expense activity right */
#dashboard .dashboard-fleet-layout{
 display:grid!important;
 grid-template-columns:minmax(0,1.22fr) minmax(245px,.78fr)!important;
 gap:10px!important;align-items:start!important;
}
#dashboard .dashboard-timeline-card,
#dashboard .dashboard-expense-timeline-card{
 min-width:0;padding:12px!important;margin-top:10px!important;
}
#dashboard .dashboard-timeline-card .timeline-stats-row{gap:6px;margin-bottom:7px}
#dashboard .dashboard-timeline-card .timeline-stats-row .stat{padding:6px 9px!important}
#dashboard .dashboard-timeline-card .timeline-head{gap:6px;margin-bottom:6px}
#dashboard .dashboard-timeline-card .timeline-head h3{font-size:14px}
#dashboard .dashboard-timeline-card .fleet-timeline-table{min-width:590px;font-size:9px}
#dashboard .dashboard-timeline-card .fleet-timeline-table .timeline-car-col{min-width:150px;max-width:150px}
#dashboard .dashboard-timeline-card .fleet-timeline-table th,
#dashboard .dashboard-timeline-card .fleet-timeline-table td{padding:4px 2px}
#dashboard .dashboard-timeline-card .fleet-timeline-track{height:21px}
#dashboard .dashboard-timeline-card .fleet-timeline-bar{top:2px;height:17px;line-height:17px;font-size:8px}
#dashboard .dashboard-expense-timeline-card{max-height:620px;overflow:hidden}
#dashboard .expense-timeline-head{display:flex;align-items:flex-start;justify-content:space-between;gap:8px;flex-wrap:wrap}
#dashboard .expense-timeline-head h3{font-size:14px}
#dashboard .expense-timeline-head .field{width:130px;margin:0}
#dashboard .expense-timeline-head label{font-size:10px}
#dashboard .expense-timeline-head input{font-size:11px;padding:6px}
#dashboard .expense-timeline-total{display:flex;justify-content:space-between;align-items:center;gap:8px;padding:9px 0;margin:7px 0;border-bottom:1px solid var(--line);font-size:11px}
#dashboard .expense-timeline-total strong{font-size:14px;color:var(--gold)}
#dashboard .expense-timeline-list{max-height:480px;overflow:auto;padding-right:3px}
#dashboard .expense-timeline-item{position:relative;display:flex;align-items:flex-start;gap:9px;padding:8px 0 8px 12px;border-left:1px solid var(--line)}
#dashboard .expense-timeline-dot{position:absolute;left:-4px;top:13px;width:7px;height:7px;border-radius:50%;background:var(--gold)}
#dashboard .expense-timeline-content{min-width:0;flex:1;font-size:10px}
#dashboard .expense-timeline-date{font-size:9px;color:var(--muted);margin-bottom:2px}
#dashboard .expense-timeline-content strong{display:block;font-size:11px}
#dashboard .expense-timeline-content .muted{font-size:10px;overflow-wrap:anywhere}
#dashboard .expense-timeline-amount{font-size:10px;white-space:nowrap;color:var(--gold)}
@media(max-width:900px){
 #dashboard .dashboard-fleet-layout{grid-template-columns:minmax(0,1fr)!important}
 #dashboard .dashboard-expense-timeline-card{max-height:none}
 #dashboard .expense-timeline-list{max-height:360px}
}

/* Menu Mitra: daftar booking dan database pembayaran berdampingan */
#mitra .partner-booking-payment-layout{
 display:grid;grid-template-columns:minmax(0,1.55fr) minmax(280px,.85fr);
 gap:12px;align-items:start;
}
#mitra .partner-booking-list-card,#mitra .partner-payment-database-card{min-width:0}
#mitra .partner-payment-database-card .tablewrap{max-height:620px;overflow:auto}
#mitra .partner-payment-database-card table{min-width:440px;font-size:11px}
#mitra .partner-payment-database-card th,
#mitra .partner-payment-database-card td{padding:7px 6px;white-space:normal}
@media(max-width:1050px){
 #mitra .partner-booking-payment-layout{grid-template-columns:minmax(0,1fr)}
 #mitra .partner-payment-database-card .tablewrap{max-height:420px}
}

/* Penyempurnaan tipografi menu Mitra: ringkas, rapi, tetap terbaca */
#mitra{font-size:12px;line-height:1.45}
#mitra h2{font-size:18px;line-height:1.3;margin-bottom:10px}
#mitra h3{font-size:13px;line-height:1.35;margin:0 0 8px}
#mitra p.muted{font-size:10.5px;line-height:1.5;margin:5px 0 10px}
#mitra .card{padding:12px}
#mitra .field label{font-size:10px;margin-bottom:4px}
#mitra input,#mitra select,#mitra textarea{font-size:11px;padding:7px 9px;min-height:32px}
#mitra .btn{font-size:10.5px;padding:6px 9px;min-height:28px}
#mitra .tablewrap{width:100%;overflow:auto;border-radius:8px}
#mitra table{width:100%;border-collapse:collapse;font-size:10.5px;line-height:1.4}
#mitra th{font-size:10px;font-weight:700;letter-spacing:.1px;padding:8px 7px;white-space:normal}
#mitra td{font-size:10.5px;padding:7px;vertical-align:middle;white-space:normal;overflow-wrap:anywhere}
#mitra .partner-booking-payment-layout{gap:10px}
#mitra .partner-booking-list-card,#mitra .partner-payment-database-card{padding:11px;min-width:0}
#mitra .partner-booking-list-card .tablewrap table{min-width:690px}
#mitra .partner-payment-database-card .tablewrap table{min-width:390px}
#mitra .partner-booking-list-card td:nth-child(2),
#mitra .partner-booking-list-card td:nth-child(3){white-space:nowrap}
#mitra .partner-booking-list-card td button{font-size:9.5px;padding:4px 7px;min-height:24px}
#mitra .partner-payment-database-card .tablewrap{max-height:520px;overflow:auto}
#mitra .partner-booking-list-card tfoot th{font-size:10.5px;padding:8px}
#mitra .partner-booking-list-card tr td[colspan]{line-height:1.55;padding:8px}
#mitra .partner-booking-list-card tr td[colspan] .btn{margin-left:6px}
@media(max-width:1050px){
 #mitra .partner-booking-payment-layout{grid-template-columns:minmax(0,1fr)}
 #mitra .partner-booking-list-card .tablewrap table{min-width:650px}
 #mitra .partner-payment-database-card .tablewrap table{min-width:390px}
}

</style></head>
<body class="auth-required">
<div id="authScreen" style="position:fixed;inset:0;z-index:1000;background:#0b1220;display:flex;align-items:center;justify-content:center;padding:18px">
  <div class="card" style="width:min(440px,100%);padding:24px">
    <div style="text-align:center;margin-bottom:16px">
      <img src="/icons/alfa_prima_logo.png" alt="Logo Alfa Prima Rent Car" style="height:56px;width:auto;max-width:180px;object-fit:contain;margin-bottom:8px;filter:drop-shadow(0 2px 5px rgba(0,0,0,0.4))">
      <div class="brand" style="margin-bottom:4px">ALFA <span>PRIMA</span> RENT CAR</div>
      <div class="muted">Login aman • Database Laravel &amp; MySQL</div>
    </div>
    <div id="authContent">
      <h3 style="margin-top:0;margin-bottom:14px;font-size:1.05rem;color:#e2e8f0">Masuk ke Aplikasi</h3>
      <form id="authForm">
        <div class="field"><label>Username</label><input id="authUser" required autocomplete="username" placeholder="Masukkan username"></div>
        <div class="field" style="margin-top:12px"><label>Password</label><input id="authPass" type="password" required autocomplete="current-password" placeholder="Masukkan password"></div>
        <button class="btn primary" style="width:100%;margin-top:18px" type="submit">Login</button>
      </form>
    </div>
  </div>
</div>
<header><div class="header-brand-wrap"><img src="/icons/alfa_prima_logo.png" alt="Logo Alfa Prima Rent Car" class="header-logo"><div><div class="brand">ALFA <span>PRIMA</span> RENT CAR</div><div class="sub">Sistem Informasi Rental Mobil • Database MySQL • HP &amp; Komputer</div></div></div><div style="display:flex;align-items:center;gap:10px"><div class="sub" id="syncStatus">Menghubungkan ke database MySQL…</div><button class="btn primary no-print" id="installPwaBtn" style="display:none;padding:7px 12px" title="Pasang ke Layar Utama HP">📲 Pasang Aplikasi</button><button class="btn no-print" id="logoutBtn" style="padding:7px 10px">Keluar</button></div></header>
<main>
<aside id="rightToolbar" class="no-print" aria-label="Navigasi utama">
  <button class="toolbar-card active" data-tab="dashboard" title="Home"><span class="toolbar-icon">⌂</span><span>Home</span></button>
  <button class="toolbar-card" data-tab="editMenu" aria-expanded="false" onclick="toggleToolbarEditMenu()"><span class="toolbar-icon">＋</span><span>Tambah &amp; Edit</span></button>
  <div id="toolbarEditMenu" class="toolbar-edit-menu hidden">
    <button data-tab="pelanggan">Pelanggan</button><button data-tab="mitra">Mitra</button>
    <button data-tab="armada">Armada</button><button data-tab="driver">Driver</button>
    <button data-tab="pembayaran">Pembayaran</button><button data-tab="pengeluaran">Pengeluaran</button>
    <button data-tab="pengguna" id="toolbarUsersNav" class="hidden">Pengguna</button>
  </div>
  <button class="toolbar-card" data-tab="daftarBooking" onclick="openDashboardMenu('daftarBooking')"><span class="toolbar-icon">▤</span><span>Rekap</span></button>
  <button class="toolbar-card" data-tab="laporan" onclick="openDashboardMenu('laporan')"><span class="toolbar-icon">▥</span><span>Laporan</span></button>
  <button class="toolbar-card" data-tab="changelog" onclick="openDashboardMenu('changelog')"><span class="toolbar-icon">◷</span><span>Riwayat Perubahan</span></button>
</aside>
<section id="dashboard">
<div class="grid"><div class="stat dashboard-nav-card dashboard-income-card" role="button" tabindex="0" aria-label="Tampilkan rincian pemasukan bulan berjalan" title="Klik untuk melihat rincian pembayaran bulan ini" onclick="toggleDashboardIncomeDetails()" onkeydown="if(event.key==='Enter'||event.key===' '){event.preventDefault();toggleDashboardIncomeDetails()}"><small id="sPayLabel">Pemasukan Bulan</small><strong id="sPay">Rp0</strong></div><div class="stat dashboard-nav-card" role="button" tabindex="0" aria-label="Buka menu Armada" title="Klik untuk membuka menu Armada" onclick="openDashboardMenu('armada')" onkeydown="if(event.key==='Enter'||event.key===' '){event.preventDefault();openDashboardMenu('armada')}"><small>Total Armada</small><strong id="sCar">0</strong></div></div>
<div id="dashboardOverdueWarnings" class="card hidden dashboard-overdue-warning-card" style="margin:0 0 10px;border:1px solid #b45309;background:rgba(180,83,9,.10)">
  <details class="dashboard-overdue-main-dropdown">
    <summary>
      <span class="dashboard-overdue-main-title">⚠ Peringatan Tagihan Belum Lunas</span>
      <strong id="dashboardOverdueCount"></strong>
      <strong id="dashboardOverdueTotal" class="dashboard-overdue-total">Total: Rp0</strong>
      <span class="dashboard-overdue-main-chevron">▾</span>
    </summary>
    <div class="dashboard-overdue-main-content">
      <div class="muted" style="font-size:11px;margin-bottom:8px">Booking yang belum lunas lebih dari 5 hari setelah tanggal selesai sewa. Data dikelompokkan berdasarkan pelanggan.</div>
      <div id="dashboardOverdueGroups" class="dashboard-overdue-groups"></div>
    </div>
  </details>
</div>
<div id="dashboardIncomeDetails" class="card hidden" style="margin:0 0 10px">
  <div class="toolbar"><h3 id="dashboardIncomeTitle">Daftar Pembayaran Bulan Ini</h3><strong id="dashboardIncomeTotal">Total: Rp0</strong></div>
  <div class="tablewrap"><table><thead><tr><th>Tanggal Pembayaran</th><th>Nama Pelanggan</th><th>ID Booking</th><th>Nominal Pembayaran</th></tr></thead><tbody id="dashboardIncomeRows"></tbody></table></div>
</div>
<div id="customerQuickActions" class="card no-print hidden" style="margin:0 0 10px;padding:10px 12px">
  <div style="font-size:11px;font-weight:700;margin-bottom:8px;color:var(--muted)">PILIHAN PELANGGAN</div>
  <div class="row" style="gap:7px;flex-wrap:wrap">
    <button class="btn primary small" type="button" onclick="openCustomerMenu('add')">Tambah Pelanggan</button>
    <button class="btn small" type="button" onclick="openCustomerMenu('edit')">Edit Pelanggan</button>
  </div>
</div>
<div class="dashboard-fleet-layout">
<div class="card dashboard-timeline-card" style="margin-top:14px">
  <div class="timeline-stats-row">
    <div class="stat dashboard-booking-card dashboard-booking-stat"><div class="dashboard-booking-stat-main"><small>Total Booking</small><strong id="sBook">0</strong></div><button class="btn primary small dashboard-booking-add" type="button" aria-label="Tambah booking" title="Tambah booking" onclick="openDashboardMenu('booking');toggleBookingFormContainer(true);document.getElementById('bookingFormContainer')?.scrollIntoView({behavior:'smooth',block:'start'})">＋</button></div>
    <div class="stat dashboard-customer-card" role="button" tabindex="0" aria-label="Buka pilihan menu pelanggan" onclick="toggleCustomerQuickActions()" onkeydown="if(event.key==='Enter'||event.key===' '){event.preventDefault();toggleCustomerQuickActions()}"><small>Total Pelanggan</small><strong id="sCust">0</strong></div>
  </div>
  <div class="timeline-head"><h3 style="margin:0">Timeline Armada Terjadwal</h3><div class="field timeline-month-field"><label for="fleetTimelineMonth">Bulan</label><input id="fleetTimelineMonth" type="month" onchange="render()"></div></div>
  <details class="fleet-return-warning" id="fleetReturnWarning">
    <summary><span>⚠ Peringatan Armada Pulang</span><strong id="fleetReturnCount">0 booking</strong></summary>
    <div id="fleetReturnRows" class="fleet-return-rows"></div>
  </details>
  <div class="muted timeline-summary" id="fleetTimelineSummary"></div>
  <div class="tablewrap timeline-table-wrap"><table class="fleet-timeline-table"><thead id="fleetTimelineHead"></thead><tbody id="fleetTimelineRows"></tbody></table></div>
</div>
<div class="card dashboard-expense-timeline-card">
  <div class="expense-timeline-head">
    <div><h3 style="margin:0">Timeline Pengeluaran</h3><div class="muted" style="font-size:10px">Riwayat pengeluaran operasional</div></div>
    <div class="field"><label for="dashboardExpenseMonth">Bulan</label><input id="dashboardExpenseMonth" type="month" onchange="render()"></div>
  </div>
  <div class="expense-timeline-total"><span>Total Pengeluaran</span><strong id="dashboardExpenseTotal">Rp0</strong></div>
  <div id="dashboardExpenseTimeline" class="expense-timeline-list"></div>
</div>
</div>
</section>
<section id="pelanggan" class="hidden">
<div class="toolbar"><h2>Data Pelanggan</h2><input id="qCust" placeholder="Cari ID / nama / WA" style="max-width:260px"></div>
<div class="card no-print"><h3 id="custTitle">Tambah Pelanggan</h3><form id="custForm"><input type="hidden" id="custEdit"><div class="formgrid">
<div class="field"><label>Nama</label><input id="cNama" required></div><div class="field"><label>Alamat</label><input id="cAlamat"></div><div class="field"><label>No. WA</label><input id="cWa"></div><div class="field" id="nikField"><label>NIK</label><input id="cNik" inputmode="numeric"></div><div class="field" id="simField"><label>SIM A</label><input id="cSim"></div><div class="field"><label>Status Pelanggan</label><select id="cStatus"><option>Aktif</option><option>Nonaktif</option><option>Blacklist</option></select></div>
</div><div class="row" style="margin-top:12px"><button class="btn primary" type="submit">Simpan Pelanggan</button><button class="btn" type="button" onclick="resetCust()">Batal</button></div></form></div>
<div class="card" style="margin-top:14px"><div class="tablewrap"><table><thead><tr><th style="width:42px;text-align:center">No.</th><th>ID Pelanggan</th><th>Nama</th><th>Alamat</th><th>No. WA</th><th>NIK</th><th>SIM A</th><th>Status</th><th class="no-print">Aksi</th></tr></thead><tbody id="custRows"></tbody></table></div></div>
</section>
<section id="armada" class="hidden">
<div class="toolbar"><h2>Data Armada</h2></div>
<div class="card no-print"><h3 id="carTitle">Tambah Armada</h3><form id="carForm"><input type="hidden" id="carEdit"><div class="formgrid">
<div class="field"><label>Kepemilikan</label><select id="aOwnership"><option value="sendiri">Milik Sendiri</option><option value="mitra">Milik Mitra</option></select></div><div class="field"><label>Pemilik / Mitra</label><select id="aPartner"><option value="">Pilih mitra (jika milik mitra)</option></select></div><div class="field"><label>Merk Armada</label><input id="aMerk" required placeholder="Toyota"></div><div class="field"><label>Nama / Model Armada</label><input id="aJenis" required placeholder="Innova Reborn"></div><div class="field"><label>Klasifikasi Jenis Armada</label><select id="aVehicleClass"><option>City Car</option><option>LMPV</option><option>MPV</option><option>Minibus</option><option>Premium</option></select></div><div class="field"><label>No. Polisi Armada</label><input id="aPlat" required></div><div class="field"><label>Transmisi Armada</label><select id="aTrans"><option>Matic</option><option>Manual</option></select></div><div class="field"><label>Status Armada</label><select id="aStatus"><option>Tersedia</option><option>Disewa</option><option>Servis</option><option>Nonaktif</option></select></div>

<div class="field"><label>Bagian Mitra per Hari (Rp)</label><input id="aPartnerRate" type="number" min="0" value="0"></div>
</div><div class="row" style="margin-top:12px"><button class="btn primary" type="submit">Simpan Armada</button><button class="btn" type="button" onclick="resetCar()">Batal</button></div></form></div>
<div class="card no-print" style="margin-top:14px"><div class="field"><label for="qCar">Pencarian Armada</label><input id="qCar" placeholder="Cari ID, merk, jenis, klasifikasi, polisi, kepemilikan, mitra, status..."></div></div>
<div class="card" style="margin-top:14px"><div class="tablewrap"><table><thead><tr><th>ID Armada</th><th>Merk</th><th>Jenis / Klasifikasi</th><th>No. Polisi</th><th>Transmisi</th><th>Status</th><th>Bagian Mitra / Hari</th><th class="no-print">Aksi</th></tr></thead><tbody id="carRows"></tbody></table></div></div>
</section>
<section id="booking" class="hidden">
<h2 id="bookingFormToggle" role="button" tabindex="0" aria-expanded="false" onclick="toggleBookingFormContainer()" onkeydown="if(event.key==='Enter'||event.key===' '){event.preventDefault();toggleBookingFormContainer()}" style="cursor:pointer" title="Klik untuk menampilkan atau menyembunyikan formulir">Booking Sewa <span id="bookingFormChevron" style="font-size:12px;color:var(--gold)">＋</span></h2><div class="card no-print hidden" id="bookingFormContainer"><form id="bookForm"><input type="hidden" id="bookEdit"><div class="formgrid">
<div class="field"><label>Pelanggan</label><select id="bCust" required></select></div><div class="field"><label>Jumlah Unit Sewa</label><select id="bUnitCount"><option value="1">1 Unit</option><option value="2">2 Unit</option><option value="3">3 Unit</option><option value="4">4 Unit</option><option value="5">5 Unit</option><option value="6">6 Unit</option><option value="7">7 Unit</option><option value="8">8 Unit</option><option value="9">9 Unit</option><option value="10">10 Unit</option></select></div><div class="field"><label>Tanggal Awal Sewa</label><input type="date" id="bStart" required></div><div class="field"><label>Tanggal Akhir Sewa</label><input type="date" id="bEnd" required></div><div class="field"><label>Lama Sewa</label><input id="bDays" readonly placeholder="Otomatis"></div>
</div><div id="bookingUnits" class="formgrid" style="margin-top:14px"></div>
<div class="card" style="margin-top:12px;padding:12px"><div style="display:flex;justify-content:space-between;gap:12px;flex-wrap:wrap"><b>Subtotal Harian Seluruh Unit</b><b id="bDailySubtotal">Rp0</b></div><div style="display:flex;justify-content:space-between;gap:12px;flex-wrap:wrap;margin-top:8px"><b>Total Keseluruhan</b><b id="bGrandTotal">Rp0</b></div></div><div class="row" style="margin-top:12px"><button class="btn primary" type="submit" id="bookSubmitBtn">Simpan Booking</button><button class="btn" type="button" onclick="resetBookingForm()">Batal Edit</button><span class="muted" id="bookHint">Tanggal awal dan akhir dihitung sebagai hari sewa.</span></div></form></div>

</section>
<section id="daftarBooking" class="hidden">
<h2>Seluruh Daftar Booking</h2>
<div class="grid" style="margin-bottom:14px">
<div class="stat"><small>Total Booking</small><strong id="bookingPageCount">0</strong></div>
<div class="stat"><small>Total Pelanggan</small><strong id="bookingPageCustomers">0</strong></div>
<div class="stat"><small>Total Nilai Booking</small><strong id="bookingPageValue">Rp0</strong></div>
<div class="stat"><small>Total Belum Lunas</small><strong id="bookingPageOutstanding">Rp0</strong></div>
<div class="stat"><small>Total Lunas</small><strong id="bookingPagePaid">Rp0</strong></div>
</div>
<div class="card">
<div class="toolbar"><div><h3>Daftar Booking per ID Pelanggan</h3><div class="muted" style="font-size:12px">Informasi dan daftar booking mengikuti bulan dan tahun yang dipilih.</div></div><div class="actions no-print"><div class="field"><label for="bookingMonthFilter">Bulan</label><select id="bookingMonthFilter" onchange="render()"><option value="">Semua Bulan</option><option value="01">Januari</option><option value="02">Februari</option><option value="03">Maret</option><option value="04">April</option><option value="05">Mei</option><option value="06">Juni</option><option value="07">Juli</option><option value="08">Agustus</option><option value="09">September</option><option value="10">Oktober</option><option value="11">November</option><option value="12">Desember</option></select></div><div class="field"><label for="bookingYearFilter">Tahun</label><select id="bookingYearFilter" onchange="render()"><option value="">Semua Tahun</option></select></div><button id="paidBookingFilterBtn" class="btn" type="button" onclick="setBookingStatusFilter('paid')">Lunas</button><button id="unpaidBookingFilterBtn" class="btn" type="button" onclick="setBookingStatusFilter('unpaid')">Belum Lunas</button><button class="btn primary" type="button" onclick="printSelectedInvoices()">Cetak Invoice Terpilih</button><button class="btn" type="button" onclick="document.getElementById('qBook').value='';document.getElementById('bookingMonthFilter').value='';document.getElementById('bookingYearFilter').value='';bookingStatusFilter='all';render()">Tampilkan Semua</button></div><input id="qBook" placeholder="Cari nama pelanggan, ID pelanggan, ID booking, atau status lunas / belum" style="max-width:290px"></div>
<div class="tablewrap"><table><thead><tr><th class="no-print">Pilih</th><th>Pelanggan</th><th>Armada</th><th>Awal</th><th>Akhir</th><th>Hari</th><th>Harga/Hari</th><th>Driver</th><th>Tujuan</th><th>Biaya Driver &amp; Perjalanan</th><th>Biaya Lain-lain</th><th>Keterangan Biaya Lain-lain</th><th>Total</th><th>Status</th><th class="no-print">Aksi</th></tr></thead><tbody id="bookRows"></tbody></table></div>
<div class="toolbar" style="margin-top:12px"><strong id="bookingPageFoot" class="muted">0 booking ditampilkan</strong><button class="btn no-print" type="button" onclick="window.print()">Cetak Daftar Booking</button></div>
</div>
</section>

<section id="driver" class="hidden">
<h2>Database Driver</h2>
<div class="card no-print"><h3 id="driverTitle">Tambah Driver</h3><form id="driverForm"><input type="hidden" id="driverEdit"><div class="formgrid">
<div class="field"><label>Nama Driver</label><input id="dName" required></div>
<div class="field"><label>No. WhatsApp</label><input id="dWa"></div>
<div class="field"><label>Alamat</label><input id="dAddress"></div>
<div class="field"><label>No. SIM</label><input id="dLicense"></div>
<div class="field"><label>Status</label><select id="dStatus"><option>Aktif</option><option>Nonaktif</option></select></div>
</div><div class="row" style="margin-top:12px"><button class="btn primary" type="submit">Simpan Driver</button><button class="btn" type="button" onclick="resetDriver()">Batal</button></div></form></div>
<div class="card" style="margin-top:14px"><h3>Daftar Driver</h3><div class="tablewrap"><table><thead><tr><th>ID Driver</th><th>Nama</th><th>WhatsApp</th><th>Alamat</th><th>No. SIM</th><th>Status</th><th>Aksi</th></tr></thead><tbody id="driverRows"></tbody></table></div></div>
</section>
<section id="pembayaran" class="hidden">
<h2>Pencatatan Pembayaran</h2><div class="card no-print"><form id="payForm"><div class="formgrid">
<div class="field"><label>Pelanggan</label><select id="pCustomer" required><option value="">Pilih pelanggan yang belum lunas</option></select></div><div class="field"><label>Daftar ID Booking Belum Lunas</label><div id="pBookingList" class="notice">Pilih pelanggan untuk melihat daftar booking dan sisa tagihan.</div></div><div class="field"><label>Biaya Lain-lain (Rp)</label><input id="pOtherCost" type="number" min="0" step="1" value="0" placeholder="0"></div><div class="field"><label>ID Booking untuk Biaya Lain-lain</label><select id="pOtherCostBooking"><option value="">Pilih ID Booking</option></select></div><div class="field"><label>Keterangan Biaya Lain-lain</label><input id="pOtherCostNote" type="text" maxlength="250" placeholder="Masukkan keterangan biaya lain-lain"></div><div class="field" id="pEditingBookingField" hidden><label>ID Booking yang Diedit</label><input id="pBookingEditDisplay" readonly></div><div class="field"><label>Total Sisa Tagihan</label><input id="pBill" readonly></div><div class="field" hidden><label>Booking</label><select id="pBook"></select></div><div class="field" hidden><label>Pelanggan</label><input id="pCust" readonly></div><div class="field"><label>Total Pembayaran Diterima (Rp)</label><input id="pAmount" type="number" min="0" step="1" required></div><div class="field"><label>Tanggal Pembayaran</label><input id="pDate" type="date" required></div><div class="field"><label>Status Pembayaran</label><input id="pStatus" readonly></div><div class="field"><label>Sisa Tagihan</label><input id="pRemain" readonly></div></div><div class="row" style="margin-top:12px"><button class="btn primary" type="submit">Catat Pembayaran</button><button class="btn" type="button" onclick="cancelPaymentEntry()">Batal</button><button class="btn hidden" type="button" id="cancelPaymentEditBtn" onclick="cancelPaymentEdit()">Batal Edit</button><button class="btn" type="button" onclick="printLatestPaymentForSelectedBooking()">Cetak Nota</button></div></form></div>
<div class="card" style="margin-top:14px"><h3>Riwayat Pembayaran</h3><div class="field no-print" style="margin:10px 0 14px"><label for="qPaymentHistory">Search Riwayat Pembayaran</label><input id="qPaymentHistory" type="search" placeholder="Cari ID pelanggan, nama pelanggan, ID booking, ID pembayaran..." oninput="render()"></div><div class="tablewrap"><table><thead><tr><th>Pilih</th><th>ID Pelanggan</th><th>Nama Pelanggan</th><th>ID Booking</th><th>Total Pembayaran Seluruh Booking</th><th>Status</th><th>Rincian Pembayaran</th><th class="no-print">Aksi</th></tr></thead><tbody id="payRows"></tbody></table></div></div>
</section>
<section id="daftarTagihanDriver" class="hidden">
<h2>Daftar Tagihan Driver</h2>
<p class="muted">Rekap honor driver dari setiap booking. Nilai tagihan dihitung otomatis dari tarif driver per hari dikalikan lama sewa.</p>
<div class="card" style="margin:14px 0"><form id="driverPaymentForm" onsubmit="submitDriverPayment(event)">
<div class="formgrid">
<div class="field"><label>Driver</label><input id="dpDriver" readonly placeholder="Pilih driver dari Daftar Tagihan Driver"></div>
<div class="field"><label>Penugasan yang Dibayar</label><div id="dpAssignments" class="notice">Belum ada penugasan dipilih.</div></div>
<div class="field"><label>Total Tagihan Terpilih</label><input id="dpTotal" readonly></div>
<div class="field"><label>Sisa Tagihan</label><input id="dpRemaining" readonly></div>
<div class="field hidden" id="dpMealWrap"><label>Biaya Makan Driver</label><input id="dpMealCost" readonly></div>
<div class="field"><label>Jumlah Pembayaran (Rp)</label><input id="dpAmount" type="number" min="1" step="1" required></div>
<div class="field"><label>Tanggal Bayar</label><input id="dpDate" type="date" required></div>
<div class="field"><label>Keterangan</label><input id="dpNote" placeholder="Contoh: Transfer honor driver"></div>
</div><div class="row" style="margin-top:12px"><button class="btn primary" type="submit">Simpan Pembayaran Driver</button><button class="btn" type="button" onclick="resetDriverPaymentForm()">Batal</button></div>
</form></div>
<div class="card" style="margin-top:14px"><h3>Riwayat Pembayaran Driver</h3><div class="tablewrap"><table><thead><tr><th>Tanggal</th><th>Driver</th><th>ID Booking</th><th>Unit</th><th>Nominal</th><th>Keterangan</th></tr></thead><tbody id="driverPaymentRows"></tbody></table></div></div>
</div><div class="card" style="margin-top:14px">
  <div class="stats" style="margin-bottom:14px">
    <div class="stat"><span>Total Penugasan Driver</span><strong id="drBillCount">0</strong></div>
    <div class="stat"><span>Total Tagihan Driver</span><strong id="drBillTotal">Rp0</strong></div>
    <div class="stat"><span>Jumlah Driver</span><strong id="drBillDrivers">0</strong></div>
  </div>
  <div class="actions no-print" style="margin:12px 0;align-items:end">
    <div class="field"><label for="driverBillMonthFilter">Bulan Booking</label><select id="driverBillMonthFilter" onchange="renderDriverBills()"><option value="">Semua Bulan</option><option value="01">Januari</option><option value="02">Februari</option><option value="03">Maret</option><option value="04">April</option><option value="05">Mei</option><option value="06">Juni</option><option value="07">Juli</option><option value="08">Agustus</option><option value="09">September</option><option value="10">Oktober</option><option value="11">November</option><option value="12">Desember</option></select></div>
    <div class="field"><label for="driverBillYearFilter">Tahun</label><select id="driverBillYearFilter" onchange="renderDriverBills()"><option value="">Semua Tahun</option></select></div>
    <button class="btn" type="button" onclick="document.getElementById('driverBillMonthFilter').value='';document.getElementById('driverBillYearFilter').value='';document.getElementById('driverBillSearch').value='';renderDriverBills()">Tampilkan Semua</button>
  </div>
  <div class="field no-print" style="margin:12px 0"><label for="driverBillSearch">Cari Tagihan Driver</label><input id="driverBillSearch" type="search" placeholder="Cari ID/nama driver, ID booking, pelanggan, armada, atau tujuan..." oninput="renderDriverBills()"></div>
  <div class="tablewrap"><table><thead><tr><th>Pilih / Bayar</th><th>Driver</th><th>ID Booking</th><th>Pelanggan</th><th>Armada</th><th>Periode Sewa</th><th>Tujuan</th><th>Tarif per Hari</th><th>Lama Sewa</th><th>Total Tagihan</th><th>Sudah Dibayar</th><th>Sisa</th></tr></thead><tbody id="driverBillRows"></tbody></table></div>
</div>
</section>

<section id="pengeluaran" class="hidden">
<h2>Data Pengeluaran</h2>
<div class="card no-print">
  <h3>Tambah Pengeluaran</h3>
  <form id="expenseForm">
    <div class="formgrid">
      <div class="field"><label>Tanggal Pengeluaran</label><input type="date" id="eDate" required></div>
      <div class="field"><label>Kategori Pengeluaran</label><select id="eCategory" required><option value="">Pilih kategori</option><option>BBM</option><option>Servis dan Perawatan</option><option>Tol dan Parkir</option><option>Asuransi dan Pajak</option><option>Cuci Mobil</option><option>Operasional</option><option>Lain-lain</option></select></div>
      <div class="field"><label>Nominal Pengeluaran (Rp)</label><input type="number" id="eAmount" min="1" required></div>
      <div class="field"><label>Kendaraan terkait (opsional)</label><select id="eCar"><option value="">Biaya umum usaha</option></select></div>
      <div class="field" style="grid-column:span 2"><label>Keterangan</label><input id="eNote" placeholder="Contoh: ganti oli Innova Reborn"></div>
    </div>
    <div class="row" style="margin-top:12px"><button class="btn primary" type="submit">Simpan Pengeluaran</button></div>
  </form>
</div>
<div class="card" style="margin-top:14px">
  <div class="toolbar"><h3>Riwayat Pengeluaran</h3><strong id="expenseTotal" style="color:var(--gold)">Rp0</strong></div><div class="formgrid no-print" style="margin:10px 0 14px;grid-template-columns:minmax(180px,1fr) minmax(220px,2fr);align-items:end"><div class="field"><label for="expenseMonthFilter">Pilih Bulan Riwayat</label><input id="expenseMonthFilter" type="month" onchange="render()"></div><div class="field"><label for="qExpenseHistory">Cari Riwayat Pengeluaran</label><input id="qExpenseHistory" type="search" placeholder="Cari ID, tanggal, kategori, keterangan, atau nominal..." oninput="render()"></div></div>
  <div class="tablewrap"><table><thead><tr><th>ID Pengeluaran</th><th>Tanggal</th><th>Kategori</th><th>Keterangan</th><th>Nominal</th><th class="no-print">Aksi</th></tr></thead><tbody id="expenseRows"></tbody></table></div>
</div>
</section>
<section id="mitra" class="hidden">
<h2>Database Mitra Kendaraan</h2>
<div class="card no-print"><form id="partnerForm"><div class="formgrid">
<div class="field"><label>Nama Pemilik</label><input id="mName" required></div>
<div class="field"><label>No. WhatsApp</label><input id="mWa"></div>
<div class="field"><label>Alamat</label><input id="mAddress"></div>
<div class="field"><label>Nama Bank</label><input id="mBank"></div>
<div class="field"><label>Nomor Rekening</label><input id="mAccount"></div>
<div class="field"><label>Atas Nama</label><input id="mAccountName"></div>
</div><div class="row" style="margin-top:12px"><button class="btn primary">Simpan Mitra</button></div></form></div>
<div class="card" style="margin-top:14px"><h3>Daftar Mitra</h3><div class="tablewrap"><table><thead><tr><th>ID Mitra</th><th>Nama</th><th>WA</th><th>Alamat</th><th>Bank</th><th>Rekening</th></tr></thead><tbody id="partnerRows"></tbody></table></div></div>
<div class="partner-booking-payment-layout">
<div class="card partner-booking-list-card" style="margin-top:14px"><h3>Daftar Booking Armada Mitra</h3><p class="muted">Daftar hanya menampilkan booking yang memakai armada mitra. Data dikelompokkan per mitra; biaya setiap mobil dihitung dari tarif bagian mitra per hari × lama sewa, lalu dijumlahkan menjadi total per mitra.</p><div class="tablewrap"><table><thead><tr><th>Mitra</th><th>Bulan</th><th>ID Booking</th><th>Pelanggan</th><th>Armada</th><th>Periode</th><th>Biaya Armada</th></tr></thead><tbody id="partnerBookingRows"></tbody><tfoot><tr><th colspan="6" style="text-align:right">Total Seluruh Biaya Armada Mitra</th><th id="partnerBookingGrandTotal">Rp0</th></tr></tfoot></table></div></div>
<div class="card partner-payment-database-card" style="margin-top:14px"><h3>Database Pembayaran Mitra</h3><p class="muted">Riwayat pembayaran yang sudah dicatat, dikelompokkan berdasarkan mitra.</p><div class="tablewrap"><table><thead><tr><th>ID Pembayaran</th><th>ID Booking</th><th>Tanggal</th><th>Nominal</th><th>Status</th></tr></thead><tbody id="partnerPayRowsMitra"></tbody></table></div></div>
</div>

</section>
<section id="daftarTagihanMitra" class="hidden">
<h2>Daftar Tagihan Mitra</h2>
<p class="muted">Daftar tagihan bagian pemilik armada mitra berdasarkan booking. Tagihan, pembayaran yang sudah diterima, dan sisa tagihan dihitung otomatis.</p>
<div class="card" style="margin-top:14px">
<div class="stats" style="margin-bottom:14px">
<div class="stat"><span>Total Booking Mitra</span><strong id="mtTotalBookings">0</strong></div>
<div class="stat"><span>Total Tagihan</span><strong id="mtTotalBill">Rp0</strong></div>
<div class="stat"><span>Total Dibayar</span><strong id="mtTotalPaid">Rp0</strong></div>
<div class="stat"><span>Total Sisa Tagihan</span><strong id="mtTotalOutstanding">Rp0</strong></div>
</div>
<div class="actions no-print" style="margin:12px 0;align-items:end"><div class="field"><label for="partnerBillMonthFilter">Bulan Booking</label><select id="partnerBillMonthFilter" onchange="renderPartnerBills()"><option value="">Semua Bulan</option><option value="01">Januari</option><option value="02">Februari</option><option value="03">Maret</option><option value="04">April</option><option value="05">Mei</option><option value="06">Juni</option><option value="07">Juli</option><option value="08">Agustus</option><option value="09">September</option><option value="10">Oktober</option><option value="11">November</option><option value="12">Desember</option></select></div><div class="field"><label for="partnerBillYearFilter">Tahun</label><select id="partnerBillYearFilter" onchange="renderPartnerBills()"><option value="">Semua Tahun</option></select></div><button class="btn" type="button" onclick="document.getElementById('partnerBillMonthFilter').value='';document.getElementById('partnerBillYearFilter').value='';document.getElementById('partnerBillSearch').value='';partnerBillStatusFilter='all';renderPartnerBills()">Tampilkan Semua</button></div>
<div class="field no-print" style="margin:12px 0"><label for="partnerBillSearch">Cari Tagihan Mitra</label><input id="partnerBillSearch" type="search" placeholder="Cari ID mitra, nama mitra, ID booking, pelanggan, atau armada..." oninput="renderPartnerBills()"></div>
<div class="actions no-print" style="margin:12px 0"><button id="partnerBillPaidBtn" class="btn" type="button" onclick="setPartnerBillFilter('paid')">Lunas</button><button id="partnerBillUnpaidBtn" class="btn" type="button" onclick="setPartnerBillFilter('unpaid')">Belum Lunas</button><button id="partnerBillAllBtn" class="btn" type="button" onclick="setPartnerBillFilter('all')">Semua</button></div>
<div class="tablewrap"><table><thead><tr><th>ID Booking</th><th>Pelanggan</th><th>Periode</th><th>Armada Mitra</th><th>Tagihan Mitra</th><th>Sudah Dibayar</th><th>Sisa Tagihan</th><th>Status</th><th>Aksi</th></tr></thead><tbody id="partnerBillRows"></tbody></table></div>
</div>
</section>
<section id="pembayaranMitra" class="hidden">
<h2>Pembayaran Mitra</h2>
<p class="muted">Catat pembayaran bagian pemilik kendaraan mitra dan lihat riwayat pembayarannya di menu terpisah ini.</p>
<div class="card" style="margin-top:14px"><h3>Pembayaran Bagian Mitra</h3><form id="partnerPayForm"><div class="formgrid">
<div class="field"><label>Mitra</label><select id="mpPartner" required></select></div>
<select id="mpBooking" hidden aria-hidden="true"></select>
<div class="field"><label>Tanggal Bayar</label><input type="date" id="mpDate" required></div>
<div class="field"><label>Nominal Dibayar</label><input type="number" id="mpAmount" min="1" required></div>
<div class="field"><label>Keterangan</label><input id="mpNote"></div>
</div>
<div id="partnerPaySummary" class="stats" style="margin:12px 0"><div class="stat"><span>Total Booking Mitra</span><strong id="mpTotalBookings">0</strong></div><div class="stat"><span>Total Tagihan Mitra</span><strong id="mpTotalBill">Rp0</strong></div></div>
<div class="row" style="margin-top:12px"><button class="btn primary">Catat Pembayaran Mitra</button></div></form>
<h3 style="margin-top:20px">Riwayat Pembayaran Mitra per ID Mitra</h3>
<div class="tablewrap" style="margin-top:10px"><table><thead><tr><th>ID Pembayaran</th><th>ID Booking</th><th>Tanggal</th><th>Nominal</th><th>Status</th></tr></thead><tbody id="partnerPayRows"></tbody></table></div></div>
</section>
<section id="akuntansi" class="hidden">
<h2>Buku Besar & Jurnal</h2>
<div class="card no-print"><h3>Input Jurnal Manual</h3><form id="journalForm"><div class="formgrid">
<div class="field"><label>Tanggal</label><input type="date" id="jDate" required></div>
<div class="field"><label>Keterangan</label><input id="jNote" required></div>
<div class="field"><label>Akun Debit</label><select id="jDebit"><option value="1101">1101 • Kas/Bank</option><option value="2101">2101 • Utang Mitra</option><option value="4101">4101 • Pendapatan Sewa</option><option value="4201">4201 • Pendapatan Margin Mitra</option><option value="5101">5101 • Beban Operasional</option></select></div>
<div class="field"><label>Akun Kredit</label><select id="jCredit"><option value="4101">4101 • Pendapatan Sewa</option><option value="1101">1101 • Kas/Bank</option><option value="2101">2101 • Utang Mitra</option><option value="5101">5101 • Beban Operasional</option></select></div>
<div class="field"><label>Nominal</label><input type="number" id="jAmount" min="1" required></div>
</div><div class="row" style="margin-top:12px"><button class="btn primary">Simpan Jurnal</button></div></form></div>
<div class="grid" style="margin-top:14px"><div class="stat"><small>Total Debit Jurnal Manual</small><strong id="jDebitTotal">Rp0</strong></div><div class="stat"><small>Total Kredit Jurnal Manual</small><strong id="jCreditTotal">Rp0</strong></div></div>
<div class="card"><h3>Jurnal Umum</h3><div class="tablewrap"><table><thead><tr><th>ID</th><th>Tanggal</th><th>Keterangan</th><th>Debit</th><th>Kredit</th><th>Nominal</th></tr></thead><tbody id="journalRows"></tbody></table></div></div>
<div class="card" style="margin-top:14px"><h3>Buku Besar (mutasi otomatis + jurnal manual)</h3><div class="tablewrap"><table><thead><tr><th>Tanggal</th><th>Akun</th><th>Keterangan</th><th>Debit</th><th>Kredit</th><th>Saldo</th></tr></thead><tbody id="ledgerRows"></tbody></table></div></div>
<div class="card" style="margin-top:14px"><h3>Laba Rugi Cash Basis per Kendaraan</h3><div class="tablewrap"><table><thead><tr><th>Kendaraan</th><th>Kepemilikan</th><th>Penerimaan Kas</th><th>Bagian Mitra</th><th>Biaya Langsung</th><th>Hasil</th></tr></thead><tbody id="carProfitRows"></tbody></table></div><p id="overallProfit" style="color:var(--gold);font-weight:bold"></p></div>
</section>
<section id="pengguna" class="hidden">
<h2>Manajemen Pengguna</h2>
<div class="card no-print">
  <h3>Tambah Akun Karyawan</h3>
  <form id="userForm"><div class="formgrid">
    <div class="field"><label>Username Karyawan</label><input id="uName" required minlength="4" autocomplete="off"></div>
    <div class="field"><label>Password (minimal 10 karakter)</label><input id="uPass" type="password" required minlength="10" autocomplete="new-password"></div>
  </div><div class="row" style="margin-top:12px"><button class="btn primary" type="submit">Buat Akun Karyawan</button></div></form>
  <div class="notice">Admin memiliki akses penuh. Karyawan dapat memasukkan dan mengubah transaksi, tetapi tidak dapat menghapus data atau membuat akun.</div>
</div>
<div class="card" style="margin-top:14px"><h3>Daftar Akun</h3><div class="tablewrap"><table><thead><tr><th>Username</th><th>Peran</th><th>Status</th><th class="no-print">Aksi</th></tr></thead><tbody id="userRows"></tbody></table></div></div>
</section>
<section id="laporan" class="hidden">
<div class="toolbar"><h2>Laporan</h2><div class="actions no-print"><button class="btn" onclick="printReport()">Cetak Laporan</button><button class="btn" onclick="backup()">Backup JSON</button><label class="btn" style="cursor:pointer">Pulihkan JSON<input type="file" id="restoreFile" accept=".json,application/json" hidden></label></div></div>
<div class="row no-print" style="margin-bottom:12px"><div class="field" style="max-width:220px"><label>Periode Laporan Laba Rugi</label><input type="month" id="reportMonth"></div></div><div class="grid"><div class="stat"><small>Total Nilai Booking</small><strong id="rBooking">Rp0</strong></div><div class="stat"><small>Pemasukan Bulan Terpilih</small><strong id="rIncome">Rp0</strong></div><div class="stat"><small>Sisa Tagihan</small><strong id="rRemain">Rp0</strong></div><div class="stat"><small>Pengeluaran Bulan Terpilih</small><strong id="rExpense">Rp0</strong></div><div class="stat"><small>Laba / Rugi Bulan Terpilih</small><strong id="rNet">Rp0</strong></div><div class="stat"><small>Booking Belum Lunas</small><strong id="rUnpaid">0</strong></div></div>
<div class="card" style="margin-top:14px"><div class="toolbar"><h3 id="incomeListTitle">Daftar Pembayaran Bulan Terpilih</h3><strong id="incomeListTotal">Total: Rp0</strong></div><div class="tablewrap"><table><thead><tr><th>Tanggal</th><th>Nama Pelanggan</th><th>ID Booking</th><th>Nominal Pemasukan</th></tr></thead><tbody id="incomeRows"></tbody></table></div></div>
<div class="card" style="display:none"><h3>Invoice Bulanan — Booking Belum Bayar</h3>
<div class="row no-print"><div class="field"><label>Bulan Invoice</label><input type="month" id="invoiceMonth"></div><div class="field"><label>Pelanggan</label><select id="invoicePick"></select></div><div class="field" style="align-self:end"><button class="btn primary" onclick="printInvoice()">Cetak Invoice Bulanan</button><button class="btn" type="button" onclick="sendMonthlyInvoiceWhatsApp()">Kirim Invoice via WhatsApp</button></div></div>
<div class="notice">Invoice menggabungkan booking dengan ID pelanggan yang sama, berdasarkan bulan tanggal awal sewa. Hanya booking berstatus Belum Bayar yang disertakan.</div>
<div id="invoicePreview" style="margin-top:15px"></div></div>
<div class="card" style="display:none;margin-top:14px"><div class="toolbar"><h3>Rekap Pelanggan Belum Lunas</h3><div class="actions no-print"><input id="qUnpaidCustomer" placeholder="Cari ID / nama / WA" style="max-width:240px"><button class="btn" onclick="printUnpaidCustomers()">Cetak Rekap</button></div></div><div class="notice">Menampilkan pelanggan yang masih memiliki sisa tagihan dari satu atau beberapa booking. Total tagihan dan pembayaran digabung berdasarkan ID pelanggan.</div><div class="tablewrap"><table><thead><tr><th>ID Pelanggan</th><th>Nama Pelanggan</th><th>No. WA</th><th>ID Booking</th><th>Jumlah Booking</th><th>Total Tagihan</th><th>Total Dibayar</th><th>Sisa Tagihan</th></tr></thead><tbody id="unpaidCustomerRows"></tbody></table></div><div class="toolbar" style="margin-top:12px"><strong id="unpaidCustomerSummary">0 pelanggan • Sisa tagihan Rp0</strong></div></div>
<div class="card" style="margin-top:14px"><h3>Rincian Laba Rugi Bulanan</h3><div class="tablewrap"><table><thead><tr><th>Tanggal</th><th>Jenis</th><th>Keterangan</th><th>Nominal</th></tr></thead><tbody id="plRows"></tbody></table></div></div><div class="card" style="margin-top:14px"><h3>Rekap Booking</h3><div class="tablewrap"><table><thead><tr><th class="no-print">Pilih</th><th>ID Booking</th><th>Pelanggan</th><th>Armada</th><th>Total</th><th>Dibayar</th><th>Sisa</th><th>Status</th></tr></thead><tbody id="reportRows"></tbody></table></div></div>
<div class="row no-print" style="margin-top:14px"><button class="btn" onclick="exportCSV()">Ekspor data booking CSV</button><button class="btn danger" id="clearAllBtn" onclick="clearAll()">Hapus seluruh data</button></div>
</section>

<section id="changelog" class="hidden">
  <div class="toolbar" style="align-items:center;gap:12px;flex-wrap:wrap">
    <div><h2 style="margin:0">Riwayat Perubahan Aplikasi</h2><p class="muted" style="margin:6px 0 0">Catatan pembaruan fitur, perbaikan, dan perubahan Alfa Prima Rent Car.</p></div>
    <span class="badge">Versi saat ini: 1.0.5</span>
  </div>
  <div class="card no-print" style="margin:14px 0">
    <div class="formgrid" style="grid-template-columns:repeat(auto-fit,minmax(190px,1fr));align-items:end">
      <div class="field"><label for="changelogVersionFilter">Filter versi</label>
        <select id="changelogVersionFilter" onchange="renderChangelog()">
          <option value="">Semua versi</option><option>1.0.5</option><option>1.0.4</option><option>1.0.3</option><option>1.0.2</option><option>1.0.1</option>
        </select>
      </div>
      <div class="field"><label for="changelogSearch">Cari perubahan</label><input id="changelogSearch" type="search" placeholder="Cari fitur atau perbaikan..." oninput="renderChangelog()"></div>
    </div>
  </div>
  <div id="changelogEntries" class="grid" style="grid-template-columns:1fr;gap:12px"></div>
  <p class="muted" style="font-size:12px;margin-top:12px">Catatan: riwayat versi ini merupakan catatan rilis yang disertakan pada file aplikasi. Setiap pembaruan kode berikutnya perlu menambahkan entri versi baru agar tercatat.</p>
</section>
</main><footer>ALFA PRIMA RENT CAR • Laravel & MySQL</footer>
<script>
const KEY='alfaPrimaSimpleV1';
let db=JSON.parse(localStorage.getItem(KEY)||'{"customers":[],"cars":[],"bookings":[],"payments":[],"expenses":[],"partners":[],"partnerPayments":[],"accounts":[],"journals":[]}');
db.customers=db.customers||[];db.cars=db.cars||[];db.bookings=db.bookings||[];db.payments=db.payments||[];db.otherCharges=db.otherCharges||[];db.drivers=db.drivers||[];db.driverPayments=db.driverPayments||[];db.expenses=db.expenses||[];db.partners=db.partners||[];db.partnerPayments=db.partnerPayments||[];db.accounts=db.accounts||[];db.journals=db.journals||[];let authToken=sessionStorage.getItem('ap_auth_token')||'';let currentUser=null;let dbRevision=0;const $=id=>document.getElementById(id), money=n=>'Rp'+Number(n||0).toLocaleString('id-ID');
const esc=s=>String(s??'').replace(/[&<>"']/g,c=>({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c]));
let saveInFlight=false,saveQueued=false;
function setSyncStatus(message,color){let el=$('syncStatus');if(el){el.textContent=message;if(color)el.style.color=color}}
function csrfToken() {
  return document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
}

async function apiCall(url, method = 'GET', body = null) {
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
}

async function persistToDatabase() {
  if (saveInFlight) { saveQueued = true; return; }
  saveInFlight = true;
  setSyncStatus('Menyimpan ke database MySQL…');
  const snapshot = JSON.parse(JSON.stringify(db));
  try {
    await apiCall('/api/save-all', 'POST', snapshot);
    saveInFlight = false;
    setSyncStatus('Tersimpan di MySQL ✓', '#64c69a');
    if (saveQueued) {
      saveQueued = false;
      persistToDatabase();
    }
  } catch (err) {
    saveInFlight = false;
    setSyncStatus('Gagal menyimpan ke MySQL', '#ffb3b3');
    alert('Data belum berhasil disimpan ke database MySQL: ' + err.message);
    saveQueued = false;
  }
}

function save() { render(); persistToDatabase(); }
function nextId(arr,prefix){let max=arr.reduce((m,x)=>Math.max(m,+(x.id||'').replace(/\D/g,'')||0),0);return prefix+String(max+1).padStart(4,'0')}
function cust(id){return db.customers.find(x=>x.id===id)}
function car(id){return db.cars.find(x=>x.id===id)}
function book(id){return db.bookings.find(x=>x.id===id)}
function bookingUnitsOf(b){return Array.isArray(b?.units)&&b.units.length?b.units:[b]}
function paid(id){return db.payments.filter(x=>x.bookingId===id).reduce((s,x)=>s+Number(x.amount),0)}
function paidOtherCharge(id){return db.payments.filter(x=>x.bookingId==='BLY:'+id).reduce((s,x)=>s+Number(x.amount||0),0)}
function chargesForBooking(bookingId){
  return (db.otherCharges||[]).filter(x=>String(x.bookingId||'')===String(bookingId));
}
function totalOtherChargesForBooking(bookingId){
  return chargesForBooking(bookingId).reduce((sum,x)=>sum+Number(x.amount||0),0);
}
function paidOtherChargesForBooking(bookingId){
  return chargesForBooking(bookingId).reduce((sum,x)=>sum+paidOtherCharge(x.id),0);
}
function bookingGrandTotal(bookingId){
  const b=book(bookingId);return Number(b?.total||0)+totalOtherChargesForBooking(bookingId);
}
function bookingGrandPaid(bookingId){
  return paid(bookingId)+paidOtherChargesForBooking(bookingId);
}

function outstandingOtherChargesForCustomer(cid){
  return (db.otherCharges||[]).filter(x=>String(x.customerId||'')===String(cid))
    .map(x=>({charge:x,paid:paidOtherCharge(x.id),remain:Math.max(0,Number(x.amount||0)-paidOtherCharge(x.id))}))
    .filter(x=>x.remain>0).sort((a,b)=>String(a.charge.date||'').localeCompare(String(b.charge.date||''))||String(a.charge.id).localeCompare(String(b.charge.id)));
}

function statusBook(b){let p=bookingGrandPaid(b.id),t=bookingGrandTotal(b.id);return p<=0?'Belum Bayar':p>=t?'Lunas':'Kurang Bayar'}
function days(a,b){if(!a||!b)return 0;let x=new Date(a+'T00:00:00'),y=new Date(b+'T00:00:00');return Math.round((y-x)/86400000)+1}
function formatDateDMY(value){if(!value)return '-';let parts=String(value).slice(0,10).split('-');return parts.length===3?parts[2]+'/'+parts[1]+'/'+parts[0]:String(value)}
function rupiahInput(n){return Number(n||0)}
function toggleDashboardIncomeDetails(){
  const panel=$('dashboardIncomeDetails');
  if(!panel)return;
  const open=panel.classList.contains('hidden');
  panel.classList.toggle('hidden',!open);
  if(open){
    panel.scrollIntoView({behavior:'smooth',block:'nearest'});
  }
}

const APP_CHANGELOG = [
 {version:'1.0.5',date:'2026-11-16',title:'Riwayat Pengeluaran Bulanan',items:['Riwayat pengeluaran otomatis menampilkan bulan berjalan.','Filter bulan dan tahun untuk melihat periode lain.','Total pengeluaran mengikuti bulan dan pencarian yang dipilih.']},
 {version:'1.0.4',date:'2026-11-16',title:'Perbaikan Timeline Armada dan Edit Booking',items:['Tombol tambah booking pada timeline menggunakan ikon plus.','Batang jadwal timeline diarahkan untuk membuka formulir edit booking.','Perbaikan navigasi agar formulir edit booking terbuka langsung.']},
 {version:'1.0.3',date:'2026-11-13',title:'Perbaikan Pemulihan Backup',items:['Validasi struktur file backup JSON.','Dukungan data tambahan seperti driver dan pembayaran driver.','Perbaikan status sinkronisasi saat pemulihan data.']},
 {version:'1.0.2',date:'2026-11-13',title:'Perbaikan Sinkronisasi Database',items:['Perbaikan antrean penyimpanan dan penanganan konflik revisi.','Penambahan penyimpanan data Biaya Lain-lain.']},
 {version:'1.0.1',date:'2026-11-11',title:'Pembaruan Modul Operasional',items:['Penyempurnaan modul armada, booking, pembayaran, mitra, dan driver.','Penyempurnaan laporan dan pencatatan operasional.']}
];
function renderChangelog(){
 const version=String($('changelogVersionFilter')?.value||'');
 const query=String($('changelogSearch')?.value||'').trim().toLowerCase();
 const rows=APP_CHANGELOG.filter(x=>(!version||x.version===version)&&[x.version,x.date,x.title,...x.items].join(' ').toLowerCase().includes(query));
 $('changelogEntries').innerHTML=rows.map(x=>`<article class="card" style="padding:16px">
  <div class="toolbar" style="align-items:center"><div><strong style="color:var(--gold);font-size:18px">v${esc(x.version)}</strong><h3 style="margin:5px 0">${esc(x.title)}</h3></div><span class="muted">${esc(x.date.split('-').reverse().join('-'))}</span></div>
  <ul style="margin:10px 0 0;padding-left:20px">${x.items.map(item=>`<li style="margin:5px 0">${esc(item)}</li>`).join('')}</ul>
 </article>`).join('')||'<div class="card muted">Tidak ada catatan perubahan yang cocok.</div>';
}

function toggleToolbarEditMenu(force){
  const menu=$('toolbarEditMenu');
  const trigger=document.querySelector('#rightToolbar [data-tab="editMenu"]');
  if(!menu)return;
  const show=typeof force==='boolean'?force:menu.classList.contains('hidden');
  menu.classList.toggle('hidden',!show);
  if(trigger)trigger.setAttribute('aria-expanded',show?'true':'false');
}
function openBookingForTimelineCar(carId){
  const selectedCar=db.cars.find(c=>String(c.id)===String(carId));
  if(!selectedCar){alert('Data armada tidak ditemukan.');return;}
  openDashboardMenu('booking');
  if(typeof toggleBookingFormContainer==='function')toggleBookingFormContainer(true);
  $('bookEdit').value='';
  $('bookSubmitBtn').textContent='Simpan Booking';
  $('bUnitCount').value='1';
  renderBookingUnits(1);
  const unit=document.querySelector('.booking-unit');
  if(unit){
    const ownership=unit.querySelector('.bu-ownership');
    ownership.value=(selectedCar.ownership||'sendiri')==='mitra'?'mitra':'sendiri';
    ownership.dispatchEvent(new Event('change',{bubbles:true}));
    const partner=unit.querySelector('.bu-partner');
    if(partner)partner.value=selectedCar.partnerId||'';
    const carSelect=unit.querySelector('.bu-car');
    carSelect.innerHTML=bookingUnitOptions(0,unit);
    carSelect.value=String(selectedCar.id);
    carSelect.dispatchEvent(new Event('change',{bubbles:true}));
  }
  document.getElementById('bookingFormContainer')?.scrollIntoView({behavior:'smooth',block:'start'});
}
document.addEventListener('click',e=>{
  const car=e.target.closest('.timeline-car-name[data-timeline-car-id]');
  if(car)openBookingForTimelineCar(car.dataset.timelineCarId);
});
document.addEventListener('keydown',e=>{
  const car=e.target.closest?.('.timeline-car-name[data-timeline-car-id]');
  if(car&&(e.key==='Enter'||e.key===' ')){e.preventDefault();openBookingForTimelineCar(car.dataset.timelineCarId);}
});

function openDashboardMenu(tabId){
  document.querySelectorAll('#rightToolbar button').forEach(x=>x.classList.toggle('active',x.dataset.tab===tabId));
  document.querySelectorAll('main section').forEach(x=>x.classList.add('hidden'));
  const target=$(tabId);
  if(target)target.classList.remove('hidden');
  $('customerQuickActions')?.classList.add('hidden');
  if(tabId==='changelog')renderChangelog();
  render();
}
function toggleCustomerQuickActions(){
  const panel=$('customerQuickActions');
  if(panel)panel.classList.toggle('hidden');
}
function openCustomerMenu(mode){
  document.querySelectorAll('#rightToolbar button').forEach(x=>x.classList.toggle('active',x.dataset.tab==='pelanggan'));
  document.querySelectorAll('main section').forEach(x=>x.classList.add('hidden'));
  $('pelanggan').classList.remove('hidden');
  if(mode==='add'){
    resetCust();
    $('custTitle').textContent='Tambah Pelanggan';
    $('cNama').focus();
  }else{
    resetCust();
    $('qCust').focus();
  }
  $('customerQuickActions')?.classList.add('hidden');
  render();
}
document.querySelectorAll('#rightToolbar > button').forEach(btn=>btn.onclick=()=>{
  if(btn.dataset.tab==='editMenu'){toggleToolbarEditMenu();return;}
  openDashboardMenu(btn.dataset.tab);
});
document.querySelectorAll('#toolbarEditMenu button').forEach(btn=>btn.onclick=()=>{toggleToolbarEditMenu(false);openDashboardMenu(btn.dataset.tab);});
function resetCust(){$('custForm').reset();$('custEdit').value='';$('custTitle').textContent='Tambah Pelanggan'}
$('custForm').onsubmit=e=>{e.preventDefault();let id=$('custEdit').value||nextId(db.customers,'PLG-'),o={id,nama:$('cNama').value.trim(),alamat:$('cAlamat').value.trim(),wa:$('cWa').value.trim(),nik:$('cNik').value.trim(),sim:$('cSim').value.trim(),status:$('cStatus').value};let i=db.customers.findIndex(x=>x.id===id);i<0?db.customers.push(o):db.customers[i]=o;resetCust();save()};
function editCust(id){let x=cust(id);$('custEdit').value=x.id;$('cNama').value=x.nama;$('cAlamat').value=x.alamat;$('cWa').value=x.wa;$('cNik').value=x.nik;$('cSim').value=x.sim;$('cStatus').value=x.status;$('custTitle').textContent='Edit '+id;window.scrollTo(0,0)}
function delCust(id){if(currentUser?.role!=='admin'){alert('Hanya admin yang dapat menghapus data.');return}if(db.bookings.some(b=>b.customerId===id)){alert('Pelanggan sudah memiliki booking dan tidak dapat dihapus.');return}if(confirm('Hapus pelanggan '+id+'?')){db.customers=db.customers.filter(x=>x.id!==id);save()}}
function updateCarOwnershipFields(){let mitra=$('aOwnership').value==='mitra';$('aPartner').closest('.field').classList.toggle('hidden',!mitra);$('aPartnerRate').closest('.field').classList.toggle('hidden',!mitra);if(!mitra){$('aPartner').value='';$('aPartnerRate').value=0}}
$('aOwnership').onchange=updateCarOwnershipFields;

function resetCar(){
  $('carForm').reset();$('carEdit').value='';$('carTitle').textContent='Tambah Armada';
  $('aVehicleClass').value='City Car';$('aStatus').value='Tersedia';$('aOwnership').value='sendiri';
  $('aPartner').value='';$('aPartnerRate').value='0';updateCarOwnershipFields();
}
function editCar(id){
  const x=car(id);if(!x){alert('Data armada tidak ditemukan: '+id);return;}
  $('carEdit').value=x.id;$('aMerk').value=x.merk||'';$('aJenis').value=x.jenis||'';
  $('aVehicleClass').value=x.vehicleClass||'City Car';$('aPlat').value=x.plat||'';
  $('aTrans').value=x.trans||'Matic';$('aStatus').value=x.status||'Tersedia';
  $('aOwnership').value=x.ownership||'sendiri';
  $('aPartner').value=x.partnerId||'';$('aPartnerRate').value=Number(x.partnerRate||0);
  $('carTitle').textContent='Edit Armada '+id;updateCarOwnershipFields();
  document.querySelector('[data-tab="armada"]').click();window.scrollTo({top:0,behavior:'smooth'});
}
$('carForm').onsubmit=e=>{
  e.preventDefault();
  const id=$('carEdit').value||nextId(db.cars,'ARM-');
  const ownership=$('aOwnership').value,partnerId=ownership==='mitra'?$('aPartner').value:'';
  if(ownership==='mitra'&&!partnerId){alert('Pilih pemilik / mitra untuk armada mitra.');return;}
  const old=car(id)||{};
  const record={...old,id,merk:$('aMerk').value.trim(),jenis:$('aJenis').value.trim(),
    vehicleClass:$('aVehicleClass').value,plat:$('aPlat').value.trim().toUpperCase(),
    trans:$('aTrans').value,status:$('aStatus').value,ownership,partnerId,
    partnerRate:ownership==='mitra'?Number($('aPartnerRate').value||0):0};
  const ix=db.cars.findIndex(x=>x.id===id);if(ix<0)db.cars.push(record);else db.cars[ix]=record;
  resetCar();save();alert('Data armada berhasil '+(ix<0?'ditambahkan.':'diperbarui.'));
};
function delCar(id){
  if(currentUser?.role!=='admin'){alert('Hanya admin yang dapat menghapus data armada.');return;}
  if(db.bookings.some(b=>bookingUnitsOf(b).some(u=>u.carId===id))){alert('Armada sudah digunakan dalam booking dan tidak dapat dihapus. Ubah status menjadi Nonaktif jika tidak digunakan lagi.');return;}
  if(confirm('Hapus data armada '+id+'?')){db.cars=db.cars.filter(x=>x.id!==id);save();}
}

function bookingUnitOptions(index,card){
  let type=card?.querySelector('.bu-ownership')?.value||'sendiri',partnerId=card?.querySelector('.bu-partner')?.value||'';
  let cars=db.cars.filter(a=>(a.ownership||'sendiri')===type&&['Tersedia','Disewa'].includes(a.status)&&(type!=='mitra'||(partnerId&&a.partnerId===partnerId)));
  return '<option value="">Pilih armada</option>'+cars.map(a=>`<option value="${esc(a.id)}">${esc(a.jenis)} (${esc(a.plat)})</option>`).join('');
}
function bookingDriverOptions(){
  return '<option value="">Tanpa sopir</option>'+db.drivers.filter(d=>d.status!=='Nonaktif').map(d=>`<option value="${esc(d.id)}">${esc(d.name)}</option>`).join('');
}
function renderBookingUnits(count,values=[]){
  let wrap=$('bookingUnits'); if(!wrap)return;
  wrap.innerHTML=Array.from({length:count},(_,i)=>{
    let v=values[i]||{};
    return `<div class="card booking-unit" data-unit="${i}" style="grid-column:1/-1;padding:14px">
      <h3 style="margin:0 0 10px">Rincian Unit ${i+1}</h3>
      <div class="formgrid">
        <div class="field"><label>Jenis Kepemilikan Armada</label><select class="bu-ownership"><option value="sendiri">Pribadi</option><option value="mitra">Armada Mitra</option></select></div>
        <div class="field bu-partner-wrap hidden"><label>Pilih Mitra</label><select class="bu-partner"><option value="">Pilih mitra</option>${db.partners.map(m=>`<option value="${esc(m.id)}">${esc(m.name)} (${m.id})</option>`).join('')}</select></div>
        <div class="field"><label>Armada</label><select class="bu-car" required>${bookingUnitOptions(i)}</select></div>
        <div class="field"><label>Harga Sewa per Hari (Rp)</label><input class="bu-rate" type="number" min="0" required value="${Number(v.rate||'')||''}"></div>
        <div class="field"><label>Biaya Lain-lain Unit (Rp)</label><input class="bu-other-cost" type="number" min="0" step="1" value="${Number(v.otherCost||0)}" placeholder="0"></div>
        <div class="field"><label>Keterangan Biaya Lain-lain</label><input class="bu-other-note" type="text" maxlength="250" value="${esc(v.otherCostNote||'')}" placeholder="Keterangan biaya tambahan"></div>
        <div class="field"><label>Sopir</label><select class="bu-driver">${bookingDriverOptions()}</select></div>
        <div class="field bu-driver-name-wrap hidden"><label>Nama Sopir</label><input class="bu-driver-name" readonly></div>
        
        <div class="field bu-destination-type-wrap"><label>Kategori Tujuan Driver</label><select class="bu-destination-type"><option value="">Pilih tujuan</option><option>Dalam kota</option><option>Luar kota dalam provinsi</option><option>Luar provinsi</option><option>Luar pulau</option></select></div><div class="field bu-driver-fee-wrap"><label>Tarif Driver per Hari (Rp)</label><input class="bu-driver-fee" type="number" min="0" value="${Number(v.driverFeePerDay||0)}"></div><div class="field"><label>Rute / Keterangan Tujuan</label><input class="bu-destination" placeholder="Contoh: Semarang - Yogyakarta" value="${esc(v.destination||'')}"></div>
        <div class="field bu-toll-wrap hidden"><label>Biaya Tol / E-toll Parking per Hari (Rp)</label><input class="bu-toll" type="number" min="0" value="${Number(v.tollPerDay??v.tollCostPerDay??(v.days?Number(v.tollCost||0)/Number(v.days):0))}"></div>
        <div class="field bu-fuel-wrap hidden"><label>Biaya BBM per Hari (Rp)</label><input class="bu-fuel" type="number" min="0" value="${Number(v.fuelPerDay??v.fuelCostPerDay??(v.days?Number(v.fuelCost||0)/Number(v.days):0))}"></div>
        <div class="field bu-meal-wrap hidden"><label>Uang Makan Driver per Hari (Rp)</label><input class="bu-meal" type="number" min="0" value="${Number(v.mealPerDay??v.mealCostPerDay??(v.days?Number(v.mealCost||0)/Number(v.days):0))}"></div>
        <div class="field bu-lodging-wrap hidden"><label>Biaya Inap Driver per Hari (Rp)</label><input class="bu-lodging" type="number" min="0" value="${Number(v.lodgingPerDay??v.lodgingCostPerDay??(v.days?Number(v.lodgingCost||0)/Number(v.days):0))}"></div>
        <div class="field bu-daily-total-wrap"><label>Subtotal per Mobil per Hari</label><input class="bu-daily-total" readonly></div>
        <div class="field"><label>Total Unit ${i+1}</label><input class="bu-total" readonly></div>
      </div></div>`;
  }).join('');
  [...wrap.querySelectorAll('.booking-unit')].forEach((card,i)=>{
    let v=values[i]||{};
    let savedCar=car(v.carId);
    card.querySelector('.bu-ownership').value=savedCar?.ownership||'sendiri';
    card.querySelector('.bu-partner').value=savedCar?.partnerId||'';
    card.querySelector('.bu-partner-wrap').classList.toggle('hidden',card.querySelector('.bu-ownership').value!=='mitra');
    card.querySelector('.bu-car').innerHTML=bookingUnitOptions(i,card);
    card.querySelector('.bu-car').value=v.carId||'';
    card.querySelector('.bu-ownership').addEventListener('change',()=>{if(card.querySelector('.bu-ownership').value!=='mitra')card.querySelector('.bu-partner').value='';card.querySelector('.bu-partner-wrap').classList.toggle('hidden',card.querySelector('.bu-ownership').value!=='mitra');refreshUnitCars(card);});
    card.querySelector('.bu-partner').addEventListener('change',()=>refreshUnitCars(card));
    card.querySelector('.bu-driver').value=v.driverId||'';
    card.querySelector('.bu-destination-type').value=v.destinationType||'';
    card.querySelector('.bu-destination-type').addEventListener('change',()=>{const rates={'Dalam kota':200000,'Luar kota dalam provinsi':250000,'Luar provinsi':300000,'Luar pulau':400000};card.querySelector('.bu-driver-fee').value=rates[card.querySelector('.bu-destination-type').value]||0;updateBookingCalc();});
    card.querySelector('.bu-driver-name').value=v.driverName||'';
    card.querySelector('.bu-driver').addEventListener('change',()=>{let d=db.drivers.find(x=>x.id===card.querySelector('.bu-driver').value);card.querySelector('.bu-driver-name').value=d?.name||'';updateBookingDriverVisibility(card);updateBookingCalc()});
    card.querySelectorAll('input,select').forEach(el=>el.addEventListener('input',updateBookingCalc));
    card.querySelectorAll('select').forEach(el=>el.addEventListener('change',updateBookingCalc));
    updateBookingDriverVisibility(card);
  });
  updateBookingCalc();
}
function updateBookingDriverVisibility(card){
  let has=!!card.querySelector('.bu-driver').value;
  ['.bu-driver-name-wrap','.bu-destination-type-wrap','.bu-driver-fee-wrap','.bu-toll-wrap','.bu-fuel-wrap','.bu-meal-wrap','.bu-lodging-wrap','.bu-daily-total-wrap'].forEach(sel=>card.querySelector(sel).classList.toggle('hidden',!has));
  if(!has){['.bu-driver-fee','.bu-toll','.bu-fuel','.bu-meal','.bu-lodging'].forEach(sel=>card.querySelector(sel).value=0);card.querySelector('.bu-driver-name').value='';}
}
function refreshUnitCars(card){
  let old=card.querySelector('.bu-car').value;
  card.querySelector('.bu-car').innerHTML=bookingUnitOptions(0,card);
  if([...card.querySelector('.bu-car').options].some(o=>o.value===old))card.querySelector('.bu-car').value=old;
}
function updateBookingCalc(){
  let d=days($('bStart').value,$('bEnd').value);
  $('bDays').value=d>0?d+' hari':'';
  let daily=0;
  [...document.querySelectorAll('.booking-unit')].forEach((card,i)=>{
    let val=sel=>rupiahInput(card.querySelector(sel)?.value);
    let driver=!!card.querySelector('.bu-driver').value;
    let subtotal=val('.bu-rate')+(driver?(val('.bu-driver-fee')+val('.bu-toll')+val('.bu-fuel')+val('.bu-meal')+val('.bu-lodging')):0);
    let otherCost=val('.bu-other-cost');
    let total=d>0?subtotal*d+otherCost:0;
    card.querySelector('.bu-daily-total').value=subtotal?money(subtotal):'';
    card.querySelector('.bu-total').value=total?money(total):'';
    daily+=subtotal;
  });
  $('bDailySubtotal').textContent=money(daily);
  const extras=[...document.querySelectorAll('.booking-unit')].reduce((sum,card)=>sum+rupiahInput(card.querySelector('.bu-other-cost')?.value||0),0);
  $('bGrandTotal').textContent=money(daily*d+extras);
}
['bStart','bEnd'].forEach(id=>$(id).addEventListener('input',updateBookingCalc));
$('bUnitCount').onchange=()=>renderBookingUnits(Number($('bUnitCount').value));
function toggleBookingFormContainer(forceOpen){
  const panel=$('bookingFormContainer');
  if(!panel)return;
  const shouldOpen=typeof forceOpen==='boolean'?forceOpen:panel.classList.contains('hidden');
  panel.classList.toggle('hidden',!shouldOpen);
  const heading=$('bookingFormToggle');
  if(heading)heading.setAttribute('aria-expanded',String(shouldOpen));
  const icon=$('bookingFormChevron');
  if(icon)icon.textContent=shouldOpen?'−':'＋';
}
function resetBookingForm(){
  $('bookForm').reset();$('bookEdit').value='';$('bookSubmitBtn').textContent='Simpan Booking';
  $('bUnitCount').value='1';renderBookingUnits(1);updateBookingCalc();
}
function editBooking(id){
  const b=book(String(id||''));
  if(!b){alert('Booking '+String(id||'')+' tidak ditemukan. Muat ulang data lalu coba lagi.');return;}
  // Bagian Booking tidak memiliki tombol navbar tersendiri; buka section secara langsung.
  openDashboardMenu('booking');
  toggleBookingFormContainer(true);
  const units=bookingUnitsOf(b);
  $('bookEdit').value=b.id;
  $('bCust').value=b.customerId||'';
  $('bStart').value=String(b.start||'').slice(0,10);
  $('bEnd').value=String(b.end||'').slice(0,10);
  $('bUnitCount').value=String(units.length);
  renderBookingUnits(units.length,units);
  $('bookSubmitBtn').textContent='Simpan Perubahan Booking';
  updateBookingCalc();
  $('bookingFormContainer').scrollIntoView({behavior:'smooth',block:'start'});
}

// Delegasi event: batang timeline dibuat ulang setiap kali bulan/data berubah.
document.addEventListener('click',function(event){
  const bar=event.target.closest('.fleet-timeline-bar[data-booking-id]');
  if(!bar)return;
  event.preventDefault();
  event.stopPropagation();
  editBooking(bar.getAttribute('data-booking-id'));
});
document.addEventListener('keydown',function(event){
  const bar=event.target.closest('.fleet-timeline-bar[data-booking-id]');
  if(!bar||!(event.key==='Enter'||event.key===' '))return;
  event.preventDefault();
  event.stopPropagation();
  editBooking(bar.getAttribute('data-booking-id'));
});
$('bookForm').onsubmit=e=>{
  e.preventDefault();
  let customerId=$('bCust').value,start=$('bStart').value,end=$('bEnd').value,d=days(start,end),editId=$('bookEdit').value;
  if(!customerId||!d||d<1){alert('Periksa pelanggan dan tanggal booking.');return;}
  if(cust(customerId)?.status!=='Aktif'){alert('Pelanggan harus berstatus Aktif untuk booking.');return;}
  let cards=[...document.querySelectorAll('.booking-unit')];
  if(!cards.length){alert('Tambahkan minimal satu unit.');return;}
  let unitData=[];
  for(let card of cards){
    let carId=card.querySelector('.bu-car').value,c=car(carId),rate=rupiahInput(card.querySelector('.bu-rate').value);
    if(!carId||!c||rate<=0){alert('Lengkapi armada dan harga sewa setiap unit.');return;}
    if(!['Tersedia','Disewa'].includes(c.status)){alert('Armada '+carId+' tidak tersedia.');return;}
    let clash=db.bookings.some(b=>b.id!==editId&&start<=b.end&&end>=b.start&&bookingUnitsOf(b).some(u=>u.carId===carId));
    if(clash){alert('Jadwal armada '+carId+' bentrok dengan booking lain.');return;}
    let driver=db.drivers.find(x=>x.id===card.querySelector('.bu-driver').value),hasDriver=!!driver;
    let fee=hasDriver?rupiahInput(card.querySelector('.bu-driver-fee').value):0;
    let toll=hasDriver?rupiahInput(card.querySelector('.bu-toll').value):0;
    let fuel=hasDriver?rupiahInput(card.querySelector('.bu-fuel').value):0;
    let meal=hasDriver?rupiahInput(card.querySelector('.bu-meal').value):0;
    let lodging=hasDriver?rupiahInput(card.querySelector('.bu-lodging').value):0;
    let daily=rate+fee+toll+fuel+meal+lodging;
    let otherCost=rupiahInput(card.querySelector('.bu-other-cost')?.value||0),otherCostNote=String(card.querySelector('.bu-other-note')?.value||'').trim();
    unitData.push({carId,rate,driver,fee,toll,fuel,meal,lodging,daily,total:daily*d+otherCost,otherCost,otherCostNote,destination:card.querySelector('.bu-destination').value.trim(),destinationType:card.querySelector('.bu-destination-type').value,ownership:c.ownership||'sendiri',partnerId:c.partnerId||'',c});
  }
  let prior=editId?book(editId):null;
  let bookingId=editId||nextId(db.bookings,'BKG-');
  let units=unitData.map(u=>({
    carId:u.carId,ownership:u.ownership,partnerId:u.partnerId,rate:u.rate,total:u.total,partnerRate:Number(u.c.partnerRate||0),
    driverId:u.driver?.id||'',driverName:u.driver?.name||'',driverFeePerDay:u.fee,
    driverFee:d*u.fee,destination:u.destination,destinationType:u.destinationType,tollCost:d*u.toll,fuelCost:d*u.fuel,
    mealCost:d*u.meal,lodgingCost:d*u.lodging,tollPerDay:u.toll,fuelPerDay:u.fuel,
    mealPerDay:u.meal,lodgingPerDay:u.lodging,dailySubtotal:u.daily,otherCost:u.otherCost,otherCostNote:u.otherCostNote
  }));
  let first=units[0];
  let record={...(prior||{}),...first,id:bookingId,customerId,start,end,days:d,
    units,total:units.reduce((sum,u)=>sum+Number(u.total||0),0),
    created:prior?.created||new Date().toISOString()};
  if(editId){let ix=db.bookings.findIndex(x=>x.id===editId);db.bookings[ix]=record;}
  else db.bookings.push(record);
  resetBookingForm();save();alert(editId?'Booking berhasil diperbarui.':'Booking gabungan '+bookingId+' tersimpan untuk '+unitData.length+' mobil.');
};
let editingPaymentId=null;
function refreshPaymentEditOptions(){
  const q=String($('paymentEditSearch')?.value||'').trim().toLowerCase();
  const pick=$('paymentEditPick');if(!pick)return;
  const current=pick.value;
  const rows=[...db.payments].filter(p=>{
    const name=cust(p.customerId)?.nama||'';
    return [p.id,p.bookingId,p.customerId,name,p.date,p.amount].join(' ').toLowerCase().includes(q);
  }).sort((a,b)=>String(b.date||'').localeCompare(String(a.date||'')));
  pick.innerHTML='<option value="">Pilih transaksi...</option>'+rows.map(p=>`<option value="${esc(p.id)}">${esc(p.date||'')} • ${esc(cust(p.customerId)?.nama||p.customerId||'')} • ${esc(p.bookingId)} • ${money(p.amount)}</option>`).join('');
  if(rows.some(p=>p.id===current))pick.value=current;
}
function loadPaymentForEdit(){
  const id=$('paymentEditPick').value;
  const p=db.payments.find(x=>x.id===id);
  if(!p){alert('Pilih transaksi pembayaran yang akan diedit.');return}
  const b=book(p.bookingId);if(!b){alert('Booking terkait tidak ditemukan.');return}
  editingPaymentId=p.id;
  $('pBook').value=b.id;$('pBook').disabled=true;
  $('pAmount').value=p.amount;$('pDate').value=String(p.date||'').slice(0,10);
  updatePayForm();
  updatePayForm();
  $('payForm').querySelector('button[type="submit"]').textContent='Simpan Perubahan Pembayaran';
  $('paymentEditMode').textContent='Mode edit: '+p.id+' • '+p.bookingId;
  $('cancelPaymentEdit').classList.remove('hidden');
  updatePayForm();
}
function cancelPaymentEntry(){
  if(editingPaymentId){cancelPaymentEdit();return}
  paymentTargetBookingId='';
  $('pCustomer').disabled=false;
  $('pBook').disabled=false;
  $('pCustomer').value='';
  $('pBook').value='';
  $('pAmount').value='';
  $('pOtherCost').value='0';
  $('pOtherCostNote').value='';
  $('pOtherCostBooking').value='';
  $('pDate').value=new Date().toISOString().slice(0,10);
  $('pBookingEditDisplay').value='';
  $('pEditingBookingField').hidden=true;
  $('payForm').querySelector('button[type="submit"]').textContent='Catat Pembayaran';
  $('paymentEditHint')?.remove();
  refreshOtherCostBookingOptions();
  updatePayForm();
}
function cancelPaymentEdit(){
  editingPaymentId=null;
  $('pBook').disabled=false;
  $('pCustomer').disabled=false;
  [...$('pBook').options].filter(opt=>opt.dataset.editOnly==='1').forEach(opt=>opt.remove());
  $('pBook').value='';
  $('pBookingEditDisplay').value='';
  $('pEditingBookingField').hidden=true;
  $('pCustomer').value='';
  $('pAmount').value='';
  $('pOtherCost').value='0';$('pOtherCostNote').value='';$('pOtherCostBooking').value='';
  $('pDate').value=new Date().toISOString().slice(0,10);
  $('payForm').querySelector('button[type="submit"]').textContent='Catat Pembayaran';
  $('paymentEditHint')?.remove();
  const cancel=$('cancelPaymentEditBtn');if(cancel)cancel.classList.add('hidden');
  updatePayForm();
}

function outstandingBookingsForCustomer(cid){
  return db.bookings
    .filter(b=>String(b.customerId||'')===String(cid))
    .map(b=>({booking:b,paid:paid(b.id),remain:Math.max(0,Number(b.total||0)-paid(b.id))}))
    .filter(x=>x.remain>0)
    .sort((a,b)=>String(a.booking.start||'').localeCompare(String(b.booking.start||''))||String(a.booking.id).localeCompare(String(b.booking.id)));
}
let paymentTargetBookingId='';
function payFromBooking(bookingId){
  const b=book(bookingId);if(!b){alert('Booking tidak ditemukan.');return}
  const cid=String(b.customerId||'');
  const customerSelect=$('pCustomer');
  if(![...customerSelect.options].some(opt=>opt.value===cid)){
    const opt=document.createElement('option');opt.value=cid;
    opt.textContent=(cust(cid)?.nama||cid);customerSelect.appendChild(opt);
  }
  customerSelect.disabled=false;customerSelect.value=cid;
  paymentTargetBookingId=String(b.id);
  $('pOtherCostBooking').value=String(b.id);
  refreshOtherCostBookingOptions();
  $('pOtherCostBooking').value=String(b.id);
  $('pOtherCost').value='0';$('pOtherCostNote').value='';
  $('pAmount').value='';
  $('pDate').value=new Date().toISOString().slice(0,10);
  $('pBook').value=String(b.id);
  updatePayForm();
  document.querySelector('[data-tab="pembayaran"]')?.click();
  $('pAmount').scrollIntoView({behavior:'smooth',block:'center'});
}
function updatePayForm(){
  const editing=!!editingPaymentId;
  const selectedBooking=editing?book($('pBook').value):null;
  const currentPayment=db.payments.find(x=>x.id===editingPaymentId);
  const isEditingOther=!!(currentPayment&&String(currentPayment.bookingId||'').startsWith('BLY:'));
  const cid=editing?String(selectedBooking?.customerId||currentPayment?.customerId||$('pCustomer').value||''):String($('pCustomer').value||'');
  if(!cid){
    $('pCust').value='';$('pBill').value='';$('pStatus').value='';$('pRemain').value='';
    $('pBookingList').textContent='Pilih pelanggan untuk melihat daftar booking dan sisa tagihan.';
    return;
  }

  const allBookings=(db.bookings||[])
    .filter(b=>String(b.customerId||'')===cid)
    .filter(b=>!editing||String(b.id)===String(selectedBooking?.id||''))
    .filter(b=>editing||!paymentTargetBookingId||String(b.id)===paymentTargetBookingId)
    .sort((a,b)=>String(a.start||'').localeCompare(String(b.start||''))||String(a.id).localeCompare(String(b.id)));

  const otherCost=editing&&isEditingOther?0:Math.max(0,Number($('pOtherCost')?.value||0));
  const targetExtraBooking=String($('pOtherCostBooking')?.value||selectedBooking?.id||'');
  const detailRows=[];
  let total=0;

  allBookings.forEach(b=>{
    let paidBooking=paid(b.id);
    if(editing&&currentPayment&&!isEditingOther&&String(currentPayment.bookingId)===String(b.id)){
      paidBooking-=Number(currentPayment.amount||0);
    }
    const baseTotal=Number(b.total||0);
    const baseRemain=Math.max(0,baseTotal-paidBooking);

    const charges=(db.otherCharges||[]).filter(ch=>
      String(ch.customerId||'')===cid&&String(ch.bookingId||'')===String(b.id)
    ).map(ch=>{
      let paidCharge=paidOtherCharge(ch.id);
      if(editing&&currentPayment&&String(currentPayment.bookingId)==='BLY:'+String(ch.id)){
        paidCharge-=Number(currentPayment.amount||0);
      }
      return {charge:ch,remain:Math.max(0,Number(ch.amount||0)-paidCharge)};
    });
    const chargeTotal=charges.reduce((sum,x)=>sum+Number(x.charge.amount||0),0);
    const chargeRemain=charges.reduce((sum,x)=>sum+x.remain,0);
    const newChargeForThisBooking=(otherCost>0&&targetExtraBooking===String(b.id))?otherCost:0;
    const bookingBill=baseTotal+chargeTotal+newChargeForThisBooking;
    const bookingRemain=baseRemain+chargeRemain+newChargeForThisBooking;
    total+=bookingRemain;

    const lines=[
      `<div style="display:flex;justify-content:space-between;gap:12px"><span>Biaya sewa</span><strong>${money(baseTotal)}</strong></div>`,
      ...charges.map(x=>`<div style="display:flex;justify-content:space-between;gap:12px"><span>Biaya lain-lain · ${esc(x.charge.description||'Tanpa keterangan')}</span><strong>${money(x.charge.amount||0)}${x.remain<Number(x.charge.amount||0)?` <small style="opacity:.7">(sisa ${money(x.remain)})</small>`:''}</strong></div>`),
      ...(newChargeForThisBooking>0?[`<div style="display:flex;justify-content:space-between;gap:12px"><span>Biaya lain-lain baru · ${esc($('pOtherCostNote')?.value||'Tanpa keterangan')}</span><strong>${money(newChargeForThisBooking)}</strong></div>`]:[])
    ];
    if(bookingRemain>0||editing){
      detailRows.push(`<div style="border:1px solid #34445f;border-radius:9px;padding:12px;background:rgba(255,255,255,.025)">
        <div style="display:flex;justify-content:space-between;gap:10px;align-items:flex-start;margin-bottom:8px">
          <div><strong>${esc(b.id)}</strong><div style="font-size:12px;opacity:.8">Sewa ${formatDateDMY(b.start)}–${formatDateDMY(b.end)} · ${Number(b.days||0)} hari</div></div>
          <strong>${money(bookingBill)}</strong>
        </div>
        <div style="display:grid;gap:6px;font-size:13px">${lines.join('')}</div>
        <div style="display:flex;justify-content:space-between;gap:10px;border-top:1px solid #34445f;margin-top:9px;padding-top:8px">
          <strong>Sisa tagihan booking</strong><strong>${money(bookingRemain)}</strong>
        </div>
      </div>`);
    }
  });

  // Biaya baru tetap ditampilkan di bawah booking yang dipilih; tidak dibuat sebagai baris tagihan terpisah.
  if(otherCost>0&&!allBookings.some(b=>String(b.id)===targetExtraBooking)){
    total+=otherCost;
    detailRows.push(`<div class="notice">Pilih ID Booking yang sesuai agar biaya lain-lain masuk ke rincian booking.</div>`);
  }
  $('pCust').value=(cust(cid)?.nama||cid)+' ('+cid+')';
  $('pBill').value=money(total);
  $('pBookingList').innerHTML=detailRows.length?'<div style="display:grid;gap:9px">'+detailRows.join('')+'</div>':'Tidak ada booking yang memiliki sisa tagihan.';
  const entered=rupiahInput($('pAmount').value);
  $('pRemain').value=money(Math.max(0,total-entered));
  $('pStatus').value=total<=0?'Lunas':entered<=0?'Belum Bayar':entered>=total?'Lunas':'Kurang Bayar';
}

function refreshOtherCostBookingOptions(){
  const select=$('pOtherCostBooking');if(!select)return;
  const cid=String($('pCustomer').value||'');
  const previous=select.value;
  const list=(db.bookings||[]).filter(b=>String(b.customerId||'')===cid)
    .sort((a,b)=>String(a.start||'').localeCompare(String(b.start||'')));
  select.innerHTML='<option value="">Pilih ID Booking</option>'+list.map(b=>`<option value="${esc(b.id)}">${esc(b.id)} · ${formatDateDMY(b.start)}–${formatDateDMY(b.end)}</option>`).join('');
  if(list.some(b=>String(b.id)===previous))select.value=previous;
}
$('pCustomer').onchange=()=>{
  if(editingPaymentId) return;
  paymentTargetBookingId='';
  $('pBook').value='';
  refreshOtherCostBookingOptions();
  updatePayForm();
};
$('pAmount').oninput=updatePayForm;
$('pOtherCost').oninput=updatePayForm;
$('pOtherCostNote').oninput=updatePayForm;
$('pOtherCostBooking').onchange=updatePayForm;
$('payForm').onsubmit=e=>{
  e.preventDefault();
  const amount=rupiahInput($('pAmount').value);
  if(amount<0||(!editingPaymentId&&amount<=0)){alert(editingPaymentId?'Nominal pembayaran tidak boleh negatif. Untuk mengosongkan pembayaran, masukkan 0.':'Masukkan nominal pembayaran lebih dari 0.');return}
  if(!$('pDate').value){alert('Tanggal pembayaran wajib diisi.');return}
  const date=$('pDate').value;
  if(editingPaymentId){
    const old=db.payments.find(x=>x.id===editingPaymentId);
    if(!old){alert('Transaksi pembayaran yang diedit tidak ditemukan.');return}
    const isOther=String(old.bookingId||'').startsWith('BLY:');
    if(isOther){
      const chargeId=String(old.bookingId).slice(4);
      const charge=(db.otherCharges||[]).find(x=>String(x.id)===chargeId);
      if(!charge){alert('Biaya lain-lain terkait tidak ditemukan.');return}
      const paidExcludingThis=paidOtherCharge(chargeId)-Number(old.amount||0);
      const remain=Math.max(0,Number(charge.amount||0)-paidExcludingThis);
      if(amount>remain){alert('Nominal pembayaran melebihi sisa biaya lain-lain '+money(remain));return}
      old.amount=amount;old.date=date;
      const paidAfterEdit=paidExcludingThis+amount;old.status=paidAfterEdit<=0?'Belum Bayar':paidAfterEdit>=Number(charge.amount||0)?'Lunas':'Kurang Bayar';
      if($('pOtherCostBooking').value)charge.bookingId=String($('pOtherCostBooking').value);
      const editedChargeAmount=Math.max(0,Number($('pOtherCost').value||0));
      if(editedChargeAmount>0)charge.amount=editedChargeAmount;
      charge.description=String($('pOtherCostNote').value||charge.description||'').trim();
    }else{
      const b=book(old.bookingId);
      if(!b){alert('Booking terkait tidak ditemukan.');return}
      const paidExcludingThis=paid(b.id)-Number(old.amount||0);
      const remain=Math.max(0,Number(b.total||0)-paidExcludingThis);
      if(amount>remain){alert('Pembayaran melebihi sisa tagihan booking '+money(remain));return}
      old.amount=amount;old.date=date;
      const paidAfterEdit=paidExcludingThis+amount;old.status=paidAfterEdit<=0?'Belum Bayar':paidAfterEdit>=Number(b.total||0)?'Lunas':'Kurang Bayar';
    }
    const extraCost=String(old.bookingId||'').startsWith('BLY:')?0:Math.max(0,Number($('pOtherCost').value||0));
    if(extraCost>0&&!$('pOtherCostBooking').value){alert('Pilih ID Booking untuk biaya lain-lain.');return}
    if(extraCost>0){
      db.otherCharges=db.otherCharges||[];
      db.otherCharges.push({id:nextId(db.otherCharges,'BLY-'),customerId:String(old.customerId||$('pCustomer').value||''),bookingId:String($('pOtherCostBooking').value||''),date,amount:extraCost,description:String($('pOtherCostNote').value||'').trim()||'Biaya lain-lain dari edit riwayat pembayaran'});
    }
    cancelPaymentEdit();save();return;
  }
  const cid=String($('pCustomer').value||'');
  if(!cid){alert('Pilih pelanggan terlebih dahulu.');return}
  const rows=outstandingBookingsForCustomer(cid).filter(x=>!paymentTargetBookingId||String(x.booking.id)===paymentTargetBookingId);
  const oldCharges=outstandingOtherChargesForCustomer(cid).filter(x=>!paymentTargetBookingId||String(x.charge.bookingId||'')===paymentTargetBookingId);
  const otherCost=Math.max(0,Number($('pOtherCost').value||0));
  const total=rows.reduce((s,x)=>s+x.remain,0)+oldCharges.reduce((s,x)=>s+x.remain,0)+otherCost;
  if(otherCost>0&&!$('pOtherCostBooking').value){alert('Pilih ID Booking untuk biaya lain-lain.');return}
  if(!rows.length&&!oldCharges.length&&otherCost<=0){alert('Pelanggan ini tidak memiliki tagihan.');return}
  if(amount>total){alert('Nominal pembayaran melebihi total sisa tagihan '+money(total));return}
  let allocation=amount;
  rows.forEach(x=>{
    if(allocation<=0)return;
    const part=Math.min(allocation,x.remain);
    if(part>0){
      const newPaid=x.paid+part;
      db.payments.push({id:nextId(db.payments,'BYR-'),bookingId:x.booking.id,customerId:cid,amount:part,status:newPaid>=Number(x.booking.total||0)?'Lunas':'Kurang Bayar',date});
      allocation-=part;
    }
  });
  // Pembayaran berikutnya dialokasikan ke biaya lain-lain lama, kemudian biaya baru.
  oldCharges.forEach(x=>{
    if(allocation<=0)return;
    const part=Math.min(allocation,x.remain);
    if(part>0){
      db.payments.push({id:nextId(db.payments,'BYR-'),bookingId:'BLY:'+x.charge.id,customerId:cid,amount:part,status:x.paid+part>=Number(x.charge.amount||0)?'Lunas':'Kurang Bayar',date});
      allocation-=part;
    }
  });
  let newCharge=null;
  if(otherCost>0){
    db.otherCharges=db.otherCharges||[];
    newCharge={id:nextId(db.otherCharges,'BLY-'),customerId:cid,bookingId:String($('pOtherCostBooking').value||''),date,amount:otherCost,description:String($('pOtherCostNote').value||'').trim()||'Biaya lain-lain dari pencatatan pembayaran'};
    db.otherCharges.push(newCharge);
    if(allocation>0){
      const part=Math.min(allocation,otherCost);
      db.payments.push({id:nextId(db.payments,'BYR-'),bookingId:'BLY:'+newCharge.id,customerId:cid,amount:part,status:part>=otherCost?'Lunas':'Kurang Bayar',date});
      allocation-=part;
    }
  }
  const allocated=amount-allocation;
  $('pAmount').value='';
  $('pOtherCost').value='0'; $('pOtherCostNote').value='';
  save();
  $('pCustomer').value=outstandingBookingsForCustomer(cid).length?cid:'';
  updatePayForm();
  alert('Pembayaran berhasil dicatat. Pembayaran dialokasikan ke booking dan biaya lain-lain sesuai urutan tagihan. Total dialokasikan: '+money(allocated));
};
$('pDate').value=new Date().toISOString().slice(0,10);
$('eDate').value=new Date().toISOString().slice(0,10);
$('expenseForm').onsubmit=e=>{e.preventDefault();let amount=rupiahInput($('eAmount').value);if(amount<=0)return;db.expenses=db.expenses||[];db.expenses.push({id:nextId(db.expenses,'EXP-'),date:$('eDate').value,category:$('eCategory').value,amount,note:$('eNote').value.trim(),carId:$('eCar').value,created:new Date().toISOString()});$('expenseForm').reset();$('eDate').value=new Date().toISOString().slice(0,10);save();alert('Pengeluaran berhasil dicatat.')};

function selectPaymentForEdit(box){
  if(!box.checked){
    if(editingPaymentId===box.value)cancelPaymentEdit();
    return;
  }
  document.querySelectorAll('.payment-history-check').forEach(other=>{
    if(other!==box)other.checked=false;
  });
  const p=db.payments.find(x=>x.id===box.value);
  if(!p){alert('Data pembayaran tidak ditemukan.');box.checked=false;return}
  const b=book(p.bookingId);
  if(!b){alert('Booking terkait tidak ditemukan.');box.checked=false;return}
  editingPaymentId=p.id;
  const bookingSelect=$('pBook');
  if(![...bookingSelect.options].some(opt=>opt.value===String(b.id))){
    const opt=document.createElement('option');
    opt.value=b.id;
    opt.textContent=(cust(b.customerId)?.nama||b.customerId)+' / '+b.id+' (riwayat pembayaran)';
    opt.dataset.editOnly='1';
    bookingSelect.appendChild(opt);
  }
  bookingSelect.value=String(b.id);
  bookingSelect.disabled=false;
  updatePayForm();
  bookingSelect.disabled=true;
  $('pCustomer').disabled=true;
  $('pAmount').value=Number(p.amount||0);
  $('pDate').value=String(p.date||'').slice(0,10);
  const submit=$('payForm').querySelector('button[type="submit"]');
  submit.textContent='Simpan Perubahan Pembayaran';$('cancelPaymentEditBtn').classList.remove('hidden');
  $('pStatus').value=p.status||statusBook(b);
  $('paymentEditHint')?.remove();
  const hint=document.createElement('div');hint.id='paymentEditHint';hint.className='notice';
  hint.textContent='Mode edit: '+p.id+' — ubah tanggal atau nominal, lalu klik Simpan Perubahan Pembayaran.';
  $('payForm').prepend(hint);
}
function cancelPaymentEdit(){
  editingPaymentId=null;
  $('pBook').disabled=false;
  $('pCustomer').disabled=false;
  [...$('pBook').options].filter(opt=>opt.dataset.editOnly==='1').forEach(opt=>opt.remove());
  $('pBook').value='';
  $('pCustomer').value='';
  $('pAmount').value='';
  $('pDate').value=new Date().toISOString().slice(0,10);
  $('payForm').querySelector('button[type="submit"]').textContent='Catat Pembayaran';
  $('paymentEditHint')?.remove();
  const cancel=$('cancelPaymentEditBtn');if(cancel)cancel.classList.add('hidden');
  document.querySelectorAll('.payment-history-check').forEach(box=>box.checked=false);
  updatePayForm();
}
function togglePaymentCustomer(master){
  const cid=master.dataset.customer;
  document.querySelectorAll('.payment-history-check').forEach(box=>{
    if(box.dataset.customer===cid)box.checked=master.checked;
  });
}
function printLatestPaymentForSelectedBooking(){
  const bookingId=$('pBook').value;
  if(!bookingId){alert('Pilih booking terlebih dahulu.');return}
  const latest=db.payments.filter(p=>p.bookingId===bookingId).sort((a,b)=>String(b.date||'').localeCompare(String(a.date||'')))[0];
  if(!latest){alert('Belum ada pembayaran untuk booking ini. Catat pembayaran terlebih dahulu.');return}
  printPaymentNote(latest.id);
}
function printSelectedPaymentNotesForCustomer(cid){
  const ids=[...document.querySelectorAll('.payment-history-check:checked')].filter(box=>box.dataset.customer===cid).map(box=>box.value);
  if(!ids.length){alert('Pilih minimal satu riwayat pembayaran pelanggan ini.');return}
  ids.forEach((id,index)=>setTimeout(()=>printPaymentNote(id),index*900));
}

function printCustomerPaymentNote(cid){
  const items=db.payments.filter(p=>String(p.customerId||book(p.bookingId)?.customerId||'')===String(cid))
    .sort((a,b)=>String(a.date||'').localeCompare(String(b.date||'')));
  if(!items.length){alert('Belum ada riwayat pembayaran untuk pelanggan ini.');return}
  const c=cust(cid)||{};
  const bookingIds=[...new Set(items.map(p=>p.bookingId))];
  const totalPaid=items.reduce((s,p)=>s+Number(p.amount||0),0);
  const totalBill=bookingIds.reduce((s,id)=>s+Number(book(id)?.total||0),0);
  const totalOutstanding=bookingIds.reduce((s,id)=>s+Math.max(0,Number(book(id)?.total||0)-paid(id)),0);
  const rows=items.map(p=>{
    const b=book(p.bookingId)||{};
    return `<tr>
      <td>${formatDateDMY(p.date)}</td>
      <td>${formatDateDMY(b.start)}</td>
      <td>${formatDateDMY(b.end)}</td>
      <td>${Number(b.days||0)} hari</td>
      <td>${esc([...new Set(bookingUnitsOf(b).map(u=>String(u.destination||'').trim()).filter(Boolean))].join(', ')||'-')}</td>
      <td>${esc(bookingUnitsOf(b).map(u=>{const a=car(u.carId)||{};return (a.jenis||u.carId||'-')+' ('+(a.plat||'-')+')'}).join(', ')||'-')}</td>
      <td style="text-align:right">${money(p.amount)}</td>
    </tr>`;
  }).join('');
  const receipt=`<div style="max-width:780px;margin:20px auto;padding:28px;border:1px solid #ddd;font:13px Arial;color:#172033">
    <div style="display:flex;justify-content:space-between;border-bottom:3px solid #b18a3b;padding-bottom:14px">
      <div><h2 style="margin:0;color:#17243a">ALFA PRIMA RENTCAR</h2><div style="font-size:11px;margin-top:5px">Rekap Bukti Pembayaran Pelanggan</div></div>
      <div style="text-align:right;font-size:11px;line-height:1.5">Harmony Residence C16, Sendang Mulyo,<br>Tembalang, Semarang<br>WhatsApp: 081226611507</div>
    </div>
    <h2 style="text-align:center;margin:22px 0">NOTA PEMBAYARAN</h2>
    <table style="width:100%;border-collapse:collapse;margin-bottom:18px">
      <tr><td style="padding:7px">Nama Pelanggan</td><td style="padding:7px"><b>${esc(c.nama||'-')}</b></td></tr>
      <tr><td style="padding:7px">No. WhatsApp</td><td style="padding:7px">${esc(c.wa||'-')}</td></tr>
      <tr><td style="padding:7px">Jumlah Booking</td><td style="padding:7px">${bookingIds.length}</td></tr>
    </table>
    <table style="width:100%;border-collapse:collapse;margin:12px 0">
      <thead><tr style="background:#f1eee7"><th style="padding:8px;text-align:left">Tanggal Bayar</th><th style="padding:8px;text-align:left">Awal Sewa</th><th style="padding:8px;text-align:left">Akhir Sewa</th><th style="padding:8px;text-align:left">Lama Sewa</th><th style="padding:8px;text-align:left">Tujuan</th><th style="padding:8px;text-align:left">Armada</th><th style="padding:8px;text-align:right">Pembayaran</th></tr></thead>
      <tbody>${rows}</tbody>
    </table>
    <table style="width:100%;border-collapse:collapse;margin-top:18px">
      <tr><td style="padding:8px">Total Tagihan Seluruh Booking</td><td style="padding:8px;text-align:right">${money(totalBill)}</td></tr>
      <tr><td style="padding:8px">Total Pembayaran Diterima</td><td style="padding:8px;text-align:right;font-weight:bold">${money(totalPaid)}</td></tr>
      <tr><td style="padding:8px;font-weight:bold;border-top:2px solid #b18a3b">Total Sisa Tagihan</td><td style="padding:8px;text-align:right;font-weight:bold;border-top:2px solid #b18a3b">${money(totalOutstanding)}</td></tr>
    </table>
    <div style="display:flex;justify-content:space-between;align-items:flex-end;gap:18px;margin-top:38px">
      <div style="font-size:11px;text-align:center;width:100%;margin:0 auto">Terimakasih atas kepercayaan anda telah menggunakan jasa ALFAPRIMArentcar</div>
      <div style="width:180px;text-align:center;font-size:11px">Hormat kami,<br><b>ALFA PRIMA RENTCAR</b><div style="height:48px"></div><div style="border-top:1px solid #333;padding-top:6px"><b>Alfa Prima</b><br>Pemilik</div></div>
    </div></div>`;
  const w=window.open('','_blank');
  if(!w){alert('Izinkan pop-up browser untuk mencetak nota.');return}
  w.document.write('<html><head><title>Nota Pembayaran - '+esc(c.nama||cid)+'</title><style>@page{size:A4 portrait;margin:12mm}body{margin:0}table th,table td{border-bottom:1px solid #ddd}</style><' + '/head><body>'+receipt+'<' + '/body><' + '/html>');
  w.document.close();w.onload=()=>{w.focus();w.print()};setTimeout(()=>{w.focus();w.print()},700);
}
function printPaymentNote(id){
  const p=db.payments.find(x=>x.id===id);
  if(!p){alert('Data pembayaran tidak ditemukan.');return}
  const b=book(p.bookingId)||{};
  const c=cust(p.customerId||b.customerId)||{};
  const carInfo=bookingUnitsOf(b).map(u=>{
    const a=car(u.carId)||{};
    return `<tr><td>${esc(a.jenis||'-')}</td><td>${esc(a.plat||'-')}</td><td>${esc(u.destination||'-')}</td></tr>`;
  }).join('');
  const paidTotal=paid(p.bookingId);
  const remaining=Math.max(0,Number(b.total||0)-paidTotal);
  const status=remaining<=0?'LUNAS':(paidTotal>0?'KURANG BAYAR':'BELUM BAYAR');
  const receipt=`<div style="max-width:720px;margin:20px auto;padding:28px;border:1px solid #ddd;font:13px Arial;color:#172033">
    <div style="display:flex;justify-content:space-between;border-bottom:3px solid #b18a3b;padding-bottom:14px">
      <div><h2 style="margin:0;color:#17243a">ALFA PRIMA RENTCAR</h2><div style="font-size:11px;margin-top:5px">Bukti Penerimaan Pembayaran</div></div>
      <div style="text-align:right;font-size:11px;line-height:1.5">Harmony Residence C16, Sendang Mulyo,<br>Tembalang, Semarang<br>WhatsApp: 081226611507</div>
    </div>
    <h2 style="text-align:center;margin:22px 0">NOTA PEMBAYARAN</h2>
    <table style="width:100%;border-collapse:collapse;margin-bottom:18px">
      <tr><td style="padding:7px;width:35%">Tanggal Pembayaran</td><td style="padding:7px"><b>${formatDateDMY(p.date)}</b></td></tr>
      <tr><td style="padding:7px">Pelanggan</td><td style="padding:7px"><b>${esc(c.nama||'')}</b></td></tr>
      <tr><td style="padding:7px">No. WhatsApp</td><td style="padding:7px">${esc(c.wa||'-')}</td></tr>
      <tr><td style="padding:7px">Awal Sewa</td><td style="padding:7px">${formatDateDMY(b.start)}</td></tr>
      <tr><td style="padding:7px">Akhir Sewa</td><td style="padding:7px">${formatDateDMY(b.end)}</td></tr>
      <tr><td style="padding:7px">Lama Sewa</td><td style="padding:7px"><b>${Number(b.days||0)} hari</b></td></tr>
      <tr><td style="padding:7px">Tujuan</td><td style="padding:7px">${esc([...new Set(bookingUnitsOf(b).map(u=>String(u.destination||'').trim()).filter(Boolean))].join(', ')||'-')}</td></tr>
    </table>
    <table style="width:100%;border-collapse:collapse;margin:12px 0">
      <thead><tr style="background:#f1eee7"><th style="padding:8px;text-align:left">Armada</th><th style="padding:8px;text-align:left">No. Polisi</th><th style="padding:8px;text-align:left">Tujuan</th></tr></thead>
      <tbody>${carInfo}</tbody>
    </table>
    <table style="width:100%;border-collapse:collapse;margin-top:20px">
      <tr><td style="padding:8px">Total Tagihan Booking</td><td style="padding:8px;text-align:right">${money(b.total||0)}</td></tr>
      <tr><td style="padding:8px">Pembayaran Diterima (nota ini)</td><td style="padding:8px;text-align:right;font-weight:bold">${money(p.amount)}</td></tr>
      <tr><td style="padding:8px">Total Pembayaran Terkumpul</td><td style="padding:8px;text-align:right">${money(paidTotal)}</td></tr>
      <tr><td style="padding:8px;font-weight:bold;border-top:2px solid #b18a3b">Sisa Tagihan</td><td style="padding:8px;text-align:right;font-weight:bold;border-top:2px solid #b18a3b">${money(remaining)}</td></tr>
      <tr><td style="padding:8px">Status</td><td style="padding:8px;text-align:right;font-weight:bold">${status}</td></tr>
    </table>
    <div style="display:flex;justify-content:space-between;align-items:flex-end;gap:18px;margin-top:38px">
      <div style="font-size:11px;text-align:center;width:100%;margin:0 auto">Terimakasih atas kepercayaan anda telah menggunakan jasa ALFAPRIMArentcar</div>
      <div style="width:180px;text-align:center;font-size:11px">Hormat kami,<br><b>ALFA PRIMA RENTCAR</b><div style="height:48px"></div><div style="border-top:1px solid #333;padding-top:6px"><b>Alfa Prima</b><br>Pemilik</div></div>
    </div></div>`;
  const w=window.open('','_blank');
  if(!w){alert('Izinkan pop-up browser untuk mencetak nota.');return}
  w.document.write('<html><head><title>Nota Pembayaran</title><style>@page{size:A4 portrait;margin:12mm}body{margin:0}</style><' + '/head><body>'+receipt+'<' + '/body><' + '/html>');
  w.document.close();w.onload=()=>{w.focus();w.print()};setTimeout(()=>{w.focus();w.print()},700);
}
function deletePayment(id){
  if(currentUser?.role!=='admin'){alert('Hanya admin yang dapat menghapus pembayaran.');return}
  const p=db.payments.find(x=>x.id===id);
  if(!p)return;
  if(!confirm('Hapus catatan pembayaran '+id+' sebesar '+money(p.amount)+'? Status dan sisa tagihan booking akan dihitung ulang.'))return;
  db.payments=db.payments.filter(x=>x.id!==id);
  save();
  alert('Catatan pembayaran berhasil dihapus.');
}
function editPayment(id){
  if(currentUser?.role!=='admin'){alert('Hanya admin yang dapat mengedit pembayaran.');return}
  const p=db.payments.find(x=>x.id===id);if(!p)return;
  editingPaymentId=p.id;
  const isOther=String(p.bookingId||'').startsWith('BLY:');
  let cid=String(p.customerId||'');
  let b=null, charge=null;
  if(isOther){
    const chargeId=String(p.bookingId).slice(4);
    charge=(db.otherCharges||[]).find(x=>String(x.id)===chargeId);
    if(!charge){alert('Data biaya lain-lain terkait pembayaran tidak ditemukan.');editingPaymentId=null;return}
  }else{
    b=book(p.bookingId);
    if(!b){alert('Booking terkait tidak ditemukan.');editingPaymentId=null;return}
    cid=String(b.customerId||cid);
  }
  const customerSelect=$('pCustomer');
  if(![...customerSelect.options].some(opt=>opt.value===cid)){
    const opt=document.createElement('option');opt.value=cid;
    opt.textContent=(cust(cid)?.nama||cid);customerSelect.appendChild(opt);
  }
  customerSelect.value=cid;customerSelect.disabled=true;
  refreshOtherCostBookingOptions();
  const bookingSelect=$('pBook');
  bookingSelect.disabled=false;
  if(b){
    if(![...bookingSelect.options].some(opt=>opt.value===String(b.id))){
      const opt=document.createElement('option');opt.value=b.id;
      opt.textContent=(cust(cid)?.nama||cid)+' / '+b.id+' (riwayat)';
      opt.dataset.editOnly='1';bookingSelect.appendChild(opt);
    }
    bookingSelect.value=String(b.id);
    $('pBookingEditDisplay').value=String(b.id);
    $('pEditingBookingField').hidden=false;
  }else{
    const relatedBooking=book(charge.bookingId);
    if(relatedBooking){
      if(![...bookingSelect.options].some(opt=>opt.value===String(relatedBooking.id))){
        const opt=document.createElement('option');opt.value=relatedBooking.id;
        opt.textContent=(cust(cid)?.nama||cid)+' / '+relatedBooking.id+' (riwayat)';
        opt.dataset.editOnly='1';bookingSelect.appendChild(opt);
      }
      bookingSelect.value=String(relatedBooking.id);
      $('pBookingEditDisplay').value=String(relatedBooking.id)+' · Biaya '+charge.id;
    }else{
      bookingSelect.value='';
      $('pBookingEditDisplay').value='Biaya lain-lain: '+charge.id+' (belum terkait booking)';
    }
    $('pEditingBookingField').hidden=false;
  }
  updatePayForm();
  bookingSelect.disabled=true;
  $('pAmount').value=Number(p.amount||0);
  $('pDate').value=String(p.date||'').slice(0,10);
  $('pOtherCost').value=isOther?Number(charge.amount||0):0;
  $('pOtherCostNote').value=isOther?String(charge.description||''):'';
  $('pOtherCostBooking').value=isOther?String(charge.bookingId||''):String(b?.id||'');
  if(isOther){
    const total=Number(charge.amount||0);
    const paidExcludingThis=paidOtherCharge(charge.id)-Number(p.amount||0);
    $('pBill').value=money(total);
    $('pRemain').value=money(Math.max(0,total-paidExcludingThis-Number(p.amount||0)));
    $('pStatus').value=(paidExcludingThis+Number(p.amount||0))>=total?'Lunas':'Kurang Bayar';
  }else{
    const total=Number(b.total||0);
    const paidExcludingThis=paid(b.id)-Number(p.amount||0);
    $('pBill').value=money(total);
    $('pRemain').value=money(Math.max(0,total-paidExcludingThis-Number(p.amount||0)));
    $('pStatus').value=(paidExcludingThis+Number(p.amount||0))>=total?'Lunas':'Kurang Bayar';
  }
  $('payForm').querySelector('button[type="submit"]').textContent='Simpan Perubahan Pembayaran';
  $('paymentEditHint')?.remove();
  const hint=document.createElement('div');hint.id='paymentEditHint';hint.className='notice';
  hint.textContent='Mode edit: '+p.id+'. Data pelanggan, booking/biaya terkait, nominal, tanggal, dan status ditampilkan pada kolom pencatatan pembayaran. Ubah nominal atau tanggal, lalu simpan.';
  $('payForm').prepend(hint);
  const cancel=$('cancelPaymentEditBtn');if(cancel)cancel.classList.remove('hidden');
  document.querySelector('[data-tab="pembayaran"]')?.click();
  $('pAmount').scrollIntoView({behavior:'smooth',block:'center'});
}

function delExpense(id){if(currentUser?.role!=='admin'){alert('Hanya admin yang dapat menghapus data.');return}if(confirm('Hapus catatan pengeluaran '+id+'?')){db.expenses=(db.expenses||[]).filter(x=>x.id!==id);save()}}
function delBooking(id){
  if(currentUser?.role!=='admin'){alert('Hanya admin yang dapat menghapus booking.');return}
  const b=book(id);
  if(!b){alert('Booking tidak ditemukan.');return}
  const linkedPayments=db.payments.filter(p=>p.bookingId===id);
  let message='Hapus booking '+id+'?';
  if(linkedPayments.length){
    message+='\n\nPerhatian: '+linkedPayments.length+' catatan pembayaran terkait juga akan dihapus dari database.';
  }
  message+='\nTindakan ini tidak dapat dibatalkan. Pastikan Anda sudah memeriksa transaksi.';
  if(!confirm(message))return;
  db.bookings=db.bookings.filter(x=>x.id!==id);
  db.payments=db.payments.filter(x=>x.bookingId!==id);
  save();
  alert('Booking '+id+' berhasil dihapus dari database MySQL.');
}
function resetDriver(){$('driverForm').reset();$('driverEdit').value='';$('driverTitle').textContent='Tambah Driver'}
$('driverForm').onsubmit=e=>{e.preventDefault();let id=$('driverEdit').value||nextId(db.drivers,'DRV-');let row={id,name:$('dName').value.trim(),wa:$('dWa').value.trim(),address:$('dAddress').value.trim(),license:$('dLicense').value.trim(),status:$('dStatus').value};let ix=db.drivers.findIndex(x=>x.id===id);ix<0?db.drivers.push(row):db.drivers[ix]=row;resetDriver();save()};
function editDriver(id){let d=db.drivers.find(x=>x.id===id);if(!d)return;$('driverEdit').value=d.id;$('dName').value=d.name||'';$('dWa').value=d.wa||'';$('dAddress').value=d.address||'';$('dLicense').value=d.license||'';$('dStatus').value=d.status||'Aktif';$('driverTitle').textContent='Edit Driver '+id;document.querySelector('[data-tab="driver"]').click();window.scrollTo(0,0)}
function deleteDriver(id){if(currentUser?.role!=='admin')return;if(db.bookings.some(b=>b.driverId===id)){alert('Driver sudah terhubung dengan booking. Ubah status menjadi Nonaktif.');return}if(confirm('Hapus driver '+id+'?')){db.drivers=db.drivers.filter(x=>x.id!==id);save()}}
$('mpDate').value=new Date().toISOString().slice(0,10);$('jDate').value=new Date().toISOString().slice(0,10);
$('partnerForm').onsubmit=e=>{e.preventDefault();db.partners.push({id:nextId(db.partners,'MTR-'),name:$('mName').value.trim(),wa:$('mWa').value.trim(),address:$('mAddress').value.trim(),bank:$('mBank').value.trim(),accountNo:$('mAccount').value.trim(),accountName:$('mAccountName').value.trim()});$('partnerForm').reset();save()};
$('partnerPayForm').onsubmit=e=>{e.preventDefault();let m=db.partners.find(x=>String(x.id)===String($('mpPartner').value)),amount=rupiahInput($('mpAmount').value);if(!m||amount<=0){alert('Pilih mitra dan masukkan nominal pembayaran.');return}const bookings=(db.bookings||[]).filter(b=>partnerUnitsForBooking(b,m.id).length>0).sort((a,b)=>String(a.start||'').localeCompare(String(b.start||'')));let remaining=amount;const allocations=bookings.map(b=>{const bill=partnerBillForBooking(b,m.id);const already=(db.partnerPayments||[]).filter(p=>String(p.partnerId)===String(m.id)&&String(p.bookingId)===String(b.id)).reduce((sum,p)=>sum+Number(p.amount||0),0);return {b,outstanding:Math.max(0,bill-already)}}).filter(x=>x.outstanding>0);const totalOutstanding=allocations.reduce((sum,x)=>sum+x.outstanding,0);if(!bookings.length){alert('Mitra ini belum memiliki booking.');return}if(amount>totalOutstanding){alert('Nominal pembayaran melebihi sisa tagihan mitra sebesar '+money(totalOutstanding)+'.');return}const records=[];for(const x of allocations){if(remaining<=0)break;const part=Math.min(remaining,x.outstanding);if(part>0){records.push({id:nextId([...db.partnerPayments,...records],'PMT-'),bookingId:x.b.id,partnerId:m.id,date:$('mpDate').value,amount:part,status:'Dibayar',note:$('mpNote').value});remaining-=part}}db.partnerPayments.push(...records);$('partnerPayForm').reset();$('mpDate').value=new Date().toISOString().slice(0,10);save()};
$('mpPartner').onchange=()=>renderPartnerPaymentSection();
$('journalForm').onsubmit=e=>{e.preventDefault();let amount=rupiahInput($('jAmount').value);if(amount<=0||$('jDebit').value===$('jCredit').value){alert('Nominal harus positif dan akun debit/kredit harus berbeda.');return}db.journals.push({id:nextId(db.journals,'JRN-'),date:$('jDate').value,note:$('jNote').value,debitAccount:$('jDebit').value,creditAccount:$('jCredit').value,amount,source:'Manual',reference:''});$('journalForm').reset();$('jDate').value=new Date().toISOString().slice(0,10);save()};
function partnerUnitsForBooking(b,partnerId){
 return bookingUnitsOf(b).map(u=>{const a=car(u.carId)||{};const ownership=u.ownership||a.ownership||'sendiri';const pid=u.partnerId||a.partnerId||'';const daily=Number(u.partnerRate??a.partnerRate??b.partnerRate??0);return {u,a,pid,ownership,daily,cost:daily*Number(b.days||0)}}).filter(x=>x.ownership==='mitra'&&String(x.pid)===String(partnerId));
}
function partnerBillForBooking(b,partnerId){return partnerUnitsForBooking(b,partnerId).reduce((sum,x)=>sum+x.cost,0)}
function payPartnerGroup(partnerId){
 const m=(db.partners||[]).find(x=>String(x.id)===String(partnerId));
 if(!m){alert('Data mitra tidak ditemukan.');return;}
 const allocations=(db.bookings||[]).slice().sort((a,b)=>String(a.start||'').localeCompare(String(b.start||''))).map(b=>{
   const bill=partnerBillForBooking(b,partnerId);
   const paid=(db.partnerPayments||[]).filter(p=>String(p.partnerId)===String(partnerId)&&String(p.bookingId)===String(b.id)).reduce((sum,p)=>sum+Number(p.amount||0),0);
   return {b,outstanding:Math.max(0,bill-paid)};
 }).filter(x=>x.outstanding>0);
 const totalOutstanding=allocations.reduce((sum,x)=>sum+x.outstanding,0);
 if(totalOutstanding<=0){alert('Pembayaran mitra '+m.name+' sudah dibayar lunas.');return;}
 const raw=prompt('Pembayaran untuk mitra '+m.name+'\nTotal sisa tagihan: '+money(totalOutstanding)+'\nMasukkan nominal pembayaran:',String(totalOutstanding));
 if(raw===null)return;
 const amount=rupiahInput(raw);
 if(!Number.isFinite(amount)||amount<=0){alert('Nominal pembayaran harus lebih dari 0.');return;}
 if(amount>totalOutstanding){alert('Nominal melebihi sisa tagihan '+money(totalOutstanding)+'.');return;}
 const date=($('mpDate')?.value)||new Date().toISOString().slice(0,10);
 let remaining=amount;const records=[];
 for(const item of allocations){
   if(remaining<=0)break;
   const part=Math.min(remaining,item.outstanding);
   if(part>0){records.push({id:nextId([...(db.partnerPayments||[]),...records],'PMT-'),bookingId:item.b.id,partnerId:m.id,date,amount:part,status:'Dibayar',note:'Pembayaran dari Daftar Booking Armada Mitra'});remaining-=part;}
 }
 db.partnerPayments=db.partnerPayments||[];
 db.partnerPayments.push(...records);
 save();
}
function payPartnerBooking(partnerId,bookingId,maxAmount){
 const m=(db.partners||[]).find(x=>String(x.id)===String(partnerId));
 const b=(db.bookings||[]).find(x=>String(x.id)===String(bookingId));
 if(!m||!b){alert('Data mitra atau booking tidak ditemukan.');return}
 const bill=partnerBillForBooking(b,partnerId);
 const already=(db.partnerPayments||[]).filter(p=>String(p.partnerId)===String(partnerId)&&String(p.bookingId)===String(bookingId)).reduce((sum,p)=>sum+Number(p.amount||0),0);
 const outstanding=Math.max(0,bill-already);
 if(outstanding<=0){alert('Booking ini sudah lunas.');return}
 const raw=prompt('Pembayaran untuk '+m.name+' — Booking '+b.id+'\\nSisa tagihan: '+money(outstanding)+'\\nMasukkan nominal pembayaran:',String(outstanding));
 if(raw===null)return;
 const amount=rupiahInput(raw);
 if(!Number.isFinite(amount)||amount<=0){alert('Nominal pembayaran harus lebih dari 0.');return}
 if(amount>outstanding){alert('Nominal melebihi sisa tagihan booking sebesar '+money(outstanding)+'.');return}
 const dateEl=$('mpDate');
 const date=(dateEl&&dateEl.value)||new Date().toISOString().slice(0,10);
 db.partnerPayments=db.partnerPayments||[];
 db.partnerPayments.push({id:nextId(db.partnerPayments,'PMT-'),bookingId:b.id,partnerId:m.id,date,amount,status:'Dibayar',note:'Pembayaran dari Daftar Tagihan Mitra'});
 save();
}
let partnerBillStatusFilter='all';
function setPartnerBillFilter(status){
 partnerBillStatusFilter=status;
 renderPartnerBills();
}
function renderPartnerBills(){
 const rows=[];let totalBookings=0,totalBill=0,totalPaid=0,totalOutstanding=0;
 const query=String($('partnerBillSearch')?.value||'').trim().toLowerCase();
 const monthFilter=$('partnerBillMonthFilter')?.value||'';
 const yearSelect=$('partnerBillYearFilter');
 const previousYear=yearSelect?.value||'';
 const years=[...new Set((db.bookings||[]).map(b=>String(b.start||'').slice(0,4)).filter(y=>/^\d{4}$/.test(y)))].sort((a,b)=>b.localeCompare(a));
 if(yearSelect){yearSelect.innerHTML='<option value="">Semua Tahun</option>'+years.map(y=>`<option value="${y}">${y}</option>`).join('');if(years.includes(previousYear))yearSelect.value=previousYear;}
 const yearFilter=yearSelect?.value||'';
 (db.partners||[]).slice().sort((a,b)=>String(a.id).localeCompare(String(b.id))).forEach(m=>{

  const items=[];
  (db.bookings||[]).forEach(b=>{
   const bookingDate=String(b.start||'');
   const monthYearMatch=(!monthFilter||bookingDate.slice(5,7)===monthFilter)&&(!yearFilter||bookingDate.slice(0,4)===yearFilter);
   if(!monthYearMatch)return;
   const units=partnerUnitsForBooking(b,m.id);
   if(!units.length)return;
   const bill=units.reduce((sum,x)=>sum+x.cost,0);
   const paid=(db.partnerPayments||[]).filter(p=>String(p.partnerId)===String(m.id)&&String(p.bookingId)===String(b.id)).reduce((sum,p)=>sum+Number(p.amount||0),0);
   const outstanding=Math.max(0,bill-paid);
   const customerName=cust(b.customerId)?.nama||'';
   const vehicleText=units.map(u=>`${u.a.jenis||u.u.carId||''} ${u.a.plat||''}`).join(' ');
   const searchable=[m.id,m.name,b.id,b.customerId,customerName,vehicleText].join(' ').toLowerCase();
   if(query&&!searchable.includes(query))return;
   items.push({b,units,bill,paid,outstanding});
  });
  if(!items.length)return;
  const visibleItems=items.filter(x=>partnerBillStatusFilter==='paid'?x.outstanding<=0:partnerBillStatusFilter==='unpaid'?x.outstanding>0:true);
  if(!visibleItems.length)return;
  const subtotalBill=visibleItems.reduce((sum,x)=>sum+x.bill,0);
  const subtotalPaid=visibleItems.reduce((sum,x)=>sum+x.paid,0);
  const subtotalOutstanding=visibleItems.reduce((sum,x)=>sum+x.outstanding,0);
  totalBookings+=visibleItems.length;totalBill+=subtotalBill;totalPaid+=subtotalPaid;totalOutstanding+=subtotalOutstanding;
  rows.push(`<tr><td colspan="9" style="background:#263750;color:var(--gold);font-weight:bold">ID MITRA: ${esc(m.id)} — ${esc(m.name)} · ${visibleItems.length} booking · Tagihan: ${money(subtotalBill)} · Dibayar: ${money(subtotalPaid)} · Sisa: ${money(subtotalOutstanding)}</td></tr>`);
  visibleItems.forEach(x=>{
   const status=x.outstanding<=0?'Lunas':x.paid>0?'Kurang Bayar':'Belum Lunas';
   const vehicles=x.units.map(u=>`${u.a.jenis||u.u.carId||'-'} (${u.a.plat||'-'})`).join(', ');
   rows.push(`<tr><td>${esc(x.b.id)}</td><td>${esc(cust(x.b.customerId)?.nama||x.b.customerId||'-')}</td><td>${formatDateDMY(x.b.start)} - ${formatDateDMY(x.b.end)}<br><small>${Number(x.b.days||0)} hari</small></td><td>${esc(vehicles)}</td><td>${money(x.bill)}</td><td>${money(x.paid)}</td><td><strong>${money(x.outstanding)}</strong></td><td>${status}</td><td>${x.outstanding>0?`<button type="button" class="btn primary small" onclick="payPartnerBooking('${esc(m.id)}','${esc(x.b.id)}',${x.outstanding})">Bayar</button>`:'-'}</td></tr>`);
  });
 });
 $('partnerBillRows').innerHTML=rows.join('')||'<tr><td colspan="9" class="muted">Tidak ada tagihan mitra yang sesuai dengan pencarian.</td></tr>';
 $('mtTotalBookings').textContent=totalBookings;
 $('mtTotalBill').textContent=money(totalBill);
 $('mtTotalPaid').textContent=money(totalPaid);
 $('mtTotalOutstanding').textContent=money(totalOutstanding);
 $('partnerBillPaidBtn')?.classList.toggle('primary',partnerBillStatusFilter==='paid');
 $('partnerBillUnpaidBtn')?.classList.toggle('primary',partnerBillStatusFilter==='unpaid');
 $('partnerBillAllBtn')?.classList.toggle('primary',partnerBillStatusFilter==='all');
}
function renderPartnerPaymentSection(){
 const partnerSelect=$('mpPartner'), bookingSelect=$('mpBooking');
 if(!partnerSelect||!bookingSelect)return;
 const previousPartner=partnerSelect.value;
 partnerSelect.innerHTML='<option value="">Pilih mitra</option>'+db.partners.map(m=>`<option value="${esc(m.id)}">${esc(m.id)} — ${esc(m.name)}</option>`).join('');
 if(db.partners.some(m=>String(m.id)===String(previousPartner)))partnerSelect.value=previousPartner;
 const selectedPartner=partnerSelect.value;
 let partnerGroups='';
 (db.partners||[]).forEach(m=>{
  const bookings=(db.bookings||[]).filter(b=>partnerUnitsForBooking(b,m.id).length>0);
  if(!bookings.length)return;
  partnerGroups+=`<optgroup label="${esc(m.id)} — ${esc(m.name)}">`+bookings.map(b=>`<option value="${esc(b.id)}">${esc(b.id)} — ${esc(cust(b.customerId)?.nama||b.customerId||'Pelanggan')} · ${money(partnerBillForBooking(b,m.id))}</option>`).join('')+'</optgroup>';
 });
 const priorBooking=bookingSelect.value;
 const selectedBookings=selectedPartner?(db.bookings||[]).filter(b=>partnerUnitsForBooking(b,selectedPartner).length>0):[];
 bookingSelect.innerHTML='<option value="">'+(selectedPartner?'Pilih booking mitra':'Pilih mitra terlebih dahulu')+'</option>'+(selectedPartner?selectedBookings.map(b=>`<option value="${esc(b.id)}">${esc(b.id)} — ${esc(cust(b.customerId)?.nama||b.customerId||'Pelanggan')} · ${money(partnerBillForBooking(b,selectedPartner))}</option>`).join(''):partnerGroups);
 if(selectedBookings.some(b=>String(b.id)===String(priorBooking)))bookingSelect.value=priorBooking;
 const partnerBookings=selectedPartner?(db.bookings||[]).filter(b=>partnerUnitsForBooking(b,selectedPartner).length>0):[];
 const totalBill=partnerBookings.reduce((sum,b)=>sum+partnerBillForBooking(b,selectedPartner),0);
 $('mpTotalBookings').textContent=selectedPartner?partnerBookings.length:0;
 $('mpTotalBill').textContent=money(totalBill);
 const partnerPayments=db.partnerPayments||[];
 const grouped=new Map();
 partnerPayments.forEach(p=>{const pid=String(p.partnerId||'Tanpa ID Mitra');if(!grouped.has(pid))grouped.set(pid,[]);grouped.get(pid).push(p)});
 const rows=[];
 [...grouped.keys()].sort((a,b)=>a.localeCompare(b)).forEach(pid=>{
  const m=db.partners.find(x=>String(x.id)===pid);const items=grouped.get(pid).slice().sort((a,b)=>String(a.date||'').localeCompare(String(b.date||'')));
  const subtotal=items.reduce((sum,p)=>sum+Number(p.amount||0),0);
  rows.push(`<tr><td colspan="5" style="background:#263750;color:var(--gold);font-weight:bold">ID MITRA: ${esc(pid)} — ${esc(m?.name||'Mitra tidak ditemukan')} · Total pembayaran: ${money(subtotal)}</td></tr>`);
  items.forEach(p=>rows.push(`<tr><td>${esc(p.id)}</td><td>${esc(p.bookingId)}</td><td>${esc(formatDateDMY(p.date)||p.date||'-')}</td><td>${money(p.amount)}</td><td>${esc(p.status||'Dibayar')}</td></tr>`));
 });
 $('partnerPayRows').innerHTML=rows.join('')||'<tr><td colspan="5" class="muted">Belum ada pembayaran mitra.</td></tr>';
 const paymentRowsHtml=rows.join('')||'<tr><td colspan="5" class="muted">Belum ada pembayaran mitra.</td></tr>';
 if($('partnerPayRowsMitra'))$('partnerPayRowsMitra').innerHTML=paymentRowsHtml;
 renderPartnerBills();
}
function renderPartnerBookings(){
 const rows=[];let grand=0;
 (db.partners||[]).forEach(m=>{
  const group=[];
  (db.bookings||[]).forEach(b=>{
   const partnerUnits=bookingUnitsOf(b).map((u,index)=>({u,index,a:car(u.carId)||{}})).filter(x=>{
    const ownership=x.u.ownership||x.a.ownership||'sendiri';
    const partnerId=x.u.partnerId||x.a.partnerId||'';
    return ownership==='mitra'&&String(partnerId)===String(m.id);
   });
   if(!partnerUnits.length)return;
   const bill=partnerBillForBooking(b,m.id);
   const paid=(db.partnerPayments||[]).filter(p=>String(p.partnerId)===String(m.id)&&String(p.bookingId)===String(b.id)).reduce((sum,p)=>sum+Number(p.amount||0),0);
   const remaining=Math.max(0,bill-paid);
   if(remaining<=0)return; // hanya booking yang masih memiliki sisa tagihan
   partnerUnits.forEach(({u,a})=>{
    const daily=Number(u.partnerRate??a.partnerRate??b.partnerRate??0);
    const cost=daily*Number(b.days||0);
    group.push({b,u,a,daily,cost,remainingBooking:remaining});
   });
  });
  if(!group.length)return;
  const bookingIds=[...new Set(group.map(x=>String(x.b.id)))];
  const subtotal=bookingIds.reduce((sum,id)=>{
   const b=group.find(x=>String(x.b.id)===id)?.b;
   return sum+(b?Math.max(0,partnerBillForBooking(b,m.id)-(db.partnerPayments||[]).filter(p=>String(p.partnerId)===String(m.id)&&String(p.bookingId)===id).reduce((v,p)=>v+Number(p.amount||0),0)):0);
  },0);
  grand+=subtotal;
  rows.push(`<tr><td colspan="7" style="background:#263750;color:var(--gold);font-weight:bold">MITRA: ${esc(m.name)} (${esc(m.id)}) · ${bookingIds.length} booking belum lunas · Sisa tagihan: ${money(subtotal)} <button type="button" class="btn small primary" style="margin-left:8px" onclick="payPartnerGroup('${esc(m.id)}')">Bayar</button></td></tr>`);
  group.forEach(x=>{
   const bookingStart=String(x.b.start||'').slice(0,10);
   const monthLabel=bookingStart?new Intl.DateTimeFormat('id-ID',{month:'long',year:'numeric'}).format(new Date(bookingStart+'T00:00:00')):'-';
   rows.push(`<tr><td>${esc(m.name)}</td><td>${esc(monthLabel)}</td><td>${esc(x.b.id)}</td><td>${esc(cust(x.b.customerId)?.nama||x.b.customerId||'-')}</td><td>${esc(x.a.jenis||x.u.carId||'-')} (${esc(x.a.plat||'-')})</td><td>${formatDateDMY(x.b.start)} - ${formatDateDMY(x.b.end)}<br><small>${Number(x.b.days||0)} hari • ${money(x.daily)}/hari</small></td><td><strong>${money(x.cost)}</strong><br><button type="button" class="btn small" style="margin-top:5px" onclick="editBooking('${esc(x.b.id)}')">Edit</button></td></tr>`);
  });
 });
 $('partnerBookingRows').innerHTML=rows.join('')||'<tr><td colspan="7" class="muted">Tidak ada booking armada mitra yang belum dibayar.</td></tr>';
 $('partnerBookingGrandTotal').textContent=money(grand);
}
let bookingStatusFilter='all';
function setBookingStatusFilter(status){
 bookingStatusFilter=status;
 render();
}

let selectedDriverBill=null;
function driverAssignmentKey(x){return String(x.b.id)+'::'+String(x.index)}
function driverPaid(key){return (db.driverPayments||[]).filter(p=>String(p.assignmentKey)===key).reduce((sum,p)=>sum+Number(p.amount||0),0)}
function driverBillGroups(){
 const query=String($('driverBillSearch')?.value||'').trim().toLowerCase();
 const month=$('driverBillMonthFilter')?.value||'';
 const year=$('driverBillYearFilter')?.value||'';
 const groups=new Map();
 (db.bookings||[]).forEach(b=>{
  const start=String(b.start||'');
  if(month&&start.slice(5,7)!==month)return;
  if(year&&start.slice(0,4)!==year)return;
  bookingUnitsOf(b).forEach((u,index)=>{
   const driverId=String(u.driverId||'');
   const driverName=String(u.driverName||'').trim();
   if(!(driverId||driverName)||/tanpa\\s*sopir|tanpa\\s*driver|tidak\\s*ada/i.test(driverName))return;
   const fee=Number(u.driverFeePerDay??b.driverFeePerDay??0),daysCount=Number(b.days||0),total=fee*daysCount;
   if(total<=0)return;
   const driver=(db.drivers||[]).find(d=>String(d.id)===driverId)||{};
   const name=driver.name||driverName||driverId;
   const carInfo=car(u.carId)||{},customer=cust(b.customerId)||{};
   const destination=String(u.destination||b.destination||'-');
   if(query&&![driverId,name,b.id,b.customerId,customer.nama,carInfo.jenis,carInfo.plat,destination].join(' ').toLowerCase().includes(query))return;
   const key=driverId||name;
   if(!groups.has(key))groups.set(key,{key,driverId,name,items:[],total:0});
   const g=groups.get(key);
   const item={b,u,index,driverId,name,carInfo,customer,destination,fee,daysCount,total};
   item.assignmentKey=driverAssignmentKey(item);item.paid=driverPaid(item.assignmentKey);
   item.remaining=Math.max(0,total-item.paid);
   g.items.push(item);g.total+=total;
  });
 });
 return [...groups.values()].sort((a,b)=>a.name.localeCompare(b.name));
}
function renderDriverBills(){
 const yearSelect=$('driverBillYearFilter'),previous=yearSelect?.value||'';
 const years=[...new Set((db.bookings||[]).map(b=>String(b.start||'').slice(0,4)).filter(y=>/^\\d{4}$/.test(y)))].sort((a,b)=>b.localeCompare(a));
 if(yearSelect){yearSelect.innerHTML='<option value="">Semua Tahun</option>'+years.map(y=>`<option value="${y}">${y}</option>`).join('');if(years.includes(previous))yearSelect.value=previous;}
 const groups=driverBillGroups(),rows=[];
 let count=0,grand=0;
 groups.forEach(g=>{
  count+=g.items.length;grand+=g.total;
  const remaining=g.items.reduce((v,x)=>v+x.remaining,0);
  rows.push(`<tr><td colspan="12" style="background:#263750;color:var(--gold);font-weight:bold"><label><input type="checkbox" class="driver-group-check" data-driver="${esc(g.key)}" onchange="toggleDriverBillSelection(this)"> Pilih</label> &nbsp; DRIVER: ${esc(g.name)}${g.driverId?' · ID: '+esc(g.driverId):''} · ${g.items.length} penugasan · Total: ${money(g.total)} · Sisa: ${money(remaining)} &nbsp; <button type="button" class="btn small" onclick="openDriverPayment('${esc(g.key)}')">Bayar</button></td></tr>`);
  g.items.sort((a,b)=>String(a.b.start||'').localeCompare(String(b.b.start||''))).forEach(x=>{
   rows.push(`<tr><td><input type="checkbox" class="driver-assignment-check" data-driver="${esc(g.key)}" value="${esc(x.assignmentKey)}" ${x.remaining<=0?'disabled':''} onchange="syncDriverGroupCheck('${esc(g.key)}')"></td><td>${esc(x.name)}</td><td>${esc(x.b.id)}</td><td>${esc(x.customer.nama||x.b.customerId||'-')}</td><td>${esc(x.carInfo.jenis||x.u.carId||'-')} (${esc(x.carInfo.plat||'-')})</td><td>${formatDateDMY(x.b.start)} – ${formatDateDMY(x.b.end)}</td><td>${esc(x.destination)}</td><td>${money(x.fee)}</td><td>${x.daysCount} hari</td><td>${money(x.total)}</td><td>${money(x.paid)}</td><td><strong>${money(x.remaining)}</strong></td></tr>`);
  });
 });
 $('driverBillRows').innerHTML=rows.join('')||'<tr><td colspan="12" class="muted">Belum ada tagihan driver.</td></tr>';
 $('drBillCount').textContent=count;$('drBillTotal').textContent=money(grand);$('drBillDrivers').textContent=groups.length;
 renderDriverPaymentHistory();
}
function toggleDriverBillSelection(el){
 document.querySelectorAll('.driver-assignment-check').forEach(x=>{if(x.dataset.driver===el.dataset.driver&&!x.disabled)x.checked=el.checked});
}
function syncDriverGroupCheck(key){
 const boxes=[...document.querySelectorAll('.driver-assignment-check')].filter(x=>x.dataset.driver===key&&!x.disabled);
 const group=[...document.querySelectorAll('.driver-group-check')].find(x=>x.dataset.driver===key);
 if(group){group.checked=boxes.length>0&&boxes.every(x=>x.checked);group.indeterminate=boxes.some(x=>x.checked)&&!group.checked;}
}
function openDriverPayment(key){
 const g=driverBillGroups().find(x=>x.key===key);
 if(!g)return alert('Driver tidak ditemukan pada filter saat ini.');
 const checked=[...document.querySelectorAll('.driver-assignment-check')].filter(x=>x.dataset.driver===key&&x.checked&&!x.disabled).map(x=>x.value);
 const items=g.items.filter(x=>x.remaining>0&&(checked.length===0||checked.includes(x.assignmentKey)));
 if(!items.length)return alert('Tidak ada sisa tagihan yang dapat dibayar.');
 selectedDriverBill={key,name:g.name,items};
 $('dpDriver').value=g.name+(g.driverId?' ('+g.driverId+')':'');
 $('dpAssignments').innerHTML=items.map(x=>{
  const vehicle=car(x.u.carId)||{};
  const unitName=vehicle.jenis||x.u.carId||'Armada tidak diketahui';
  const plate=vehicle.plat||'-';
  const period=formatDateDMY(x.b.start)+' s.d. '+formatDateDMY(x.b.end);
  return `<div style="padding:7px 0;border-bottom:1px solid rgba(148,163,184,.2)">
    <div><strong>${esc(x.b.id)}</strong> — <strong>Rincian Unit ${Number(x.index)+1}</strong></div>
    <div style="font-size:12px;color:var(--muted,#9aa8bc)">${esc(unitName)} · ${esc(plate)}</div>
    <div style="font-size:12px;color:var(--muted,#9aa8bc)">${esc(period)} · ${esc(x.destination||'-')}</div>
  </div>`;
 }).join('');
 $('dpTotal').value=money(items.reduce((v,x)=>v+x.total,0));
 const remaining=items.reduce((v,x)=>v+x.remaining,0);
 $('dpRemaining').value=money(remaining);$('dpAmount').max=String(remaining);$('dpAmount').value='';
 const mealTotal=items.reduce((sum,x)=>{
  const unitMeal=x.u.mealCost!=null?Number(x.u.mealCost):x.u.mealPerDay!=null?Number(x.u.mealPerDay)*Number(x.daysCount||0):x.u.meal!=null?Number(x.u.meal)*Number(x.daysCount||0):x.b.mealCost!=null?Number(x.b.mealCost):x.b.mealPerDay!=null?Number(x.b.mealPerDay)*Number(x.daysCount||0):0;
  return sum+Math.max(0,unitMeal||0);
 },0);
 $('dpMealWrap').classList.toggle('hidden',mealTotal<=0);
 $('dpMealCost').value=mealTotal>0?money(mealTotal):'';
 $('dpDate').value=new Date().toLocaleDateString('en-CA');$('dpNote').value='';
 document.querySelectorAll('#rightToolbar button[data-tab]').forEach(btn=>btn.classList.toggle('active',btn.dataset.tab==='daftarTagihanDriver'));
 const paymentForm=$('driverPaymentForm');
 if(paymentForm)paymentForm.scrollIntoView({behavior:'smooth',block:'center'});
}
function resetDriverPaymentForm(){selectedDriverBill=null;$('driverPaymentForm').reset();$('dpAssignments').textContent='Belum ada penugasan dipilih.';$('dpTotal').value='';$('dpRemaining').value='';if($('dpMealWrap'))$('dpMealWrap').classList.add('hidden');if($('dpMealCost'))$('dpMealCost').value='';}
function submitDriverPayment(event){
 event.preventDefault();
 if(!selectedDriverBill)return alert('Pilih driver dari menu Daftar Tagihan Driver.');
 const amount=Number($('dpAmount').value),date=$('dpDate').value;
 const remaining=selectedDriverBill.items.reduce((v,x)=>v+Math.max(0,x.total-driverPaid(x.assignmentKey)),0);
 if(!Number.isFinite(amount)||amount<=0||amount>remaining)return alert('Nominal harus lebih dari nol dan tidak melebihi sisa tagihan '+money(remaining));
 if(!date)return alert('Isi tanggal pembayaran.');
 if(!confirm('Simpan pembayaran driver '+selectedDriverBill.name+' sebesar '+money(amount)+'?'))return;
 db.driverPayments=db.driverPayments||[];
 let left=amount;
 selectedDriverBill.items.forEach(x=>{
  if(left<=0)return;
  const due=Math.max(0,x.total-driverPaid(x.assignmentKey)),part=Math.min(left,due);
  if(part>0){db.driverPayments.push({id:nextId(db.driverPayments,'PDR'),assignmentKey:x.assignmentKey,bookingId:x.b.id,unitIndex:x.index,driverId:x.driverId,driverName:x.name,date,amount:part,note:$('dpNote').value||''});left-=part;}
 });
 resetDriverPaymentForm();save();alert('Pembayaran driver berhasil dicatat.');
}
function renderDriverPaymentHistory(){
 if(!$('driverPaymentRows'))return;
 $('driverPaymentRows').innerHTML=(db.driverPayments||[]).slice().sort((a,b)=>String(b.date).localeCompare(String(a.date))).map(p=>`<tr><td>${formatDateDMY(p.date)}</td><td>${esc(p.driverName||p.driverId)}</td><td>${esc(p.bookingId)}</td><td>${Number(p.unitIndex||0)+1}</td><td>${money(p.amount)}</td><td>${esc(p.note||'-')}</td></tr>`).join('')||'<tr><td colspan="6" class="muted">Belum ada pembayaran driver.</td></tr>';
}

function renderDashboardOverdueWarnings(){
  const panel=$('dashboardOverdueWarnings');
  if(!panel)return;
  const today=new Date();today.setHours(0,0,0,0);
  const overdue=[];
  (db.bookings||[]).forEach(b=>{
    const total=bookingGrandTotal(b.id);
    const balance=Math.max(0,total-bookingGrandPaid(b.id));
    if(balance<=0)return;
    const unitEnds=bookingUnitsOf(b).map(u=>String(u.end||b.end||'').slice(0,10)).filter(Boolean);
    const endDate=unitEnds.sort().slice(-1)[0];
    if(!endDate)return;
    const end=new Date(endDate+'T00:00:00');
    if(Number.isNaN(end.getTime()))return;
    const daysLate=Math.floor((today-end)/86400000);
    if(daysLate<=5)return;
    overdue.push({booking:b,endDate,daysLate,balance});
  });
  overdue.sort((a,b)=>b.daysLate-a.daysLate);
  panel.classList.toggle('hidden',overdue.length===0);
  $('dashboardOverdueCount').textContent=overdue.length+' booking';
  $('dashboardOverdueTotal').textContent='Total tagihan: '+money(overdue.reduce((sum,x)=>sum+x.balance,0));
  const groups=new Map();
  overdue.forEach(x=>{
    const cid=String(x.booking.customerId||'');
    const name=cust(cid)?.nama||cid||'Pelanggan tanpa nama';
    if(!groups.has(cid))groups.set(cid,{name,items:[],total:0});
    const g=groups.get(cid);g.items.push(x);g.total+=x.balance;
  });
  $('dashboardOverdueGroups').innerHTML=Array.from(groups.entries()).map(([cid,g],index)=>`
    <details class="dashboard-overdue-customer"${index===0?'':''}>
      <summary>
        <span class="dashboard-overdue-customer-name">${esc(g.name)}</span>
        <span class="dashboard-overdue-customer-meta">${g.items.length} booking · ${money(g.total)}</span>
      </summary>
      <div class="dashboard-overdue-table-wrap"><table class="dashboard-overdue-table">
        <thead><tr><th>ID Booking</th><th>Selesai Sewa</th><th>Terlambat</th><th>Sisa Tagihan</th></tr></thead>
        <tbody>${g.items.map(x=>`<tr><td>${esc(x.booking.id)}</td><td>${esc(formatDateDMY(x.endDate))}</td><td><span class="badge bad">${x.daysLate} hari</span></td><td><strong>${money(x.balance)}</strong></td></tr>`).join('')}</tbody>
      </table></div>
    </details>`).join('');
}

function render(){if($('aPartner'))$('aPartner').innerHTML='<option value="">Pilih mitra (jika milik mitra)</option>'+db.partners.map(m=>`<option value="${esc(m.id)}">${esc(m.name)}</option>`).join('');let q=($('qCust')?.value||'').toLowerCase();$('custRows').innerHTML=db.customers.filter(x=>(x.id+x.nama+x.wa).toLowerCase().includes(q)).map((x,index)=>`<tr><td style="text-align:center">${index+1}</td><td>${esc(x.id)}</td><td>${esc(x.nama)}</td><td>${esc(x.alamat)}</td><td>${esc(x.wa)}</td><td>${esc(x.nik)}</td><td>${esc(x.sim)}</td><td><span class="badge ${x.status==='Aktif'?'ok':x.status==='Blacklist'?'bad':'warn'}">${esc(x.status)}</span></td><td class="no-print"><div class="actions"><button class="btn small" onclick="editCust('${x.id}')">Edit</button>${currentUser?.role==='admin'?`<button class="btn small danger" onclick="delCust('${x.id}')">Hapus</button>`:''}</div></td></tr>`).join('')||'<tr><td colspan="9" class="muted">Belum ada data pelanggan.</td></tr>';
let qc=($('qCar')?.value||'').trim().toLowerCase();let filteredCars=db.cars.filter(x=>{let owner=(x.ownership||'sendiri')==='mitra'?'mitra':'pribadi';let partner=db.partners.find(m=>m.id===x.partnerId);let keywords=[x.id,x.merk,x.jenis,x.vehicleClass,x.plat,x.trans,x.status,owner,(owner==='mitra'?'milik mitra':'milik pribadi'),partner?.name,partner?.nama,x.partnerId,x.partnerRate].filter(v=>v!==undefined&&v!==null).join(' ').toLowerCase();return !qc||keywords.includes(qc)});let carRow=x=>`<tr><td>${esc(x.id)}</td><td>${esc(x.merk)}</td><td>${esc(x.jenis)}<br><small>${esc(x.vehicleClass||'-')}</small></td><td>${esc(x.plat)}</td><td>${esc(x.trans)}</td><td><span class="badge">${esc(x.status)}</span></td><td>${(x.ownership||'sendiri')==='mitra'?money(Number(x.partnerRate||0)):'-'}</td><td class="no-print"><div class="actions"><button class="btn small" onclick="editCar('${x.id}')">Edit</button>${currentUser?.role==='admin'?`<button class="btn small danger" onclick="delCar('${x.id}')">Hapus</button>`:''}</div></td></tr>`;$('carRows').innerHTML=(filteredCars.length?['sendiri','mitra'].map(type=>{let group=filteredCars.filter(x=>(x.ownership||'sendiri')===type);return group.length?`<tr><td colspan="8" style="background:#263750;color:var(--gold);font-weight:bold">${type==='sendiri'?'ARMADA MILIK PRIBADI':'ARMADA MILIK MITRA'}</td></tr>`+group.map(carRow).join(''):''}).join(''):'<tr><td colspan="8" class="muted">Belum ada data armada.</td></tr>');

if($('fleetTimelineMonth')){
 const currentMonth=(()=>{const n=new Date();return n.getFullYear()+'-'+String(n.getMonth()+1).padStart(2,'0')})();
 const selectedMonth=$('fleetTimelineMonth').value||currentMonth;
 if(!$('fleetTimelineMonth').value)$('fleetTimelineMonth').value=selectedMonth;
 const [ty,tm]=selectedMonth.split('-').map(Number);
 const daysInMonth=new Date(ty,tm,0).getDate();
 const dayLabels=Array.from({length:daysInMonth},(_,i)=>i+1);
 const scheduled=[];
 (db.bookings||[]).forEach(b=>bookingUnitsOf(b).forEach((u,i)=>{
   const carId=String(u.carId||b.carId||'');
   const car=db.cars.find(c=>String(c.id)===carId);
   const start=String(u.start||b.start||'').slice(0,10);
   const end=String(u.end||b.end||'').slice(0,10);
   if(!car||!start||!end||end<selectedMonth+'-01'||start>selectedMonth+'-'+String(daysInMonth).padStart(2,'0'))return;
   const from=Math.max(1,Number(start.slice(8,10)));
   const to=Math.min(daysInMonth,Number(end.slice(8,10)));
   scheduled.push({car,booking:b,unit:i+1,start,end,from,to});
 }));
 const nowLocal=new Date();
 const todayIso=nowLocal.getFullYear()+'-'+String(nowLocal.getMonth()+1).padStart(2,'0')+'-'+String(nowLocal.getDate()).padStart(2,'0');
 const finishedBookings=[];
 (db.bookings||[]).forEach(b=>bookingUnitsOf(b).forEach(u=>{
   const carId=String(u.carId||b.carId||'');
   const car=db.cars.find(c=>String(c.id)===carId);
   const end=String(u.end||b.end||'').slice(0,10);
   if(car&&end===todayIso)finishedBookings.push({booking:b,car,end});
 }));
 finishedBookings.sort((a,b)=>b.end.localeCompare(a.end));
 if($('fleetReturnCount'))$('fleetReturnCount').textContent=finishedBookings.length+' booking';
 if($('fleetReturnRows'))$('fleetReturnRows').innerHTML=finishedBookings.map(x=>`<div class="fleet-return-item"><b>${esc(x.car.jenis||x.car.merk||'Armada')}</b><span>${esc(x.car.plat||'-')}</span><span>${esc(x.booking.id||'-')} · selesai ${formatDateDMY(x.end)}</span><button type="button" class="btn small" onclick="editBooking('${esc(x.booking.id||'')}')">Buka Booking</button></div>`).join('')||'<div class="muted">Tidak ada armada dengan jadwal selesai hari ini.</div>';
 const uniqueCars=(db.cars||[]).slice().sort((a,b)=>String(a.jenis||'').localeCompare(String(b.jenis||'')));
 const monthName=new Intl.DateTimeFormat('id-ID',{month:'long',year:'numeric'}).format(new Date(ty,tm-1,1));
 $('fleetTimelineSummary').textContent=scheduled.length+' jadwal penugasan pada '+monthName+' · '+uniqueCars.length+' armada terjadwal';
 $('fleetTimelineHead').innerHTML='<tr><th class="timeline-car-col">Armada</th>'+dayLabels.map(d=>'<th class="timeline-day">'+d+'</th>').join('')+'</tr>';
 $('fleetTimelineRows').innerHTML=uniqueCars.map(car=>{
   const bars=scheduled.filter(x=>String(x.car.id)===String(car.id)).map(x=>{
     const left=((x.from-1)/daysInMonth)*100;
     const width=((x.to-x.from+1)/daysInMonth)*100;
     const label=(x.booking.id||'Booking')+' · '+(cust(x.booking.customerId)?.nama||'Pelanggan');
     return `<div class="fleet-timeline-bar" role="button" tabindex="0" data-booking-id="${esc(x.booking.id||'')}" aria-label="Edit booking ${esc(x.booking.id||'')}" title="${esc(label)} (${formatDateDMY(x.start)}–${formatDateDMY(x.end)}) · Klik untuk edit booking" style="left:${left}%;width:${width}%;cursor:pointer;pointer-events:auto;z-index:3">${esc(x.booking.id||'Booking')}</div>`;
   }).join('');
   const isPartner=(car.ownership||'sendiri')==='mitra';const partner=db.partners.find(m=>String(m.id)===String(car.partnerId||''));const ownerLabel=isPartner?(partner?.name||partner?.nama||'Mitra'):'Pribadi';return `<tr><td class="timeline-car-col"><strong class="timeline-car-name ${(db.bookings||[]).some(b=>bookingUnitsOf(b).some(u=>String(u.carId||b.carId||'')===String(car.id)&&String(u.start||b.start||'').slice(0,10)<=todayIso&&String(u.end||b.end||'').slice(0,10)>=todayIso))?'is-busy-today':'is-free-today'}" role="button" tabindex="0" data-timeline-car-id="${esc(car.id)}" title="Klik untuk membuat booking dengan armada ini">${esc(car.merk||'')} ${esc(car.jenis||'')}</strong><div class="timeline-car-meta"><small>${esc(car.plat||'-')}</small><span class="timeline-car-owner" title="${esc(ownerLabel)}">${esc(ownerLabel)}</span></div></td><td colspan="${daysInMonth}" class="timeline-track-cell"><div class="fleet-timeline-track">${bars}</div></td></tr>`;
 }).join('')||`<tr><td colspan="${daysInMonth+1}" class="muted">Tidak ada jadwal armada pada ${monthName}.</td></tr>`;
}

// Timeline pengeluaran dashboard: filter per bulan, terbaru di atas.
const expenseMonthInput=$('dashboardExpenseMonth');
const localNowForExpense=new Date();
const currentExpenseMonth=localNowForExpense.getFullYear()+'-'+String(localNowForExpense.getMonth()+1).padStart(2,'0');
if(expenseMonthInput&&!expenseMonthInput.value)expenseMonthInput.value=currentExpenseMonth;
const dashboardExpenseMonth=expenseMonthInput?.value||currentExpenseMonth;
const dashboardExpenseItems=(db.expenses||[]).filter(x=>String(x.date||'').slice(0,7)===dashboardExpenseMonth).slice().sort((a,b)=>String(b.date||'').localeCompare(String(a.date||'')));
if($('dashboardExpenseTotal'))$('dashboardExpenseTotal').textContent=money(dashboardExpenseItems.reduce((sum,x)=>sum+(Number(x.amount)||0),0));
if($('dashboardExpenseTimeline'))$('dashboardExpenseTimeline').innerHTML=dashboardExpenseItems.slice(0,12).map(x=>`<div class="expense-timeline-item"><span class="expense-timeline-dot"></span><div class="expense-timeline-content"><div class="expense-timeline-date">${esc(formatDateDMY(x.date||''))}</div><strong>${esc(x.category||'Pengeluaran')}</strong><div class="muted">${esc(x.note||'-')}</div></div><b class="expense-timeline-amount">${money(x.amount)}</b></div>`).join('')||'<div class="muted" style="padding:12px 0">Belum ada pengeluaran pada bulan ini.</div>';

$('bCust').innerHTML='<option value="">Pilih pelanggan</option>'+db.customers.filter(x=>x.status==='Aktif').map(x=>`<option value="${esc(x.id)}">${esc(x.nama)}</option>`).join('');
$('bUnitCount').value='1';renderBookingUnits(1);
const monthFilter=$('bookingMonthFilter')?.value||'';
const yearSelect=$('bookingYearFilter');
const priorYear=yearSelect?.value||'';
const years=[...new Set((db.bookings||[]).map(b=>String(b.start||'').slice(0,4)).filter(y=>/^\\d{4}$/.test(y)))].sort((a,b)=>b.localeCompare(a));
if(yearSelect){yearSelect.innerHTML='<option value="">Semua Tahun</option>'+years.map(y=>`<option value="${y}">${y}</option>`).join('');if(years.includes(priorYear))yearSelect.value=priorYear;}
const yearFilter=yearSelect?.value||'';
let qb=($('qBook')?.value||'').trim().toLowerCase();
let filteredBookings=db.bookings.filter(b=>{
  const bookingDate=String(b.start||'');
  const monthYearMatch=(!monthFilter||bookingDate.slice(5,7)===monthFilter)&&(!yearFilter||bookingDate.slice(0,4)===yearFilter);
  if(!monthYearMatch)return false;
  const customerId=String(b.customerId||'');
  const customerName=String(cust(customerId)?.nama||'');
  const identityMatch=[customerName,customerId,String(b.id||'')].join(' ').toLowerCase().includes(qb);
  const bookingIsPaid=statusBook(b)==='Lunas';
  const statusMatch=qb==='lunas' ? bookingIsPaid : ['belum','belum lunas','belum bayar','dp'].includes(qb) ? !bookingIsPaid : false;
  const statusFilterMatch=bookingStatusFilter==='paid'?bookingIsPaid:bookingStatusFilter==='unpaid'?!bookingIsPaid:true;
  return statusFilterMatch&&(!qb||identityMatch||statusMatch);
});
let customerGroups=[...new Set(filteredBookings.map(b=>String(b.customerId||'')))];
if($('bookingPageCount'))$('bookingPageCount').textContent=filteredBookings.length;
if($('bookingPageCustomers'))$('bookingPageCustomers').textContent=new Set(filteredBookings.map(b=>String(b.customerId||''))).size;
if($('bookingPageValue'))$('bookingPageValue').textContent=money(filteredBookings.reduce((s,b)=>s+Number(b.total||0),0));
if($('bookingPageOutstanding'))$('bookingPageOutstanding').textContent=money(filteredBookings.reduce((s,b)=>s+Math.max(0,Number(b.total||0)-paid(b.id)),0));
if($('bookingPagePaid'))$('bookingPagePaid').textContent=money(filteredBookings.filter(b=>statusBook(b)==='Lunas').reduce((s,b)=>s+Number(b.total||0),0));
if($('paidBookingFilterBtn'))$('paidBookingFilterBtn').classList.toggle('primary',bookingStatusFilter==='paid');
if($('unpaidBookingFilterBtn'))$('unpaidBookingFilterBtn').classList.toggle('primary',bookingStatusFilter==='unpaid');
if($('bookingPageFoot'))$('bookingPageFoot').textContent=`${filteredBookings.length} dari ${db.bookings.length} booking ditampilkan`;
$('bookRows').innerHTML=customerGroups.map(cid=>{
  let group=filteredBookings.filter(b=>String(b.customerId||'')===cid);
  let customer=cust(cid)||{};
  let subtotal=group.reduce((sum,b)=>sum+Number(b.total||0),0);
  let heading=`<tr class="booking-customer-group" data-customer="${esc(cid)}"><td colspan="15" style="background:#202c40;color:#d8bd7a;font-weight:700;padding:10px"><label style="display:inline-flex;align-items:center;gap:7px;color:#d8bd7a"><input type="checkbox" class="invoice-customer-check" data-customer="${esc(cid)}" onchange="toggleBookingCustomer(this)"> Semua</label> &nbsp; <button type="button" class="booking-customer-toggle" onclick="toggleCustomerBookingDetails('${esc(cid)}')" aria-expanded="false" title="Klik untuk melihat seluruh booking pelanggan">${esc(customer.nama||'Nama pelanggan tidak ditemukan')} <span class="booking-toggle-indicator">＋</span></button></td></tr>`;
  let rows=group.map(b=>{
    const units=bookingUnitsOf(b);
    const unitLines=units.map((u,index)=>{
      const a=car(u.carId)||{};
      return `<div style="padding:3px 0;${index?'border-top:1px dashed #cbd5e1;':''}"><b>Rincian ${index+1}:</b> ${esc(a.jenis||u.carId||'-')} <small>(${esc(a.plat||'-')})</small></div>`;
    }).join('');
    const rateLines=units.map((u,index)=>{const v=Number(u.rate||0);return `<div style="padding:3px 0;${index?'border-top:1px dashed #cbd5e1;':''}">${v>0?`<b>Unit ${index+1}:</b> ${money(v)}`:'-'}</div>`}).join('');
    const driverLines=units.map((u,index)=>{const v=String(u.driverName||'').trim();return `<div style="padding:3px 0;${index?'border-top:1px dashed #cbd5e1;':''}">${v?`<b>Unit ${index+1}:</b> ${esc(v)}`:'-'}</div>`}).join('');
    const destinationLines=units.map((u,index)=>{const v=String(u.destination||b.destination||'').trim();return `<div style="padding:3px 0;${index?'border-top:1px dashed #cbd5e1;':''}">${v?`<b>Unit ${index+1}:</b> ${esc(v)}`:'-'}</div>`}).join('');
    const tripLines=units.map((u,index)=>{
      const d=Number(b.days||0);
      const hasDriver=!!String(u.driverName||'').trim()&&!/tanpa\\s*sopir|tanpa\\s*driver|tidak\\s*ada/i.test(String(u.driverName||''));
      const cost=hasDriver?(Number(u.driverFeePerDay||0)*d+Number(u.fuelCost!=null?u.fuelCost:Number(u.fuelPerDay||0)*d)+Number(u.tollCost!=null?u.tollCost:Number(u.tollPerDay||0)*d)+Number(u.mealCost!=null?u.mealCost:Number(u.mealPerDay||0)*d)+Number(u.lodgingCost!=null?u.lodgingCost:Number(u.lodgingPerDay||0)*d)):0;
      return `<div style="padding:3px 0;${index?'border-top:1px dashed #cbd5e1;':''}">${cost>0?`<b>Unit ${index+1}:</b> ${money(cost)}`:'-'}</div>`;
    }).join('');
    const linkedCharges=chargesForBooking(b.id);
    const otherCostLines=[
      ...units.map((u,index)=>Number(u.otherCost||0)>0?`<div style="padding:3px 0;${index?'border-top:1px dashed #cbd5e1;':''}"><b>Unit ${index+1}:</b> ${money(u.otherCost)}</div>`:'').filter(Boolean),
      ...linkedCharges.map(ch=>`<div style="padding:3px 0;border-top:1px dashed #cbd5e1">${money(ch.amount||0)}</div>`)
    ].join('')||'-';
    const otherNoteLines=[
      ...units.map((u,index)=>Number(u.otherCost||0)>0?`<div style="padding:3px 0;${index?'border-top:1px dashed #cbd5e1;':''}"><b>Unit ${index+1}:</b> ${esc(u.otherCostNote||'Tanpa keterangan')}</div>`:'').filter(Boolean),
      ...linkedCharges.map(ch=>`<div style="padding:3px 0;border-top:1px dashed #cbd5e1">${esc(ch.description||'Tanpa keterangan')}</div>`)
    ].join('')||'-';
    const totalLines=units.map((u,index)=>{const v=Number(u.total||0);return `<div style="padding:3px 0;${index?'border-top:1px dashed #cbd5e1;':''}">${v>0?`<b>Unit ${index+1}:</b> ${money(v)}`:'-'}</div>`}).join('');
    const status=statusBook(b);
    return `<tr class="booking-customer-detail" data-customer="${esc(cid)}" style="display:none"><td class="no-print"><input type="checkbox" class="invoice-book-check" data-customer="${esc(cid)}" value="${esc(b.id)}" onchange="syncBookingCustomerCheck(this)" aria-label="Pilih booking ${esc(b.id)} untuk invoice"></td><td>${esc(customer.nama||cid)}</td><td>${unitLines}</td><td>${b.start?formatDateDMY(b.start):'-'}</td><td>${b.end?formatDateDMY(b.end):'-'}</td><td>${Number(b.days||0)>0?Number(b.days)+' hari':'-'}</td><td>${rateLines}</td><td>${driverLines}</td><td>${destinationLines}</td><td>${tripLines}</td><td>${otherCostLines}</td><td>${otherNoteLines}</td><td><strong>${totalLines}</strong></td><td><div style="display:flex;flex-direction:column;align-items:flex-start;gap:3px"><span class="badge ${status==='Lunas'?'ok':status==='Kurang Bayar'?'warn':'bad'}">${status}</span>${status==='Kurang Bayar'?`<strong style="font-size:11px;line-height:1.2;white-space:nowrap">${money(Math.max(0,bookingGrandTotal(b.id)-bookingGrandPaid(b.id)))}</strong>`:''}</div></td><td class="no-print"><div class="actions"><button class="btn small" onclick="payFromBooking('${b.id}')">Bayar</button><button class="btn small" onclick="editBooking('${b.id}')">Edit</button>${currentUser?.role==='admin'?`<button class="btn small danger" onclick="delBooking('${b.id}')">Hapus</button>`:''}</div></td></tr>`;
  }).join('');
  let subtotalRow=`<tr class="booking-customer-subtotal" data-customer="${esc(cid)}" style="display:none"><td colspan="12" style="text-align:right;font-weight:700;background:#f1eee7">SUBTOTAL ${esc(customer.nama||cid)}</td><td colspan="3" style="font-weight:700;background:#f1eee7">${money(group.reduce((sum,b)=>sum+bookingGrandTotal(b.id),0))}</td></tr>`;
  return heading+rows+subtotalRow;
}).join('')||'<tr><td colspan="15" class="muted">Belum ada booking.</td></tr>';
const selectedCustomer=$('pCustomer')?.value||'';const unpaidCustomerIds=[...new Set(db.bookings.filter(b=>Math.max(0,Number(b.total||0)-paid(b.id))>0).map(b=>String(b.customerId||'')))];if(editingPaymentId){const editingRecord=db.payments.find(p=>p.id===editingPaymentId);const editingBooking=editingRecord&&book(editingRecord.bookingId);if(editingBooking){const editingCid=String(editingBooking.customerId||editingRecord.customerId||'');if(editingCid&&!unpaidCustomerIds.includes(editingCid))unpaidCustomerIds.push(editingCid);}}unpaidCustomerIds.sort((a,b)=>(cust(a)?.nama||'').localeCompare(cust(b)?.nama||''));$('pCustomer').innerHTML='<option value="">Pilih pelanggan yang belum lunas</option>'+unpaidCustomerIds.map(cid=>`<option value="${esc(cid)}">${esc(cust(cid)?.nama||cid)}</option>`).join('');if(unpaidCustomerIds.includes(selectedCustomer))$('pCustomer').value=selectedCustomer;
$('driverRows').innerHTML=db.drivers.map(d=>`<tr><td>${esc(d.id)}</td><td>${esc(d.name)}</td><td>${esc(d.wa||'')}</td><td>${esc(d.address||'')}</td><td>${esc(d.license||'')}</td><td>${esc(d.status||'Aktif')}</td><td><button class="btn small" onclick="editDriver('${d.id}')">Edit</button>${currentUser?.role==='admin'?`<button class="btn small danger" onclick="deleteDriver('${d.id}')">Hapus</button>`:''}</td></tr>`).join('')||'<tr><td colspan="7">Belum ada driver.</td></tr>';
renderDriverBills();
const paymentQuery=String($('qPaymentHistory')?.value||'').trim().toLowerCase();
const filteredPaymentHistory=db.payments.filter(p=>{
  const cid=String(p.customerId||'');
  const customer=cust(cid)||{};
  const searchable=[cid,customer.nama,customer.wa,p.bookingId,p.id,p.date,formatDateDMY(p.date),p.amount].join(' ').toLowerCase();
  return !paymentQuery||searchable.includes(paymentQuery);
});
const paymentCustomerIds=[...new Set(filteredPaymentHistory.map(p=>String(p.customerId||'')))].sort((a,b)=>a.localeCompare(b));
$('payRows').innerHTML=paymentCustomerIds.map(cid=>{let items=filteredPaymentHistory.filter(p=>String(p.customerId||'')===cid);let bookingIds=[...new Set(items.map(p=>p.bookingId))];let totalPaid=items.reduce((sum,p)=>sum+Number(p.amount||0),0);let allSettled=bookingIds.every(id=>statusBook(book(id)||{id,total:0})==='Lunas');let details=items.map(p=>`<div style="margin:6px 0;padding:6px;border-bottom:1px solid var(--line)"><div><b>${esc(p.bookingId)}</b> • ${esc(p.id)} • ${money(p.amount)} • ${formatDateDMY(p.date)}</div><div class="row no-print" style="gap:5px;margin-top:5px"><button class="btn small" onclick="editPayment('${esc(p.id)}')">Edit</button></div></div>`).join('');return `<tr><td class="no-print"><input type="checkbox" class="payment-customer-check" data-customer="${esc(cid)}" aria-label="Pilih pelanggan ${esc(cid)}"></td><td>${esc(cid)}</td><td>${esc(cust(cid)?.nama||'')}</td><td>${bookingIds.map(esc).join('<br>')}</td><td><strong>${money(totalPaid)}</strong></td><td><span class="badge ${allSettled?'ok':'warn'}">${allSettled?'Lunas':'Ada DP / belum lunas'}</span></td><td>${details}</td><td class="no-print"><button class="btn small" onclick="printCustomerPaymentNote('${esc(cid)}')">Cetak Nota</button></td></tr>`}).join('')||'<tr><td colspan="8" class="muted">Belum ada pembayaran.</td></tr>';
db.expenses=db.expenses||[];let total=db.bookings.reduce((s,b)=>s+b.total,0),allIncome=db.payments.reduce((s,p)=>p.amount+s,0),allExpense=db.expenses.reduce((s,x)=>s+Number(x.amount||0),0),remain=db.bookings.reduce((s,b)=>s+Math.max(0,b.total-paid(b.id)),0),unpaid=db.bookings.filter(b=>statusBook(b)!=='Lunas').length;
let period=$('reportMonth')?.value||new Date().toISOString().slice(0,7);
const periodDate=new Date(period+'-01T00:00:00');const periodLabel=new Intl.DateTimeFormat('id-ID',{month:'long',year:'numeric'}).format(periodDate);if($('incomeListTitle'))$('incomeListTitle').textContent='Daftar Pembayaran Bulan '+periodLabel;
let monthIncome=db.payments.filter(p=>String(p.date||'').slice(0,7)===period).reduce((s,p)=>s+Number(p.amount||0),0);
let dashboardCurrentMonth=(()=>{const now=new Date();return now.getFullYear()+'-'+String(now.getMonth()+1).padStart(2,'0')})();
const dashboardMonthPayments=db.payments.filter(p=>String(p.date||'').slice(0,7)===dashboardCurrentMonth).sort((a,b)=>String(b.date||'').localeCompare(String(a.date||'')));
let dashboardMonthIncome=dashboardMonthPayments.reduce((s,p)=>s+Number(p.amount||0),0);
let dashboardMonthName=new Intl.DateTimeFormat('id-ID',{month:'long'}).format(new Date());$('sPayLabel').textContent='Pemasukan Bulan '+dashboardMonthName;
if($('dashboardIncomeTitle'))$('dashboardIncomeTitle').textContent='Daftar Pembayaran Bulan '+dashboardMonthName;
if($('dashboardIncomeTotal'))$('dashboardIncomeTotal').textContent='Total: '+money(dashboardMonthIncome);
if($('dashboardIncomeRows'))$('dashboardIncomeRows').innerHTML=dashboardMonthPayments.map(p=>`<tr><td>${esc(formatDateDMY(p.date))}</td><td>${esc(cust(p.customerId)?.nama||p.customerId||'-')}</td><td>${esc(p.bookingId||'-')}</td><td>${money(p.amount)}</td></tr>`).join('')||'<tr><td colspan="4" class="muted">Belum ada pembayaran pada bulan ini.</td></tr>';
let monthExpense=db.expenses.filter(x=>String(x.date||'').slice(0,7)===period).reduce((s,x)=>s+Number(x.amount||0),0);
const dashboardMonthBookings=db.bookings.filter(b=>String(b.start||'').slice(0,7)===dashboardCurrentMonth);
const dashboardBookingMonthLabel=new Intl.DateTimeFormat('id-ID',{month:'long'}).format(new Date());
const bookingCardLabel=document.querySelector('#dashboard .dashboard-booking-card small');
if(bookingCardLabel)bookingCardLabel.textContent='Total Booking '+dashboardBookingMonthLabel;
renderDashboardOverdueWarnings();
$('sCust').textContent=db.customers.length;$('sCar').textContent=db.cars.length;$('sBook').textContent=dashboardMonthBookings.length;$('sPay').textContent=money(dashboardMonthIncome);$('rBooking').textContent=money(total);$('rIncome').textContent=money(monthIncome);$('rRemain').textContent=money(remain);$('rExpense').textContent=money(monthExpense);$('rNet').textContent=money(monthIncome-monthExpense);$('rUnpaid').textContent=unpaid;
const periodPayments=db.payments.filter(p=>String(p.date||'').slice(0,7)===period).sort((a,b)=>String(b.date||'').localeCompare(String(a.date||'')));
const periodIncome=periodPayments.reduce((sum,p)=>sum+Number(p.amount||0),0);
$('incomeListTotal').textContent='Total: '+money(periodIncome);
$('incomeRows').innerHTML=periodPayments.map(p=>`<tr><td>${esc(formatDateDMY(p.date))}</td><td>${esc(cust(p.customerId)?.nama||p.customerId||'-')}</td><td>${esc(p.bookingId||'-')}</td><td>${money(p.amount)}</td></tr>`).join('')||'<tr><td colspan="4" class="muted">Belum ada pemasukan pada periode ini.</td></tr>';
let pl=[];db.payments.filter(p=>String(p.date||'').slice(0,7)===period).forEach(p=>pl.push({date:String(p.date||'').slice(0,10),kind:'Pemasukan',note:(cust(p.customerId)?.nama||p.customerId)+' • '+p.bookingId,amount:Number(p.amount||0)}));db.expenses.filter(x=>String(x.date||'').slice(0,7)===period).forEach(x=>pl.push({date:x.date,kind:'Pengeluaran',note:(x.category||'')+' • '+(x.note||''),amount:Number(x.amount||0)}));pl.sort((a,b)=>a.date.localeCompare(b.date));
$('plRows').innerHTML=pl.map(x=>`<tr><td>${esc(x.date)}</td><td><span class="badge ${x.kind==='Pemasukan'?'ok':'bad'}">${x.kind}</span></td><td>${esc(x.note)}</td><td>${money(x.amount)}</td></tr>`).join('')||'<tr><td colspan="4" class="muted">Belum ada transaksi pada periode ini.</td></tr>';
if($('clearAllBtn'))$('clearAllBtn').classList.toggle('hidden',currentUser?.role!=='admin');
if($('usersNav'))$('usersNav').classList.toggle('hidden',currentUser?.role!=='admin');
if($('toolbarUsersNav'))$('toolbarUsersNav').classList.toggle('hidden',currentUser?.role!=='admin');
$('reportRows').innerHTML=db.bookings.map(b=>`<tr><td>${b.id}</td><td>${esc(cust(b.customerId)?.nama||'')}</td><td>${esc(car(b.carId)?.jenis||'')}</td><td>${money(b.total)}</td><td>${money(paid(b.id))}</td><td>${money(Math.max(0,b.total-paid(b.id)))}</td><td>${statusBook(b)}</td></tr>`).join('')||'<tr><td colspan="7" class="muted">Belum ada data booking.</td></tr>';
const unpaidByCustomer=new Map();db.bookings.forEach(b=>{const balance=Math.max(0,Number(b.total||0)-paid(b.id));if(balance<=0)return;const cid=String(b.customerId||'');if(!unpaidByCustomer.has(cid))unpaidByCustomer.set(cid,{customerId:cid,bookings:[],total:0,paid:0,balance:0});const g=unpaidByCustomer.get(cid);g.bookings.push(b);g.total+=Number(b.total||0);g.paid+=paid(b.id);g.balance+=balance;});
const unpaidCustomerList=[...unpaidByCustomer.values()].sort((a,b)=>b.balance-a.balance);const uq=String($('qUnpaidCustomer')?.value||'').toLowerCase();const visibleUnpaid=unpaidCustomerList.filter(g=>{const c=cust(g.customerId)||{};return (g.customerId+' '+(c.nama||'')+' '+(c.wa||'')).toLowerCase().includes(uq)});
$('unpaidCustomerRows').innerHTML=visibleUnpaid.map(g=>{const c=cust(g.customerId)||{};return `<tr><td>${esc(g.customerId)}</td><td>${esc(c.nama||'-')}</td><td>${esc(c.wa||'-')}</td><td>${g.bookings.map(b=>esc(b.id)).join('<br>')}</td><td>${g.bookings.length}</td><td>${money(g.total)}</td><td>${money(g.paid)}</td><td><strong style="color:var(--red)">${money(g.balance)}</strong></td></tr>`}).join('')||'<tr><td colspan="8" class="muted">Tidak ada pelanggan dengan tagihan tertunggak.</td></tr>';
$('unpaidCustomerSummary').textContent=unpaidCustomerList.length+' pelanggan • Sisa tagihan '+money(unpaidCustomerList.reduce((sum,g)=>sum+g.balance,0));

const expenseMonthEl=$('expenseMonthFilter');
if(expenseMonthEl&&!expenseMonthEl.value){
  const now=new Date();
  expenseMonthEl.value=now.getFullYear()+'-'+String(now.getMonth()+1).padStart(2,'0');
}
const selectedExpenseMonth=String(expenseMonthEl?.value||'');
const expenseQuery=String($('qExpenseHistory')?.value||'').trim().toLowerCase();
const filteredExpenses=db.expenses.filter(x=>
  (!selectedExpenseMonth||String(x.date||'').slice(0,7)===selectedExpenseMonth) &&
  [x.id,x.date,x.category,x.note,x.amount,money(x.amount)].join(' ').toLowerCase().includes(expenseQuery)
);
$('expenseTotal').textContent=money(filteredExpenses.reduce((sum,x)=>sum+(Number(x.amount)||0),0));
$('expenseRows').innerHTML=filteredExpenses.slice().sort((a,b)=>String(b.date||'').localeCompare(String(a.date||''))).map(x=>`<tr><td>${esc(x.id)}</td><td>${esc(x.date)}</td><td>${esc(x.category)}</td><td>${esc(x.note)}</td><td>${money(x.amount)}</td><td class="no-print">${currentUser?.role==='admin'?`<button class="btn small danger" onclick="delExpense('${x.id}')">Hapus</button>`:''}</td></tr>`).join('')||'<tr><td colspan="6" class="muted">Tidak ada pengeluaran pada bulan dan pencarian tersebut.</td></tr>';
const ownExpenseCars=db.cars.filter(a=>String(a.ownership||'sendiri').toLowerCase()!=='mitra');
const partnerExpenseCars=db.cars.filter(a=>String(a.ownership||'sendiri').toLowerCase()==='mitra');
const expenseCarOption=a=>`<option value="${esc(a.id)}">${esc(a.merk||'')} ${esc(a.jenis||'')} (${esc(a.plat||'-')})</option>`;
const ownExpenseOptions=ownExpenseCars.map(expenseCarOption).join('');
const partnerExpenseOptions=partnerExpenseCars.map(a=>{
 const partner=db.partners.find(m=>String(m.id)===String(a.partnerId))||{};
 return `<option value="${esc(a.id)}">${esc(a.merk||'')} ${esc(a.jenis||'')} (${esc(a.plat||'-')})${partner.name?' — '+esc(partner.name):''}</option>`;
}).join('');
$('eCar').innerHTML=(ownExpenseOptions?`<optgroup label="Armada Milik Sendiri">${ownExpenseOptions}</optgroup>`:'')+(partnerExpenseOptions?`<optgroup label="Armada Milik Mitra">${partnerExpenseOptions}</optgroup>`:'');
$('aPartner').innerHTML='<option value="">Pilih mitra (jika milik mitra)</option>'+db.partners.map(m=>`<option value="${m.id}">${esc(m.name)} (${m.id})</option>`).join('');
$('partnerRows').innerHTML=db.partners.map(m=>`<tr><td>${esc(m.id)}</td><td>${esc(m.name)}</td><td>${esc(m.wa)}</td><td>${esc(m.address)}</td><td>${esc(m.bank)}</td><td>${esc(m.accountNo)}</td></tr>`).join('')||'<tr><td colspan="6">Belum ada mitra.</td></tr>';renderPartnerBookings();
renderPartnerPaymentSection();
$('journalRows').innerHTML=db.journals.map(j=>`<tr><td>${esc(j.id)}</td><td>${esc(j.date)}</td><td>${esc(j.note)}</td><td>${esc(j.debitAccount)}</td><td>${esc(j.creditAccount)}</td><td>${money(j.amount)}</td></tr>`).join('')||'<tr><td colspan="6">Belum ada jurnal manual.</td></tr>';
let jDebit=db.journals.reduce((s,j)=>s+Number(j.amount||0),0);$('jDebitTotal').textContent=money(jDebit);$('jCreditTotal').textContent=money(jDebit);
let ledger=[];db.payments.forEach(p=>{let b=book(p.bookingId),a=b?car(b.carId):null,amount=Number(p.amount||0);ledger.push({date:String(p.date||'').slice(0,10),account:'1101 Kas/Bank',note:'Penerimaan pelanggan '+p.bookingId,debit:amount,credit:0});if(a?.ownership==='mitra'){let shareTotal=Number(b.partnerRate??a.partnerRate??0)*Number(b.days||0);let sharePart=b.total>0?Math.min(amount,amount*shareTotal/b.total):0;ledger.push({date:String(p.date||'').slice(0,10),account:'2101 Utang Mitra',note:'Bagian pemilik '+p.bookingId,debit:0,credit:sharePart});ledger.push({date:String(p.date||'').slice(0,10),account:'4201 Pendapatan Margin Mitra',note:'Margin '+p.bookingId,debit:0,credit:amount-sharePart})}else{ledger.push({date:String(p.date||'').slice(0,10),account:'4101 Pendapatan Sewa',note:'Pendapatan sewa '+p.bookingId,debit:0,credit:amount})}});
db.expenses.forEach(x=>{ledger.push({date:x.date,account:'5101 Beban Operasional',note:x.note||x.category,debit:x.amount,credit:0});ledger.push({date:x.date,account:'1101 Kas/Bank',note:x.note||x.category,debit:0,credit:x.amount})});
db.driverPayments.forEach(p=>{ledger.push({date:p.date,account:'5102 Beban Honor Driver',note:'Pembayaran driver '+p.bookingId,debit:p.amount,credit:0});ledger.push({date:p.date,account:'1101 Kas/Bank',note:'Pembayaran driver '+p.bookingId,debit:0,credit:p.amount})});
db.partnerPayments.forEach(p=>{ledger.push({date:p.date,account:'2101 Utang Mitra',note:'Pembayaran mitra '+p.bookingId,debit:p.amount,credit:0});ledger.push({date:p.date,account:'1101 Kas/Bank',note:'Pembayaran mitra '+p.bookingId,debit:0,credit:p.amount})});
db.journals.forEach(j=>{ledger.push({date:j.date,account:j.debitAccount,note:j.note,debit:j.amount,credit:0});ledger.push({date:j.date,account:j.creditAccount,note:j.note,debit:0,credit:j.amount})});
ledger.sort((a,b)=>a.date.localeCompare(b.date));let balances={};$('ledgerRows').innerHTML=ledger.map(x=>{balances[x.account]=(balances[x.account]||0)+Number(x.debit||0)-Number(x.credit||0);return `<tr><td>${esc(x.date)}</td><td>${esc(x.account)}</td><td>${esc(x.note)}</td><td>${money(x.debit)}</td><td>${money(x.credit)}</td><td>${money(balances[x.account])}</td></tr>`}).join('')||'<tr><td colspan="6">Belum ada mutasi buku besar.</td></tr>';
let carRows=db.cars.map(a=>{let inc=db.payments.filter(p=>book(p.bookingId)?.carId===a.id).reduce((s,p)=>s+Number(p.amount||0),0);let partnerShare=a.ownership==='mitra'?db.bookings.filter(b=>b.carId===a.id).reduce((s,b)=>s+Number(b.partnerRate??a.partnerRate??0)*Number(b.days||0),0):0;let partnerPaid=db.partnerPayments.filter(p=>db.bookings.find(b=>b.id===p.bookingId)?.carId===a.id).reduce((s,p)=>s+Number(p.amount||0),0);let direct=db.expenses.filter(x=>x.carId===a.id).reduce((s,x)=>s+Number(x.amount||0),0);let result=a.ownership==='mitra'?inc-partnerPaid-direct:inc-direct;return `<tr><td>${esc(a.jenis)} (${esc(a.plat)})</td><td>${a.ownership==='mitra'?'Mitra':'Sendiri'}</td><td>${money(inc)}</td><td>${money(a.ownership==='mitra'?partnerPaid:0)}</td><td>${money(direct)}</td><td>${money(result)}</td></tr>`}).join('');
$('carProfitRows').innerHTML=carRows||'<tr><td colspan="6">Belum ada kendaraan.</td></tr>';
let totalDriver=db.driverPayments.reduce((sum,p)=>sum+Number(p.amount||0),0);let totalIn=db.payments.reduce((s,p)=>s+Number(p.amount||0),0),totalPartner=db.partnerPayments.reduce((s,p)=>s+Number(p.amount||0),0),totalExp=db.expenses.reduce((s,x)=>s+Number(x.amount||0),0);$('overallProfit').textContent='Hasil kas usaha (seluruh periode): '+money(totalIn-totalPartner-totalExp-totalDriver);
if($('invoiceMonth')&&!$('invoiceMonth').value)$('invoiceMonth').value=new Date().toISOString().slice(0,7);
let invoicePeriod=$('invoiceMonth')?.value||new Date().toISOString().slice(0,7);
let invoiceBookings=db.bookings.filter(b=>statusBook(b)==='Belum Bayar'&&String(b.start||'').slice(0,7)===invoicePeriod);
let unpaidCustomers=[...new Set(invoiceBookings.map(b=>b.customerId))];
let selectedInvoice=$('invoicePick').value;
$('invoicePick').innerHTML='<option value="">Pilih pelanggan (booking belum bayar)</option>'+unpaidCustomers.map(id=>{let c=cust(id)||{};let count=invoiceBookings.filter(b=>b.customerId===id).length;return `<option value="${id}">${esc(id)} — ${esc(c.nama||'')} (${count} booking)</option>`}).join('');
if(unpaidCustomers.includes(selectedInvoice))$('invoicePick').value=selectedInvoice;else $('invoicePreview').innerHTML='';
updateCarOwnershipFields();
}
function printUnpaidCustomers(){const rows=[...document.querySelectorAll('#unpaidCustomerRows tr')].map(tr=>tr.outerHTML).join('');const w=window.open('','_blank');if(!w){alert('Izinkan pop-up untuk mencetak rekap.');return}w.document.write(`<html><head><title>Rekap Pelanggan Belum Lunas</title><style>body{font:13px Arial;padding:24px}h2{margin-bottom:6px}table{width:100%;border-collapse:collapse}th,td{border:1px solid #bbb;padding:8px;text-align:left}th{background:#eee}</style><' + '/head><body><h2>ALFA PRIMA RENT CAR</h2><h3>Rekap Pelanggan Belum Lunas</h3><p>Tanggal cetak: ${new Date().toLocaleDateString('id-ID')}</p><table><thead><tr><th>ID Pelanggan</th><th>Nama Pelanggan</th><th>No. WA</th><th>ID Booking</th><th>Jumlah Booking</th><th>Total Tagihan</th><th>Total Dibayar</th><th>Sisa Tagihan</th></tr></thead><tbody>${rows}</tbody></table><' + '/body><' + '/html>`);w.document.close();w.onload=()=>{const imgs=[...w.document.images];Promise.all(imgs.map(img=>img.decode?img.decode().catch(()=>{}):new Promise(resolve=>{img.onload=img.onerror=resolve}))).then(()=>{w.focus();w.print()})};setTimeout(()=>{w.focus();w.print()},1200)}
function selectInvoice(id){let b=book(id);if(!b)return;$('invoiceMonth').value=String(b.start||'').slice(0,7);render();$('invoicePick').value=b.customerId;showInvoice();document.querySelector('[data-tab="laporan"]').click()}
$('invoicePick').onchange=showInvoice;
function unpaidBookingsForCustomer(customerId,month){return db.bookings.filter(b=>b.customerId===customerId&&statusBook(b)==='Belum Bayar'&&String(b.start||'').slice(0,7)===month)}
function invoiceHtmlForCustomer(customerId,month,bookingIds=null){
  let list=bookingIds?db.bookings.filter(b=>bookingIds.includes(b.id)&&b.customerId===customerId):unpaidBookingsForCustomer(customerId,month),c=cust(customerId)||{};
  if(!list.length)return '<p style="color:#111">Tidak ada booking belum bayar untuk pelanggan ini pada bulan terpilih.</p>';
  let total=list.reduce((s,b)=>s+bookingGrandTotal(b.id),0);
  let monthLabel=month?new Date(month+'-01T00:00:00').toLocaleDateString('id-ID',{month:'long',year:'numeric'}):'-';
  let rows=list.flatMap(b=>bookingUnitsOf(b).map(u=>{
    let a=car(u.carId)||{};
    let duration=Number(b.days||0),rate=Number(u.rate||0);
    let driverName=String(u.driverName||'').trim();
    let hasDriver=!!driverName && !/tanpa\\s*sopir|tanpa\\s*driver|tidak\\s*ada/i.test(driverName);
    let detailLines=[`Sewa mobil/hari: ${money(rate)}`];
    let driverFeePerDay=Number(u.driverFeePerDay||0);
    let fuelPerDay=Number(u.fuelPerDay!=null?u.fuelPerDay:(duration?Number(u.fuelCost||0)/duration:0));
    let tollPerDay=Number(u.tollPerDay!=null?u.tollPerDay:(duration?Number(u.tollCost||0)/duration:0));
    let mealPerDay=Number(u.mealPerDay!=null?u.mealPerDay:(duration?Number(u.mealCost||0)/duration:0));
    if(hasDriver){
      detailLines.push(`Sopir/hari (${esc(driverName)}): ${money(driverFeePerDay)}`);
      detailLines.push(`BBM/hari: ${money(fuelPerDay)}`);
      detailLines.push(`Tol/E-toll/hari: ${money(tollPerDay)}`);
      detailLines.push(`Uang makan/hari: ${money(mealPerDay)}`);
    }
    const dailySubtotal=rate+(hasDriver?(driverFeePerDay+fuelPerDay+tollPerDay+mealPerDay):0);
    detailLines.push(`<b>Subtotal per hari: ${money(dailySubtotal)}</b>`);
    return `<tr><td><small>${formatDateDMY(b.start)} s.d. ${formatDateDMY(b.end)}</small></td>
      <td>${esc(a.jenis||u.carId||'-')} — ${esc(a.plat||'-')}</td>
      <td>${esc(u.destination||'-')}</td><td>${duration} hari</td>
      <td>${detailLines.join('<br><small>')}</td><td><b>${money(u.total||0)}</b></td></tr>`;
  })).join('')+list.map(b=>chargesForBooking(b.id).map(ch=>`<tr><td><small>${formatDateDMY(b.start)} s.d. ${formatDateDMY(b.end)}<br>${esc(b.id)}</small></td><td>Biaya Lain-lain</td><td>-</td><td>-</td><td>${esc(ch.description||'Biaya lain-lain')}</td><td><b>${money(ch.amount||0)}</b></td></tr>`).join('')).join('');
  return `<div style="max-width:760px;margin:auto;padding:22px;color:#172033;background:#fff;font-family:Arial,sans-serif;border:1px solid #ddd">
    <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:14px;padding-bottom:12px;border-bottom:3px solid #b18a3b">
      <div style="font-size:18px;font-weight:800;letter-spacing:1px;color:#17243a;white-space:nowrap">ALFA PRIMA RENTCAR</div>
      <div style="text-align:right;font-size:10px;line-height:1.5">Harmony Residence C16, Sendang Mulyo,<br>Tembalang, Semarang<br>Instagram: @alfaprima.rentcar<br>WhatsApp: 081226611507</div>
    </div>
    <div style="text-align:center;padding:16px 0 10px"><h2 style="margin:0 0 7px;font-size:21px;letter-spacing:1px">INVOICE BULANAN</h2><div style="font-size:14px"><b>Nama Pelanggan: ${esc(c.nama||'-')}</b></div><div style="font-size:11px;line-height:1.5;margin-top:4px"><div>Alamat: ${esc(c.alamat||'-')}</div><div>WhatsApp: ${esc(c.wa||'-')}</div></div><div style="font-size:11px;margin-top:6px">Periode: <b>${esc(monthLabel)}</b></div></div>
    <table style="width:100%;border-collapse:collapse;font-size:9px;color:#172033;table-layout:fixed"><thead><tr style="background:#f1eee7"><th style="width:17%;border:1px solid #aaa;padding:5px">Booking & Tanggal</th><th style="width:16%;border:1px solid #aaa;padding:5px">Armada</th><th style="width:14%;border:1px solid #aaa;padding:5px">Tujuan</th><th style="width:8%;border:1px solid #aaa;padding:5px">Durasi</th><th style="width:29%;border:1px solid #aaa;padding:5px">Rincian Biaya</th><th style="width:16%;border:1px solid #aaa;padding:5px">Total</th></tr></thead><tbody>${rows}</tbody></table>
    <div style="margin-left:auto;max-width:280px;margin-top:14px;text-align:right"><div style="font-size:11px">Jumlah booking: <b>${uniqueInvoiceBookings.length}</b></div><div style="font-size:15px;margin-top:7px;padding:8px;border-top:2px solid #b18a3b">TOTAL TAGIHAN: <b>${money(total)}</b></div></div>
    <div style="display:flex;justify-content:space-between;align-items:flex-end;gap:18px;margin-top:20px">
      <div style="max-width:58%;font-size:9px;line-height:1.5;text-align:left">
        <b>Pembayaran bisa di transfer melalui</b><br>
        Nomor Rekening : 0095049228 (BCA)<br>
        Atas Nama&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: Alfa Prima<br>
        Lakukan Konfirmasi dan kirim bukti transfer bila telah transfer ke nomor rekening tersebut
      </div>
      <div style="width:190px;text-align:center;font-size:11px;flex-shrink:0">
        <div>Hormat kami,</div><div style="font-weight:bold;margin-top:4px">ALFA PRIMA RENTCAR</div><div style="height:52px"></div><div style="border-top:1px solid #333;padding-top:6px;font-weight:bold">Alfa Prima</div><div>Pemilik</div>
      </div>
    </div>
    <p style="text-align:center;font-size:10px;margin:14px 0 0">Terima kasih telah menggunakan layanan Alfa Prima Rent Car.</p>
    
  </div>`;
}
function getSequentialInvoiceNumber(list){
  const bookingKey=[...new Set((list||[]).map(b=>String(b.id||'')))].sort().join('|')||'empty';
  const mapKey='alfaPrimaInvoiceNumbersV1';
  const dateKey=(()=>{const d=new Date();return String(d.getFullYear())+String(d.getMonth()+1).padStart(2,'0')+String(d.getDate()).padStart(2,'0')})();
  try{
    const saved=JSON.parse(localStorage.getItem(mapKey)||'{}');
    if(saved.byBookingKey&&saved.byBookingKey[bookingKey])return saved.byBookingKey[bookingKey];
    const next=(Number(saved.dailyDate)===Number(dateKey)?Number(saved.dailyCounter||0):0)+1;
    const invoiceNo='INV-'+dateKey+'-'+String(next).padStart(3,'0');
    saved.dailyDate=Number(dateKey);saved.dailyCounter=next;saved.byBookingKey=saved.byBookingKey||{};
    saved.byBookingKey[bookingKey]=invoiceNo;
    localStorage.setItem(mapKey,JSON.stringify(saved));
    return invoiceNo;
  }catch(err){
    return 'INV-'+dateKey+'-'+String(Date.now()).slice(-6);
  }
}
function invoiceHtmlForBookings(list){
  const invoiceNumber=getSequentialInvoiceNumber(list);
  const uniqueInvoiceBookings=[...new Map((list||[]).map(b=>[String(b.id||''),b])).values()];
  const totalFleetCount=uniqueInvoiceBookings.reduce((sum,b)=>sum+bookingUnitsOf(b).length,0);
  const total=uniqueInvoiceBookings.reduce((sum,b)=>sum+bookingGrandTotal(b.id),0);
  const totalPaid=uniqueInvoiceBookings.reduce((sum,b)=>sum+bookingGrandPaid(b.id),0);
  const remaining=Math.max(0,total-totalPaid);
  const allFullyPaid=list.length>0&&list.every(b=>statusBook(b)==='Lunas');
  const hasAnyPayment=totalPaid>0;
  const documentTitle=allFullyPaid?'NOTA LUNAS':(hasAnyPayment?'NOTA PEMBAYARAN':'INVOICE');
  const grouped=new Map();
  uniqueInvoiceBookings.forEach(b=>{
    const cid=String(b.customerId||'Tanpa ID');
    if(!grouped.has(cid))grouped.set(cid,[]);
    grouped.get(cid).push(b);
  });
  const rows=[...grouped.entries()].map(([cid,bookings])=>{
    const customer=cust(cid)||{};
    const customerName=customer.nama||"Pelanggan";
    const customerTotal=bookings.reduce((sum,b)=>sum+bookingGrandTotal(b.id),0);
    let invoiceRowNumber=0;
    const bookingRows=bookings.flatMap(b=>bookingUnitsOf(b).map(u=>{
      const c=cust(b.customerId)||{},a=car(u.carId)||{};
      const duration=Number(b.days||0),rate=Number(u.rate||0);
      const driverName=String(u.driverName||'').trim();
      const hasDriver=!!driverName&&!/tanpa\s*sopir|tanpa\s*driver|tidak\s*ada/i.test(driverName);
      const details=[`Sewa mobil/hari: ${money(rate)}`];
      const driverFee=Number(u.driverFeePerDay||0);
      const fuel=Number(u.fuelPerDay!=null?u.fuelPerDay:(duration?Number(u.fuelCost||0)/duration:0));
      const toll=Number(u.tollPerDay!=null?u.tollPerDay:(duration?Number(u.tollCost||0)/duration:0));
      const meal=Number(u.mealPerDay!=null?u.mealPerDay:(duration?Number(u.mealCost||0)/duration:0));
      if(hasDriver){details.push(`Sopir/hari (${esc(driverName)}): ${money(driverFee)}`,`BBM/hari: ${money(fuel)}`,`Tol/E-toll/hari: ${money(toll)}`,`Uang makan/hari: ${money(meal)}`);}
      details.push(`<b>Subtotal per hari: ${money(rate+(hasDriver?driverFee+fuel+toll+meal:0))}</b>`);
      if(Number(u.otherCost||0)>0)details.push(`Biaya lain-lain: ${esc(u.otherCostNote||'Tanpa keterangan')} — ${money(u.otherCost)}`);
      return `<tr><td style="text-align:center">${++invoiceRowNumber}</td><td><small>${formatDateDMY(b.start)} s.d. ${formatDateDMY(b.end)}</small></td><td style="white-space:nowrap;word-break:keep-all;overflow-wrap:normal">${esc(a.jenis||u.carId||'-')} — ${esc(a.plat||'-')}</td><td>${esc(u.destination||'-')}</td><td>${duration} hari</td><td>${details.join('<br>')}</td><td><b>${money(u.total||0)}</b></td></tr>`;
    })).join('')+bookings.map(b=>chargesForBooking(b.id).map(ch=>`<tr><td style="text-align:center">${++invoiceRowNumber}</td><td><small>${formatDateDMY(b.start)} s.d. ${formatDateDMY(b.end)}<br>${esc(b.id)}</small></td><td>Biaya Lain-lain</td><td>-</td><td>-</td><td>${esc(ch.description||'Biaya lain-lain')}</td><td><b>${money(ch.amount||0)}</b></td></tr>`).join('')).join('');
    return bookingRows;
  }).join('');
  const customerNames=[...grouped.keys()].map(cid=>{const c=cust(cid)||{};return esc(c.nama||"Pelanggan");}).join(" dan ");
  const selectedBookingIds=uniqueInvoiceBookings.map(b=>String(b.id));
  const invoiceDateLabel=formatDateDMY(new Date().toISOString().slice(0,10));
  const customerInfo=`<div style="font-size:10px;line-height:1.55"><div><b>Nomor Nota :</b> ${esc(invoiceNumber)}</div></div>`+[...grouped.keys()].map(cid=>{
    const c=cust(cid)||{};
    return `<div style="font-size:10px;line-height:1.55"><div><b>Nama :</b> ${esc(c.nama||'Pelanggan')}</div><div><b>Alamat :</b> ${esc(c.alamat||'-')}</div><div><b>Nomor Tlp :</b> ${esc(c.wa||'-')}</div></div>`;
  }).join('');

  const paymentDates=[...new Set((db.payments||[]).filter(p=>selectedBookingIds.includes(String(p.bookingId||''))).map(p=>String(p.date||'').slice(0,10)).filter(Boolean))].sort();
  const paymentDateLabel=paymentDates.length?paymentDates.map(d=>formatDateDMY(d)).join(', '):'-';
  const paymentSummary=hasAnyPayment?`<div style="font-size:11px;margin-top:7px">Tanggal Bayar: <b>${paymentDateLabel}</b></div>${remaining>0?`<div style="font-size:11px">Sisa pembayaran: <b>${money(remaining)}</b></div>`:`<div style="font-size:11px;font-weight:bold">STATUS: LUNAS</div>`}`:'';
  const transferInfo=hasAnyPayment?'':`<div style="max-width:58%;font-size:9px;line-height:1.5"><b>Pembayaran bisa di transfer melalui</b><br>Nomor Rekening : 0095049228 (BCA)<br>Atas Nama&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: Alfa Prima<br>Lakukan Konfirmasi dan kirim bukti transfer bila telah transfer ke nomor rekening tersebut</div>`;
  return `<style>
.alfa-invoice-detail-table{width:100%;table-layout:fixed;border-collapse:collapse}
.alfa-invoice-detail-table th,.alfa-invoice-detail-table td{
 box-sizing:border-box;padding:5px 4px;border:1px solid #aaa;
 vertical-align:top;text-align:left;white-space:normal!important;
 overflow-wrap:anywhere;word-break:normal;line-height:1.35;
}
.alfa-invoice-detail-table th{font-weight:700;background:#f1eee7}
@media print{
 @page{size:A4 portrait;margin:10mm}
 .alfa-invoice-detail-table{font-size:8px!important}
 .alfa-invoice-detail-table th,.alfa-invoice-detail-table td{padding:4px 3px}
}
</style><div style="max-width:900px;margin:auto;padding:22px;color:#172033;background:#fff;font-family:Arial,sans-serif;border:1px solid #ddd">
    <div style="display:flex;justify-content:space-between;gap:14px;padding-bottom:12px;border-bottom:3px solid #b18a3b"><div style="font-size:18px;font-weight:800;letter-spacing:1px;color:#17243a">ALFA PRIMA RENTCAR</div><div style="text-align:right;font-size:10px;line-height:1.5">Harmony Residence C16, Sendang Mulyo,<br>Tembalang, Semarang<br>Instagram: @alfaprima.rentcar<br>WhatsApp: 081226611507</div></div>
    <div style="text-align:center;padding:16px 0 10px"><h2 style="margin:0 0 7px;font-size:21px;letter-spacing:1px">${documentTitle}</h2></div>
    <div style="display:flex;justify-content:space-between;align-items:flex-start;gap:16px;padding:0 0 10px">
      <div style="text-align:left;flex:1;min-width:0">${customerInfo}</div>
      <div style="text-align:right;flex:0 0 auto;font-size:10px;line-height:1.55;white-space:nowrap">Tanggal : <b>${esc(invoiceDateLabel)}</b></div>
    </div>
    <table class="alfa-invoice-detail-table" style="width:100%;border-collapse:collapse;font-size:8.5px;line-height:1.35;color:#172033;table-layout:fixed;overflow-wrap:anywhere"><colgroup><col style="width:4%"><col style="width:16%"><col style="width:16%"><col style="width:10%"><col style="width:6%"><col style="width:35%"><col style="width:13%"></colgroup><thead><tr style="background:#f1eee7"><th>No.</th><th>Waktu &amp; Tanggal</th><th>Armada</th><th>Tujuan</th><th>Durasi</th><th>Rincian Biaya</th><th>Total</th></tr></thead><tbody>${rows}</tbody></table>
    <div style="margin-left:auto;max-width:300px;margin-top:14px;text-align:right"><div style="font-size:15px;margin-top:7px;padding:8px;border-top:2px solid #b18a3b">TOTAL: <b>${money(total)}</b></div>${paymentSummary}</div>
    <div style="display:flex;justify-content:space-between;align-items:flex-end;gap:18px;margin-top:20px">${transferInfo}<div style="width:190px;text-align:center;font-size:11px"><div>Hormat kami,</div><div style="font-weight:bold;margin-top:4px">ALFA PRIMA RENTCAR</div><div style="height:52px"></div><div style="border-top:1px solid #333;padding-top:6px;font-weight:bold">Alfa Prima</div><div>Pemilik</div></div></div>
    <p style="text-align:center;font-size:10px;margin:14px 0 0">Terima kasih telah menggunakan layanan Alfa Prima Rent Car.</p></div>`;
}
function toggleBookingCustomer(master){
  const customerId=master.dataset.customer;
  document.querySelectorAll('.invoice-book-check').forEach(box=>{
    if(box.dataset.customer===customerId)box.checked=master.checked;
  });
}
function toggleCustomerBookingDetails(customerId){
  const rows=[...document.querySelectorAll('.booking-customer-detail[data-customer]')].filter(row=>row.dataset.customer===String(customerId));
  const subtotal=[...document.querySelectorAll('.booking-customer-subtotal[data-customer]')].find(row=>row.dataset.customer===String(customerId));
  const heading=[...document.querySelectorAll('.booking-customer-group')].find(row=>row.querySelector('.booking-customer-toggle')?.getAttribute('onclick')===`toggleCustomerBookingDetails('${customerId}')`);
  const button=heading?.querySelector('.booking-customer-toggle');
  const isOpening=rows.some(row=>row.style.display==='none');
  rows.forEach(row=>row.style.display=isOpening?'table-row':'none');
  if(subtotal)subtotal.style.display=isOpening?'table-row':'none';
  if(heading)heading.classList.toggle('is-expanded',isOpening);
  if(button){button.setAttribute('aria-expanded',isOpening?'true':'false');const indicator=button.querySelector('.booking-toggle-indicator');if(indicator)indicator.textContent=isOpening?'−':'＋';}
  const anyExpanded=!!document.querySelector('.booking-customer-group.is-expanded');
  const tableHead=document.querySelector('#daftarBooking .tablewrap table thead');
  if(tableHead)tableHead.style.display=anyExpanded?'table-header-group':'none';
}
function syncBookingCustomerCheck(box){
  const customerId=box.dataset.customer;
  const boxes=[...document.querySelectorAll('.invoice-book-check')].filter(item=>item.dataset.customer===customerId);
  const master=[...document.querySelectorAll('.invoice-customer-check')].find(item=>item.dataset.customer===customerId);
  if(master)master.checked=boxes.length>0&&boxes.every(item=>item.checked);
}
function printSelectedInvoices(){
  const ids=[...document.querySelectorAll('.invoice-book-check:checked')].map(el=>el.value);
  if(!ids.length){alert('Pilih minimal satu ID Booking untuk dicetak.');return;}
  const selected=db.bookings.filter(b=>ids.includes(b.id));
  const invoice=invoiceHtmlForBookings(selected);
  const w=window.open('','_blank');
  if(!w){alert('Izinkan pop-up browser untuk mencetak invoice.');return;}
  w.document.write('<html><head><title>Dokumen Booking Terpilih</title><style>body{font:11px Arial;padding:0;color:#172033}table{width:100%;border-collapse:collapse}th,td{padding:5px;border:1px solid #bbb;text-align:left;vertical-align:top;overflow-wrap:anywhere}th{background:#eee}@page{size: A4 portrait;margin:10mm}</style><' + '/head><body>'+invoice+'<' + '/body><' + '/html>');
  w.document.close();w.onload=()=>{w.focus();w.print()};setTimeout(()=>{w.focus();w.print()},1000);
}
function showInvoice(){let id=$('invoicePick').value,month=$('invoiceMonth').value;$('invoicePreview').innerHTML=id?invoiceHtmlForCustomer(id,month):''}

function sendMonthlyInvoiceWhatsApp(){
  const customerId=$('invoicePick').value, month=$('invoiceMonth').value;
  if(!customerId){alert('Pilih pelanggan terlebih dahulu.');return;}
  if(!month){alert('Pilih bulan invoice terlebih dahulu.');return;}
  const customer=cust(customerId)||{};
  let phone=String(customer.wa||'').replace(/\D/g,'');
  if(phone.startsWith('0'))phone='62'+phone.slice(1);
  if(!phone){alert('Nomor WhatsApp pelanggan belum tersedia. Lengkapi nomor WA pada Data Pelanggan.');return;}
  const list=unpaidBookingsForCustomer(customerId,month);
  if(!list.length){alert('Tidak ada booking belum bayar untuk pelanggan ini pada bulan terpilih.');return;}
  const total=list.reduce((sum,b)=>sum+bookingGrandTotal(b.id),0);
  const totalPaid=list.reduce((sum,b)=>sum+bookingGrandPaid(b.id),0);
  const remaining=Math.max(0,total-totalPaid);
  const monthLabel=new Date(month+'-01T00:00:00').toLocaleDateString('id-ID',{month:'long',year:'numeric'});
  const bookingLines=list.map(b=>'- '+b.id+' | '+formatDateDMY(b.start)+' s.d. '+formatDateDMY(b.end)+' | '+money(bookingGrandTotal(b.id))).join('\n');
  const message=[
    'Yth. Bapak/Ibu '+(customer.nama||'Pelanggan')+',',
    '',
    'Berikut kami sampaikan tagihan penyewaan Alfa Prima Rent Car untuk '+monthLabel+'.',
    '',
    'Rincian booking:',
    bookingLines,
    '',
    'Total tagihan: '+money(total),
    'Total pembayaran: '+money(totalPaid),
    'Sisa tagihan: '+money(remaining),
    '',
    'Mohon konfirmasi setelah melakukan pembayaran. Terima kasih telah menggunakan layanan Alfa Prima Rent Car.',
    '',
    'Alfa Prima Rent Car'
  ].join('\n');
  window.open('https://wa.me/'+phone+'?text='+encodeURIComponent(message),'_blank');
  alert('WhatsApp dibuka dengan pesan invoice. Untuk mengirim PDF, cetak/simpan invoice sebagai PDF lalu lampirkan di chat WhatsApp sebelum menekan Kirim.');
}

function printInvoice(){let customerId=$('invoicePick').value,month=$('invoiceMonth').value;if(!customerId){alert('Pilih pelanggan terlebih dahulu.');return}let list=unpaidBookingsForCustomer(customerId,month);if(!list.length){alert('Tidak ada booking belum bayar untuk pelanggan ini pada bulan terpilih.');return}let w=window.open('','_blank');w.document.write('<html><head><title>Invoice Bulanan '+customerId+'</title><style>body{font:11px Arial;padding:0;color:#172033}table{width:100%;border-collapse:collapse}th,td{padding:5px;border:1px solid #bbb;text-align:left;vertical-align:top;overflow-wrap:anywhere}th{background:#eee}@page{size:A4 portrait;margin:10mm}</style><' + '/head><body>'+invoiceHtmlForCustomer(customerId,month)+'<' + '/body><' + '/html>');w.document.close();w.onload=()=>{const imgs=[...w.document.images];Promise.all(imgs.map(img=>img.decode?img.decode().catch(()=>{}):new Promise(resolve=>{img.onload=img.onerror=resolve}))).then(()=>{w.focus();w.print()})};setTimeout(()=>{w.focus();w.print()},1200)}
$('invoiceMonth').onchange=()=>{render();showInvoice()};
$('reportMonth').onchange=render;
function printReport(){window.print()}
function backup(){let blob=new Blob([JSON.stringify(db,null,2)],{type:'application/json'}),a=document.createElement('a');a.href=URL.createObjectURL(blob);a.download='backup_alfa_prima_rent_car.json';a.click();URL.revokeObjectURL(a.href)}
$('restoreFile').onchange=e=>{let f=e.target.files[0];if(!f)return;let r=new FileReader();r.onload=()=>{try{let x=JSON.parse(r.result);if(!x.customers||!x.cars||!x.bookings||!x.payments)throw Error();if(!x.expenses)x.expenses=[];if(confirm('Pulihkan backup? Data saat ini akan diganti.')){db=x;save();alert('Backup berhasil dipulihkan.')}}catch(err){alert('File backup tidak valid.')}};r.readAsText(f);e.target.value=''};
function exportCSV(){let rows=[['ID Booking','ID Pelanggan','Nama','ID Armada','Jenis Armada','Tanggal Awal','Tanggal Akhir','Lama Hari','Harga/Hari','Total','Dibayar','Sisa','Status'],...db.bookings.map(b=>[b.id,b.customerId,cust(b.customerId)?.nama||'',b.carId,car(b.carId)?.jenis||'',b.start,b.end,b.days,b.rate,b.total,paid(b.id),Math.max(0,b.total-paid(b.id)),statusBook(b)])];let csv=rows.map(r=>r.map(v=>'"'+String(v??'').replace(/"/g,'""')+'"').join(';')).join('\n');let blob=new Blob(['\ufeff'+csv],{type:'text/csv;charset=utf-8'}),a=document.createElement('a');a.href=URL.createObjectURL(blob);a.download='laporan_booking_alfa_prima.csv';a.click();URL.revokeObjectURL(a.href)}
function clearAll(){if(currentUser?.role!=='admin'){alert('Hanya admin yang dapat menghapus seluruh data.');return}if(confirm('Yakin menghapus SELURUH data pelanggan, armada, booking, dan pembayaran? Unduh backup terlebih dahulu.')){db={customers:[],cars:[],bookings:[],payments:[],expenses:[],partners:[],partnerPayments:[],accounts:[],journals:[]};save()}}
['qCust','qCar','qBook'].forEach(id=>$(id).addEventListener('input',render));
$('qUnpaidCustomer')?.addEventListener('input',render);
function normalizeDb(data){
  return {customers:Array.isArray(data.customers)?data.customers:[],
          cars:Array.isArray(data.cars)?data.cars:[],
          bookings:Array.isArray(data.bookings)?data.bookings:[],
          payments:Array.isArray(data.payments)?data.payments:[],
          otherCharges:Array.isArray(data.otherCharges)?data.otherCharges:[],
          expenses:Array.isArray(data.expenses)?data.expenses:[],partners:Array.isArray(data.partners)?data.partners:[],partnerPayments:Array.isArray(data.partnerPayments)?data.partnerPayments:[],accounts:Array.isArray(data.accounts)?data.accounts:[],journals:Array.isArray(data.journals)?data.journals:[],drivers:Array.isArray(data.drivers)?data.drivers:[],driverPayments:Array.isArray(data.driverPayments)?data.driverPayments:[]};
}
function bindAuthForm(){
  const form = $('authForm');
  if (!form) return;
  form.onsubmit = async e => {
    e.preventDefault();
    const username = $('authUser')?.value.trim() || '', password = $('authPass')?.value || '';
    if (!username || !password) {
      alert('Silakan masukkan username dan password.');
      return;
    }
    try {
      setSyncStatus('Memeriksa akun…', '#cbd5e1');
      const res = await apiCall('/api/login', 'POST', { username, password });
      currentUser = res.user;
      document.body.classList.remove('auth-required');
      if ($('authScreen')) $('authScreen').style.display = 'none';
      await loadAppData();
    } catch (err) {
      alert('Login gagal: ' + err.message);
      setSyncStatus('Login gagal: ' + err.message, '#ffb3b3');
    }
  };
}

function authView(mode){
  document.body.classList.add('auth-required');
  if ($('authScreen')) $('authScreen').style.display = 'flex';
  const content=$('authContent');
  if (content) {
    content.innerHTML=`<h3 style="margin-top:0;margin-bottom:14px;font-size:1.05rem;color:#e2e8f0">Masuk ke Aplikasi</h3>
      <form id="authForm">
        <div class="field"><label>Username</label><input id="authUser" required autocomplete="username" placeholder="Masukkan username"></div>
        <div class="field" style="margin-top:12px"><label>Password</label><input id="authPass" type="password" required autocomplete="current-password" placeholder="Masukkan password"></div>
        <button class="btn primary" style="width:100%;margin-top:18px" type="submit">Login</button>
      </form>`;
    bindAuthForm();
  }
}

async function loadAppData(){
  setSyncStatus('Mengambil data dari database MySQL…');
  try {
    const res = await apiCall('/api/load-data');
    if (!res.user) {
      currentUser = null;
      document.body.classList.add('auth-required');
      if ($('authScreen')) $('authScreen').style.display = 'flex';
      authView('login');
      setSyncStatus('Silakan login terlebih dahulu', '#cbd5e1');
      return;
    }
    db = normalizeDb(res.db || {});
    currentUser = res.user;
    document.body.classList.remove('auth-required');
    if ($('authScreen')) $('authScreen').style.display = 'none';
    if ($('usersNav')) $('usersNav').classList.toggle('hidden', currentUser.role !== 'admin');
    if ($('toolbarUsersNav')) $('toolbarUsersNav').classList.toggle('hidden', currentUser.role !== 'admin');
    if ($('nikField')) $('nikField').classList.toggle('hidden', currentUser.role !== 'admin');
    if ($('simField')) $('simField').classList.toggle('hidden', currentUser.role !== 'admin');

    $('eCar').innerHTML='<option value="">Biaya umum usaha</option>'+db.cars.map(a=>`<option value="${a.id}">${esc(a.jenis)} (${esc(a.plat)})</option>`).join('');
    $('aPartner').innerHTML='<option value="">Pilih mitra (jika milik mitra)</option>'+db.partners.map(m=>`<option value="${m.id}">${esc(m.name)} (${m.id})</option>`).join('');
    $('partnerRows').innerHTML=db.partners.map(m=>`<tr><td>${esc(m.id)}</td><td>${esc(m.name)}</td><td>${esc(m.wa)}</td><td>${esc(m.address)}</td><td>${esc(m.bank)}</td><td>${esc(m.accountNo)}</td></tr>`).join('')||'<tr><td colspan="6">Belum ada mitra.</td></tr>';
    renderPartnerBookings();
    renderPartnerPaymentSection();
    $('journalRows').innerHTML=db.journals.map(j=>`<tr><td>${esc(j.id)}</td><td>${esc(j.date)}</td><td>${esc(j.note)}</td><td>${esc(j.debitAccount)}</td><td>${esc(j.creditAccount)}</td><td>${money(j.amount)}</td></tr>`).join('')||'<tr><td colspan="6">Belum ada jurnal manual.</td></tr>';
    let jDebit=db.journals.reduce((s,j)=>s+Number(j.amount||0),0);$('jDebitTotal').textContent=money(jDebit);$('jCreditTotal').textContent=money(jDebit);
    let ledger=[];db.payments.forEach(p=>{let b=book(p.bookingId),a=b?car(b.carId):null,amount=Number(p.amount||0);ledger.push({date:String(p.date||'').slice(0,10),account:'1101 Kas/Bank',note:'Penerimaan pelanggan '+p.bookingId,debit:amount,credit:0});if(a?.ownership==='mitra'){let shareTotal=Number(b.partnerRate??a.partnerRate??0)*Number(b.days||0);let sharePart=b.total>0?Math.min(amount,amount*shareTotal/b.total):0;ledger.push({date:String(p.date||'').slice(0,10),account:'2101 Utang Mitra',note:'Bagian pemilik '+p.bookingId,debit:0,credit:sharePart});ledger.push({date:String(p.date||'').slice(0,10),account:'4201 Pendapatan Margin Mitra',note:'Margin '+p.bookingId,debit:0,credit:amount-sharePart})}else{ledger.push({date:String(p.date||'').slice(0,10),account:'4101 Pendapatan Sewa',note:'Pendapatan sewa '+p.bookingId,debit:0,credit:amount})}});
    db.expenses.forEach(x=>{ledger.push({date:x.date,account:'5101 Beban Operasional',note:x.note||x.category,debit:x.amount,credit:0});ledger.push({date:x.date,account:'1101 Kas/Bank',note:x.note||x.category,debit:0,credit:x.amount})});
    db.driverPayments.forEach(p=>{ledger.push({date:p.date,account:'5102 Beban Honor Driver',note:'Pembayaran driver '+p.bookingId,debit:p.amount,credit:0});ledger.push({date:p.date,account:'1101 Kas/Bank',note:'Pembayaran driver '+p.bookingId,debit:0,credit:p.amount})});
    db.partnerPayments.forEach(p=>{ledger.push({date:p.date,account:'2101 Utang Mitra',note:'Pembayaran mitra '+p.bookingId,debit:p.amount,credit:0});ledger.push({date:p.date,account:'1101 Kas/Bank',note:'Pembayaran mitra '+p.bookingId,debit:0,credit:p.amount})});
    db.journals.forEach(j=>{ledger.push({date:j.date,account:j.debitAccount,note:j.note,debit:j.amount,credit:0});ledger.push({date:j.date,account:j.creditAccount,note:j.note,debit:0,credit:j.amount})});
    ledger.sort((a,b)=>a.date.localeCompare(b.date));let balances={};$('ledgerRows').innerHTML=ledger.map(x=>{balances[x.account]=(balances[x.account]||0)+Number(x.debit||0)-Number(x.credit||0);return `<tr><td>${esc(x.date)}</td><td>${esc(x.account)}</td><td>${esc(x.note)}</td><td>${money(x.debit)}</td><td>${money(x.credit)}</td><td>${money(balances[x.account])}</td></tr>`}).join('')||'<tr><td colspan="6">Belum ada mutasi buku besar.</td></tr>';
    let carRows=db.cars.map(a=>{let inc=db.payments.filter(p=>book(p.bookingId)?.carId===a.id).reduce((s,p)=>s+Number(p.amount||0),0);let partnerShare=a.ownership==='mitra'?db.bookings.filter(b=>b.carId===a.id).reduce((s,b)=>s+Number(b.partnerRate??a.partnerRate??0)*Number(b.days||0),0):0;let partnerPaid=db.partnerPayments.filter(p=>db.bookings.find(b=>b.id===p.bookingId)?.carId===a.id).reduce((s,p)=>s+Number(p.amount||0),0);let direct=db.expenses.filter(x=>x.carId===a.id).reduce((s,x)=>s+Number(x.amount||0),0);let result=a.ownership==='mitra'?inc-partnerPaid-direct:inc-direct;return `<tr><td>${esc(a.jenis)} (${esc(a.plat)})</td><td>${a.ownership==='mitra'?'Mitra':'Sendiri'}</td><td>${money(inc)}</td><td>${money(a.ownership==='mitra'?partnerPaid:0)}</td><td>${money(direct)}</td><td>${money(result)}</td></tr>`}).join('');
    $('carProfitRows').innerHTML=carRows||'<tr><td colspan="6">Belum ada kendaraan.</td></tr>';
    let totalDriver=db.driverPayments.reduce((sum,p)=>sum+Number(p.amount||0),0);let totalIn=db.payments.reduce((s,p)=>s+Number(p.amount||0),0),totalPartner=db.partnerPayments.reduce((s,p)=>s+Number(p.amount||0),0),totalExp=db.expenses.reduce((s,x)=>s+Number(x.amount||0),0);$('overallProfit').textContent='Hasil kas usaha (seluruh periode): '+money(totalIn-totalPartner-totalExp-totalDriver);
    if($('invoiceMonth')&&!$('invoiceMonth').value)$('invoiceMonth').value=new Date().toISOString().slice(0,7);
    if($('reportMonth')&&!$('reportMonth').value)$('reportMonth').value=new Date().toISOString().slice(0,7);

    render();
    setSyncStatus('Login: '+currentUser.username+' ('+currentUser.role+') • MySQL tersambung ✓','#64c69a');
    if(currentUser.role==='admin') renderUsers();
  } catch (err) {
    setSyncStatus('Gagal mengambil data MySQL: ' + err.message, '#ffb3b3');
    alert('Gagal mengambil data MySQL: ' + err.message);
  }
}

async function renderUsers(){
  if(currentUser?.role!=='admin')return;
  try {
    const users = await apiCall('/api/users');
    $('userRows').innerHTML=users.map(u=>`<tr><td>${esc(u.username)}</td><td>${esc(u.role)}</td><td>${u.active?'Aktif':'Nonaktif'}</td><td class="no-print">${u.role==='admin'?'':`<button class="btn small ${u.active?'danger':''}" onclick="toggleUser('${u.id}',${!u.active})">${u.active?'Nonaktifkan':'Aktifkan'}</button>`}</td></tr>`).join('')||'<tr><td colspan="4">Belum ada pengguna.</td></tr>';
  } catch (e) {
    console.error('Gagal memuat pengguna:', e);
  }
}

$('userForm').onsubmit=async e=>{
  e.preventDefault();
  if(currentUser?.role!=='admin'){alert('Hanya admin yang dapat membuat akun.');return}
  const username=$('uName').value.trim(),password=$('uPass').value;
  try {
    await apiCall('/api/users', 'POST', { username, password });
    $('userForm').reset();
    await renderUsers();
    alert('Akun karyawan berhasil dibuat.');
  } catch (err) {
    alert('Gagal membuat akun: ' + err.message);
  }
};

async function toggleUser(id,active){
  if(currentUser?.role!=='admin')return;
  if(!confirm((active?'Aktifkan':'Nonaktifkan')+' akun karyawan?'))return;
  try {
    await apiCall('/api/users/'+id+'/toggle', 'POST', { active });
    await renderUsers();
  } catch (e) {
    alert('Gagal mengubah status akun: ' + e.message);
  }
}

if ($('logoutBtn')) {
  $('logoutBtn').style.display = 'inline-block';
  $('logoutBtn').onclick = async () => {
    try {
      await apiCall('/api/logout', 'POST');
    } catch (_) {}
    currentUser = null;
    authView('login');
    setSyncStatus('Sesi berakhir', '#ffb3b3');
  };
}

async function startApp() {
  bindAuthForm();
  try {
    await loadAppData();
  } catch (err) {
    console.error('Startup error:', err);
    authView('login');
  }
}
startApp();

// Progressive Web App (PWA) Support
let deferredPrompt = null;
window.addEventListener('beforeinstallprompt', e => {
  e.preventDefault();
  deferredPrompt = e;
  const btn = $('installPwaBtn');
  if (btn) btn.style.display = 'inline-block';
});

if ($('installPwaBtn')) {
  $('installPwaBtn').onclick = async () => {
    if (deferredPrompt) {
      deferredPrompt.prompt();
      const choice = await deferredPrompt.userChoice;
      if (choice && choice.outcome === 'accepted') {
        $('installPwaBtn').style.display = 'none';
      }
      deferredPrompt = null;
    } else {
      alert('Untuk memasang di HP Android:\n1. Buka menu browser Chrome (titik 3 di pojok kanan atas)\n2. Pilih "Tambahkan ke Layar Utama" atau "Install Aplikasi".');
    }
  };
}

window.addEventListener('appinstalled', () => {
  if ($('installPwaBtn')) $('installPwaBtn').style.display = 'none';
  deferredPrompt = null;
});

if ('serviceWorker' in navigator) {
  window.addEventListener('load', () => {
    navigator.serviceWorker.register('/sw.js').catch(err => {
      console.log('SW registration note:', err);
    });
  });
}
</script></body></html>