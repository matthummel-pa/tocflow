# User SOP — TOCflow

A step-by-step guide for **using** the TOCflow plugin. No coding required.

TOCflow adds one block — **Table of Contents** — that builds a linked outline from the headings in your post. You can also auto-insert it on every post or place it with a shortcode.

Online version: https://matthummel-pa.github.io/tocflow/

---

## 1. Install

**Option A — ZIP**

1. Download `tocflow.zip` from [Releases](https://github.com/matthummel-pa/tocflow/releases).
2. WordPress admin: **Plugins → Add New → Upload Plugin**.
3. Install, then **Activate**.

**Option B — Folder**

Copy the `tocflow` folder into `wp-content/plugins/` and activate **TOCflow**.

Open **Settings → TOCflow** once. Set a scroll offset if your site has a sticky header (try 80–120px).

---

## 2. Add a table of contents

1. Edit a post that has **Heading** blocks (H2–H6).
2. Click **+**, search **Table of Contents**, insert it (usually after the intro).
3. The editor shows a live outline. Publish/preview to click the links.

---

## 3. Customize the block

With the block selected, use the sidebar:

| Setting | What it does |
| --- | --- |
| **Title** (on the block) | Label above the list. Sidebar: show/hide, paragraph vs H2–H4. |
| **Include H1–H6** | Which heading levels appear. H1 is off by default. |
| **Numbered list** | Toolbar: bullets vs numbers. Numbered lists can use nested 1.1.1 counters. |
| **Hide markers** | Drop bullets/numbers (nested counters still show). |
| **Two columns / compact** | Layout density. Columns stack on small screens. |
| **Always underline links** | Keep TOC links underlined, not only on hover. |
| **Max height** | Scroll the list when it is taller than this (0 = unlimited). |
| **Style** | Block Styles panel: Default, Minimal, Boxed, Underline, Card. |
| **Sticky / collapsible / highlight** | Reading behavior. Smooth scroll can inherit the site setting or override it. |
| **Minimum headings / scroll offset** | `-1` inherits **Settings → TOCflow**. |

Color, spacing, typography, and border are the normal block controls.

---

## 4. Auto-insert (optional)

**Settings → TOCflow → Auto-insert**

- Off (default)
- Top of content
- After the first heading

Choose post types (Posts, Pages, …). If a post already has the block or `[tocflow]`, auto-insert is skipped.

---

## 5. Shortcode

```
[tocflow]
[tocflow title="On this page" ordered="1" numbering="nested" style="boxed" collapsible="1"]
```

Attributes: `title`, `showtitle`, `titletag`, `h1`–`h6`, `ordered`, `numbering`, `markers`, `collapsible`, `collapsed`, `sticky`, `compact`, `columns`, `underline`, `highlight`, `maxheight`, `min`, `smooth`, `style`.

---

## 6. Skip a heading

On the Heading block: **Advanced → Additional CSS class(es)** → `no-toc` (or `tocflow-skip`).

---

## 7. Troubleshooting

**Empty TOC**
- Use real Heading blocks, not bold paragraphs.
- Enable that heading level in the sidebar.
- Raise/lower **Minimum headings** in settings.

**Links miss the heading**
- Sticky headers need a larger **Scroll offset**.
- Custom HTML anchors on the heading are kept; keep them unique.

**Block missing from the inserter**
- Plugin activated? Using the block editor (not Classic unless you use the shortcode)?

**Styles clash with the theme**
- Try another preset, or CSS on `.tocflow`, `.tocflow__link`, `.tocflow__link.is-active`.

---

## 8. FAQ

**Classic Editor?** Use `[tocflow]`.

**Slow site?** No. The outline is PHP-rendered HTML. A small script loads only on pages that have a TOC (smooth scroll / collapse / highlight).

**Multiple TOCs?** They all list the same headings. Prefer one.

**Data leaving the site?** No.

---

## 9. Getting help

[GitHub Issues](https://github.com/matthummel-pa/tocflow/issues) — include WordPress version, theme, and a screenshot. Policy: [SUPPORT.md](../SUPPORT.md).
