# CLAUDE.md — TOCflow

Context file for Claude (Cowork / Claude Code) working on this project.

## What this is
A single-purpose WordPress block plugin: a **Table of Contents** block that
auto-generates a linked outline from a post's headings. Built as ONE focused
block (not a block library).

Display name **TOCflow**. GitHub / WordPress.org / folder / text domain slug:
**`tocflow`**. Do not rename it (see `docs/NAMING.md`).

Matt's first WordPress product — portfolio for an agency and a freemium product.
v1.0.0 is the marketplace-ready free core (WordPress.org + CodeCanyon packaging).
ThemeForest does not sell plugins; themes should *require* this slug instead.

## WordPress.org directory rules
Treat `.cursor/rules/wordpress-org-plugin-directory.mdc` and
`docs/wordpress-org/PLUGIN_DIRECTORY.md` as required product constraints
(FAQ + 18 guidelines). Official docs:
https://developer.wordpress.org/plugins/wordpress-org/plugin-developer-faq/

This plugin is **Plugin Directory** (settings, auto-insert, shortcode), not
Block Directory (those cannot have wp-admin UI).

## Tech / conventions
- `@wordpress/scripts` (`create-block` dynamic variant). `npm run build` / `npm run start`.
- Follow `.cursor/rules/wordpress-block-coding.mdc` (Gutenberg handbook APIs).
- **Dynamic block**: `block.json` + `src/save.js` (`null`) + `src/render.php`.
- Wrapper: `useBlockProps` in the editor, `get_block_wrapper_attributes()` on the front end.
- Visual presets are Gutenberg **Block Styles** (`is-style-*`), not a custom SelectControl.
- PHP: WordPress coding standards, tabs, text domain literal `tocflow`.
- Helpers live under `includes/` (loaded once from `tocflow.php`).
  `src/render.php` is output only — never declare functions there.
- Admin UI loads only when `is_admin()`.
- Front-end JS is `src/view.js` via `block.json` `viewScript`.

## How it works
1. `TOCflow_Headings::get_all()` parses the post with `parse_blocks()` and builds
   ONE slug-stamped list (custom `anchor` / existing `id` wins).
2. `render.php` → `TOCflow_Headings::render_nav()` filters levels, normalizes
   depths, prints a nested list inside `<nav>`.
3. A `render_block` filter injects matching `id` attributes with
   `WP_HTML_Tag_Processor`. Both sides use the same map.
4. Settings (`tocflow_settings`) control smooth-scroll offset, auto-insert,
   schema, and uninstall cleanup.
5. Auto-insert and `[tocflow]` reuse `render_nav()`; view assets are enqueued
   when those paths are used because `block.json` only auto-loads for the block.

## File map
- `tocflow.php` — headers, constants, boot.
- `includes/` — settings, headings, plugin, admin.
- `admin/` — settings/support views + CSS.
- `src/block.json` — metadata, attributes, supports.
- `src/index.js` / `edit.js` / `save.js` / `view.js` / `headings.js` / `render.php`
- `uninstall.php` — deletes data only if the owner opted in.
- `docs/` — GitHub Pages support site + marketplace kit.
- `.wordpress-org/` — directory banner/icon sources.

## Roadmap
**Free (this repo, v1.0):** block + shortcode + auto-insert, presets, collapse,
sticky, scroll-spy, offset, schema opt-in, admin support pages.

**Later / Pro ideas:** extra numbering styles, per-heading include/exclude UI,
site-editor pattern library, premium presets. Do not cripple the free plugin
to upsell — WordPress.org and Envato both reject that.
