<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>PILAR — Pusat Informasi dan Laporan Aset yang Rusak</title>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,700;1,700&family=Plus+Jakarta+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
<style>
  *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

  :root {
    --bg:       #fdf6f0;
    --white:    #ffffff;
    --pink:     #f472b6;
    --pink-lt:  #fce7f3;
    --blue:     #60a5fa;
    --blue-dk:  #3b82f6;
    --text:     #1e293b;
    --muted:    #94a3b8;
    --border:   #e2e8f0;
    --ok:       #22c55e;
    --danger:   #ef4444;
    --warn:     #f59e0b;
    --radius:   18px;
    --shadow:   0 8px 40px rgba(0,0,0,.08);
    --trans:    .22s cubic-bezier(.4,0,.2,1);
  }

  body {
    min-height: 100vh;
    background: var(--bg);
    display: flex;
    flex-direction: column;
    align-items: center;
    font-family: 'Plus Jakarta Sans', sans-serif;
    color: var(--text);
  }

  /* ── top bar ── */
  .topbar {
    width: 100%;
    padding: 18px 40px;
    display: flex;
    align-items: center;
    gap: 10px;
  }
  .back-btn {
    background: none; border: none; cursor: pointer;
    font-size: 20px; color: var(--muted);
    transition: color var(--trans);
  }
  .back-btn:hover { color: var(--text); }

  /* ── header ── */
  .header {
    text-align: center;
    padding: 10px 20px 28px;
    animation: fadeDown .5s ease both;
  }
  .logo-placeholder {
    width: 64px; height: 64px;
    background: linear-gradient(135deg, #1d4ed8, #0ea5e9);
    border-radius: 16px;
    display: flex; align-items: center; justify-content: center;
    margin: 0 auto 10px;
    font-size: 28px;
  }
  .brand-name {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-weight: 600;
    font-size: 13px;
    letter-spacing: 2px;
    color: var(--blue-dk);
    margin-bottom: 2px;
  }
  .brand-sub {
    font-size: 10px;
    color: var(--muted);
    letter-spacing: 1px;
    text-transform: uppercase;
    margin-bottom: 14px;
  }
  .page-title {
    font-family: 'Playfair Display', serif;
    font-style: italic;
    font-size: 36px;
    font-weight: 700;
    color: var(--text);
    line-height: 1.15;
    margin-bottom: 8px;
  }
  .page-desc {
    font-size: 13.5px;
    color: var(--muted);
    max-width: 380px;
    line-height: 1.6;
  }

  /* ── main layout ── */
  .main {
    display: flex;
    align-items: flex-start;
    gap: 48px;
    padding: 0 40px 60px;
    width: 100%;
    max-width: 960px;
    animation: fadeUp .5s ease both .1s;
  }

  /* ── logo side ── */
  .logo-side {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding-top: 30px;
    flex-shrink: 0;
  }
  .logo-big {
    width: 200px; height: 200px;
    background: linear-gradient(145deg, #1e40af, #0284c7, #0ea5e9);
    border-radius: 28px;
    display: flex; align-items: center; justify-content: center;
    font-size: 80px;
    margin-bottom: 16px;
    box-shadow: 0 12px 40px #1d4ed833;
  }
  .logo-big-label {
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-weight: 700;
    font-size: 22px;
    letter-spacing: 3px;
    color: #1d4ed8;
  }
  .logo-big-sub {
    font-size: 10px;
    color: var(--muted);
    text-align: center;
    letter-spacing: 1px;
    text-transform: uppercase;
    max-width: 180px;
    line-height: 1.5;
    margin-top: 4px;
  }

  /* ── card ── */
  .card {
    flex: 1;
    background: var(--white);
    border-radius: var(--radius);
    padding: 36px 40px;
    box-shadow: var(--shadow);
    border: 1px solid var(--border);
  }

  /* ── input field ── */
  .field { margin-bottom: 16px; }

  .input-wrap {
    position: relative;
    display: flex;
    align-items: center;
  }
  .input-wrap input {
    width: 100%;
    padding: 14px 48px 14px 18px;
    background: #f8fafc;
    border: 1.5px solid var(--border);
    border-radius: 12px;
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 14px;
    color: var(--text);
    outline: none;
    transition: var(--trans);
  }
  .input-wrap input::placeholder { color: var(--muted); }
  .input-wrap input:focus {
    border-color: var(--blue);
    background: #fff;
    box-shadow: 0 0 0 3px #60a5fa22;
  }
  .input-wrap input.valid   { border-color: var(--ok);     box-shadow: 0 0 0 3px #22c55e18; }
  .input-wrap input.invalid { border-color: var(--danger);  box-shadow: 0 0 0 3px #ef444418; }

  .input-icon {
    position: absolute; right: 14px;
    color: var(--muted); font-size: 17px;
    pointer-events: none;
  }
  .eye-btn {
    position: absolute; right: 14px;
    background: none; border: none;
    color: var(--muted); font-size: 16px;
    cursor: pointer; padding: 0;
    transition: color var(--trans);
  }
  .eye-btn:hover { color: var(--text); }

  /* select */
  .input-wrap select {
    width: 100%;
    padding: 14px 18px;
    background: #f8fafc;
    border: 1.5px solid var(--border);
    border-radius: 12px;
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 14px;
    color: var(--text);
    outline: none;
    transition: var(--trans);
    appearance: none;
    cursor: pointer;
  }
  .input-wrap select:focus {
    border-color: var(--blue);
    background: #fff;
    box-shadow: 0 0 0 3px #60a5fa22;
  }

  /* remeber row */
  .row-flex {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 16px;
    font-size: 13px;
  }
  .check-label {
    display: flex; align-items: center; gap: 7px;
    cursor: pointer; color: var(--text);
    user-select: none;
  }
  .check-label input[type=checkbox] { accent-color: var(--blue-dk); width: 15px; height: 15px; }
  .forgot { color: var(--blue-dk); text-decoration: none; font-weight: 500; font-size: 13px; }
  .forgot:hover { text-decoration: underline; }

  /* pw strength */
  .pw-strength { margin-top: 10px; display: none; }
  .bar-wrap { display: flex; gap: 4px; margin-bottom: 9px; }
  .bar-seg {
    flex: 1; height: 4px; border-radius: 4px;
    background: var(--border);
    transition: background var(--trans);
  }
  .strength-lbl {
    font-size: 11px; font-weight: 600;
    letter-spacing: .4px; text-transform: uppercase;
    margin-bottom: 8px; color: var(--muted);
  }
  .req-list { list-style: none; display: flex; flex-direction: column; gap: 5px; }
  .req-item {
    display: flex; align-items: center; gap: 8px;
    font-size: 12.5px; color: var(--muted);
    transition: color var(--trans);
  }
  .req-item.ok   { color: var(--ok); }
  .req-item.fail { color: var(--danger); }
  .req-dot {
    width: 16px; height: 16px; border-radius: 50%;
    border: 1.5px solid var(--muted);
    display: flex; align-items: center; justify-content: center;
    font-size: 9px; flex-shrink: 0;
    transition: var(--trans);
  }
  .req-item.ok   .req-dot { border-color: var(--ok);    background: #dcfce7; color: var(--ok); }
  .req-item.fail .req-dot { border-color: var(--danger); background: #fee2e2; color: var(--danger); }

  /* buttons */
  .btn-pink {
    width: 100%; padding: 14px;
    background: linear-gradient(135deg, #f9a8d4, #f472b6);
    color: #fff; border: none; border-radius: 12px;
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 15px; font-weight: 600;
    cursor: pointer; transition: var(--trans);
    box-shadow: 0 4px 16px #f472b633;
    margin-bottom: 16px;
  }
  .btn-pink:hover  { transform: translateY(-2px); box-shadow: 0 8px 24px #f472b655; }
  .btn-pink:active { transform: translateY(0); }
  .btn-pink:disabled { opacity: .5; cursor: not-allowed; transform: none; }

  .btn-blue {
    width: 100%; padding: 14px;
    background: linear-gradient(135deg, var(--blue), var(--blue-dk));
    color: #fff; border: none; border-radius: 12px;
    font-family: 'Plus Jakarta Sans', sans-serif;
    font-size: 15px; font-weight: 600;
    cursor: pointer; transition: var(--trans);
    box-shadow: 0 4px 16px #3b82f633;
    margin-bottom: 16px;
  }
  .btn-blue:hover  { transform: translateY(-2px); box-shadow: 0 8px 24px #3b82f655; }
  .btn-blue:active { transform: translateY(0); }
  .btn-blue:disabled { opacity: .5; cursor: not-allowed; transform: none; }

  .divider {
    display: flex; align-items: center; gap: 12px;
    margin-bottom: 12px; color: var(--muted); font-size: 12px;
  }
  .divider::before, .divider::after {
    content: ''; flex: 1; height: 1px; background: var(--border);
  }

  .bottom-note {
    text-align: center; font-size: 13px;
    color: var(--muted); margin-top: 6px;
  }
  .hint-text { font-size: 12.5px; color: var(--muted); text-align: center; }

  .switch-text {
    text-align: center; font-size: 13.5px;
    color: var(--muted); margin-top: 24px;
  }
  .switch-text a {
    color: var(--blue-dk); font-weight: 600;
    text-decoration: none;
  }
  .switch-text a:hover { text-decoration: underline; }

  .alert {
    padding: 11px 14px; border-radius: 10px;
    font-size: 13px; margin-bottom: 14px;
    display: none;
  }
  .alert.show    { display: block; animation: fadeUp .25s ease both; }
  .alert.success { background: #dcfce7; border: 1px solid #86efac; color: #15803d; }
  .alert.error   { background: #fee2e2; border: 1px solid #fca5a5; color: #b91c1c; }
  .alert.info    { background: #eff6ff; border: 1px solid #93c5fd; color: #1d4ed8; }

  .spinner {
    display: inline-block; width: 13px; height: 13px;
    border: 2px solid #ffffff66; border-top-color: #fff;
    border-radius: 50%; animation: spin .6s linear infinite;
    vertical-align: middle; margin-right: 6px;
  }
  @keyframes spin    { to { transform: rotate(360deg); } }
  @keyframes fadeDown { from{opacity:0;transform:translateY(-16px)} to{opacity:1;transform:translateY(0)} }
  @keyframes fadeUp   { from{opacity:0;transform:translateY(12px)}  to{opacity:1;transform:translateY(0)} }

  .section { display: none; }
  .section.active { display: block; animation: fadeUp .3s ease both; }

  @media (max-width: 680px) {
    .logo-side { display: none; }
    .main { padding: 0 16px 40px; }
    .card { padding: 28px 22px; }
    .page-title { font-size: 28px; }
  }
</style>
</head>
<body>

<div class="topbar">
  <button class="back-btn" onclick="window.location.href='../../index.php'">&#8592;</button>
</div>

<div class="header" id="pageHeader">
  <div class="logo-placeholder">🏛️</div>
  <div class="brand-name">PILAR</div>
  <div class="brand-sub">Pusat Informasi dan Laporan Aset yang Rusak</div>
  <div class="page-title" id="pageTitle">Selamat Datang</div>
  <div class="page-desc" id="pageDesc">Masuk akunmu dan lanjutkan pelaporan fasilitas yang rusak! 👋</div>
</div>

<div class="main">

  <div class="logo-side">
    <div class="logo-big">🏛️</div>
    <div class="logo-big-label">PILAR</div>
    <div class="logo-big-sub">Pusat Informasi dan Laporan Aset yang Rusak</div>
  </div>

  <div class="card">
    <div class="alert" id="alertBox"></div>

    <div class="section active" id="loginSection">
      <div class="field">
        <div class="input-wrap">
          <input type="text" id="loginIdentifier" placeholder="Email atau Username">
          <span class="input-icon">✉️</span>
        </div>
      </div>

      <div class="field">
        <div class="input-wrap">
          <input type="password" id="loginPassword" placeholder="Password">
          <button class="eye-btn" type="button" onclick="toggleEye('loginPassword',this)">👁</button>
        </div>
      </div>

      <div class="row-flex">
        <label class="check-label">
          <input type="checkbox" id="rememberMe"> Ingat Saya
        </label>
        <a href="#" class="forgot">Lupa Password?</a>
      </div>

      <button class="btn-pink" id="loginBtn" onclick="doLogin()">Masuk Sekarang</button>
      <div class="divider">or</div>
      <div class="hint-text">Akses mudah, lebih aman, dan lebih cepat untuk melapor! 😊</div>
      <div class="switch-text">
        Belum memiliki akun? <a href="#" onclick="switchTo('register')">Daftar Disini</a>
      </div>
    </div>

    <div class="section" id="registerSection">
      <div class="field">
        <div class="input-wrap">
          <input type="text" id="regNama" placeholder="Nama Lengkap">
          <span class="input-icon">👤</span>
        </div>
      </div>

      <div class="field">
        <div class="input-wrap">
          <input type="email" id="regEmail" placeholder="Email">
          <span class="input-icon">✉️</span>
        </div>
      </div>

      <div class="field">
        <div class="input-wrap">
          <input type="text" id="regUsername" placeholder="Username">
          <span class="input-icon">👤</span>
        </div>
      </div>

      <div class="field">
        <div class="input-wrap">
          <select id="regKategori">
            <option value="">-- Kategori Pengguna --</option>
            <option value="mahasiswa">Mahasiswa</option>
            <option value="dosen">Dosen</option>
            <option value="staff">Staff</option>
          </select>
        </div>
      </div>

      <div class="field">
        <div class="input-wrap">
          <input type="text" id="regRole" value="pelapor" readonly>
          <span class="input-icon">🔒</span>
        </div>
        <span class="autofill-tag">✦ Auto-fill: pelapor</span>
      </div>

      <div class="field">
        <div class="input-wrap">
          <input type="password" id="regPassword" placeholder="Password (Min. 8 karakter)" oninput="checkPassword(this.value)">
          <button class="eye-btn" type="button" onclick="toggleEye('regPassword',this)">🔒</button>
        </div>

        <div class="pw-strength" id="pwStrength">
          <div style="display:flex;align-items:center;justify-content:space-between;margin:10px 0 6px">
            <span class="strength-lbl" id="strengthLbl">Kekuatan Password</span>
          </div>
          <div class="bar-wrap">
            <div class="bar-seg" id="s1"></div>
            <div class="bar-seg" id="s2"></div>
            <div class="bar-seg" id="s3"></div>
            <div class="bar-seg" id="s4"></div>
          </div>
          <ul class="req-list">
            <li class="req-item" id="r-len">  <span class="req-dot"></span> Minimal 8 karakter</li>
            <li class="req-item" id="r-upper"><span class="req-dot"></span> Huruf kapital (A–Z)</li>
            <li class="req-item" id="r-lower"><span class="req-dot"></span> Huruf kecil (a–z)</li>
            <li class="req-item" id="r-num">  <span class="req-dot"></span> Angka (0–9)</li>
            <li class="req-item" id="r-sym">  <span class="req-dot"></span> Simbol (!@#$% …)</li>
          </ul>
        </div>
      </div>

      <div class="field">
        <div class="input-wrap">
          <input type="password" id="regKonfirmasi" placeholder="Konfirmasi Password" oninput="checkConfirm()">
          <button class="eye-btn" type="button" onclick="toggleEye('regKonfirmasi',this)">🔒</button>
        </div>
      </div>

      <button class="btn-blue" id="registerBtn" onclick="doRegister()">Daftar Sekarang</button>
      <div class="divider">atau</div>
      <div class="hint-text">Daftar dengan email aktif untuk verifikasi lebih mudah! 😊</div>
      <div class="switch-text">
        Sudah memiliki akun? <a href="#" onclick="switchTo('login')">Masuk Disini</a>
      </div>
    </div>

  </div>
</div>

<script>
function switchTo(page) {
  const isLogin = page === 'login';
  document.getElementById('loginSection').classList.toggle('active', isLogin);
  document.getElementById('registerSection').classList.toggle('active', !isLogin);
  document.getElementById('pageTitle').textContent = isLogin ? 'Selamat Datang' : 'Bergabunglah';
  document.getElementById('pageDesc').textContent  = isLogin
    ? 'Masuk akunmu dan lanjutkan pelaporan fasilitas yang rusak! 👋'
    : 'Buat akunmu dan mari mulai laporin masalah fasilitas di kampus,\nBantu kami membuat kampus menjadi lebih baik! 😍';
  clearAlert();
}

function toggleEye(id, btn) {
  const inp = document.getElementById(id);
  const isPass = inp.type === 'password';
  inp.type = isPass ? 'text' : 'password';
  btn.textContent = isPass ? '🙈' : '🔒';
}

function showAlert(type, msg) {
  const el = document.getElementById('alertBox');
  el.className = `alert ${type} show`;
  el.innerHTML = msg;
  el.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
}
function clearAlert() {
  const el = document.getElementById('alertBox');
  el.className = 'alert'; el.textContent = '';
}

const rules = {
  'r-len':   v => v.length >= 8,
  'r-upper': v => /[A-Z]/.test(v),
  'r-lower': v => /[a-z]/.test(v),
  'r-num':   v => /[0-9]/.test(v),
  'r-sym':   v => /[^A-Za-z0-9]/.test(v),
};

function checkPassword(val) {
  const wrap = document.getElementById('pwStrength');
  if (!val) { wrap.style.display = 'none'; return; }
  wrap.style.display = 'block';

  let passed = 0;
  for (const [id, fn] of Object.entries(rules)) {
    const li   = document.getElementById(id);
    const dot  = li.querySelector('.req-dot');
    const ok   = fn(val);
    li.className = 'req-item ' + (ok ? 'ok' : 'fail');
    dot.textContent = ok ? '✓' : '✕';
    if (ok) passed++;
  }

  const colors  = ['#ef4444','#f59e0b','#60a5fa','#22c55e'];
  const labels  = ['Sangat Lemah','Lemah','Cukup Kuat','Kuat','Sangat Kuat'];
  const strength = passed === 0 ? 0 : passed <= 2 ? 1 : passed <= 3 ? 2 : passed === 4 ? 3 : 4;
  ['s1','s2','s3','s4'].forEach((s,i) => {
    document.getElementById(s).style.background =
      i < strength ? colors[Math.min(strength-1,3)] : 'var(--border)';
  });
  const lbl = document.getElementById('strengthLbl');
  lbl.textContent = labels[strength];
  lbl.style.color = strength < 2 ? '#ef4444' : strength < 4 ? '#f59e0b' : '#22c55e';

  checkConfirm();
}

function checkConfirm() {
  const pw = document.getElementById('regPassword').value;
  const cf = document.getElementById('regKonfirmasi');
  if (!cf.value) { cf.classList.remove('valid','invalid'); return; }
  cf.classList.toggle('valid',   pw === cf.value);
  cf.classList.toggle('invalid', pw !== cf.value);
}

function isPasswordStrong(pw) {
  return Object.values(rules).every(fn => fn(pw));
}

async function doRegister() {
  clearAlert();
  const nama       = document.getElementById('regNama').value.trim();
  const email      = document.getElementById('regEmail').value.trim();
  const username   = document.getElementById('regUsername').value.trim();
  const kategori   = document.getElementById('regKategori').value;
  const password   = document.getElementById('regPassword').value;
  const konfirmasi = document.getElementById('regKonfirmasi').value;

  if (!nama || !email || !username || !kategori || !password || !konfirmasi)
    return showAlert('error', '⚠ Semua field wajib diisi.');

  if (!isPasswordStrong(password))
    return showAlert('error', '⚠ Password belum memenuhi semua persyaratan.');

  if (password !== konfirmasi)
    return showAlert('error', '⚠ Konfirmasi password tidak cocok.');

  const btn = document.getElementById('registerBtn');
  btn.disabled = true;
  btn.innerHTML = '<span class="spinner"></span>Mendaftarkan...';
  showAlert('info', '🔐 Mengenkripsi password dan menyimpan data...');

  const body = new URLSearchParams({ nama, email, username, password, konfirmasi, status_pengguna: kategori });

  try {
    const res  = await fetch('../../controllers/Register.php', { method: 'POST', body });
    const data = await res.json();
    showAlert(data.status === 'success' ? 'success' : 'error', data.message);
    if (data.status === 'success') {
      setTimeout(() => switchTo('login'), 2500);
      ['regNama','regEmail','regUsername','regPassword','regKonfirmasi'].forEach(id =>
        document.getElementById(id).value = '');
      document.getElementById('regKategori').value = '';
      document.getElementById('pwStrength').style.display = 'none';
    }
  } catch (e) {
    showAlert('error', '⚠ Gagal terhubung ke server.');
  }

  btn.disabled = false;
  btn.innerHTML = 'Daftar Sekarang';
}

async function doLogin() {
  clearAlert();
  const identifier = document.getElementById('loginIdentifier').value.trim();
  const password   = document.getElementById('loginPassword').value;
  const remember   = document.getElementById('rememberMe').checked ? '1' : '0';

  if (!identifier || !password)
    return showAlert('error', '⚠ Email/username dan password wajib diisi.');

  const btn = document.getElementById('loginBtn');
  btn.disabled = true;
  btn.innerHTML = '<span class="spinner"></span>Memverifikasi...';
  showAlert('info', '🔍 Memeriksa kredensial...');

  const body = new URLSearchParams({ identifier, password, remember });

  try {
    const res  = await fetch('../../controllers/Login.php', { method: 'POST', body });
    const data = await res.json();
    showAlert(data.status === 'success' ? 'success' : 'error', data.message);
    if (data.status === 'success') {
      setTimeout(() => {
        const role = data.user.role;
        if (role === 'admin') 
            window.location.href = '../admin/dashboard/data.php';
        else if (role === 'manager_teknisi') 
            window.location.href = '../manager_teknisi/dashboard/data.php';
        else 
            window.location.href = '../pelapor/dashboard/data.php';
      }, 1500);
    }
  } catch (e) {
    showAlert('error', '⚠ Gagal terhubung ke server.');
  }

  btn.disabled = false;
  btn.innerHTML = 'Masuk Sekarang';
}

document.addEventListener('keydown', e => {
  if (e.key !== 'Enter') return;
  document.getElementById('loginSection').classList.contains('active')
    ? doLogin() : doRegister();
});
</script>
</body>
</html>