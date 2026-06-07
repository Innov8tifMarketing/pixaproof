---
name: auto-documenter
description: Document architectural changes and learnings. Use after adding components, routes, patterns, or learning new company/product information. Updates relevant docs and the index.
---

# Auto-Documenter

Automatically documents architectural changes, new patterns, and learnings about the company/product.

## Instructions

### 1. Determine What Changed

**Architecture changes** → Update `architecture.md`:
- New directories or files
- New routes
- New Livewire components
- New patterns (Actions, Concerns, etc.)
- Database schema changes

**Tech stack changes** → Update `tech-stack.md`:
- Dependency additions/updates
- New build tools or scripts
- Deployment configuration changes

**Company/product learnings** → Update `pixaproof-company.md` or `pixaproof-product.md`:
- New use cases discovered
- Updated pricing/features
- New target markets
- Brand refinements

**Page content changes** → Update `pages/*.md`:
- New page copy
- Updated CTAs or messaging
- New sections

### 2. Update the Relevant Document

Read the existing document:
```bash
cat .claude/docs/{document}.md
```

Then edit to add new information in the appropriate section.

### 3. Update the Index

If new keywords or topics were added, update `.claude/docs/index.md`:
- Add to Keyword Index table
- Update Quick Reference if new docs created

### 4. Log the Change

Add entry to bottom of the updated document:
```markdown
---
*Updated: YYYY-MM-DD - [Brief description]*
```

## When to Use

| Change Type | Document to Update |
|-------------|-------------------|
| New route added | architecture.md → Routes |
| New Livewire component | architecture.md → Directory Structure |
| New Action class | architecture.md → Patterns |
| New model/migration | architecture.md → Database Schema |
| npm/composer dependency | tech-stack.md → Dependencies |
| New page view | architecture.md, pages/*.md |
| Company info learned | pixaproof-company.md |
| Product feature learned | pixaproof-product.md |

## Output Format

```markdown
## Documentation Updated

### Changes Made
- [Document]: [Section] - [What was added/changed]

### Index Updated
- [Yes/No] - [New keywords if yes]

### Files Modified
- .claude/docs/[filename].md
```
