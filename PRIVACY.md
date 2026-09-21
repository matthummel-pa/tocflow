# Privacy

TOCguide does not collect personal data, set marketing cookies, or call remote APIs. It does not phone home, load front-end fonts or scripts from a CDN, or require an account.

## What stays on the site

WordPress stores plugin settings in the `tocguide_settings` option. If a user dismisses the welcome notice, that flag is stored as user meta. Uninstall deletes those **only** when the site owner opted in under **Settings → TOCguide**. Deactivating the plugin does not delete data.

Optional ItemList JSON-LD is printed in page HTML only if a site owner enables it. That markup is public document data, not a tracker.

## What stays in the reader’s browser

When an author enables study tools, the following keys may be written to `localStorage` on the visitor’s device (never sent to a server):

| Key pattern | Feature |
| --- | --- |
| `tocguide-r-{postId}-{slug}-{emoji}` | Emoji reactions |
| `tocguide-rn-{postId}-{slug}` | Reader note pads |
| `tocguide-bm-{postId}` | Resume bookmark |

## Third-party services

None. Guideline 7: no tracking or external contact. The GitHub Pages marketing site (`docs/*.html`) may load the Outfit font from Google Fonts; that is **not** part of the plugin zip and is not loaded on WordPress sites that install TOCguide.

Security reports: see [SECURITY.md](SECURITY.md) or email **matt@matthummel.com**.
