# Changelog

All notable changes to TOCflow are documented here.
This project adheres to [Semantic Versioning](https://semver.org/).

## [1.3.1] - 2026-09-09

### Fixed
- **`WordPress.Security.EscapeOutput`**: `$swatch_val` in the admin colour-picker `printf()` was pre-escaped at construction time but not at the call site — PHPCS (and WordPress.org reviewers) require escaping _at the point of output_. Moved `esc_attr()` to the `printf` argument and removed the premature escape.
- Added missing PHPDoc block for `TOCflow_Settings::sanitize()`.
- Inline comment in `class-tocflow-plugin.php` now ends with a full stop (WPCS `Squiz.Commenting.InlineComment`).
- PHPCBF auto-corrected 181 array-alignment and indentation warnings across three PHP files.

## [1.3.0] - 2026-09-08

### Added
- **Settings → Design & Appearance**: global background colour, text colour, link colour, font size, font weight, line height, border (width / style / colour / radius), and padding. Applied as CSS custom properties (`--tocflow-bg`, `--tocflow-color`, `--tocflow-link-color`, `--tocflow-font-size`, etc.) so per-block editor overrides still cascade correctly.
- **Settings → Reading Guide & Study Tools**: global defaults for hover preview, guide mode, section previews, density bars, per-section read time, progress fade, emoji reactions, academic citations, and citation format.
- **Settings → Study Tools & Export**: global defaults for reading progress bar, resume bookmark, reader note pads, and export toolbar.
- **Settings → Accessibility**: focus ring style picker — Default (underline), Bold (3 px outline, WCAG 2.1 AA), or High-contrast (yellow background + black outline, WCAG 2.1 AAA). Rendered as `data-tocflow-focus` attribute on the `<nav>`.
- `admin/js/admin.js`: vanilla JS that syncs hex text inputs with companion `<input type=color>` swatches and toggles guide-mode sub-options when the guide-mode checkbox is toggled.
- `admin/css/admin.css`: styles for color-picker widget, section badge chips, and indented guide sub-options panel.

### Changed
- CSS custom properties now drive the root border, padding, background, font-size, and link colour so global design settings layer cleanly beneath block-level inline styles from Gutenberg's block supports.
- `is-style-minimal` preset explicitly resets design custom props to ensure the preset always wins over any global colour/padding setting.
- `block_attributes()` now passes Reading Guide, Study Tools, and Export defaults to auto-inserted blocks.

## [1.2.2] - 2026-09-08

### Fixed
- `TOCFLOW_VERSION` constant was `'1.2.0'` while the plugin header read `1.2.1` / `1.2.2`; in-admin version badge now matches.
- `Tested up to` updated from `6.7` to `7.1` (WordPress 7.1 "Mary Lou" released 2026-08-19).
- Removed third-party trademark tag `elementor`; replaced with descriptive `study tools`.
- PHP WPCS: fixed 3-tab indentation on Study-tool shortcode attributes (should be 4-tab like surrounding code).
- Admin view: fixed indentation on shortcode-docs `<p>` tags in `admin/views/settings.php`.

## [1.2.1] - 2026-09-08

### Changed
- Debounced bookmark `localStorage` writes to 500 ms (previously wrote on every `IntersectionObserver` callback during scroll — could fire once per heading during fast scrolling).

### Documentation
- `CHANGELOG.md`: completed v1.1.0 entry with hover preview, export/print toolbar, accessibility, and full page-builder compatibility details.
- `README.md`: added "What's new" feature tables for v1.1.0 and v1.2.0 for WordPress.org reviewers; added "Performance" section documenting asset-loading gates, `IntersectionObserver` use, no remote calls, debounced storage writes, and PHP static caches.

## [1.2.0] - 2026-09-08

### Added
- **Reader note pads** — a 📝 button per section lets readers jot personal notes stored privately in localStorage. No account, no server. Enable with `rnotes="1"` in the shortcode or the "Reader note pads" toggle in the block sidebar.
- **Reading progress bar** — a thin animated bar shows 0–100% of the document read (headings scrolled past via IntersectionObserver). Enable with `rprogress="1"`.
- **Resume reading bookmark** — automatically bookmarks the last-read heading in localStorage and shows a "↩ Resume" button on return visits. Enable with `bookmark="1"`.
- **Section Planner** — the "Section Notes" sidebar panel is now "Section Planner" with per-heading writing status (✏️ Draft / 🔄 In progress / ✅ Done) tracked in the editor canvas and a reader-facing teaser note.
- **Total read-time badge** — when Reading Guide + read-time are active, the TOC header shows the aggregated total read time for the entire post.
- New shortcode attributes: `rprogress`, `bookmark`, `rnotes`.
- New block attributes: `showReaderNotes`, `showReadingProgress`, `showBookmark`, `sectionStatus`.

## [1.1.0] - 2026-09-08

### Added
- **Reading Guide mode** — opt-in block feature that enriches the TOC into a full reading companion:
  - **Section content previews** — opening ~20 words of each section, extracted server-side from parsed block content via `TOCflow_Headings::get_sections()` (no JS fetch, no external API).
  - **Content density bars** — thin bar showing each section's word count relative to the longest section, computed at render time.
  - **Per-section read-time estimates** — `~N min` badge based on word count ÷ 200 wpm.
  - **Reading progress** — `IntersectionObserver` fades each TOC item as the reader scrolls past its heading (no scroll event handlers; passive main thread).
- **Author section notes** — block attribute `sectionNotes` (object keyed by heading slug). Writers type a per-section teaser or hook in the "Section Notes" sidebar panel; readers reveal it with a ✍ toggle button.
- **Emoji reactions** — readers react per section (💡 ⭐ 🤔 ✅); state stored in `localStorage`, zero server calls, zero accounts.
- **Per-section academic citations** — § button copies a formatted citation (APA / MLA / Chicago / Harvard / plain link) built entirely from WordPress post meta. No external API.
- **Hover section preview** — floating tooltip on TOC link hover/focus shows the section's opening sentence. Viewport-aware positioning (left or right). `aria-describedby` links the tooltip to the anchor for screen readers. `previewOnHover` attribute; works without full Reading Guide mode.
- **Export / print toolbar** — `showExport` attribute adds Copy (.md), Download (.md), Download (.doc), and Print buttons below the outline using only the Blob API and `navigator.clipboard`; zero server round-trips. Screen reader live region announces success.
- **Accessibility** — `aria-live="polite"` region for clipboard and export announcements; `focus-visible` outlines on all interactive elements; all buttons labeled; note and export toggles use `aria-expanded` / `aria-controls` / `hidden`.
- **Page-builder compatibility** — `TOCflow_Headings::get_all()` now falls back to builder-specific parsers when `parse_blocks()` finds no headings:
  - **Elementor** — walks `_elementor_data` widget JSON to find heading widgets and Text Editor blocks.
  - **Bricks Builder** — reads `_bricks_page_content_2` element JSON.
  - **Divi, WPBakery, Oxygen, Beaver Builder, Breakdance, Classic Editor** — generic `<h*>` regex scan of `post_content`.
  - `inject_builder_heading_ids()` runs as `the_content` filter at priority 999 so headings inside builder output receive matching `id` attributes.
  - `should_inject_ids()` now scans builder meta for `[tocflow]` shortcodes so assets load correctly even when the shortcode lives inside a builder widget.
  - `get_sections()` extended with `builder_raw_html()` and `flatten_html_to_sequence()` fallbacks so Reading Guide previews and read-time estimates work on builder-built pages.
- New block attributes: `guideMode`, `showPreviews`, `showDensity`, `showReadTime`, `trackProgress`, `showReactions`, `showCitations`, `citationStyle`, `sectionNotes`, `previewOnHover`, `showExport`.
- New PHP methods: `TOCflow_Headings::flatten_content()`, `get_sections()`, `citation_meta()`, `get_all_from_html()`, `get_all_from_elementor()`, `collect_elementor_headings()`, `get_all_from_bricks()`, `inject_ids_in_html()`, `builder_raw_html()`, `flatten_html_to_sequence()`, `builder_has_tocflow()`.
- New editor panels: "Reading Guide", "Section Notes", and "Behavior" enhancements in the block sidebar.
- Print CSS: expanded collapsed TOC, hidden all interactive controls, author notes shown expanded.

### Changed
- `render_list()` accepts an optional `$guide` array; fully backward-compatible.
- `render_nav()` merges section data and embeds citation meta on the `<nav>` when guide mode is active.
- `TOCflow_Plugin::inject_builder_heading_ids()` added as `the_content` hook (priority 999).
- `enqueue_front_assets()` broadened to cover page-builder pages via `should_inject_ids()`.

## [1.0.2] - 2026-09-01

WordPress.org Plugin Check cleanup for the directory review (v1.0.1 is Awaiting Review). Behavior is unchanged.

### Changed
- Removed `load_plugin_textdomain()` so Plugin Check is clean. WordPress.org auto-loads translations from the `tocflow` text domain (WP 4.6+).
- Prefixed uninstall and admin/render template variables with `tocflow_` (`PrefixAllGlobals`).
- `Tested up to` 7.1; zip-facing license copy is GPLv2 or later with no Envato split-license language; readme documents `src/` + `npm run build`.

## [1.0.1] - 2026-08-31

First **installable** GitHub Release of the 1.0 plugin. The June `v1.0.0` tag had no working zip; `v0.1.0` was still marked Latest. Download `tocflow.zip` from this release.

### Added
- GitHub Actions release workflow: tagging `vX.Y.Z` builds and attaches `tocflow.zip`.
- `languages/tocflow.pot`, PHPCS (`composer.json` / `phpcs.xml.dist`), Dependabot.
- WordPress.org banner and icon assets in `.wordpress-org/`.
- Privacy policy, code of conduct contact (`matt@matthummel.com`), 100% GPLv2-or-later grant with copyright.
- Docs site: bold sans-serif (Outfit), consistent footers, social preview.

### Changed
- Plugin Documentation and Settings links point at the GitHub Pages site.

## [1.0.0] - 2026-08-31

Marketplace-ready release: WordPress.org / CodeCanyon coding standards, a complete free feature set, and listing-quality docs.

### Added
- Live outline preview in the block editor (updates as you type headings).
- Style presets: Default, Minimal, Boxed, Underline, Card.
- Collapsible list, sticky positioning, and scroll-spy highlighting.
- Per-block layout: nested 1.1.1 numbering, hide markers, two columns, compact spacing, max height, title element, H1, and smooth-scroll override.
- Smooth-scroll with a configurable offset for sticky headers (honors `prefers-reduced-motion`).
- H5 / H6 heading support.
- Site-wide settings: auto-generate the Gutenberg block (with layout options), minimum heading count, schema JSON-LD, uninstall cleanup.
- `[tocflow]` shortcode for classic content and theme templates.
- Skip headings with the CSS class `no-toc` or `tocflow-skip`.
- In-plugin **Settings** and **Docs & Support** screens.
- WordPress.org / Envato-oriented documentation, support policy, and security policy.

### Fixed
- Heading IDs now prefer an author-supplied HTML anchor so TOC links match custom slugs.
- Empty headings no longer desync the ID injection pointer.
- Heading IDs are injected with `WP_HTML_Tag_Processor` when available.

### Changed
- Plugin version, text domain, GitHub slug, and WordPress.org slug remain **`tocflow`**.
- Plugin header description is plain text (no HTML) for directory compliance.
- Block follows Gutenberg handbook / `create-block` patterns: `save.js` returns `null`, presets are Block Styles (`is-style-*`), wrapper uses `useBlockProps` / `get_block_wrapper_attributes()`.

## [0.1.0] - 2026-06-23
### Added
- Initial release: core **Table of Contents** block.
- Auto-generates a linked outline from a post's H2/H3/H4 headings.
- Toggle which heading levels are included.
- Numbered or bulleted list option.
- Server-rendered output with an accessible `<nav>` landmark.
- Automatic anchor IDs injected into headings so links scroll correctly.
