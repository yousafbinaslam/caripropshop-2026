# CariPropShop - Real Estate Website

## Project Overview

CariPropShop is a custom-built real estate website combining the best features of the Houzez theme with a modern React frontend, all powered by WordPress as the backend CMS.

### Key Features
- **Custom WordPress Backend** - Built from scratch with custom plugins
- **React Frontend** - Modern, fast, and interactive UI
- **Property Management** - Full-featured real estate listing system
- **Agent Management** - Directory and profiles for real estate agents
- **Multilingual Support** - Indonesian and English (Polylang)
- **SEO Optimized** - Rank Math SEO integration
- **GDPR Compliant** - Cookie consent system

## Project Structure

```
caripropshop/
├── wordpress/              # WordPress installation
│   └── wp-content/
│       ├── plugins/        # Custom WordPress plugins
│       ├── themes/         # WordPress themes
│       └── uploads/        # Media uploads
├── react-app/              # React frontend application
│   ├── src/
│   │   ├── components/    # React components
│   │   ├── pages/         # Page components
│   │   ├── services/      # API services
│   │   ├── hooks/         # Custom hooks
│   │   └── utils/         # Utility functions
│   └── public/            # Static assets
├── docker/                 # Docker configuration
├── docs/                   # Documentation
└── scripts/               # Build scripts
```

## Custom Plugins

| Plugin | Description |
|--------|-------------|
| CariPropShop Core | Property, Agent, Agency post types, taxonomies, REST API |
| CariPropShop CRM | Lead management, client database, inquiries |
| CariPropShop Login | User registration, agent profiles, social login |
| CariPropShop Builder | Custom Elementor widgets |
| CariPropShop Widgets | Advanced property widgets |
| CariPropShop Analytics | Property view tracking, analytics |
| CariPropShop Chat | Live chat functionality |
| CariPropShop Cookie | GDPR compliance |
| CariPropShop Forms | Contact and inquiry forms |
| CariPropShop Sliders | Hero and property sliders |
| CariPropShop Mail | Email marketing integration |
| CariPropShop Import | Demo content import |

## Technology Stack

### Backend
- WordPress 6.x
- PHP 8.x
- MariaDB 10.x
- Custom REST API

### Frontend
- React 18.x
- TypeScript
- Vite
- Tailwind CSS
- React Router

### Plugins & Tools
- Elementor Page Builder
- Rank Math SEO
- Polylang Pro
- Redux Framework

## Getting Started

### Prerequisites
- Docker / Podman
- Node.js 18+
- PHP 8.0+
- MariaDB / MySQL

### Installation

1. Clone the repository
```bash
git clone https://github.com/YOUR_USERNAME/caripropshop.git
cd caripropshop
```

2. Set up Docker containers
```bash
cd docker
docker-compose up -d
```

3. Install WordPress dependencies
```bash
cd wordpress
# Follow WordPress installation wizard
```

4. Set up React app
```bash
cd react-app
npm install
npm run dev
```

## Development

### WordPress Development
- Custom plugins go in `wordpress/wp-content/plugins/`
- Custom theme goes in `wordpress/wp-content/themes/`
- Activate plugins via WordPress admin

### React Development
```bash
cd react-app
npm run dev    # Development server
npm run build  # Production build
```

## Deployment

The website will be deployed to https://www.caripropshop.com

See `docs/DEPLOYMENT.md` for detailed deployment instructions.

## Documentation

- [API Documentation](docs/API.md)
- [Plugin Development](docs/PLUGINS.md)
- [Deployment Guide](docs/DEPLOYMENT.md)
- [Contributing](CONTRIBUTING.md)

## License

Copyright © 2026 CariPropShop. All rights reserved.

## Author

**CariPropShop Development Team**

---

*Built with ❤️ for the Indonesian real estate market*
