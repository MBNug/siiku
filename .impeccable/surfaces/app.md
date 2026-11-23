---
version: 1
slug: "app"
primary_target: "app"
related_targets: []
---

# Surface Brief — SI-IKU Workspace

- **Scope & Mode:** Authenticated academic KPI workspace (`/`, `/renstra/*`, `/ptnbh/*`, `/config/*`, `/login`), Operate mode (code-led).
- **Audience & Task:** Faculty Admins (level 1), Deans (level 0), and Department Operators (level 2) monitoring annual KPI targets, approving/rejecting targets, reporting quarterly realizations (Triwulan 1–4), managing evidence files, and exporting PDF reports.
- **Constraints:** Preserve all role permissions, neutral faculty branding (remove specific university logo hotlinks/names), tabular data readability, and production/demo parity.

## Direction contract

- **THESIS:** University Senate Folio refuses generic SaaS card-soup by framing faculty KPI tracking as a structured governance workspace anchored by a persistent Quarterly Rollover Ribbon showing approval state and active quarter across Renstra and PTN-BH tracks.
- **OWN-WORLD:** Deep academic slate-indigo navigation rail (`#182234`), warm archival stone canvas (`#F6F5F1`), crisp white sheets (`#FFFFFF`), 1px stone borders (`#E2E0D8`), royal cobalt primary actions (`#1D4ED8`), and semantic emerald/amber/crimson state tokens; paired with `Source Sans 3` UI typography and `JetBrains Mono` tabular KPI codes/numerals.
- **STORY:** An operator or dean logs in, immediately knows the active year (`2026`), current phase (Target Approval vs Realisasi TW 1–4), and exact counts per department, and completes approvals, realization updates, or PDF exports without losing track of permissions or destructive actions.
- **FIRST VIEWPORT:** Left `248px` slate-indigo rail with Renstra, PTN-BH, and Config groups (`aria-expanded` collapsibles); sticky clean top bar showing track breadcrumb, active user badge, and POST logout; directly beneath it the Quarterly Rollover Ribbon (`Target -> TW 1 -> TW 2 -> TW 3 -> TW 4`); followed by a 4-column summary strip and department realization comparison chart + table.
- **FORM:** University Senate Folio, candidate 4 of 7 grounded directions, seed:3ae0e5ee42c99340. Raised with spatial isolation around destructive actions (`Tolak`, `Hapus`, `Akhiri Triwulan`) and symmetric tabular alignment across department comparison columns.
- **FINISH:** unreviewed and undocumented is unfinished; this build ends with the finish review, the verdict, DESIGN.md, and every shipping raster carrying its provenance.
