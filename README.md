# TTIBase theme for Groups sites
Genesis child theme developed for [Texas A&amp;M Transportation Institute (TTI)](https://tti.tamu.edu) groups' Wordpress websites hosted on WP Engine. See [mobility.tamu.edu](https://mobility.tamu.edu) for demo.

## Dependencies
### Running locally (recommended)
- Local ([Install](https://localwp.com/), [*Developing locally with Local*](https://comweb.tti.tamu.edu/developing-locally-with-local/))
- TTI API feeds TTI groups' people data. For local development, define credentials in wordpress config. *Refer to [comweb](https://comweb.tti.tamu.edu/paid-plugins/)*

### Theme modifications
- node
- npm

## Theme
TTIBase, a [TTIStarter](https://github.com/ttitamu/ttistarter) sister theme for Wordpress built custom using the [Genesis framework](https://my.studiopress.com/documentation/genesis-framework/), comes with TTI branding and functionality for groups and other TTI sites.
### Install Theme
- ```cd /wp-content/themes/ttibase```
- ```npm install```

### Build Theme
- ```npm run build/watch```

## Deploy
- Uses Github Actions to automatically deploy on push or completed pull request to main branch
  - see ```.github/workflows/main.yml```
  - skip build: [Skipping and requesting checks for individual commits](https://help.github.com/en/github/collaborating-with-issues-and-pull-requests/about-status-checks#skipping-and-requesting-checks-for-individual-commits)
- How to setup Github Actions: [Github Actions for WP Engine Build Deploy (comweb)](https://comweb.tti.tamu.edu/github-actions-for-wp-engine-build-deploy/) and, more recently, [Deploying to WPEngine via a Github Action](https://cognition.happycog.com/article/deploying-to-wpe-through-a-git-action)

### Events

This theme modifies Event views provided by The Events Calendar Pro plugin and accommodates an event submission form when created with Gravity Forms. This plugin and feature are optional, but in order to display events using this theme's customizations you must use The Events Calendar Pro. Gravity Forms is not required but you must create a form on a page on your site with a permalink set to "submit-event".
