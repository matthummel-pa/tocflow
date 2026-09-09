# TOCflow

<p align="center">
  <img src="docs/assets/tocflow-logo.svg" alt="TOCflow — WordPress Table of Contents block" width="440">
</p>

<p align="center">
  <strong>A server-rendered Table of Contents block for WordPress.</strong><br>
  Add one block. Get an accessible, SEO-friendly outline from your headings.
</p>

<p align="center">
  <a href="https://matthummel-pa.github.io/tocflow/"><strong>Docs</strong></a>
  ·
  <a href="https://github.com/matthummel-pa/tocflow/releases/latest">Download</a>
  ·
  <a href="https://github.com/matthummel-pa/tocflow/issues">Issues</a>
  ·
  <a href="LICENSE">GPLv2 or later</a>
</p>

<p align="center">
  <a href="https://github.com/matthummel-pa/tocflow/actions/workflows/ci.yml"><img alt="CI" src="https://github.com/matthummel-pa/tocflow/actions/workflows/ci.yml/badge.svg"></a>
  <img alt="WordPress" src="https://img.shields.io/badge/WordPress-6.4%2B-3858e9">
  <img alt="PHP" src="https://img.shields.io/badge/PHP-7.4%2B-777bb3">
  <img alt="License" src="https://img.shields.io/badge/license-GPLv2%20or%20later-1b1f24">
</p>

---

## What's new — v1.3.1 (Sep 2026)

> For WordPress.org reviewers: the sections below describe every change since v1.0.2.

### v1.3.1 — Security & code-quality fix

| Fix | Detail |
|---|---|
| **`WordPress.Security.EscapeOutput`** | `$swatch_val` in the admin colour-picker `printf()` was pre-escaped at construction; moved `esc_attr()` to the call site — the only form WordPress.org reviewers accept |
| **Missing PHPDoc** | Added doc block for `TOCflow_Settings::sanitize()` |
| **Inline comment style** | Fixed casing and trailing full-stop in `class-tocflow-plugin.php` (WPCS `Squiz.Commenting.InlineComment`) |
| **Array alignment** | PHPCBF auto-corrected 181 `=>` alignment and indentation warnings across PHP files |
| **Short description length** | Trimmed `readme.txt` short description from 175 → 145 characters (WordPress.org parser enforces a 150-character max; longer values are silently truncated) |

### v1.3.0 — Global design & accessibility settings

| Feature | Where | Detail |
|---|---|---|
| **Design & Appearance** | Settings → TOCflow | Background, text, link colours; font size, weight, line height; border width/style/colour/radius; padding — all applied as CSS custom properties (`--tocflow-bg`, `--tocflow-color`, etc.) |
| **Reading Guide defaults** | Settings → TOCflow | Global on/off for hover preview, guide mode, section previews, density bars, read time, progress fade, reactions, citations, and citation format |
| **Study Tools & Export defaults** | Settings → TOCflow | Global on/off for reading progress bar, resume bookmark, reader note pads, export toolbar |
| **Accessibility — focus ring style** | Settings → TOCflow | Default (underline), Bold (3 px outline, WCAG 2.1 AA), High-contrast (yellow background, WCAG 2.1 AAA) via `data-tocflow-focus` |
| **Admin colour picker** | Settings page JS | Hex text input syncs with `<input type=color>` swatch; guide sub-options show/hide when guide mode is toggled |

All global defaults apply to auto-inserted blocks and shortcodes. Per-block editor settings always override them.

### v1.2.2 — WordPress.org compliance fixes

| Fix | Detail |
|---|---|
| **`TOCFLOW_VERSION` constant** | Was stuck at `1.2.0`; corrected to `1.2.2` |
| **`Tested up to`** | Updated from `6.7` → `7.1` (WP 7.1 "Mary Lou" released 2026-08-19) |
| **Tags** | Removed third-party trademark `elementor`; replaced with `study tools` |
| **PHP indentation** | Fixed WPCS 3-tab → 4-tab on shortcode Study-tool attrs and admin settings view |
| **readme.txt entries** | Added `= 1.2.1 =` and `= 1.2.2 =` Changelog + Upgrade Notice entries |
| **GitHub Actions** | Bumped `softprops/action-gh-release` from v2 → v3 (Node 20 → Node 24 runtime) |

