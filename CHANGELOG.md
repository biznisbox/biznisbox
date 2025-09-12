# 2.14.0

## ✨ New Features & Enhancements

- Added a new feature for paying invoices via client portal using Stripe and PayPal.

## 🐛 Bug Fixes

- Fixed an issue with sending emails when using the queue system (mails are send on the moment, not in the background).

## 🧑‍💻 Development Updates

- Improved code quality and maintainability by refactoring code structure.
- Refactored the payment gateway integrations for better reliability and options for future enhancements.

# 2.13.0

## ✨ New Features & Enhancements

- Change email sending to use queued jobs for improved performance.
- Change saving mail settings to use the database instead of the .env file.
- Add accept-reject feature for quotes in the client portal.
- Improve dashboard elements with new UI components.

## 🐛 Bug Fixes

- Fixed issue with Docker container accepting bigger files for uploads.

## 🧑‍💻 Development Updates

- Improved code quality and maintainability by refactoring code structure.

# 2.12.0

## ✨ New Features & Enhancements

- Add support for calculating and displaying the total of tax amounts for invoices.
- Convert text-based email settings for encryption to a dropdown selection.
- Add support for the type of contract signing (e.g., electronic signature, digital signature, paper signature).

## 🐛 Bug Fixes

- Fixed issue with rejected contracts not displaying the correct status.

## 🧑‍💻 Development Updates

- Refactored some code for better readability and maintainability.

# 2.11.0

## ✨ New Features & Enhancements

- Introduced support for importing VAT rates from the EU VAT Rates API.

- Added validation of VAT numbers via the EU VAT Number Validation API.

- Implemented Docker Health Checks for improved container monitoring and management.

- Added an option for automatic document archiving (invoices, contracts). When a document is created or updated, a copy is automatically saved to the archive.

## 🐛 Bug Fixes

- Fixed issue with TinyMCE editor integration (license key set to GPL).

## 🧑‍💻 Development Updates

- Added a `modelName` property to all models for consistent referencing.

# 2.10.0

## ✨ New Features & Enhancements

- New icons from FontAwesome 7 have been added to the app, enhancing the visual appeal and usability of the interface.

## 🧑‍💻 Development Updates

- Migrate the TailwindCSS 3 configuration to the latest version (4), ensuring compatibility with the latest features and improvements in TailwindCSS.
- Improved user interface by updating the TailwindCSS configuration to use the latest version, enhancing the overall design and responsiveness of the app (maybe need some updates in the UI - coming in future releases).

# 2.9.0

## ✨ New Features & Enhancements

- Updated the design of the Partner Details page, specifically the contract grid section under Contact Email.
- Redesigned the "Add Document to Archive" form for improved usability and layout.
- Added a new Document Status column to the archive table for better tracking and visibility.
- The numbering system for all modules (invoices, quotes, etc.) now supports automatic yearly resets. If the numbering format includes a date placeholder (e.g., `{{DATE:Y}}`), the counter will reset to 1 at the beginning of each new year. Formats without a date will continue to increment sequentially.
- Updates on the client portal for partners, allowing them to see their quotes, invoices, and contracts.

## 🐛 Bug Fixes

- Fixed a UI issue that occurred when a client attempted to open a non-existent support ticket.

# 2.8.0

## ✨ New Features & Enhancements

- Added a new feature to add partner contact access to the client portal.
- Introduced a new feature client portal for partners, allowing them to see their quotes and invoices.
- Added \* as trusted proxy for all requests in the app (see `bootstrap/app.php`)

# 2.7.0

## ✨ New Features & Enhancements

