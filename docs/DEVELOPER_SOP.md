# Developer SOP — TOCflow

Standard operating procedure for contributing to **TOCflow**. Architecture: [`CLAUDE.md`](../CLAUDE.md). Naming: [`NAMING.md`](NAMING.md). WordPress.org FAQ + guidelines: [`wordpress-org/PLUGIN_DIRECTORY.md`](wordpress-org/PLUGIN_DIRECTORY.md) (must stay compliant).

---

## 1. Prerequisites

| Tool | Version | Why |
| --- | --- | --- |
| Node.js | 20 LTS | `@wordpress/scripts` |
| npm | 9+ | Lockfile |
| Git | recent | VCS |
| WordPress | 6.4+ / PHP 7.4+ | `wp-env`, Local, or Docker |

---

## 2. Setup

```bash
git clone https://github.com/<your-username>/tocflow.git
cd tocflow
git remote add upstream https://github.com/matthummel-pa/tocflow.git
npm install
```

`build/` is gitignored. You must build before the plugin will register.

---

## 3. Dev loop

```bash
npm run start      # watch → build/
npm run build      # production
npx wp-env start   # http://localhost:8888  admin / password
```

Symlink this folder to `wp-content/plugins/tocflow` if you are not using wp-env.

---

## 4. Branches & commits

```bash
git fetch upstream && git checkout -b feat/your-change upstream/main
```

Prefixes: `feat/`, `fix/`, `docs/`, `chore/`. Imperative commit messages.

---

## 5. Code standards

**PHP** ([WordPress PHP CS](https://developer.wordpress.org/coding-standards/wordpress-coding-standards/php/)):

- Tabs, Yoda where it helps, escape on output, sanitize on input.
- Prefix functions `tocflow_`, classes `TOCflow_`, option `tocflow_settings`.
- Never declare functions in `src/render.php`.
- Text domain is the literal `'tocflow'` — never a variable or constant.
- Admin classes load only when `is_admin()`.
- Heading IDs: `WP_HTML_Tag_Processor`, not a second regex parser, when available.

**JavaScript / block**

```bash
npm run lint:js
npm run lint:css
npm run format
```

Match [Gutenberg block coding](https://developer.wordpress.org/block-editor/getting-started/tutorial/): `block.json` as metadata, `useBlockProps` / `get_block_wrapper_attributes()`, Block Styles in `block.json`, `@wordpress/*` packages only. Front-end `view.js` must not require jQuery. See `.cursor/rules/wordpress-block-coding.mdc`.

---

## 6. Test before a PR

- [ ] `npm run build`
- [ ] `npm run lint:js` and `npm run lint:css`
- [ ] Block inserts, live-previews headings, saves
- [ ] Front-end links hit the right `id` (including custom anchors)
- [ ] Level toggles, presets, collapse, sticky
- [ ] `[tocflow]` and auto-insert (and *not* duplicating when the block is present)
- [ ] Duplicate heading text → unique slugs
- [ ] `WP_DEBUG` is quiet

---

## 7. Pull requests

PR against `matthummel-pa/tocflow:main`. Fill in the template.

---

## 8. Release (maintainers)

Bump **all** of: `tocflow.php` (`Version` + `TOCFLOW_VERSION`), `package.json`, `src/block.json`, `readme.txt` (`Stable tag`).

1. Dated `CHANGELOG.md` + `readme.txt` changelog.
2. `npm run build` && `npm run plugin-zip`
3. Tag `vX.Y.Z` and attach the ZIP to a GitHub Release.
4. WordPress.org: SVN tag matching `Stable tag`.
5. CodeCanyon: upload the same ZIP + HTML docs.

---

## 9. Help

[Issues](https://github.com/matthummel-pa/tocflow/issues) · [SECURITY.md](../SECURITY.md)
