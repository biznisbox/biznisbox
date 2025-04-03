# Unreleased

## ✨ New Features and Enhancements

- Updated generation of the API documentation to include new endpoints and features.

## 🐛 Bug Fixes

# 2.2.0

## ✨ New Features and Enhancements

- Added a new feature for sending email to partner contact.
- Added feature to view and manage user personal access tokens by admin.

## 🧪 Experiment (may be deleted in feature)

- Added feature for get real IP address of user (not proxy).

## 🐛 Bug Fixes

- Fixed security issue with showing token value in the API response.

## 🌐 Localization

- Updated translations with the latest contributions from Crowdin to support better multilingual usability.

# v2.1.1

## 🐛 Bug Fixes

- Fixed an issue with WorldSeeder by locking the package version
- Fixed color format for the company color in settings
- Fixed an issue where the sendmail path was not displayed in settings
- Fixed unit updating issue in settings
- Fixed text color of changelog on the status page

# v2.1.0

## ✨ New Features and Enhancements

- Added functions for generating personal access tokens for authentication (mobile apps, etc.).

## 🐛 Bug Fixes

- Fixed an issue where the language cookie was missing during app installation.
- Fixed a bug preventing user webhooks from being saved via the API.
- Removed the requirement for the item number field (now generated automatically).
- Fixed an issue causing incorrect behavior in the API (`getPublicProducts`).

## 💄 UI/UX Improvements

- Improved UI design for displaying partner activities in dark mode.

## 🌐 Localization

- Updated translations with the latest contributions from Crowdin to support better multilingual usability.

# v2.0.0

This marks the official release of the new BiznisBox.

## ✨ New Features and Enhancements

- Added an option to reject contracts.
- Implemented email notifications for first-time logins from a new browser.
- Introduced a console command for creating users.
- Added new configuration settings for enhanced customization.

## 🐛 Bug Fixes

- Improved the API's permanent delete function for archive documents.
- Fixed a security vulnerability related to auto-generated passwords.

## 💄 UI/UX Improvements

- Updated the default font to Roboto for a more modern look.
- Made minor UI refinements for a smoother user experience.
- Fixed various dark mode display issues.
- Updated PDF document templates (invoices, bills, contracts, etc.).

## 🌐 Localization

- Integrated the latest translations from Crowdin, enhancing multilingual support and usability.

**Note**: This release includes several internal updates and improvements that are not listed here.

# v2.0.0-beta.5

**Important**: This release introduces significant changes that are not backwards-compatible with previous versions (v2.x.x-beta.x) due to database migrations and structural updates.

## ✨ New Features and Enhancements

- Added an App Status page view for system health monitoring.
- Implemented validation for the old password when users change their password.
- Upgraded to a more secure and up-to-date JWT provider for improved authentication.

## 🐛 Bug Fixes

- Fixed an issue with adding webhooks due to database migration issues.
- Resolved an issue where admin operations were not being logged when managing users.
- Addressed a bug preventing images from displaying correctly in documents (related to base64 encoding).

## 💄 UI/UX Improvements

- Updated the color scheme for a more modern and cohesive look.
- Refined the design of input validation feedback.
- Added dark mode support to the rich text editor for improved user experience in low-light environments.
- Replaced the old app logo with a new, updated design.
- Overhauled the Role page view for a cleaner, more intuitive interface.

## 🧑‍💻 Development Updates

- Introduced support for Swagger generation to improve API documentation.

## 🌐 Localization

- Updated translations with the latest contributions from Crowdin, enhancing multilingual support and usability.

# v2.0.0-beta.4

## ✨ New Features and Improvements

- Add function for sharing contacts with other users (via magic link).
- Add function for internal tickets in the support module.

## 🐛 Bug Fixes

- Fixed some little bugs in UI.
- Fix security issues in the app (HTML injection, XSS) reported by SonarQube.

## 🌐 Localization

- Updated translations with the latest contributions from Crowdin to support better multilingual usability.

**Note**: This release includes numerous additional changes not listed here.

# v2.0.0-beta.3

## ✨ New Features and Improvements

- Enhanced user experience during BiznisBox installation, with improved setup guidance and clearer prompts.

## 🐛 Bug Fixes

- Resolved an issue preventing the map icons from displaying in the production build.
- Corrected formatting errors with invoice, bills ... numbers format to ensure consistency and accuracy.
- Fixed multiple issues encountered during BiznisBox installation via the installer for a smoother setup.

## 🌐 Localization

- Updated translations with the latest contributions from Crowdin to support better multilingual usability.

**Note**: This release includes numerous additional changes not listed here.

# v2.0.0-beta.2

## ✨ New Features and Improvements

- Added a notification popup to check and manage notifications more efficiently.
- Introduced a new "Contracts" module, enabling seamless management of contracts with clients and partners.
- Implemented permission checks on API routes to enhance security.
- Launched a new "Partners" feature, providing better tools to manage activities and collaborations with partners.

## 🐛 Bug Fixes

- Resolved migration issues on Linux servers, including problems with migration rollbacks.
- Fixed a bug related to refreshing open banking transactions.
- Corrected output formatting for documents such as quotes and invoices.

**Note**: This release includes numerous additional changes not listed here.

# 2.0.0-beta.1

**Important**: This release is not backwards-compatible with previous versions (v1.x.x) due to significant changes, including database migrations and structure updates.

## ✨ New Features and Improvements

- **App Install UI**: Introduced a new user interface for app installations.
- **Audit Log View**: Added audit log visibility across all application sections.
- **Custom Dashboard**: Implemented a customizable dashboard (with more elements to come).
- **Webhooks (Beta)**: Enabled webhooks for app events.
- **Settings Enhancements**: Improved department and email settings management.
- **Support Ticket**: Enhanced the functionality for managing support tickets.
- **Document Archive**: Improved document archive features.

## 🐛 Bug Fixes

- **Discounts & Taxes**: Resolved issues with discounts and taxes calculations.
- **Theme Settings**: Fixed the bug preventing user profile theme settings from being saved.

## 💄 UI/UX Changes

- **TailwindCSS Integration**: The user interface is now powered by TailwindCSS.
- **UI Updates**: Several visual updates have been made to the UI.

## 🌐 Localization

- **New Translations**: Added translations for Spanish, French, Portuguese, Italian, Russian, Chinese, Dutch, Norwegian, Danish, Swedish, and Finnish. (Crowdin has been utilized for automatic translation.)

**Note**: This release includes numerous additional changes not listed here.