### v1.2.1 — Performance patch

| Fix | Detail |
|---|---|
| **Bookmark localStorage debounce** | Debounced resume-bookmark writes from every `IntersectionObserver` callback to every 500 ms — prevents redundant writes during fast scrolling |

### v1.2.0 — Study assistant & writer tools

| Feature | How to enable | Where state lives |
|---|---|---|
| **Reading progress bar** (0–100 % of headings read) | "Study Tools" panel → "Reading progress bar", or `rprogress="1"` shortcode | Client only — `IntersectionObserver`, no server |
| **Resume reading bookmark** (↩ Resume button on return) | "Study Tools" → "Resume reading bookmark", or `bookmark="1"` | `localStorage` key `tocflow-bm-{post_id}` |
| **Reader note pads** (📝 per-section personal notes) | "Study Tools" → "Reader note pads", or `rnotes="1"` | `localStorage` key `tocflow-rn-{post_id}-{slug}` |
| **Section Planner** (writing status per heading for authors) | Block sidebar → "Section Planner" panel | `sectionStatus` block attribute — never sent to front end |
| **Total read-time badge** | Automatic when Reading Guide + read-time are both active | Computed server-side from word counts, no extra query |

All three reader tools are **off by default**. They only activate when the author explicitly enables them. No feature writes to the database; no feature makes a network call.

### v1.1.0 — Reading Guide, hover previews, citations, page-builder compatibility

| Feature | Default | Notes |
|---|---|---|
| **Reading Guide mode** (previews, density bars, read time, progress fading) | Off | `guideMode` attribute; server-side word-count extraction |
| **Hover section preview** (floating tooltip on TOC link) | Off | `previewOnHover`; `aria-describedby`; viewport-aware |
| **Emoji reactions** per section (💡 ⭐ 🤔 ✅) | Off | `localStorage` only |
| **Academic citations** (APA, MLA, Chicago, Harvard, plain) | Off | Built from WP post meta; no external API |
| **Export / print toolbar** (Copy .md, Download .md, Download .doc, Print) | Off | Blob API + `navigator.clipboard`; no server |
| **Elementor** heading extraction | Automatic fallback | Parses `_elementor_data` widget JSON |
| **Bricks Builder** heading extraction | Automatic fallback | Parses `_bricks_page_content_2` JSON |
| **Divi, WPBakery, Oxygen, Beaver, Breakdance** heading extraction | Automatic fallback | HTML regex scan of `post_content` |
| **Accessibility** (`aria-live`, `focus-visible`, `aria-expanded`) | Always on | WCAG 2.1 AA compatible |

Full entry-by-entry detail in [`CHANGELOG.md`](CHANGELOG.md).

---

## Performance

TOCflow is built to add **zero measurable overhead** on pages that don't use it, and minimal overhead on pages that do.

| Concern | How TOCflow handles it |
|---|---|
| **Assets on unrelated pages** | JS + CSS only load on singular posts/pages that contain the block, shortcode, or auto-insert target. The `enqueue_front_assets()` check gates all enqueues. |
| **Front-end JavaScript** | `view.js` — 13 KB minified, ~4 KB gzipped. Loaded via `block.json viewScript` (WordPress handles the dependency). No jQuery. No framework. |
| **Front-end CSS** | `style-index.css` — 19 KB minified, ~4 KB gzipped. One file; no render-blocking imports. |
| **Scroll event handlers** | None. All scroll-position features (`initScrollSpy`, `initProgressTracking`, `initReadingProgress`, `initBookmark`) use `IntersectionObserver` — passive, runs off the main thread. The only `scroll` listener (`window.addEventListener('scroll', pick, { passive: true })`) is in the scroll-spy fallback and is marked passive. |
| **localStorage writes** | Reader notes are debounced (400 ms). Bookmark writes are debounced (500 ms). localStorage is never read or written until the author explicitly enables a study tool. |
| **PHP database queries** | `TOCflow_Headings::get_all()` and `get_sections()` cache their results in a static array — at most one `get_post()` call per post per request. No extra `WP_Query` or custom table reads. |
| **Remote calls** | None, ever. No phone-home, no CDN assets, no tracking pixels, no external fonts loaded by the plugin. |
| **`the_content` filters** | Two filters run at priority 12 and 999, both guarded by `is_singular() && in_the_loop() && is_main_query()`. The builder ID-injection filter (999) short-circuits immediately on pure Gutenberg posts. |
| **`prefers-reduced-motion`** | Smooth scroll and CSS transitions respect the OS preference. |

