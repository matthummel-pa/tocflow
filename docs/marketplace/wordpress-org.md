# WordPress.org listing

## Before you submit

1. Create a wordpress.org account. Put that username in `readme.txt` → `Contributors:` (replace `matthummel` if needed).
2. Confirm the slug **`tocguide`** is still free: https://wordpress.org/plugins/tocguide/
3. `npm run build` then `npm run plugin-zip`.
4. Validate `readme.txt`: https://wordpress.org/plugins/developers/readme-validator/

## Submit / slug change during review

https://wordpress.org/plugins/developers/add/

The plugins team asked for a display name and slug that do **not** imply affiliation with another entity. Use:

- **Name:** TOCguide
- **ZIP:** `tocguide.zip` (folder inside the zip must be `tocguide/`)
- **In the existing review email/thread:** ask them to change the slug from `tocflow` to `tocguide`. Do not open a second submission unless they say the 3-month timeout applies.

After approval you get SVN. Trunk holds code; `.wordpress-org/` in this repo is **not** committed to trunk.

Follow the Plugin Developer FAQ and the 18 guidelines as product requirements:

- https://developer.wordpress.org/plugins/wordpress-org/plugin-developer-faq/
- Repo copy: [`docs/wordpress-org/PLUGIN_DIRECTORY.md`](../wordpress-org/PLUGIN_DIRECTORY.md)
- Agent rule: `.cursor/rules/wordpress-org-plugin-directory.mdc`

## Reply to paste into the review thread

> Hi — thanks for the note on the display name and slug.
>
> I have uploaded an updated zip. The plugin is now **TOCguide** (Plugin Name header and readme). Please change the slug to **`tocguide`**.
>
> TOCguide is an independent plugin by Matt Hummel. It is not affiliated with Webflow or any other company or plugin.
>
> Thank you.

## SVN assets (after approval)

Upload from `.wordpress-org/` to `assets/` in SVN (not inside the plugin folder):

- `banner-1544x500.png` / `banner-772x250.png` (generated from `banner.svg`)
- `icon-256x256.png` / `icon-128x128.png` / `icon.svg`

Banners and the icon are in `.wordpress-org/` already. To regenerate PNGs: `npm install --no-save @resvg/resvg-js && node scripts/rasterize-wporg-assets.js`.

## Review hot spots this plugin already avoids

- No HTML in the plugin header `Description:`
- No remote POST of user data
- No `eval`, no obfuscation, no bundled junk
- `uninstall.php` only deletes when the owner opted in
- Deactivation does not delete settings
- Admin code loads only in `is_admin()`
- All output escaped; settings sanitized
- Text domain is the literal `tocguide`

## After listing

Point Plugin URI at the WordPress.org page (or keep GitHub). Add the plugin to your wordpress.org profile. Enable forum support and watch https://wordpress.org/support/plugin/tocguide/
