# PixaProof Website Structure

## Architecture
Single-page mega landing with anchor navigation. All content consolidated into the homepage (`/`), with only Contact and Privacy as separate pages.

## Primary Navigation

```
Home                    → / (scroll to top)
Solutions               → /#solutions (anchor)
Technology              → /#technology (anchor)
About                   → /#about (anchor)
Request Demo            → /contact (separate page, primary CTA)
```

The navbar uses anchor links that scroll to sections on the homepage. On the contact/privacy pages, these links navigate back to `/#section`.

---

## Page Hierarchy

### Active Pages
| Route | Template | Description |
|-------|----------|-------------|
| `/` | pages.home | Enterprise mega landing (9 sections) |
| `/contact` | pages.contact | Demo request / contact form (Livewire) |
| `/privacy` | pages.privacy | Privacy policy |

### Homepage Sections (Anchor Navigation)
| Section | Anchor | Key Content |
|---------|--------|-------------|
| Hero | (top) | Innov8tif co-branding, tagline, CTAs |
| The Challenge | `#challenge` | Verification Gap, Cost of Compensating Controls |
| Solution | `#solution` | PixaProof introduction |
| How It Works | `#how-it-works` | Capture → Analyze → Deliver (3-step flow) |
| Use Cases | `#solutions` | Tabbed: Loan Draw, Insurance, KYC, Asset Verification |
| Technology | `#technology` | PIEA capabilities bento grid |
| Company | `#about` | Innov8tif background, certifications, stats |
| FAQ | `#faq` | Accordion Q&A |
| Final CTA | (bottom) | "Ready to Eliminate Image Fraud?" |

### Archived Pages (301 Redirects)
All legacy multi-page routes redirect to homepage anchors or the contact page. See `architecture.md` for the full redirect map.

---

## Key CTAs

| Location | Primary CTA | Secondary CTA |
|----------|-------------|---------------|
| Hero | Request Demo → `/contact` | Learn How It Works → `#how-it-works` |
| Final CTA | Request Demo → `/contact` | Email: sales@innov8tif.com |
| Navbar | Request Demo → `/contact` | — |

---

## Footer Sections

### Navigation Links
- Home
- Solutions
- Technology
- About

### Company
- Contact
- Privacy Policy

### Contact
- sales@innov8tif.com

### Legal
- Privacy Policy
- © Innov8tif Solutions Sdn. Bhd.

---

## Trust Elements

### Certifications (displayed in Company section)
- ISO 27001:2022
- ISO 27002:2022
- SOC 2 Type II (In Progress)
- GDPR Compliant

### Stats (displayed in Company section)
- 500+ Enterprise clients
- 3 Granted patents
- 14+ Years expertise
- 10+ Countries served

---

*Updated: 2026-02-09 - Rewritten for single-page mega landing architecture*