---

## Why TOCflow

- **Zero config** — insert the block; the outline builds itself.
- **Server-rendered** — the list is in the first HTML response (SEO + screen readers).
- **Accurate anchors** — matching `id`s are injected into headings; custom HTML anchors win.
- **Accessible** — a `<nav>` landmark, keyboard-friendly collapse, `aria-current` while you read.
- **Study-ready** — reading progress, personal notes, bookmarks, citations, and export — all without any account or server dependency.
- **Compatible** — Gutenberg, Elementor, Divi, Bricks, Beaver Builder, WPBakery, Oxygen, Breakdance, and every major theme.

### Features

- Live preview in the editor as you add or edit headings
- H1–H6 (H1 off by default), numbered or bulleted, five style presets
- Smooth scroll + offset for sticky headers (`prefers-reduced-motion` respected)
- Collapse/expand, sticky outline, scroll-spy highlight
- Auto-insert (top of content or after the first heading)
- `[tocflow]` shortcode for classic content and page builders
- Skip a heading with the class `no-toc`
- Optional ItemList JSON-LD schema
- Settings + Docs & Support screens in wp-admin

The plugin slug, folder, and text domain are **`tocflow`**. Display name: **TOCflow**. See [`docs/NAMING.md`](docs/NAMING.md).

---

## Install

Current version: **1.3.1**.

1. Download `tocflow.zip` from [Releases](https://github.com/matthummel-pa/tocflow/releases).
2. In WordPress: **Plugins → Add New → Upload Plugin**.
3. Activate. Optional: **Settings → TOCflow**.

Or clone this repo into `wp-content/plugins/tocflow`, run `npm install && npm run build`, and activate.

### Use the block

1. Edit a post that has **Heading** blocks.
2. Insert **Table of Contents** (usually right after the intro).
3. In the sidebar: title, heading levels, list style, preset, collapse, sticky.

### Shortcode

```
[tocflow]
[tocflow title="On this page" ordered="1" style="boxed"]
```

---

## Screenshots

<p align="center">
  <img src="docs/assets/tocflow-settings-panel.svg" alt="Block settings" width="420">
  <img src="docs/assets/tocflow-output.svg" alt="Front-end outline" width="420">
</p>

---

## Documentation

| Doc | Who it is for |
| --- | --- |
| [Support site](https://matthummel-pa.github.io/tocflow/) | Users, buyers, reviewers |
| [User guide](docs/USER_SOP.md) | Site owners |
| [Developer SOP](docs/DEVELOPER_SOP.md) | Contributors |
| [Support policy](SUPPORT.md) | Buyers / WordPress.org users |
| [Security](SECURITY.md) · [Privacy](PRIVACY.md) | Vulnerability reports and data handling |
| [Marketplace kit](docs/marketplace/README.md) | WordPress.org and CodeCanyon |
| [Changelog](CHANGELOG.md) | Release history |
| [WordPress.org rules](docs/wordpress-org/PLUGIN_DIRECTORY.md) | Plugin Directory FAQ + guidelines |

---

## Develop

Requires **Node.js 20+** (see `.nvmrc`).

```bash
git clone https://github.com/matthummel-pa/tocflow.git
cd tocflow
npm install
npm run start          # watch
# npm run build        # production
npm run lint:js
npm run lint:css
npx --package=@wordpress/env wp-env start   # optional local WordPress
```

The compiled `build/` directory is gitignored — build at least once before activating the plugin.

PHP: `composer install` then `composer phpcs`. See [`docs/DEVELOPER_SOP.md`](docs/DEVELOPER_SOP.md) and [`CONTRIBUTING.md`](CONTRIBUTING.md).

---

## License

[GPLv2 or later](LICENSE) — the whole plugin (PHP, JavaScript, CSS, and images), same family as WordPress.

Copyright © 2026 Matt Hummel.
