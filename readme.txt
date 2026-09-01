=== TOCflow ===
Contributors: matthummel
Donate link: https://matthummel.com
Tags: table of contents, toc, block, gutenberg, navigation
Requires at least: 6.4
Tested up to: 7.1
Requires PHP: 7.4
Stable tag: 1.0.1
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

A lightweight Table of Contents block that auto-generates a linked outline from your post headings.

== Description ==

TOCflow adds a single Table of Contents block to the WordPress editor. Add it to any post and it builds a linked outline from your headings. The list is rendered on the server, so it is present in the initial HTML — good for SEO and accessibility — and matching anchor IDs are added to your headings automatically.

= Features =

* Standard Gutenberg block (`block.json`, live editor preview, Block Styles)
* Choose H1–H6 heading levels
* Numbered or bulleted lists, including nested 1.1.1 numbering
* Hide markers, two-column layout, compact spacing, max height
* Show or hide the title; render it as a paragraph or H2–H4
* Five style presets (default, minimal, boxed, underline, card)
* Smooth scroll with an offset for sticky headers
* Collapsible outline and optional sticky positioning
* Highlights the section currently in view
* Optional auto-generate of the Gutenberg block at the top of content or after the first heading
* `[tocflow]` shortcode for classic content
* Skip a heading with the CSS class `no-toc`
* Accessible `<nav>` landmark
* Optional ItemList JSON-LD
* No account, no external API calls, no tracking

= Source =

Unminified JavaScript and SCSS ship in `src/`. Compiled assets are in `build/`. Development: https://github.com/matthummel-pa/tocflow (`npm run build`).

= How to use =

1. Edit a post that contains Heading blocks.
2. Insert the **Table of Contents** block (typically after the introduction).
3. Optionally open **Settings → TOCflow** to auto-generate the block site-wide, or to set a scroll offset.

= Shortcode =

`[tocflow]`

Optional attributes: `title`, `showtitle`, `titletag`, `h1`–`h6`, `ordered`, `numbering`, `markers`, `collapsible`, `collapsed`, `sticky`, `compact`, `columns`, `underline`, `highlight`, `maxheight`, `min`, `smooth`, `style`.

= Skip a heading =

Add the CSS class `no-toc` or `tocflow-skip` to a Heading block (Advanced → Additional CSS class(es)).

= Privacy =

TOCflow does not collect personal data, set cookies, or call remote services. Optional JSON-LD is printed in the page HTML only if you enable it in settings. Details: https://github.com/matthummel-pa/tocflow/blob/main/PRIVACY.md

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

= Can I hide the TOC on short posts? =

Yes. Set **Minimum headings** in Settings → TOCflow.

= Does it work in columns or groups? =

Yes. Headings nested inside Group, Columns, Cover, and similar blocks are included.

= Can I have more than one TOC on a page? =

Each instance lists the same headings from that post. Prefer one outline per page.

= Is any data sent off-site? =

No.

= What license is TOCflow under? =

GNU GPLv2 or later, covering the whole plugin (PHP, JavaScript, CSS, and images). Copyright Matt Hummel. Full text: `license.txt`.

== Screenshots ==

1. Table of Contents block in a post, with the settings sidebar.
2. Front-end outline with nested links.
3. Settings → TOCflow (smooth scroll, auto-generate block, uninstall).
4. Docs & Support screen inside wp-admin.

== Changelog ==

= 1.0.1 =
* First installable GitHub zip of the 1.0 feature set (build + plugin-zip on tag).
* Docs site, 100% GPLv2-or-later packaging, translation template, and WordPress.org banner/icon assets.

= 1.0.0 =
* Live editor preview, style presets, collapse, sticky, and scroll-spy.
* Smooth scroll with offset; H5/H6 support.
* Auto-generate the Gutenberg block, `[tocflow]` shortcode, skip class `no-toc`.
* Settings and Docs & Support admin screens.
* Heading IDs via WP_HTML_Tag_Processor; custom anchors respected.

= 0.1.0 =
* Initial release: core Table of Contents block.

== Upgrade Notice ==

= 1.0.1 =
Installable GitHub zip plus docs and packaging polish. Block behavior is unchanged from 1.0.0.

= 1.0.0 =
Adds live preview, auto-insert, shortcode, presets, and admin settings. Existing blocks keep working.

== License ==

TOCflow is copyright 2026 Matt Hummel and licensed under the GNU General Public License, version 2 or later. That license covers the whole plugin (PHP, JavaScript, CSS, and images). The full text is in `license.txt`.
