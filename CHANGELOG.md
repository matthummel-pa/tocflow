# Changelog

All notable changes to TOCflow are documented here.
This project adheres to [Semantic Versioning](https://semver.org/).

## [1.0.1] - 2026-08-31

First **installable** GitHub Release of the 1.0 plugin. The June `v1.0.0` tag had no working zip; `v0.1.0` was still marked Latest. Download `tocflow.zip` from this release.

### Added
- GitHub Actions release workflow: tagging `vX.Y.Z` builds and attaches `tocflow.zip`.
- `languages/tocflow.pot`, PHPCS (`composer.json` / `phpcs.xml.dist`), Dependabot.
- WordPress.org banner and icon assets in `.wordpress-org/`.
- Privacy policy, code of conduct contact (`matt@matthummel.com`), 100% GPLv2-or-later grant with copyright.
- Docs site: bold sans-serif (Outfit), consistent footers, social preview.

### Changed
- Plugin Documentation and Settings links point at the GitHub Pages site.

## [1.0.0] - 2026-08-31

Marketplace-ready release: WordPress.org / CodeCanyon coding standards, a complete free feature set, and listing-quality docs.

### Added
- Live outline preview in the block editor (updates as you type headings).
- Style presets: Default, Minimal, Boxed, Underline, Card.
- Collapsible list, sticky positioning, and scroll-spy highlighting.
- Per-block layout: nested 1.1.1 numbering, hide markers, two columns, compact spacing, max height, title element, H1, and smooth-scroll override.
- Smooth-scroll with a configurable offset for sticky headers (honors `prefers-reduced-motion`).
- H5 / H6 heading support.
- Site-wide settings: auto-generate the Gutenberg block (with layout options), minimum heading count, schema JSON-LD, uninstall cleanup.
- `[tocflow]` shortcode for classic content and theme templates.
- Skip headings with the CSS class `no-toc` or `tocflow-skip`.
- In-plugin **Settings** and **Docs & Support** screens.
- WordPress.org / Envato-oriented documentation, support policy, and security policy.

### Fixed
- Heading IDs now prefer an author-supplied HTML anchor so TOC links match custom slugs.
- Empty headings no longer desync the ID injection pointer.
- Heading IDs are injected with `WP_HTML_Tag_Processor` when available.

### Changed
- Plugin version, text domain, GitHub slug, and WordPress.org slug remain **`tocflow`**.
- Plugin header description is plain text (no HTML) for directory compliance.
- Block follows Gutenberg handbook / `create-block` patterns: `save.js` returns `null`, presets are Block Styles (`is-style-*`), wrapper uses `useBlockProps` / `get_block_wrapper_attributes()`.

## [0.1.0] - 2026-06-23
### Added
- Initial release: core **Table of Contents** block.
- Auto-generates a linked outline from a post's H2/H3/H4 headings.
- Toggle which heading levels are included.
- Numbered or bulleted list option.
- Server-rendered output with an accessible `<nav>` landmark.
- Automatic anchor IDs injected into headings so links scroll correctly.
