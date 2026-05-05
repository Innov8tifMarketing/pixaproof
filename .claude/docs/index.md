# PixaProof Documentation Index

> Reference index for project documentation. Use this to locate relevant information.

## Quick Reference

| Topic | Document | Description |
|-------|----------|-------------|
| Tech Stack | [tech-stack.md](./tech-stack.md) | Laravel 12, Livewire 3, Tailwind 4, devices.css |
| Architecture | [architecture.md](./architecture.md) | Directory structure, patterns, routes, schema |
| **Stylesheet** | [stylesheet-guidelines.md](./stylesheet-guidelines.md) | Colors (primary/neutral/accent), typography, components |
| Company | [pixaproof-company.md](./pixaproof-company.md) | Innov8tif, brand, certifications |
| Product | [pixaproof-product.md](./pixaproof-product.md) | Enterprise SDK, API, PIEA technology |
| Site Structure | [site-structure.md](./site-structure.md) | Anchor navigation, routes, CTAs |

## Current Architecture

The site uses a **single-page mega landing** (`home.blade.php`, ~724 lines) with anchor navigation. Only Contact and Privacy are separate pages. All former multi-page routes are 301 redirects.

## Website Content (pages/)

### Active Page
| Page | Document | Key Content |
|------|----------|-------------|
| Homepage | [pages/homepage.md](./pages/homepage.md) | Enterprise mega landing (9 sections with anchors) |

### Archived Pages (consolidated into homepage)
These docs describe content that was planned as separate pages but has been consolidated into the homepage. They contain useful reference content for industry-specific messaging.

| Page | Document | Status |
|------|----------|--------|
| Banking | [pages/solutions-banking.md](./pages/solutions-banking.md) | Archived — content in `/#solutions` tabs |
| Insurance | [pages/solutions-insurance.md](./pages/solutions-insurance.md) | Archived — content in `/#solutions` tabs |
| Government | [pages/solutions-government.md](./pages/solutions-government.md) | Archived — redirects to `/` |
| E-commerce | [pages/solutions-ecommerce.md](./pages/solutions-ecommerce.md) | Archived — redirects to `/` |
| Healthcare | [pages/solutions-healthcare.md](./pages/solutions-healthcare.md) | Archived — redirects to `/` |
| Technology | [pages/technology.md](./pages/technology.md) | Archived — content in `/#technology` section |
| Developers | [pages/developers.md](./pages/developers.md) | Archived — not yet implemented |

## By Task Type

### Frontend Development
- **Design System**: `stylesheet-guidelines.md` → Colors (primary/neutral/accent), typography, spacing, components
- **Primary Color**: Sky blue (`primary-*` tokens)
- **Neutral Color**: Slate (`neutral-*` tokens)
- **Accent Color**: Amber (`accent-*` tokens)
- **Styling**: `tech-stack.md` → Tailwind CSS v4 (CSS-first config via `@theme`)
- **Components**: `stylesheet-guidelines.md` → Button, Card, Badge, Bento Grid, Vertical Tabs, Patterns, Graphics
- **Layouts**: `architecture.md` → Base → App → Page hierarchy

### Backend Development
- **Forms**: `architecture.md` → Actions pattern, rate limiting
- **Database**: `architecture.md` → Lead model, schema
- **Email**: `architecture.md` → ContactFormSubmission mailable
- **Routes**: `architecture.md` → Active pages, 301 redirects

### Content & Copywriting
- **Brand Voice**: `pixaproof-company.md` → Tone, pillars
- **Product Messaging**: `pixaproof-product.md` → Enterprise SDK, PIEA technology
- **Homepage Sections**: `pages/homepage.md` → All 9 sections detailed
- **Industry Content**: `pages/solutions-*.md` → Reference for industry-specific messaging

### Deployment
- **Config**: `tech-stack.md` → nixpacks.toml, Coolify
- **Environment**: See `CLAUDE.md` in project root

## Keyword Index

| Keyword | Document | Section |
|---------|----------|---------|
| Accent Colors | stylesheet-guidelines.md | Color Palette |
| Alpine.js | tech-stack.md | Frontend |
| Anchor Navigation | architecture.md | Anchor Navigation |
| Badge | stylesheet-guidelines.md | Components |
| Bento Grid | stylesheet-guidelines.md | Components |
| Brand | pixaproof-company.md | Brand Identity |
| Button | stylesheet-guidelines.md | Components |
| Card | stylesheet-guidelines.md | Components |
| Certifications | pixaproof-company.md | Certifications |
| Company Section | pages/homepage.md | Section 7 |
| Contact Form | architecture.md | Data Flow |
| CTA | site-structure.md | Key CTAs |
| Database | architecture.md | Database Schema |
| devices.css | tech-stack.md | Frontend |
| FAQ | pages/homepage.md | Section 8 |
| Footer | stylesheet-guidelines.md | Files Reference |
| Hero | pages/homepage.md | Section 1 |
| Homepage | pages/homepage.md | Full page |
| How It Works | pages/homepage.md | Section 4 |
| Industry Use Cases | pages/homepage.md | Section 5 |
| Innov8tif | pixaproof-company.md | Parent Organization |
| Layouts | architecture.md | Layout Hierarchy |
| Leads | architecture.md | Database Schema |
| Livewire | tech-stack.md | Core Framework |
| Mega Landing | architecture.md | Architecture |
| Navbar | stylesheet-guidelines.md | Navbar |
| Navigation | site-structure.md | Primary Navigation |
| Neutral Colors | stylesheet-guidelines.md | Color Palette |
| PIEA | pixaproof-product.md | Core Technology |
| Primary Colors | stylesheet-guidelines.md | Color Palette |
| Rate Limiting | architecture.md | Livewire Concerns |
| Redirects | architecture.md | 301 Redirects |
| Routes | architecture.md | Routes |
| SDK | pixaproof-product.md | Enterprise Solutions |
| Section Pattern | stylesheet-guidelines.md | Structural Conventions |
| Spacing | stylesheet-guidelines.md | Spacing |
| Tailwind | tech-stack.md | Frontend |
| Technology Section | pages/homepage.md | Section 6 |
| Typography | stylesheet-guidelines.md | Typography |
| Use Cases | pages/homepage.md | Section 5 |
| Vertical Tabs | stylesheet-guidelines.md | Components |
| Vite | tech-stack.md | Frontend |

---
*Updated: 2026-02-09 - Rewritten for single-page mega landing architecture*
