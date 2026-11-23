---
name: SI-IKU Fakultas
description: University Senate Folio design system for academic KPI target approval and quarterly realization governance.
colors:
  senate-indigo: "#182234"
  senate-indigo-elevated: "#212e45"
  royal-cobalt: "#1d4ed8"
  royal-cobalt-deep: "#1e40af"
  cobalt-tint: "#eff6ff"
  archival-stone: "#f6f5f1"
  folio-sheet: "#ffffff"
  sheet-muted: "#faf9f6"
  stone-hairline: "#e2e0d8"
  stone-strong: "#c8c4b8"
  muted-slate: "#525e71"
  semantic-emerald: "#047857"
  semantic-amber: "#b45309"
  semantic-crimson: "#b91c1c"
typography:
  display:
    fontFamily: "Source Sans 3, system-ui, -apple-system, sans-serif"
    fontSize: "1.5rem"
    fontWeight: 700
    lineHeight: 1.2
    letterSpacing: "-0.02em"
  title:
    fontFamily: "Source Sans 3, system-ui, -apple-system, sans-serif"
    fontSize: "1rem"
    fontWeight: 600
    lineHeight: 1.3
  body:
    fontFamily: "Source Sans 3, system-ui, -apple-system, sans-serif"
    fontSize: "0.875rem"
    fontWeight: 400
    lineHeight: 1.55
  mono:
    fontFamily: "JetBrains Mono, ui-monospace, monospace"
    fontSize: "0.8125rem"
    fontWeight: 500
    lineHeight: 1.4
rounded:
  sm: "6px"
  md: "10px"
  lg: "12px"
spacing:
  sm: "8px"
  md: "16px"
  lg: "24px"
components:
  button-primary:
    backgroundColor: "{colors.royal-cobalt}"
    textColor: "{colors.folio-sheet}"
    rounded: "{rounded.sm}"
    padding: "8px 14px"
  button-primary-hover:
    backgroundColor: "{colors.royal-cobalt-deep}"
  card-sheet:
    backgroundColor: "{colors.folio-sheet}"
    rounded: "{rounded.lg}"
    padding: "20px"
  nav-rail:
    backgroundColor: "{colors.senate-indigo}"
    textColor: "{colors.folio-sheet}"
    width: "248px"
---

# Design System: SI-IKU Fakultas

## Overview

**Creative North Star: "University Senate Folio"**

University Senate Folio treats faculty KPI governance like an authoritative academic ledger rather than generic SaaS card-soup. A deep slate-indigo rail anchors persistent navigation across Renstra and PTN-BH tracks while wide, sunlit archival-stone workspaces hold crisp white data sheets divided by clean 1px hairlines.

Every surface reinforces operational clarity across academic roles (Dean, Faculty Admin, and Department Operator): permissions stay explicit, quarterly rollover phases stay legible at a glance, and destructive governance actions (`Tolak`, `Hapus`, `Akhiri Triwulan`) remain visually isolated from routine saves.

**Key Characteristics:**
- Anchored `248px` slate-indigo left rail paired with warm archival stone ground (`#f6f5f1`).
- Persistent **Quarterly Rollover Ribbon** surfacing active year (`tahun`) and Triwulan 1–4 progression beneath the sticky bar.
- Strict tabular numeral alignment (`JetBrains Mono` + `tabular-nums`) for KPI codes, target totals, and department scores.
- Spatial isolation for destructive actions (`Tolak`, `Hapus`) separated from constructive actions (`Simpan`, `Setujui`).

## Colors

The palette pairs authoritative university slate-indigo with warm stone neutrals and disciplined royal-cobalt primary CTAs.

### Primary
- **Royal Cobalt** (`#1d4ed8`): Reserved for primary operational CTAs (`Simpan`, `Login`, active rollover phase badges, and focus states).
- **Royal Cobalt Deep** (`#1e40af`): Hover and pressed feedback on primary buttons and interactive links.
- **Cobalt Tint** (`#eff6ff`): Subtle highlight background for active phases in the Quarterly Rollover Ribbon.

### Semantic
- **Semantic Emerald** (`#047857`): Approved KPI targets (`Disetujui`), completed quarterly milestones, and positive verification alerts.
- **Semantic Amber** (`#b45309`): Pending verification (`Menunggu Persetujuan`) and draft alerts.
- **Semantic Crimson** (`#b91c1c`): Rejected targets (`Ditolak`), validation errors, and destructive confirmation controls.

