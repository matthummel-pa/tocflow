=== TOCflow ===
Contributors: matthummel
Donate link: https://matthummel.com
Tags: table of contents, toc, reading guide, citations, block
Requires at least: 6.4
Tested up to: 6.7
Requires PHP: 7.4
Stable tag: 1.1.0
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

= Source =

Unminified JavaScript and SCSS ship in `src/`. Compiled assets are in `build/`. Development: https://github.com/matthummel-pa/tocflow (`npm run build`).

= How to use =

1. Edit a post that contains Heading blocks.
2. Insert the **Table of Contents** block (typically after the introduction).
3. Optionally open the **Reading Guide** panel in the block sidebar to enable any of the reading companion features.
4. Open **Settings → TOCflow** to auto-generate the block sitewide or set a scroll offset.

= Shortcode =

`[tocflow]`

Optional attributes: `title`, `showtitle`, `titletag`, `h1`–`h6`, `ordered`, `numbering`, `markers`, `collapsible`, `collapsed`, `sticky`, `compact`, `columns`, `underline`, `highlight`, `maxheight`, `min`, `smooth`, `style`.

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

= 1.1.0 =
* New: **Reading Guide mode** — enable per-block to show section content previews (server-extracted, no JS fetch), visual content-density bars, per-section read-time estimates, and scroll-based reading progress.
* New: **Author section notes** — type a teaser or hook per heading in the block sidebar (Section Notes panel); readers reveal it with a ✍ button.
* New: **Emoji reactions** — readers react per section (💡 ⭐ 🤔 ✅) with state stored in localStorage; no accounts, no server calls.
* New: **Per-section academic citations** — § button copies APA, MLA, Chicago, Harvard, or plain-link citation built from WordPress post meta; no external API.
* New block attributes: `guideMode`, `showPreviews`, `showDensity`, `showReadTime`, `trackProgress`, `showReactions`, `showCitations`, `citationStyle`, `sectionNotes`.
* Block internals: `TOCflow_Headings::get_sections()` (word count + preview extraction), `citation_meta()`, updated `render_list()` and `render_nav()`.

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

= 1.1.0 =
Adds Reading Guide mode: section previews, density bars, read-time estimates, reading progress, author notes, emoji reactions, and per-section academic citations. No breaking changes — all new features are opt-in via the block sidebar.

= 1.0.2 =
Plugin Check and readme cleanup for the WordPress.org review. Same block, settings, and shortcode as 1.0.1.

== License ==

TOCflow is copyright 2026 Matt Hummel and licensed under the GNU General Public License, version 2 or later. That license covers the whole plugin (PHP, JavaScript, CSS, and images). The full text is in `license.txt`.
