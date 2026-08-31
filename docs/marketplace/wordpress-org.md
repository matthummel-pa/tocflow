# WordPress.org listing

## Before you submit

1. Create a wordpress.org account. Put that username in `readme.txt` → `Contributors:` (replace `matthummel` if needed).
2. Confirm the slug **`tocflow`** is still free: https://wordpress.org/plugins/tocflow/
3. `npm run build` then `npm run plugin-zip`.
4. Validate `readme.txt`: https://wordpress.org/plugins/developers/readme-validator/

## Submit

https://wordpress.org/plugins/developers/add/

- **Name:** TOCflow – Table of Contents Block
- **ZIP:** the built plugin (folder name inside the zip must be `tocflow/`)
- After approval you get SVN. Trunk holds code; `.wordpress-org/` in this repo is **not** committed to trunk.

Follow the Plugin Developer FAQ and the 18 guidelines as product requirements:

- https://developer.wordpress.org/plugins/wordpress-org/plugin-developer-faq/
- Repo copy: [`docs/wordpress-org/PLUGIN_DIRECTORY.md`](../wordpress-org/PLUGIN_DIRECTORY.md)
- Agent rule: `.cursor/rules/wordpress-org-plugin-directory.mdc`

## SVN assets (after approval)

Upload from `.wordpress-org/` to `assets/` in SVN (not inside the plugin folder):

- `banner-1544x500.png` / `banner-772x250.png` (generated from `banner.svg`)
- `icon-256x256.png` / `icon-128x128.png` / `icon.svg`
- `screenshot-1.png` … matching the `== Screenshots ==` section in `readme.txt`

Banners and the icon are in `.wordpress-org/` already. Capture **real** editor and front-end screenshots before submit — the illustrated SVGs in `docs/assets/` are marketing only. To regenerate PNGs: `npm install --no-save @resvg/resvg-js && node scripts/rasterize-wporg-assets.js`.

## Review hot spots this plugin already avoids

- No HTML in the plugin header `Description:`
- No remote POST of user data
- No `eval`, no obfuscation, no bundled junk
- `uninstall.php` only deletes when the owner opted in
- Deactivation does not delete settings
- Admin code loads only in `is_admin()`
- All output escaped; settings sanitized
- Text domain is the literal `tocflow`

## After listing

Point Plugin URI at the WordPress.org page (or keep GitHub). Add the plugin to your wordpress.org profile. Enable forum support and watch https://wordpress.org/support/plugin/tocflow/