### Neutral
- **Senate Indigo** (`#182234`): Primary ink for headings/values and the full-height navigation rail background.
- **Archival Stone** (`#f6f5f1`): Default page background canvas separating white content sheets without heavy drop shadows.
- **Folio Sheet** (`#ffffff`): Crisp working surfaces for tables, charts, forms, and KPI cards.
- **Stone Hairline** (`#e2e0d8`): Structural `1px` borders across sheets, dividers, and table rows.
- **Muted Slate** (`#525e71`): Secondary metadata, labels, and breadcrumb context.

### Named Rules
**The Isolated Destructive Rule.** Destructive actions (`Tolak`, `Hapus`, `Akhiri Triwulan`) use semantic crimson styling and must be spatially separated from constructive primary cobalt buttons so operators never confirm an irreversible governance action by habit.

## Typography

**Display & Body Font:** `Source Sans 3` (fallback: `system-ui, -apple-system, sans-serif`)
**Label/Mono Font:** `JetBrains Mono` (fallback: `ui-monospace, monospace`)

**Character:** Clear humanist sans-serif built for high-density academic governance tables, paired with monospaced tabular codes for IKU identifiers (`IKU 1.1`, department codes) and numeric realizations.

### Hierarchy
- **Display / Page Title** (`700`, `1.5rem`, `1.2` line-height): Main view headings (`Renstra Fakultas`, `Target PTN-BH`).
- **Title / Sheet Heading** (`600`, `1rem`, `1.3` line-height): Panel headings above comparison charts and KPI tables.
- **Body** (`400`, `0.875rem`, `1.55` line-height): Form labels, table descriptions, and operational feedback.
- **Mono / Code** (`500`, `0.8125rem`, `1.4` line-height): KPI codes, dates, counts, and percentage comparisons with `tabular-nums`.

## Layout

Fixed `248px` left rail collapsing cleanly into a backdrop-backed slide-over drawer below `992px`. Sticky top bar (`60px`) carries breadcrumb context and POST logout; directly beneath it sits the horizontal **Quarterly Rollover Ribbon**, followed by a 4-column summary stat strip and responsive `1px`-bordered content sheets inside a centered container.

## Elevation & Depth

Surface hierarchy uses tonal contrast (`#f6f5f1` canvas vs `#ffffff` sheets) and `1px solid #e2e0d8` structural borders instead of heavy box shadows. Elevated popovers (user dropdown, mobile drawer) use subtle slate transparency rather than harsh offsets.

### Named Rules
**The Flat-Sheet Rule.** KPI sheets and summary tiles rest flat on the archival stone ground with `1px` borders; depth comes from surface contrast and clean whitespace, never decorative shadows or colored side-stripes.

## Shapes

Consistent crisp corners: `6px` on form controls and buttons, `10px` on stat tiles and alerts, and `12px` on primary KPI work sheets. No nested card-inside-card boxes.

## Components

### Buttons
- **Shape:** `6px` border-radius with compact `8px 14px` padding.
- **Primary:** Solid Royal Cobalt (`#1d4ed8`) background, white text, transitions to `#1e40af` on hover.
- **Secondary / Ghost:** Crisp white (`#ffffff`) with `1px solid #c8c4b8` outline and `#182234` ink.

### Quarterly Rollover Ribbon
- Displays `Tahun Aktif` alongside sequential phase pills (`Target` -> `TW 1` -> `TW 2` -> `TW 3` -> `TW 4`) with emerald completed states, cobalt active indicator, and isolated closure control when permitted.

### Cards / Containers
- **Corner Style:** `12px` radius on `#ffffff` background with `1px solid #e2e0d8`.
- **Internal Padding:** `20px` header and body rhythm separated by clean horizontal rules.

### Navigation
- `248px` `#182234` left rail grouping Renstra, PTN-BH, and Pengaturan sections with accessible `aria-expanded` collapsible submenus.

## Do's and Don'ts

### Do:
- **Do** render KPI codes, target totals, and triwulan numbers with `tabular-nums` (`JetBrains Mono` for codes).
- **Do** keep `Tolak`, `Hapus`, and quarter rollover buttons visually isolated and confirmed intentionally.

### Don't:
- **Don't** place university-specific external hotlinks, logos, or text in faculty branding; keep neutral `SI-IKU Fakultas` identity.
- **Don't** add small spaced-uppercase eyebrow kickers above section titles or colored `4px` left stripes on rounded cards.
