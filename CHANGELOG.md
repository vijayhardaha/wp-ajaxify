# CHANGELOG

## Version 1.1.6 - Mar 08, 2024

- Write license name in valid SPDX expression
- Add package description
- Remove unused npm-run-all dep
- Write scripts with run-s
- Bump dependencies to the latest versions
- Enhance vscode settings
- Enhance build zip bash script
- Enhance build realse workflow

## Version 1.1.5 - Oct 11, 2023

- Improved the efficiency of absolute path checking by implementing a shorter method.
- Enhanced code formatting by removing reliance on the prettier configuration.
- Refactored build scripts, utilizing the run-s command for better script execution.
- Added the npm-run-all development dependency for improved script management.
- Updated dependencies to their latest versions.
- Set a consistent tab width of 2 for JSON, Markdown (md), and YAML (yml) files.
- Removed the unused @wordpress/prettier-config dependency.
- Removed the prettier configuration file for code consistency.
- Enhanced configuration rules and added comments for clarity.

## Version 1.1.4 - Nov 02, 2022

- Adjusted the height of the progress bar from 6px to a more visually appealing 3px.

## Version 1.1.3 - Oct 12, 2022

- Added a plugin prefix for the heading row ID, ensuring unique identifiers.
- Disabled ajaxify functionality during customizer preview mode to prevent conflicts.
- Corrected the changelog link for accurate navigation.
- Improved notice positioning by adding an `<hr class="wp-header-end">` tag after the heading description.
- Implemented a build ID feature in fields setup for better organization.
- Upgraded GitHub actions to node16 for better compatibility.

## Version 1.1.2 - Oct 07, 2022

- Added specific styles for the `p.description` tag to enhance the visual presentation.
- Corrected the implementation of the name attribute for better functionality.

## Version 1.1.1 - Oct 05, 2022

- Fixed the version number in the plugin's main file to ensure consistency.
- Added new export ignore paths for more accurate exports.

## Version 1.1.0 - Oct 05, 2022

- Included a link to the GNU GPL License for improved licensing information.
- Updated the ajaxify version to 8.2.6 for compatibility.
- Restructured the Gulp setup into a module for better maintainability.
- Enhanced the UI of the dashboard table for a more user-friendly experience.
- Improved default settings of the plugin for smoother operation.
- Enhanced the rendering functions of form fields for better performance.
- Optimized global variable usage for improved efficiency.

## Version 1.0.3 - Sep 23, 2022

- Fixed issues related to missing style attributes and multiple pronto requests for a smoother user experience.

## Version 1.0.2 - Sep 15, 2022

- Resolved conflicts related to prefetch off by passing a boolean value as arguments for improved compatibility.

## Version 1.0.1 - Aug 31, 2022

- Added required and tested PHP and WP version information to the plugin's meta data for clearer compatibility information.
- Allowed empty comments and increased the maximum line length in stylelint for more flexible coding standards.
- Enhanced npm script names and tasks for better script management.
- Improved gulp task script for better task execution.
- Formatted the readme.md file with prettier for a more consistent look.
- Removed whitespace from phpcs.xml and updated the required WP version for better compliance.

## Version 1.0.0 - Aug 23, 2022

- Initial release of the plugin, providing essential features and functionalities.
