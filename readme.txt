=== TOCflow ===
Contributors: matthummel
Donate link: https://matthummel.com
Tags: table of contents, toc, reading guide, block, study tools
Requires at least: 6.4
Tested up to: 7.1
Requires PHP: 7.4
Stable tag: 1.2.2
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

The first Table of Contents block with a built-in Reading Guide: section previews, read-time estimates, emoji reactions, and one-click academic citations — all server-rendered, no external APIs.

== Description ==

TOCflow adds a Table of Contents block to the WordPress block editor. Unlike other TOC plugins, it ships a **Reading Guide mode** that turns a plain navigation list into an intelligent reading companion. Every feature is rendered server-side or handled client-side with no external API calls, no accounts, and no tracking.

= Standard TOC features =

* Standard Gutenberg block (`block.json`, live editor preview, Block Styles)
* Choose H1–H6 heading levels
* Numbered or bulleted lists, including nested 1.1.1 numbering
* Five style presets: Default, Minimal, Boxed, Underline, Card
* Show or hide the title; render it as a paragraph or H2–H4
* Smooth scroll with a configurable offset for sticky headers
* Collapsible outline and optional sticky positioning
* Scroll-spy highlights the section currently in view
* Hide bullets, two-column layout, compact spacing, max height with scroll
* Auto-generate the block sitewide (top of content or after first heading)
* `[tocflow]` shortcode for classic content and theme templates
* Skip a heading with the CSS class `no-toc`
* Accessible `<nav>` landmark with ARIA labels
* Optional ItemList JSON-LD schema markup
* No account, no external API calls, no tracking

= Reading Guide mode — what no other TOC plugin does =

Enable **Reading Guide** in the block sidebar to transform the TOC into a live reading companion. Every enrichment is computed from your block content — no JavaScript fetches, no third-party services.

**Section content previews** — The opening sentence of every section appears beneath its TOC link, extracted server-side from your block content. Readers scan the outline and know exactly what they are about to read before they click.

**Content density bars** — A subtle bar under each item shows that section's word count as a proportion of the longest section. Readers see at a glance which sections are brief and which are deep dives.

**Per-section read-time estimates** — Word count divided by average reading speed gives a `~N min` badge next to each link. Readers can decide what to read and how long it will take.

**Reading progress** — As a reader scrolls past each section, its TOC item fades out. The outline becomes a live checklist of what has been read and what remains.

**Author section notes** — Write a short teaser or hook for any section directly in the block editor's Section Notes panel. Readers reveal it with a single tap (✍ button). The note is stored in block attributes — no database round-trip.

**Emoji reactions** — Readers react to individual sections (💡 Insightful · ⭐ Saved · 🤔 Unclear · ✅ Got it) with a single click. Choices are stored in the browser's localStorage. No accounts, no server calls, no tracking.

**Per-section academic citations** — A § button on each TOC item copies a fully formatted academic citation for that specific section. Five formats supported: APA, MLA, Chicago, Harvard, and plain link. Citation data comes entirely from WordPress post meta (author, title, site name, published date, permalink). Ideal for research blogs, documentation sites, and long-form journalism.

= Compatibility =

TOCflow is designed to work with every major WordPress stack:

* **Theme builders:** Gutenberg (native block), Elementor, Divi, Beaver Builder, Bricks Builder, WPBakery, Oxygen, Breakdance — use `[tocflow]` in any shortcode/HTML element.
* **SEO plugins:** Yoast SEO, Rank Math, All in One SEO, SEOPress — schema markup is opt-in and off by default; no conflicts with any SEO plugin's TOC schema output.
* **Themes:** Works with any theme — inherits theme fonts and colors; no injected brand styles; tested on Twenty Twenty-Four, Twenty Twenty-Five, Astra, Kadence, GeneratePress, Blocksy.
* **Multilingual:** WPML, Polylang, TranslatePress — fully translation-ready with the standard `tocflow` text domain.
* **PHP:** 7.4, 8.0, 8.1, 8.2, 8.3.
* **WordPress:** 6.4 – 7.1 (tested on all major releases in this range).

