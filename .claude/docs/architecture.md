# PixaProof Marketing Site - Architecture

## Project Type
B2B marketing website for PixaProof - an enterprise image authenticity verification platform.

## Architecture
Single-page mega landing (`home.blade.php`) with anchor navigation, plus separate Contact and Privacy pages. All former multi-page routes (enterprise solutions, technology, etc.) are consolidated into the homepage and served via 301 redirects.

## Directory Structure

```
app/
├── Actions/
│   └── SubmitContactFormAction.php    # Form submission logic
├── Http/Controllers/
│   └── Controller.php                  # Base controller
├── Livewire/
│   ├── ContactForm.php                 # Contact form component
│   └── Concerns/
│       └── WithRateLimiting.php        # Rate limiting trait
├── Mail/
│   └── ContactFormSubmission.php       # Email notification
├── Models/
│   ├── User.php
│   └── Lead.php                        # Contact form submissions
└── Providers/
    └── AppServiceProvider.php

resources/
├── css/
│   └── app.css                         # Tailwind v4 + brand colors (primary/neutral/accent)
├── js/
│   └── app.js                          # Alpine.js interactions
└── views/
    ├── components/
    │   ├── navbar.blade.php            # Navigation with anchor links
    │   ├── footer.blade.php
    │   ├── button.blade.php            # Button with variants/sizes
    │   ├── rotating-text.blade.php     # Animated text rotation
    │   ├── section.blade.php           # Reveal-on-scroll section shell + centered header
    │   ├── check-list.blade.php        # <ul> of check-icon bullets (compact variant)
    │   ├── icon-card.blade.php         # Heroicon tile + title + body (inline/stacked, inverted)
    │   ├── stat.blade.php              # Animated counter / static figure for the stats strip
    │   └── graphics/
    │       ├── hero-comparison.blade.php
    │       ├── phone-mockup.blade.php
    │       ├── prevention-visual.blade.php
    │       └── solution-flow.blade.php
    ├── emails/
    │   └── contact-form.blade.php
    ├── layouts/
    │   ├── base.blade.php              # HTML skeleton, meta tags
    │   └── app.blade.php               # App layout (navbar/footer)
    ├── livewire/
    │   └── contact-form.blade.php
    └── pages/
        ├── home.blade.php              # Mega landing (~900 lines, data-driven sections)
        ├── contact.blade.php           # Demo request form (Livewire)
        ├── privacy.blade.php           # Privacy policy
        └── components.blade.php        # Component showcase (local dev only)
```

## Homepage Sections (Mega Landing)

The homepage (`pages/home.blade.php`) contains 9 major sections accessed via anchor navigation:

| # | Section | Anchor ID | Description |
|---|---------|-----------|-------------|
| 1 | Hero | (top) | Innov8tif co-branding, PIXAPROOF wordmark, CTAs |
| 2 | Problem Statement | `#challenge` | Verification Gap + Cost of Compensating Controls |
| 3 | Solution Introduction | `#solution` | PixaProof value prop |
| 4 | How It Works | `#how-it-works` | 3-step: Capture → Analyze → Deliver |
| 5 | Use Cases | `#solutions` | Tabbed: Loan Draw, Insurance, Field Operations & Assets (`$industries` array) |
| 6 | Technology Highlights | `#technology` | Disabled (`@if (false)`) — data accuracy under review |
| 7 | Company Credibility | `#about` | Innov8tif background, certifications, stats |
| 8 | FAQ | `#faq` | Accordion with Alpine.js |
| 9 | Final CTA | (bottom) | "Ready to Eliminate Image Fraud?" + Request Demo |

## Patterns

### Actions Pattern
Business logic extracted into single-purpose action classes:
- `SubmitContactFormAction` - Handles lead creation and email dispatch

### Livewire Concerns
Reusable traits for Livewire components:
- `WithRateLimiting` - IP-based rate limiting (3 attempts/5 min)

### Layout Hierarchy
1. `base.blade.php` - HTML skeleton, Inter font, Vite assets, CSRF
2. `app.blade.php` - Extends base, adds `<x-navbar />` and `<x-footer />`
3. Page views - Extend app layout via `@extends('layouts.app')`

### Homepage Section Components
Homepage sections 4–13 (except the scroll-scrubbed Challenge and the disabled Technology grid) are wrapped in `<x-section>`, which owns the `x-data="{ visible: false }"` / `x-intersect.once` reveal and the eyebrow / h2 / description header. Children may read the parent `visible` state (`<x-stat>` does). Repeated markup uses `<x-check-list>`, `<x-icon-card>` and `<x-stat>`; repeated copy lives in `@php` arrays (`$industries`, `$milestones`, `$comparisons`, `$faqs`) rendered via `@foreach`, so an industry or FAQ is added or removed in one place. Desktop copy is canonical for industries; the mobile accordion renders the same headline, body and bullets.

### Anchor Navigation
Navbar links use `/#section-id` anchors instead of separate routes. CSS handles scroll offset:
```css
section[id] {
    scroll-margin-top: 5rem;
}
```

## Routes

### Active Pages
| Route | View | Name | Notes |
|-------|------|------|-------|
| `/` | pages.home | home | Single-page mega landing |
| `/contact` | pages.contact | contact | Demo request form |
| `/privacy` | pages.privacy | privacy | Privacy policy |

### Anchor Links (on homepage)
| Link | Target |
|------|--------|
| `/#challenge` | Problem Statement section |
| `/#solution` | Solution Introduction |
| `/#how-it-works` | How It Works |
| `/#solutions` | Use Cases tabs |
| `/#technology` | Technology Highlights |
| `/#about` | Company Credibility |
| `/#faq` | FAQ |

### 301 Redirects (SEO preservation)
| Old Route | Redirects To |
|-----------|-------------|
| `/technology` | `/#technology` |
| `/about` | `/#about` |
| `/company/about` | `/#about` |
| `/company/contact` | `/contact` |
| `/pricing` | `/contact` |
| `/how-it-works` | `/#technology` |
| `/enterprise` | `/#solutions` |
| `/product` | `/#technology` |
| `/solutions/*` | `/#solutions` or `/` |
| `/resources/*` | `/` |

### Dev-Only Routes
| Route | View | Condition |
|-------|------|-----------|
| `/components` | pages.components | `local` environment only |

## Data Flow

### Contact Form Submission
1. User fills Livewire `ContactForm`
2. Rate limiting checked via `WithRateLimiting`
3. `SubmitContactFormAction` creates `Lead` record
4. `ContactFormSubmission` mail queued to admin
5. Success message displayed

## Database Schema

### leads
| Column | Type | Notes |
|--------|------|-------|
| id | bigint | Primary key |
| name | string | |
| email | string | |
| phone | string | nullable |
| company | string | nullable |
| job_title | string | nullable |
| industry | string | nullable |
| inquiry_type | string | |
| message | text | |
| source | string | nullable |
| ip_address | string | For rate limiting |
| created_at | timestamp | |
| updated_at | timestamp | |

---
*Updated: 2026-02-09 - Rewritten to match current single-page mega landing architecture*
*Updated: 2026-09-23 - Removed KYC Onboarding industry; added section, check-list, icon-card and stat components; homepage sections data-driven*
