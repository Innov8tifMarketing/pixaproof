---
name: project-consultant
description: Consult project documentation before implementing features. Use when planning new pages, making architectural decisions, writing copy, or needing brand/product context. Reads the docs index and returns relevant patterns and references.
---

# Project Consultant

Consults project documentation to provide relevant context for tasks.

## Instructions

1. **Read the index first**:
   ```bash
   cat .claude/docs/index.md
   ```

2. **Identify relevant documents** based on task type:
   - Frontend work → `tech-stack.md`, `architecture.md`
   - Backend work → `architecture.md`
   - Content/copy → `pixaproof-company.md`, `pixaproof-product.md`, `pages/*.md`
   - Page implementation → `pages/*.md`, `site-structure.md`
   - Deployment → `tech-stack.md`

3. **Read the relevant documents**:
   ```bash
   cat .claude/docs/{document}.md
   ```

4. **Return a summary** containing:
   - Relevant patterns to follow
   - Existing implementations to reference
   - Brand/voice guidelines if content-related
   - Technical constraints or requirements

## When to Use

| Task | Consult |
|------|---------|
| Add a new page | `architecture.md`, `pages/*.md` |
| Create pricing section | `pixaproof-product.md` |
| Write hero copy | `pixaproof-company.md`, `pages/homepage.md` |
| Add form validation | `architecture.md` |
| Implement solutions page | `pages/solutions-*.md` |

## Output Format

```markdown
## Consultation Summary

### Relevant Context
[Key information from docs]

### Patterns to Follow
[Existing patterns in codebase]

### References
[File paths to existing implementations]

### Recommendations
[Suggested approach based on docs]
```
