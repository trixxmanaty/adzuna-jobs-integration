# Adzuna Jobs Integration for WordPress

This WordPress plugin integrates job listings from Adzuna into your WordPress site, allowing users to search for and view job opportunities.

## Prerequisites

Before using this plugin, you will need to obtain an API key from Adzuna. Sign up for a free Adzuna API key at [Adzuna API Developer Portal](https://developer.adzuna.com).

## Features

- Job search form that integrates with the Adzuna API.
- Display job listings with details like title, company, salary, and apply link.
- Ajax-powered search functionality for a seamless user experience.
- Links to job applications open in a new tab.

## Installation

1. Download the plugin files.
2. Upload the plugin files to the `/wp-content/plugins/` directory, or install the plugin through the WordPress plugins screen directly.
3. Activate the plugin through the 'Plugins' screen in WordPress.
4. Open the `adzuna-jobs-integration.php` file in the plugin directory.
5. Replace `'YourAppIDHere'` and `'YourAppKeyHere'` with your actual Adzuna API keys.

## Usage

Add the shortcode `[adzuna_job_search]` to any post or page where you want the job search form to appear.

## Contributing

Contributions are welcome! Feel free to open an issue or submit a pull request.

## License

This project is licensed under the GPL-3.0 license - see the [LICENSE.md](https://github.com/trixxmanaty/adzuna-jobs-integration/blob/main/LICENSE) file for details.
