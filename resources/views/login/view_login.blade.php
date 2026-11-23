<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Masuk — SI-IKU Fakultas</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@500;600&family=Source+Sans+3:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet">
  <link href="{{ asset('css/folio.css') }}" rel="stylesheet">
</head>
<body>
<div class="si-login-shell">
  <section class="si-login-aside">
    <div class="d-flex align-items-center gap-3">
      <svg width="36" height="36" viewBox="0 0 32 32" fill="none" aria-hidden="true">
        <rect x="2" y="2" width="28" height="28" rx="6" fill="#1D4ED8"/>
        <path d="M9 10H23M9 16H19M9 22H15" stroke="#FFFFFF" stroke-width="2.4" stroke-linecap="round"/>
        <circle cx="22" cy="21" r="3" fill="#10B981"/>
      </svg>
      <div>
        <div class="fw-bold fs-5 text-white">SI-IKU Fakultas</div>
        <div class="small text-secondary">Sistem Informasi Indikator Kinerja Utama</div>
      </div>
    </div>

    <div style="max-width: 440px;">
      <h1 class="h2 fw-bold text-white mb-3">Tata Kelola Target, Realisasi, &amp; Pelaporan Kinerja Terpadu</h1>
      <p class="mb-4" style="color: #cbd5e1; line-height: 1.65;">
        Mengelola penetapan indikator Renstra &amp; PTN-BH, persetujuan target departemen, pelaporan realisasi Triwulan 1–4, serta pengesahan laporan PDF dalam satu workspace terstruktur.
      </p>
      <div class="d-flex flex-column gap-2 small" style="color: #94a3b8;">
        <div><i class="fa-solid fa-check text-success me-2"></i>Pemisahan peran Admin Fakultas, Dekan, dan Operator Departemen</div>
        <div><i class="fa-solid fa-check text-success me-2"></i>Tracking progres per triwulan dengan arsip dokumen bukti</div>
        <div><i class="fa-solid fa-check text-success me-2"></i>Ekspor laporan PDF terformat resmi per departemen</div>
      </div>
    </div>

    <div class="small" style="color: #64748b;">
      SI-IKU Governance Workspace · {{ date('Y') }}
    </div>
  </section>

  <main class="si-login-main">
    <div class="si-login-card">
      <div class="d-flex align-items-center gap-2 mb-4 d-lg-none">
        <svg width="28" height="28" viewBox="0 0 32 32" fill="none" aria-hidden="true">
          <rect x="2" y="2" width="28" height="28" rx="6" fill="#1D4ED8"/>
          <path d="M9 10H23M9 16H19M9 22H15" stroke="#FFFFFF" stroke-width="2.4" stroke-linecap="round"/>
          <circle cx="22" cy="21" r="3" fill="#10B981"/>
        </svg>
        <span class="fw-bold fs-5">SI-IKU Fakultas</span>
      </div>

      <h2 class="h4 fw-bold mb-1">Masuk ke Workspace</h2>
      <p class="text-muted small mb-4">Gunakan username akun fakultas, pimpinan, atau departemen Anda.</p>

      <form action="{{ url('login/proses') }}" method="post">
        @csrf
        <div class="mb-3">
          <label for="username" class="form-label fw-semibold small">Username</label>
          <input id="username" autofocus type="text" class="form-control @error('username') is-invalid @enderror" placeholder="Masukkan username" name="username" value="{{ old('username') }}" required>
          @error('username')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <div class="mb-3">
          <label for="password" class="form-label fw-semibold small">Password</label>
          <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Masukkan password" name="password" required>
          @error('password')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <button type="submit" class="btn btn-si-primary w-100 py-2 mt-1">
          Masuk <i class="fa-solid fa-arrow-right ms-1"></i>
        </button>
      </form>

      @if (config('app.demo_mode') && config('app.demo_login_password'))
        <div class="mt-4 p-3 rounded border" style="background: var(--si-sheet-muted); border-color: var(--si-border) !important;">
          <div class="fw-bold small mb-2">Akun Demo Siap Pakai</div>
          <div class="d-flex flex-wrap gap-1 mb-2">
            <button type="button" class="btn btn-sm btn-si-outline py-0 px-2 si-demo-fill" data-user="admin">admin (Fakultas)</button>
            <button type="button" class="btn btn-sm btn-si-outline py-0 px-2 si-demo-fill" data-user="dekan">dekan (Approval)</button>
            <button type="button" class="btn btn-sm btn-si-outline py-0 px-2 si-demo-fill" data-user="adminMatematika">adminMatematika</button>
          </div>
          <div class="small text-muted">
            Password semua akun: <code class="si-mono">{{ config('app.demo_login_password') }}</code><br>
            Database di-reset otomatis setiap hari pukul 03:00 WIB.
          </div>
        </div>
        <script>
          document.querySelectorAll('.si-demo-fill').forEach((btn) => {
            btn.addEventListener('click', () => {
              document.getElementById('username').value = btn.dataset.user;
              document.getElementById('password').value = @json(config('app.demo_login_password'));
            });
          });
        </script>
      @endif
    </div>
  </main>
</div>
</body>
</html>