- Introduced a new option for getting exchange rates from the currency API (https://github.com/fawazahmed0/exchange-api).
- Updates on the Docker build process to ensure compatibility with the latest changes.

## 🧑‍💻 Development Updates

- Updated the Dockerfile to use the latest PHP version and dependencies.
- Improved the Docker build process to ensure a more efficient and streamlined setup.
- Docker build images are now available on Docker Hub for easier deployment and testing, and on GitHub Packages.

## 🌐 Localization

- Updated translations with the latest contributions from Crowdin to support better multilingual usability.

# 2.6.0

## ✨ New Features & Enhancements

- Refined Docker build process; install.lock is now stored in the storage folder for improved structure.

# 2.5.0

## ✨ New Features & Enhancements

- Added support for Docker image building and deployment.

## 🐛 Bug Fixes

- Fixed an issue with the default language when the project is not installed (default language is English).

# 2.4.0

## ✨ New Features & Enhancements

- Added a new feature for sending support ticket notifications to users.
- Added a new feature for selecting a product category when creating/updating a product.

## 🐛 Bug Fixes

- Fixed an issue with not saving the payment method when creating an invoice.
- Fixed an issue with selecting bill items when creating/updating a bill.
- Fixed a validation issue with the quote selecting payment method.

# 2.3.0

**Important**: This release is not backwards-compatible with previous versions (v2.x.x) due to significant changes, including database migrations and structure updates.

## ✨ New Features & Enhancements

- Updated API documentation to include new endpoints and features.
- Added confirmation prompts for deleting taxes, units, and webhooks.
- Introduced management features for data types (e.g., payment methods, contract types, etc.).
- Added a "Document Type" field to the archive table.
- Redesigned PDF documents (invoices, bills, quotes, etc.).
- Added the ability to reset demo data (available only in demo mode).

## 🐛 Bug Fixes

- Fixed the generation of user profile images when using the command.
- Fixed bill deletion response.
- Fixed notification display options in the bill module.
- Fixed translation issues in payment responses.
- Fixed bugs during the process of adding an open banking account.
- Fixed validation bug for `payment_id` when updating a transaction.

## 💣 Breaking changes

- As part of the implementation of custom data collections, the old `payment_method` field in the invoice, transaction, quote, and bill tables has been renamed to `payment_method_id`.

**⚠️ Note**: Data from the old field is not automatically migrated. If you wish to retain the old data, manual migration is required. Otherwise, the app will not display this data correctly.

# 2.2.0

## ✨ New Features & Enhancements

- Added a new feature for sending an email to a partner contact.
- Added a feature to view and manage user personal access tokens by admin.

## 🧪 Experiment (may be deleted in feature)

- Added a feature to get the real IP address of the user (not proxy).

## 🐛 Bug Fixes

- Fixed a security issue with showing the token value in the API response.

## 🌐 Localization

- Updated translations with the latest contributions from Crowdin to support better multilingual usability.

# v2.1.1

## 🐛 Bug Fixes

- Fixed an issue with WorldSeeder by locking the package version
- Fixed colour format for the company colour in settings
- Fixed an issue where the sendmail path was not displayed in settings
- Fixed the unit updating issue in settings
- Fixed text colour of changelog on the status page

# v2.1.0

## ✨ New Features & Enhancements

- Added functions for generating personal access tokens for authentication (mobile apps, etc.).

## 🐛 Bug Fixes

- Fixed an issue where the language cookie was missing during app installation.
- Fixed a bug preventing user webhooks from being saved via the API.
- Removed the requirement for the item number field (now generated automatically).
- Fixed an issue causing incorrect behaviour in the API (`getPublicProducts`).

## 💄 UI/UX Improvements

- Improved UI design for displaying partner activities in dark mode.

## 🌐 Localization

- Updated translations with the latest contributions from Crowdin to support better multilingual usability.

# v2.0.0

This marks the official release of the new BiznisBox.

## ✨ New Features & Enhancements

- Added an option to reject contracts.
- Implemented email notifications for first-time logins from a new browser.
- Introduced a console command for creating users.
- Added new configuration settings for enhanced customisation.

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

- Updated the colour scheme for a more modern and cohesive look.
- Refined the design of input validation feedback.
- Added dark mode support to the rich text editor for improved user experience in low-light environments.
- Replaced the old app logo with a new, updated design.
- Overhauled the Role page view for a cleaner, more intuitive interface.

## 🧑‍💻 Development Updates

- Introduced support for Swagger generation to improve API documentation.

## 🌐 Localization

- Updated translations with the latest contributions from Crowdin, enhancing multilingual support and usability.

# v2.0.0-beta.4

## ✨ New Features & Improvements

- Add a function for sharing contacts with other users (via magic link).
- Add a function for internal tickets in the support module.

## 🐛 Bug Fixes

- Fixed some little bugs in UI.
- Fix security issues in the app (HTML injection, XSS) reported by SonarQube.

## 🌐 Localization

- Updated translations with the latest contributions from Crowdin to support better multilingual usability.

**Note**: This release includes numerous additional changes not listed here.

# v2.0.0-beta.3

## ✨ New Features & Enhancements

- Enhanced user experience during BiznisBox installation, with improved setup guidance and clearer prompts.

## 🐛 Bug Fixes

- Resolved an issue preventing the map icons from displaying in the production build.
- Corrected formatting errors with invoices, bills, and number format to ensure consistency and accuracy.
- Fixed multiple issues encountered during BiznisBox installation via the installer for a smoother setup.

## 🌐 Localization

- Updated translations with the latest contributions from Crowdin to support better multilingual usability.

**Note**: This release includes numerous additional changes not listed here.

# v2.0.0-beta.2

## ✨ New Features & Enhancements

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

## ✨ New Features & Enhancements

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

- **New Translations**: Added translations for Spanish, French, Portuguese, Italian, Russian, Chinese, Dutch, Norwegian, Danish, Swedish, and Finnish. (Crowdin has been utilised for automatic translation.)

**Note**: This release includes numerous additional changes not listed here.
