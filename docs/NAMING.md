# Plugin naming (GitHub + WordPress.org + Envato)

## Decision

**Repository, slug, folder, text domain, and main file all stay `tocflow`.**

Display name: **TOCflow**  
WordPress.org listing title (recommended): **TOCflow – Table of Contents Block**

Do not rename the GitHub repo to `toc-flow`, `wp-tocflow`, `wordpress-toc`, or `tocflow-plugin`.

## Why this matches WordPress standards

The [Plugin Handbook](https://developer.wordpress.org/plugins/wordpress-org/plugin-developer-faq/) treats three strings as one identity:

1. **Slug** — lowercase, unique, becomes the plugin folder and the wordpress.org/plugins/{slug}/ URL.
2. **Text domain** — must match the slug (and `Domain Path: /languages`).
3. **Main PHP file** — conventionally `{slug}.php` in that folder.

Hyphens are for *multi-word descriptions* (`easy-table-of-contents`, `contact-form-7`). A coined brand is one token (`akismet`, `jetpack`, `woocommerce`). TOCflow is a coined brand, so **`tocflow`** is the correct slug.

### Rules this name already satisfies

| Rule | `tocflow` |
| --- | --- |
| Lowercase | yes |
| No spaces | yes |
| Unique on WordPress.org (checked 2026-08-31) | yes |
| Not prefixed with `wp-` | yes (the directory rejects / discourages this) |
| Does not contain `wordpress` | yes |
| Text domain = slug | yes (`tocflow`) |
| PHP prefix can use underscores | `tocflow_` functions, `TOCflow_` classes |
| Block namespace | `tocflow/table-of-contents` |
| Envato: text domain lowercase, no variables | yes — literal `'tocflow'` |

Envato’s WordPress plugin requirements say the text domain must use **dashes rather than underscores**. A single-word domain has neither. That is valid. Do not change it to `toc_flow`.

## What *not* to do

- **`toc-flow`** — looks more “Handbook hyphenated,” but it is a breaking change: new slug, new text domain, new folder, dead WordPress.org updates, broken translations.
- **`tocflow-table-of-contents`** — fine as a *search title*, too long as a slug.
- **`wp-toc` / `wordpress-toc`** — fights directory guidelines and is generic (harder to trademark, easier to reject).
- Renaming the GitHub repo independently of the slug — GitHub Pages, issue links, Plugin URI, and Author support URLs all assume `matthummel-pa/tocflow`.

## GitHub settings to match the slug

On the repo (Settings → General):

- **Name:** `tocflow`
- **Description:** `Server-rendered Table of Contents block for the WordPress editor.`
- **Website:** `https://matthummel-pa.github.io/tocflow/`
- **Topics:** `wordpress`, `wordpress-plugin`, `gutenberg`, `block-editor`, `table-of-contents`, `toc`, `php`, `javascript`

Enable **Issues**, **Discussions** (optional), and **GitHub Pages** from `/docs`.

## WordPress.org submission name

When you submit at https://wordpress.org/plugins/developers/add/:

- **Plugin name:** TOCflow – Table of Contents Block  
- **Expected slug:** `tocflow`  
- **Contributors:** your wordpress.org username (replace the placeholder in `readme.txt` if it is not `matthummel`)

## Envato (CodeCanyon, not ThemeForest)

WordPress **plugins** are sold on **CodeCanyon**. ThemeForest is themes. Theme authors can *require or recommend* this plugin (slug `tocflow`) via TGMPA or the Site Editor’s plugin dependencies. See [`docs/marketplace/`](marketplace/README.md).
