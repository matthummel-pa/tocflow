# TOCflow

<p align="center">
  <img src="docs/assets/tocflow-logo.svg" alt="TOCflow — WordPress Table of Contents block" width="440">
</p>

<p align="center">
  <strong>A server-rendered Table of Contents block for WordPress.</strong><br>
  Add one block. Get an accessible, SEO-friendly outline from your headings.
</p>

<p align="center">
  <a href="https://matthummel-pa.github.io/tocflow/"><strong>Docs</strong></a>
  ·
  <a href="https://github.com/matthummel-pa/tocflow/releases/latest">Download</a>
  ·
  <a href="https://github.com/matthummel-pa/tocflow/issues">Issues</a>
  ·
  <a href="LICENSE">GPLv2 or later</a>
</p>

<p align="center">
  <a href="https://github.com/matthummel-pa/tocflow/actions/workflows/ci.yml"><img alt="CI" src="https://github.com/matthummel-pa/tocflow/actions/workflows/ci.yml/badge.svg"></a>
  <img alt="WordPress" src="https://img.shields.io/badge/WordPress-6.4%2B-3858e9">
  <img alt="PHP" src="https://img.shields.io/badge/PHP-7.4%2B-777bb3">
  <img alt="License" src="https://img.shields.io/badge/license-GPLv2%20or%20later-1b1f24">
</p>

---

## Why TOCflow

- **Zero config** — insert the block; the outline builds itself.
- **Server-rendered** — the list is in the first HTML response (SEO + screen readers).
- **Accurate anchors** — matching `id`s are injected into headings; custom HTML anchors win.
- **Accessible** — a `<nav>` landmark, keyboard-friendly collapse, `aria-current` while you read.
- **Focused** — one block done well, not a block library.

### Features

- Live preview in the editor as you add or edit headings
- H1–H6 (H1 off by default), numbered or bulleted, five style presets
- Smooth scroll + offset for sticky headers (`prefers-reduced-motion` respected)
- Collapse/expand, sticky outline, scroll-spy highlight
- Auto-insert (top of content or after the first heading)
- `[tocflow]` shortcode for classic content
- Skip a heading with the class `no-toc`
- Optional ItemList JSON-LD
- Settings + Docs & Support screens in wp-admin

The plugin slug, folder, and text domain are **`tocflow`**. Display name: **TOCflow**. See [`docs/NAMING.md`](docs/NAMING.md).

---

## Install

1. Download `tocflow.zip` from [Releases](https://github.com/matthummel-pa/tocflow/releases).
2. In WordPress: **Plugins → Add New → Upload Plugin**.
3. Activate. Optional: **Settings → TOCflow**.

Or clone this repo into `wp-content/plugins/tocflow`, run `npm install && npm run build`, and activate.

### Use the block

1. Edit a post that has **Heading** blocks.
2. Insert **Table of Contents** (usually right after the intro).
3. In the sidebar: title, heading levels, list style, preset, collapse, sticky.

### Shortcode

```
[tocflow]
[tocflow title="On this page" ordered="1" style="boxed"]
```

---

## Screenshots

<p align="center">
  <img src="docs/assets/tocflow-settings-panel.svg" alt="Block settings" width="420">
  <img src="docs/assets/tocflow-output.svg" alt="Front-end outline" width="420">
</p>

---

## Documentation

| Doc | Who it is for |
| --- | --- |
| [Support site](https://matthummel-pa.github.io/tocflow/) | Users, buyers, reviewers |
| [User guide](docs/USER_SOP.md) | Site owners |
| [Developer SOP](docs/DEVELOPER_SOP.md) | Contributors |
| [Support policy](SUPPORT.md) | Buyers / WordPress.org users |
| [Security](SECURITY.md) · [Privacy](PRIVACY.md) | Vulnerability reports and data handling |
| [Marketplace kit](docs/marketplace/README.md) | WordPress.org and CodeCanyon |
| [Changelog](CHANGELOG.md) | Release history |
| [WordPress.org rules](docs/wordpress-org/PLUGIN_DIRECTORY.md) | Plugin Directory FAQ + guidelines |

---

## Develop

Requires **Node.js 20+** (see `.nvmrc`).

```bash
git clone https://github.com/matthummel-pa/tocflow.git
cd tocflow
npm install
npm run start          # watch
# npm run build        # production
npm run lint:js
npm run lint:css
npx --package=@wordpress/env wp-env start   # optional local WordPress
```

The compiled `build/` directory is gitignored — build at least once before activating the plugin.

PHP: `composer install` then `composer phpcs`. See [`docs/DEVELOPER_SOP.md`](docs/DEVELOPER_SOP.md) and [`CONTRIBUTING.md`](CONTRIBUTING.md).

---

## License

[GPLv2 or later](LICENSE) — the whole plugin (PHP, JavaScript, CSS, and images), same family as WordPress.

Copyright © 2026 Matt Hummel.
