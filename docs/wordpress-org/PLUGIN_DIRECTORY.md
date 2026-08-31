# WordPress.org Plugin Directory — FAQ & guidelines for this project

Canonical pages (always win if this summary drifts):

- [Plugin Developer FAQ](https://developer.wordpress.org/plugins/wordpress-org/plugin-developer-faq/) (updated 30 Aug 2026)
- [Detailed Plugin Guidelines](https://developer.wordpress.org/plugins/wordpress-org/detailed-plugin-guidelines/)
- [Block-specific guidelines](https://developer.wordpress.org/plugins/wordpress-org/block-specific-plugin-guidelines/)
- [Common issues](https://developer.wordpress.org/plugins/wordpress-org/common-issues/)

Agents load the same policy from `.cursor/rules/wordpress-org-plugin-directory.mdc`.

## Why this lives in the repo

Matt’s plugins are built to **pass Plugin Directory review** and stay listable. These are product requirements, not optional polish.

TOCflow is listed/submitted as a **normal plugin** (block + settings + shortcode + auto-insert), **not** a Block Directory “block-only” plugin.

## FAQ points that change how we build

| Topic | Rule |
| --- | --- |
| Slug | Comes from `Plugin Name:` (`TOCflow` → `tocflow`). Frozen after approval. Also the folder, URL, SVN path, and text domain. |
| Display name | Can change in the header + readme. Don’t stuff “WordPress” / “Plugin” for SEO. |
| Trademarks | Don’t start the name or slug with someone else’s brand. Don’t sneak around with hyphens (`Face-Range`). |
| Submit | One plugin at a time; zip &lt; 10MB; production-ready; no placeholders. |
| Review mail | `plugins@wordpress.org`. Reply in-thread. Don’t resubmit except after a 3-month timeout. |
| SVN | Code in `trunk/` root; tags like `1.0.0`; artwork in SVN `assets/` (this repo: `.wordpress-org/`). No nested trunk folder. No zips inside the plugin. No SVN externals in the download. |
| Minified JS | Allowed if unminified source ships or is linked from the readme. |
| Stable tag | A version tag, not `trunk`. |
| Tested up to | Real current WP (or current RC), not a future major. |
| Tags | Max **5**. Unique-to-you tags are hidden anyway. |
| Live | First SVN commit publishes the plugin. Don’t push until ready. |
| Rebrand | Upgrade the existing plugin. Don’t submit a second slug and abandon users. |
| Support | Subscribe on the plugin’s forum. No sockpuppets. Don’t buy fake reviews. |
| Ownership | Committers via Advanced tab; authors via `Contributors:` in readme. Treat buyout emails as hostile until proven otherwise. |

## The 18 guidelines (short)

1. GPL (prefer GPLv2 or later) for **everything** in the zip. No Envato split license.  
2. You own what the plugin does, including libraries and APIs.  
3. Directory copy is the distributed copy.  
4. Human-readable; publish source / build docs.  
5. No trialware; paid code lives off-dotorg as an add-on.  
6. Real SaaS is OK if documented.  
7. No tracking without consent.  
8. No remote executable code / off-site updates / admin iframes.  
9. No illegal, dishonest, or abusive conduct.  
10. Front-end credits opt-in, default off.  
11. Don’t hijack wp-admin.  
12. Readme is not a keyword dump.  
13. Use Core’s jQuery and other bundled libs.  
14. SVN is for releases.  
15. Bump version so updates fire.  
16. Submit a complete plugin.  
17. Respect trademarks.  
18. The team can close or hotfix for safety.

## Block Directory (do not target for TOCflow)

Would require: one block, almost no PHP, **no Settings screens**, no ads, no account wall. Auto-insert + `[tocflow]` + **Settings → TOCflow** disqualify it. Keep those features; stay on the main Plugin Directory.

## Contact

Plugins team: `plugins@wordpress.org` (they aim to reply within 7 business days). Security reports go there too; no public issues for vulns (see `SECURITY.md`).
