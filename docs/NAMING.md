# Plugin naming (GitHub + WordPress.org + Envato)

## Decision (WordPress.org review, 2026-09)

WordPress.org asked for a display name and slug that make it clear this plugin is **not officially affiliated with any other entity** (guideline 17). The previous listing identity **TOCflow / `tocflow`** was too close to other `*flow` brands.

| Surface | Value |
| --- | --- |
| Display name | **TOCguide** |
| WordPress.org slug, plugin folder, text domain, main file | **`tocguide`** / `tocguide.php` |
| Listing title | **TOCguide – Table of Contents Block** |
| GitHub repository (unchanged) | `matthummel-pa/tocflow` |
| PHP functions / classes / options / CSS | still `tocflow_*`, `TOCflow_*`, `.tocflow`, option `tocflow_settings` |
| Block name (do not change — stored in post content) | `tocflow/table-of-contents` |
| Shortcodes | `[tocguide]` (matches the slug) and `[tocflow]` (legacy alias) |

Do not put `flow` back in the **Plugin Name** or WordPress.org slug. Do not rename the GitHub repo unless you also update GitHub Pages, issue links, and Plugin URI together.

## Why this matches WordPress standards

The [Plugin Handbook](https://developer.wordpress.org/plugins/wordpress-org/plugin-developer-faq/) treats three strings as one identity:

1. **Slug** — lowercase, unique, becomes the plugin folder and the wordpress.org/plugins/{slug}/ URL.
2. **Text domain** — must match the slug (and `Domain Path: /languages`). Literal `'tocguide'`.
3. **Main PHP file** — `{slug}.php` → `tocguide.php`.

Hyphens are for *multi-word descriptions* (`easy-table-of-contents`, `contact-form-7`). A coined brand is one token (`akismet`, `jetpack`). **TOCguide** is a coined brand, so **`tocguide`** is the correct slug.

### Rules this name satisfies

| Rule | `tocguide` |
| --- | --- |
| Lowercase | yes |
| No spaces | yes |
| Unique on WordPress.org (checked 2026-09-19; listing URL 404s to search) | yes |
| Not prefixed with `wp-` | yes |
| Does not contain `wordpress` | yes |
| Does not begin with another product’s trademark | yes (drops the `flow` suffix) |
| Text domain = slug | yes (`tocguide`) |
| PHP prefix can stay on the original internals | `tocflow_` functions, `TOCflow_` classes |
| Block namespace | `tocflow/table-of-contents` (stable for existing posts) |
| Envato: text domain lowercase, no variables | yes — literal `'tocguide'` |

## What *not* to do

- **`tocflow` on WordPress.org** — the plugins team asked us to change that slug during review. After approval it cannot change.
- **`toc-guide`** — unnecessary hyphen; would be a different slug.
- **`wp-toc` / `wordpress-toc`** — fights directory guidelines.
- Changing the Gutenberg block name `tocflow/table-of-contents` — that would orphan every existing block in post content.
- Renaming CSS classes / options — that would break custom CSS and stored settings.

## GitHub settings

The GitHub repo can stay `tocflow` (Pages URL, issues). On the repo (Settings → General):

- **Name:** `tocflow`
- **Description:** `Server-rendered Table of Contents block for the WordPress editor.`
- **Website:** `https://matthummel-pa.github.io/tocflow/`
- **Topics:** `wordpress`, `wordpress-plugin`, `gutenberg`, `block-editor`, `table-of-contents`, `toc`, `php`, `javascript`

## WordPress.org submission

https://wordpress.org/plugins/developers/add/

- **Plugin name / Plugin Name header:** TOCguide
- **ZIP folder:** `tocguide/` (run `npm run plugin-zip`; package name is `tocguide`)
- **Ask in the existing review thread** to change the slug from `tocflow` to `tocguide`
- **Contributors:** wordpress.org username in `readme.txt`

## Envato (CodeCanyon, not ThemeForest)

WordPress **plugins** are sold on **CodeCanyon**. Theme authors can *require or recommend* this plugin via TGMPA using slug **`tocguide`** once it is listed. See [`docs/marketplace/`](marketplace/README.md).
