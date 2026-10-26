# Frances Portfolio (WordPress plugin)

Custom post types, taxonomies, ACF field groups and a custom REST API field for my headless portfolio. WordPress holds the content; the React front end ([frances-portfolio-react](https://github.com/francescalulo/frances-portfolio-react)) reads it through the WP REST API.

- **Live site:** https://francescalulo.com
- **Version:** 1.4.0
- **Requires:** WordPress 6.5+, PHP 7.0+, Advanced Custom Fields Pro

## What it registers

### Custom post types

| Key                 | Admin label | Public URL       | Used for                                                      |
| ------------------- | ----------- | ---------------- | ------------------------------------------------------------- |
| `portfolio-project` | Work        | `/work/`         | Projects: Home featured work, Work archive, Work Detail pages |
| `experience`        | Experience  | none (REST only) | Career chapters on the Home page                              |

Both are in the REST API (`show_in_rest`). Work supports title, excerpt, featured image, page order and revisions.

### Taxonomies (on Work)

| Key             | Label      | Used for                                          |
| --------------- | ---------- | ------------------------------------------------- |
| `build`         | Build      | How the project was built (e.g. React, WordPress) |
| `tech-stack`    | Tech Stack | Tools and libraries                               |
| `collaboration` | Work With  | Solo or team                                      |
| `work-category` | Categories | The Work archive filters                          |

### REST field: `next_project`

Added to every Work post for the Work Detail "Next Up" link. Projects follow the admin order (the **Order** box, then title A–Z), and the last one loops back to the first. Read-only, with a schema.

```json
"next_project": {
  "id": 62,
  "title": "Twin Trouble",
  "slug": "twin-trouble",
  "project_type": "Game Design",
  "position": 2,
  "total": 4
}
```

It is `null` when there is only one published project.

### ACF field groups (Local JSON)

Saved in `frances-portfolio/acf-json/`, so they are version-controlled with Git and load without a database import.

| Field group        | Location         | Fields                                                                                                                                                                                     |
| ------------------ | ---------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------ |
| Work Details       | Work posts       | Project type, role, home featured, live / repo URLs, overview, challenge, approach, sidenote, key takeaway (+ coded), site preview (image, embed URL, embed width), mockups per breakpoint |
| Experience Details | Experience posts | Location, years in role, story, skills                                                                                                                                                     |
| Site Settings      | Page ID 41       | Contact text, email, location, social links                                                                                                                                                |
| About Page         | Page ID 52       | Core competencies, FAQs                                                                                                                                                                    |

All field groups have **Show in REST API** on.

## Installation

1. Install and activate **Advanced Custom Fields Pro**.
2. Copy the `frances-portfolio` folder into `wp-content/plugins/`.
3. Activate **Frances Portfolio** in **Plugins**. Activation flushes the rewrite rules, so the Work URLs work straight away.
4. The field groups load from `acf-json` automatically. If ACF shows **Sync available**, click it to save them to the database.

## Development

- Editing a field group in **ACF → Field Groups** saves its JSON into `acf-json/`. Commit that file with the change.
- Git workflow: `feature/*` and `chore/*` branches → pull request into `staging` → release into `main`.
- Every file stops direct access (`ABSPATH` check) and every function is prefixed `fcp_`.

## Changelog

**1.4.0**

- New ACF field: Site Preview Embed Width
- Rewrite rules flushed on activation and deactivation
- Translatable taxonomy labels
- Schema for the `next_project` REST field
- WordPress coding standards: plugin header and end-of-file newlines

**1.3.x**

- `next_project` REST field, ACF Local JSON, field groups organised with tabs, Key Takeaway (Coded), About and Experience field groups

## License

GPL v2 or later.

## Author

Frances Calulo, https://francescalulo.com