= Source =

Unminified JavaScript and SCSS ship in `src/`. Compiled assets are in `build/`. Development: https://github.com/matthummel-pa/tocflow (`npm run build`).

= How to use =

1. Edit a post that contains Heading blocks.
2. Insert the **Table of Contents** block (typically after the introduction).
3. Optionally open the **Reading Guide** panel in the block sidebar to enable any of the reading companion features.
4. Open **Settings → TOCflow** to auto-generate the block sitewide or set a scroll offset.

= Shortcode =

`[tocflow]`

Layout & behavior: `title`, `showtitle`, `titletag`, `h1`–`h6`, `ordered`, `numbering`, `markers`, `collapsible`, `collapsed`, `sticky`, `compact`, `columns`, `underline`, `highlight`, `maxheight`, `min`, `smooth`, `style`.

Reading Guide: `preview="1"` (hover tooltip on links), `guide="1"` (full Reading Guide mode), `previews="1"`, `density="1"`, `readtime="1"`, `progress="1"`, `reactions="1"`, `citations="1"`, `citation="apa|mla|chicago|harvard|plain"`.

Study assistant: `rprogress="1"` (document progress bar), `bookmark="1"` (resume last heading), `rnotes="1"` (private reader note pads).

Examples:

`[tocflow title="On this page" style="boxed" preview="1"]`

`[tocflow guide="1" previews="1" readtime="1" reactions="1" citations="1"]`

= Skip a heading =

Add the CSS class `no-toc` or `tocflow-skip` to a Heading block (Advanced → Additional CSS class(es)).

= Privacy =

TOCflow does not collect personal data, set cookies, or call remote services. Emoji reactions use the browser's own localStorage — no data leaves the reader's device. Optional JSON-LD is printed in the page HTML only if you enable it in settings. Details: https://github.com/matthummel-pa/tocflow/blob/main/PRIVACY.md

= Support =

Documentation and support: https://matthummel-pa.github.io/tocflow/
Issues: https://github.com/matthummel-pa/tocflow/issues

== Installation ==

1. Upload the `tocflow` folder to `/wp-content/plugins/`, or install the ZIP through **Plugins → Add New → Upload Plugin**.
2. Activate **TOCflow**.
3. Add the Table of Contents block to a post that contains headings, or enable auto-insert under **Settings → TOCflow**.

== Frequently Asked Questions ==

= Does it work with the classic editor? =

The block is for the block editor. For classic content or a theme template, use the `[tocflow]` shortcode.

= Does it work with Elementor? =

Yes. Add a Shortcode widget to your Elementor layout and enter `[tocflow]`. TOCflow automatically reads headings from your Elementor Heading widgets (via the stored widget JSON) and injects matching ID anchors into the rendered page so all TOC links scroll correctly. No extra plugin or configuration needed.

= Does it work with Divi? =

Yes. Add a Code module or Shortcode module to your Divi section and enter `[tocflow]`. TOCflow scans the rendered page HTML for headings and injects the correct anchor IDs.

= Does it work with Bricks Builder? =

Yes. Paste `[tocflow]` into a Bricks Code element or Shortcode element. TOCflow reads headings directly from Bricks' element meta (heading and rich-text elements) and injects the correct IDs.

= Does it work with Beaver Builder? =

Yes. Add an HTML module or Shortcode module containing `[tocflow]`. TOCflow uses `[tocflow]` detected in Beaver Builder data to ensure headings receive the correct anchor IDs.

= Does it work with WPBakery / Visual Composer? =

Yes. Add a Raw HTML element or Shortcode element with `[tocflow]`. TOCflow scans the rendered HTML for headings and injects IDs automatically.

= Does it work with Oxygen Builder or Breakdance? =

Yes. Insert `[tocflow]` via a Shortcode element or Code Block. TOCflow detects the shortcode in Oxygen/Breakdance meta and handles heading ID injection through the rendered HTML.

