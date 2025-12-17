# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

AdminLTE is a Bootstrap 5-based admin dashboard template with TypeScript components and SCSS styling. The project uses Astro for documentation generation and includes comprehensive build tooling for development and production.

## Development Commands

### Start Development
```bash
npm start                    # Start development server with file watching (opens http://localhost:3000)
npm run dev                  # Same as npm start
```

### Build Commands
```bash
npm run build               # Quick development build (CSS + JS + assets + docs)
npm run production          # Full production build with linting and optimization
npm run compile             # Build all assets (CSS, JS, assets, docs)
```

### Asset-Specific Commands
```bash
npm run css                 # Build CSS only (compile + prefix + RTL + minify)
npm run js                  # Build JavaScript only (compile + minify)
npm run assets              # Process assets only
```

### Linting and Quality
```bash
npm run lint                # Run all linters (JS, CSS, docs, lockfile)
npm run js-lint             # ESLint for JavaScript/TypeScript
npm run css-lint            # Stylelint for SCSS
npm run docs-lint           # Astro check for documentation
```

### Individual Build Steps
```bash
npm run css-compile         # Compile SCSS to CSS
npm run css-rtl             # Generate RTL versions
npm run js-compile          # Compile TypeScript to JavaScript
npm run docs-compile        # Build documentation with Astro
```

## Architecture

### Core Structure
- **src/ts/**: TypeScript source files for UI components
- **src/scss/**: SCSS source files for styling
- **src/html/**: Astro-based documentation and examples
- **src/config/**: Build configuration files
- **src/assets/**: Static assets (images, etc.)
- **dist/**: Built assets and documentation

### Key Components (src/ts/)
- **adminlte.ts**: Main entry point that initializes all components
- **layout.ts**: Core layout management and theme handling
- **accessibility.ts**: WCAG 2.1 AA compliance features
- **card-widget.ts**: Collapsible card functionality
- **treeview.ts**: Navigation tree component
- **push-menu.ts**: Sidebar menu toggle
- **direct-chat.ts**: Chat widget functionality
- **fullscreen.ts**: Fullscreen mode toggle

### Build System
- **Rollup**: JavaScript bundling (UMD format)
- **Sass**: SCSS compilation with Bootstrap integration
- **PostCSS**: CSS processing with autoprefixer and RTL support
- **Astro**: Static site generation for documentation
- **ESLint**: JavaScript/TypeScript linting with TypeScript ESLint, Unicorn, and Astro plugins

### Styling Architecture
- Built on Bootstrap 5.3.7 with custom variables
- Modular SCSS structure in parts/ directory
- Dark mode support with separate variable files
- RTL (Right-to-Left) language support
- Accessibility-focused styling

### Development Workflow
1. Source files are watched during development
2. CSS and JS are automatically compiled and copied to src/html/public/
3. Astro serves documentation with hot reloading
4. Production builds include minification and optimization

## Key Files and Configurations

### Build Configuration
- **src/config/rollup.config.js**: JavaScript bundling configuration
- **src/config/astro.config.mjs**: Documentation build configuration
- **src/config/postcss.config.mjs**: CSS processing configuration
- **eslint.config.js**: Linting rules and file ignores

### Main Entry Points
- **src/ts/adminlte.ts**: Main TypeScript entry point
- **src/scss/adminlte.scss**: Main SCSS entry point
- **dist/js/adminlte.min.js**: Built JavaScript for production
- **dist/css/adminlte.min.css**: Built CSS for production

### Development Notes
- The project uses ES modules (type: "module" in package.json)
- TypeScript configuration is in tsconfig.json
- File watching is handled by nodemon with specific patterns
- Assets are copied to src/html/public/ during build for Astro integration
- Production builds are flattened to dist/ root for deployment