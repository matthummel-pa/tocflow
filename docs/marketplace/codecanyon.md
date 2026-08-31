# CodeCanyon (Envato) listing

WordPress plugins are sold on **CodeCanyon**, category **WordPress**, not on ThemeForest.

Envato WordPress items must remain **GPL-compatible**. You are selling a convenient package, documentation, and item support — not a proprietary PHP lock-in.

## Item title (recommended)

**TOCflow — Table of Contents Block for WordPress (Gutenberg)**

## Tags

`wordpress` `toc` `table of contents` `gutenberg` `block` `seo` `navigation`

## Short description (~150 characters)

Server-rendered Table of Contents block for Gutenberg. Auto outline from headings, live preview, auto-insert, shortcode, accessible and SEO-friendly.

## What to upload

1. `npm run build && npm run plugin-zip` → installable `tocflow.zip`
2. A documentation ZIP or the HTML in `docs/documentation.html` (offline docs satisfy Envato)
3. Preview graphics: logo, settings, front-end TOC, style presets
4. Optional video: insert block → publish → click a link

## Requirements checklist (already implemented)

See [Envato WordPress Plugin Requirements](https://help.author.envato.com/hc/en-us/articles/360000510603-WordPress-Plugin-Requirements).

- Unique prefix `tocflow_` / `TOCflow_`
- Admin separated with `is_admin()`
- Settings API + `current_user_can( 'manage_options' )` + nonces
- Escaping on output, sanitization on input
- Assets via `wp_enqueue_*` / `block.json` (no direct `<script>` in PHP)
- No jQuery migrate hacks; no deregister of core jQuery
- `uninstall.php` does not run on deactivate; deletion is opt-in
- Translations: literal text domain `tocflow`, `languages/tocflow.pot`
- No third-party tracking
- No nagging review banners except a dismissible welcome notice
- Gutenberg block via `block.json` + dynamic `render.php`

## Support text for the item page

Support is provided via the item’s Envato support tab and GitHub issues for the GPL source. Policy: [SUPPORT.md](../../SUPPORT.md).

## Pricing note

A focused, well-documented TOC block typically sits in the lower CodeCanyon price band. Compete on quality, docs, and support — not on shipping a 40-block suite.