= Can it co-exist with my SEO plugin (Yoast, Rank Math)? =

Yes. The optional JSON-LD schema is off by default. If you enable it, turn off TOC schema in your SEO plugin (or vice versa) to avoid duplicate structured data. The `<nav>` landmark itself does not conflict with any SEO plugin.

= Will the links scroll to my headings? =

Yes. Matching anchor IDs are added automatically. Custom HTML anchors on a heading are respected. Smooth scrolling and a pixel offset are configurable under Settings → TOCflow.

= How are section previews generated? =

The server walks the parsed block content and extracts the first ~20 words after each heading. No JavaScript fetch, no API, no external service.

= How do emoji reactions work? =

Each reader's choices are stored in their browser's `localStorage`. Nothing is sent to your server or any third party. If two readers use the same browser profile they see the same reactions, but reactions are per-device and never aggregated.

= How are citations generated? =

Citations are built from data already in WordPress: the post author's display name, post title, blog name, published date, and permalink. The § button constructs the formatted string in JavaScript and copies it to the clipboard. The citation includes the section anchor (`#slug`) so it links directly to that section.

= Can I hide the TOC on short posts? =

Yes. Set **Minimum headings** in Settings → TOCflow.

= Does it work in columns or groups? =

Yes. Headings nested inside Group, Columns, Cover, and similar blocks are included in both the TOC and the Reading Guide section data.

= Can I have more than one TOC on a page? =

Each instance lists the same headings from that post. Prefer one outline per page.

= Is any data sent off-site? =

No. Zero external network requests from TOCflow in any mode.

= What license is TOCflow under? =

GNU GPLv2 or later, covering the whole plugin (PHP, JavaScript, CSS, and images). Copyright Matt Hummel. Full text: `license.txt`.

== Screenshots ==

1. Table of Contents block in the editor with Reading Guide and Section Notes panels open in the sidebar.
2. Front-end Reading Guide mode: section previews, density bars, read-time badges, author note, and emoji reactions.
3. One-click academic citation copy — APA, MLA, Chicago, Harvard, or plain link.
4. Reading progress: sections fade as the reader scrolls past them.
5. Settings → TOCflow (smooth scroll, auto-generate block, uninstall).

== Changelog ==

= 1.2.2 =
* Fix: `TOCFLOW_VERSION` constant was stuck at `1.2.0`; now reads `1.2.2` correctly (admin version badge and `Version %s` string now match the plugin header).
* Fix: `Tested up to` updated from 6.7 to 7.1 (WordPress 7.1 "Mary Lou", released 2026-08-19).
* Fix: removed third-party trademark `elementor` from tags; replaced with `study tools`.
* Fix: PHP coding-standards indentation in shortcode attribute registration and admin settings view.

= 1.2.1 =
* Fix: debounced resume-bookmark localStorage writes from every IntersectionObserver callback to every 500 ms, preventing redundant writes during fast scrolling.
* Docs: completed v1.1.0 CHANGELOG entry (hover preview, export/print toolbar, full accessibility and page-builder details).
* Docs: added "What's new" tables and "Performance" section to README for reviewers.

= 1.2.0 =
* New: **Reader note pads** — a 📝 button per section lets readers jot personal notes stored privately in localStorage. No account, no server. Enable with `rnotes="1"` in the shortcode or the new "Reader note pads" toggle in the block sidebar.
* New: **Reading progress bar** — a thin animated bar shows 0–100 % of the document read (based on headings scrolled past via IntersectionObserver). Enable with `rprogress="1"`.
* New: **Resume reading bookmark** — automatically bookmarks the last-read heading in localStorage; shows a "↩ Resume" button on return visits. Enable with `bookmark="1"`.
* New: **Section Planner** — the "Section Notes" sidebar panel is now "Section Planner" with per-heading writing status (✏️ Draft / 🔄 In progress / ✅ Done) tracked in the editor canvas and a reader-facing teaser note.
* New: **Total read-time badge** — when Reading Guide + read-time are active, the TOC header shows the aggregated total read time for the entire post.
* New shortcode attributes: `rprogress`, `bookmark`, `rnotes`.
* New block attributes: `showReaderNotes`, `showReadingProgress`, `showBookmark`, `sectionStatus`.

