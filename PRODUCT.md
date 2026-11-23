# Product

<!-- impeccable:product-schema 1 -->

## Platform

web

## Users

- **Admin Fakultas (level 1):** Manages active academic years, Renstra and PTN-BH indicator catalogs, department accounts, signatory officials (Pejabat), and oversees faculty-wide KPI progress.
- **Dekan / Pimpinan (level 0):** Reviews, approves, or rejects department KPI targets and monitors quarterly achievement charts across departments.
- **Operator / Kepala Departemen (level 2):** Submits annual KPI targets, uploads supporting evidence documents, and reports quarterly realizations (Triwulan 1–4) scoped strictly to their own department.
- **Portfolio Evaluators (in Demo Mode):** Visitors exploring all roles and workflows safely with scheduled daily resets.

## Product Purpose

SI-IKU centralizes key performance indicator (IKU) planning, target approval, quarterly realization tracking, evidence archiving, and formal PDF/Excel reporting across academic departments under both Renstra and PTN-BH tracks.

## Positioning

A unified academic KPI governance workspace linking multi-track indicators (Renstra & PTN-BH), department-scoped target approval, quarterly rollover snapshots (Triwulan 1–4), and verifiable PDF report generation in one self-hosted system.

## Operating Context

- Desktop-first institutional office environment during periodic planning, approval, and quarterly reporting cycles, with occasional mobile checks.
- Dual-mode deployment: must operate reliably in real faculty workflows and cleanly in public portfolio demo mode (`DEMO_MODE=true` with daily auto-reset).
- Flows: Authentication -> Track Dashboard (Renstra / PTN-BH) -> Target Submission & Approval -> Quarterly Realization & Evidence Upload -> Config & PDF Export.

## Capabilities and Constraints

- Built on Laravel 9 (PHP ^8.0), Blade templates, Bootstrap 5, Chart.js/ApexCharts (or chart scripts), MySQL (TiDB Cloud), and `barryvdh/laravel-snappy` (`wkhtmltopdf`) for PDF generation.
- Role-based authorization (`cekUserLogin:0/1/2`) and department-prefix IDOR isolation must hold on every route and controller action.
- Multi-step target approval and quarterly realization workflows may be streamlined for clarity without dropping core functions (Renstra & PTN-BH dashboards, Excel indicator import, Target approval/reject/batch-approve, Triwulan 1–4 rollover, Pejabat signatures & PDF downloads, Departemen & Tahun config).

## Brand Commitments

- Neutral institutional identity: **SI-IKU — Sistem Informasi Indikator Kinerja Utama Fakultas Sains dan Matematika** (or neutral faculty naming), removing specific university logos/hotlinks and third-party university branding in favor of neutral institutional emblems/marks.

## Evidence on Hand

- Seeded faculty departments (`01`–`06`), Renstra & PTN-BH indicators, targets, Triwulan 1–2 realizations, and signatory officials (`PejabatSeeder`).
- No `PRODUCT.md` or `DESIGN.md` existed previously; visual world is being replaced.

## Product Principles

1. **Clarity over ceremony:** Role state, active year, active quarter, and required next actions are unmistakable at first glance.
2. **Department & role precision:** Users only see and act on data their role authorizes, with zero silent privilege leaks or null-state crashes.
3. **Printable & operational rigor:** Forms, tables, and exported PDF reports keep clean hierarchy, tabular numbers, and complete empty/error states.
4. **Demo-safe without compromise:** Security controls, CSRF protection, and validation stay active in both demo and live operation.
