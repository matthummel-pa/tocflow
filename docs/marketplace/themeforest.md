# ThemeForest: how themes should feature TOCflow

**Do not submit this plugin to ThemeForest.** ThemeForest rejects standalone plugins. TOC UI built *into a theme* is also a common rejection: custom post types, shortcodes, and widgets belong in a plugin.

## The compliant pattern

A ThemeForest theme **requires or recommends** the plugin slug `tocflow`:

1. Bundle `tocflow.zip` in the theme package **or** load it from WordPress.org once listed.
2. Register it with [TGM Plugin Activation](http://tgmpluginactivation.com/) (classic PHP themes) or declare a plugin dependency in `theme.json` / the site editor (block themes).
3. In theme documentation, tell buyers: *Install TOCflow, insert the Table of Contents block (or enable auto-insert).*
4. Style the outline with theme CSS targeting `.tocflow`, `.tocflow--boxed`, `.tocflow.is-sticky`, `.tocflow__link.is-active`. Do not fork the PHP.

## Copy for a theme item page

> Long-form posts include a table of contents via **TOCflow**, a dedicated Gutenberg block (not baked into the theme). Headings stay in content; the outline is server-rendered for SEO.

## Why this helps the theme review

- Separation of concerns (Envato theme requirement)
- Theme updates do not clobber TOC settings
- Buyers can disable the TOC without switching themes
- You can point to this repo’s docs instead of rewriting them