= 1.1.0 =
* New: **Reading Guide mode** — enable per-block to show section content previews (server-extracted, no JS fetch), visual content-density bars, per-section read-time estimates, and scroll-based reading progress.
* New: **Author section notes** — type a teaser or hook per heading in the block sidebar (Section Notes panel); readers reveal it with a ✍ button.
* New: **Emoji reactions** — readers react per section (💡 ⭐ 🤔 ✅) with state stored in localStorage; no accounts, no server calls.
* New: **Per-section academic citations** — § button copies APA, MLA, Chicago, Harvard, or plain-link citation built from WordPress post meta; no external API.
* New: **Hover section preview** — floating tooltip on TOC link hover/focus; viewport-aware positioning; `aria-describedby` for screen readers.
* Compatibility: **Elementor** — heading data extracted from `_elementor_data` widget JSON; IDs injected into rendered output via `the_content` at priority 999.
* Compatibility: **Bricks Builder** — heading and rich-text elements parsed from `_bricks_page_content_2` meta.
* Compatibility: **Divi, WPBakery, Oxygen, Beaver Builder, Breakdance** — HTML-based heading scan as a generic fallback; IDs injected into rendered HTML so all builder-generated headings are reachable from TOC links.
* New block attributes: `guideMode`, `showPreviews`, `showDensity`, `showReadTime`, `trackProgress`, `showReactions`, `showCitations`, `citationStyle`, `sectionNotes`, `previewOnHover`.
* Block internals: `TOCflow_Headings::get_sections()` (word count + preview extraction), `citation_meta()`, `get_all_from_html()`, `get_all_from_elementor()`, `get_all_from_bricks()`, `inject_ids_in_html()`; updated `render_list()` and `render_nav()`.

= 1.0.2 =
* Removed `load_plugin_textdomain()` — WordPress.org directory auto-loads the `tocflow` text domain since WP 4.6.
* Prefixed template and uninstall variables with `tocflow_`.
* `Tested up to` 6.7.

= 1.0.1 =
* First installable GitHub zip of the 1.0 feature set (build + plugin-zip on tag).
* Docs site, 100% GPLv2-or-later packaging, translation template, and WordPress.org banner/icon assets.

= 1.0.0 =
* Live editor preview, style presets, collapse, sticky, and scroll-spy.
* Smooth scroll with offset; H5/H6 support.
* Auto-generate the Gutenberg block, `[tocflow]` shortcode, skip class `no-toc`.
* Settings and Docs & Support admin screens.
* Heading IDs via WP_HTML_Tag_Processor; custom anchors respected.

== Upgrade Notice ==

= 1.2.2 =
WordPress.org compliance fixes: corrects the in-admin version badge, updates "Tested up to" to 7.1, and removes a disallowed trademark tag. No functional changes.

= 1.2.1 =
Performance fix for the resume bookmark feature (debounced localStorage writes). Documentation updates only — no functional changes to the block, shortcode, or settings.

= 1.2.0 =
Adds study-assistant features: reader note pads, a reading progress bar, resume bookmark, Section Planner writing status, and a total read-time badge. No breaking changes — all new features are opt-in via the block sidebar or shortcode.

= 1.1.0 =
Adds Reading Guide mode: section previews, density bars, read-time estimates, reading progress, author notes, emoji reactions, and per-section academic citations. No breaking changes — all new features are opt-in via the block sidebar.

= 1.0.2 =
Plugin Check and readme cleanup for the WordPress.org review. Same block, settings, and shortcode as 1.0.1.

== License ==

TOCflow is copyright 2026 Matt Hummel and licensed under the GNU General Public License, version 2 or later. That license covers the whole plugin (PHP, JavaScript, CSS, and images). The full text is in `license.txt`.
