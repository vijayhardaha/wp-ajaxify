# Getting Started with Development

This plugin has two main scripts(dev & build) along with several other scripts.

Before running any of the scripts, you must complete several steps:

- Clone the GitHub repository into your plugins directory.
- Navigate to the cloned directory using `cd`
- In the plugin directory run `npm i` and `composer install`.

After completing the installation you can use these scripts for development and build:

- Run `npm run dev` to compile your files automatically whenever you've made changes to the associated files.
- Run `npm run build` to compile files for release.

There are some other useful linting and fixing scripts available as well:

- `npm run format` - Fix & Format CSS, JS & PHP files.
- `npm run fix:css` - Fix & Format CSS files in **src** directory.
- `npm run fix:js` - Fix & Format JS files in **src** directory.
- `npm run fix:php` - Fix & Format PHP files.
- `npm run lint` - Lint CSS, JS & PHP files.
- `npm run lint:css` - Lint SCSS files in **src** directory.
- `npm run lint:js` - Lint JS files in **src** directory.
- `npm run lint:php` - Lint PHP files.
