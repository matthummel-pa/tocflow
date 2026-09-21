# Plugin naming (GitHub + WordPress.org + Envato)

## Decision

**Display name:** TOCguide  
**Slug, GitHub repo, plugin folder, text domain, main file:** `tocguide` / `tocguide.php`  
**Listing title:** TOCguide – Table of Contents Block

WordPress.org asked for a name that does not imply affiliation with another product (guideline 17). Do not put `flow` back in the Plugin Name or slug.

| Surface | Value |
| --- | --- |
| PHP | `tocguide_*` functions, `TOCguide_*` classes, `TOCGUIDE_*` constants |
| Option | `tocguide_settings` |
| CSS | `.tocguide`, `--tocguide-*` |
| Block | `tocguide/table-of-contents` |
| Shortcode | `[tocguide]` |
| Skip a heading | `no-toc` or `tocguide-skip` |

## Why this matches WordPress standards

The [Plugin Handbook](https://developer.wordpress.org/plugins/wordpress-org/plugin-developer-faq/) treats three strings as one identity:

1. **Slug** — lowercase, unique, becomes the plugin folder and the wordpress.org/plugins/{slug}/ URL.
2. **Text domain** — must match the slug (and `Domain Path: /languages`). Literal `'tocguide'`.
3. **Main PHP file** — `{slug}.php` → `tocguide.php`.

A coined brand is one token (`akismet`, `jetpack`). **TOCguide** is a coined brand, so **`tocguide`** is the correct slug.

## What *not* to do

- **`toc-guide`** — unnecessary hyphen; would be a different slug.
- **`wp-toc` / `wordpress-toc`** — fights directory guidelines.
- Putting `flow` back in the display name or slug.

## GitHub settings

- **Name:** `tocguide`
- **Description:** `Server-rendered Table of Contents block for the WordPress editor.`
- **Website:** `https://matthummel-pa.github.io/tocguide/`
- **Topics:** `wordpress`, `wordpress-plugin`, `gutenberg`, `block-editor`, `table-of-contents`, `toc`, `php`, `javascript`

## WordPress.org submission

https://wordpress.org/plugins/developers/add/

- **Plugin name / Plugin Name header:** TOCguide
- **ZIP folder:** `tocguide/` (run `npm run plugin-zip`)
- **Contributors:** wordpress.org username in `readme.txt`
