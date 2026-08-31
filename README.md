# TOCflow

<p align="center">
  <img src="docs/assets/tocflow-logo.svg" alt="TOCflow — WordPress Table of Contents block" width="440">
</p>

<p align="center">
  <strong>A server-rendered Table of Contents block for WordPress.</strong><br>
  Add one block. Get an accessible, SEO-friendly outline from your headings.
</p>

<p align="center">
  <a href="https://matthummel-pa.github.io/tocflow/"><strong>Docs &amp; support</strong></a>
  ·
  <a href="https://github.com/matthummel-pa/tocflow/releases/latest">Download</a>
  ·
  <a href="https://github.com/matthummel-pa/tocflow/issues">Issues</a>
  ·
  <a href="LICENSE">GPL-2.0-or-later</a>
</p>

<p align="center">
  <img alt="Version" src="https://img.shields.io/badge/version-1.0.0-2f6f4e">
  <img alt="WordPress" src="https://img.shields.io/badge/WordPress-6.4%2B-3858e9">
  <img alt="PHP" src="https://img.shields.io/badge/PHP-7.4%2B-777bb3">
  <img alt="License" src="https://img.shields.io/badge/license-GPL--2.0--or--later-1b1f24">
</p>

---

## GitHub / WordPress.org name

**Keep this repository named `tocflow`.** That is the plugin slug.

| Surface | Value |
| --- | --- |
| **GitHub repo** | `tocflow` |
| **WordPress.org slug** | `tocflow` (folder + updates URL) |
| **Display name** | TOCflow |
| **Main file** | `tocflow.php` |
| **Text domain** | `tocflow` |
| **Function / class prefix** | `tocflow_` / `TOCflow_` |
| **Block name** | `tocflow/table-of-contents` |

WordPress plugin slugs are lowercase. Hyphens are for multi-word *descriptive* names (`easy-table-of-contents`). Invented single-word brands stay one token — the same pattern as `akismet`, `jetpack`, and `woocommerce`. Do **not** rename this to `wp-toc`, `wordpress-toc`, or `toc-flow-plugin`: those fight the Plugin Directory rules (no `wp-` prefix, no `wordpress` in the slug) and would force a text-domain change after release.

The public title on WordPress.org can still read **“TOCflow – Table of Contents Block”**. The slug stays `tocflow`.

Full naming notes: [`docs/NAMING.md`](docs/NAMING.md).

---

## Why TOCflow

- **Zero config** — insert the block; the outline builds itself.
- **Server-rendered** — the list is in the first HTML response (SEO + screen readers, no front-end framework).
- **Accurate anchors** — matching `id`s are injected into headings; custom HTML anchors are respected.
- **Accessible** — a `<nav>` landmark, keyboard-friendly collapse, `aria-current` while you read.
- **Focused** — one block done well, not a block library.

### Features (v1.0.0)

- Live preview in the editor as you add or edit headings
- H2–H6, numbered or bulleted, five style presets
- Smooth scroll + offset for sticky headers (`prefers-reduced-motion` respected)
- Collapse/expand, sticky outline, scroll-spy highlight
- Auto-insert (top of content or after the first heading)
- `[tocflow]` shortcode
- Skip a heading with the class `no-toc`
- Optional ItemList JSON-LD
- Settings + Docs & Support screens in wp-admin

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
| [User SOP](docs/USER_SOP.md) | Site owners |
| [Developer SOP](docs/DEVELOPER_SOP.md) | Contributors |
| [Support policy](SUPPORT.md) | Buyers / WordPress.org users |
| [Security policy](SECURITY.md) | Vulnerability reports |
| [Marketplace kit](docs/marketplace/README.md) | WordPress.org, CodeCanyon, ThemeForest themes |
| [Changelog](CHANGELOG.md) | Everyone |
| [WordPress.org directory rules](docs/wordpress-org/PLUGIN_DIRECTORY.md) | Plugin Directory FAQ + 18 guidelines |

---

## Develop

```bash
git clone https://github.com/matthummel-pa/tocflow.git
cd tocflow
npm install
npm run start          # watch
# npm run build        # production
```

The compiled `build/` directory is gitignored — build at least once before activating the plugin.

```bash
npm run lint:js
npm run lint:css
npx wp-env start       # optional local WordPress
```

See [`docs/DEVELOPER_SOP.md`](docs/DEVELOPER_SOP.md) and [`CONTRIBUTING.md`](CONTRIBUTING.md).

### Suggested GitHub topics

`wordpress` · `wordpress-plugin` · `gutenberg` · `block-editor` · `table-of-contents` · `toc` · `php` · `javascript`

---

## License

[GPL-2.0-or-later](LICENSE). WordPress.org and Envato both require GPL-compatible PHP for WordPress items.
