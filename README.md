# Time to Read Block

A WordPress Gutenberg block that displays estimated reading time for articles. This plugin automatically calculates and displays reading time based on content length and customizable reading speed.

## Features

- **Context-Aware**: Automatically detects content from current post or Query Loop context
- **Customizable Reading Speed**: Adjustable words per minute (default: 275 WPM)
- **Full WordPress Integration**: Uses native WordPress block controls and styling
- **Query Loop Compatible**: Works seamlessly within Query Loop blocks
- **Comprehensive Styling**: Supports all WordPress typography, color, spacing, and border controls

## Installation

1. Upload the plugin files to the `/wp-content/plugins/time-to-read-block` directory
2. Activate the plugin through the 'Plugins' screen in WordPress
3. Add the "Time to Read" block to your posts or pages using the block editor

## Usage

### Basic Usage
1. In the WordPress block editor, click the "+" button to add a new block
2. Search for "Time to Read" or find it in the Widgets category
3. The block will automatically calculate reading time for the current post

### In Query Loops
- Add the Time to Read block inside Query Loop blocks
- It will automatically calculate reading time for each post in the loop
- No additional configuration needed

### Customization Options

#### Reading Settings
- **Words per Minute**: Adjust the reading speed calculation (default: 275 WPM)
- Accessible via the block inspector panel

#### Styling Options
The block supports all WordPress native styling controls:

- **Colors**: Text color and background color
- **Typography**: 
  - Font size, family, weight, style
  - Line height, letter spacing
  - Text transform and decoration
- **Spacing**: Padding and margin controls
- **Dimensions**: Minimum height
- **Border**: Width, style, color, and radius

## Technical Details

### Block Information
- **Block Name**: `ttrb/time-to-read`
- **Category**: Widgets
- **Icon**: Clock (Dashicons)
- **Type**: Dynamic block (server-side rendering)

### Reading Time Calculation
- Default reading speed: 275 words per minute
- Strips HTML tags and shortcodes from content
- Rounds up to nearest minute
- Displays "Less than 1 minute" for very short content

### Context Support
- **Post ID**: Automatically detects current post or Query Loop post
- **Post Type**: Works with any post type

## Development

### Build Process
```bash
npm install
npm run build
```

### File Structure
```
time-to-read-block/
├── src/
│   ├── index.js          # Block registration and editor component
│   └── style.css         # Block styles
├── build/                # Compiled assets
├── time-to-read-block.php # Main plugin file
├── package.json          # Node.js dependencies
└── README.md            # This file
```

### WordPress Compatibility
- **Minimum WordPress Version**: 5.0
- **Tested up to**: 6.4
- **Requires PHP**: 7.4+

## Changelog

### 1.0.0
- Initial release
    - Context-aware reading time calculation
    - WordPress native styling controls
    - Query Loop compatibility
    - Customizable words per minute setting

## License

This plugin is licensed under the GPL v2 or later.

## Support

For support, feature requests, or bug reports, please create an issue in the plugin repository.

## Contributing

Contributions are welcome! Please follow WordPress coding standards and include appropriate tests for any new features.
