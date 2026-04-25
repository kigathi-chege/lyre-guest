# `lyre/guest` Agent Guide

## Package Purpose
`lyre/guest` manages anonymous visitor identity, guest UUID tracking, guest user provisioning, and guest-to-user merge orchestration during auth lifecycle events.

## What Belongs In This Package
- Guest identity model/repository.
- Guest middleware (`EnsureGuestUser`) and request/cookie/header guest flow.
- Auth event subscriber and merge job triggering.

## What Does Not Belong Here
- Commerce/cart logic (commerce may depend on this package, but business logic belongs in commerce).
- General auth policy unrelated to guest lifecycle.

## Public API / Stable Contracts
- `EnsureGuestUser` middleware behavior:
  - guest UUID propagation via `X-Guest-UUID`
  - guest cookie/session handling
  - fallback guest user creation/authentication
- Event subscriber merge behavior on login/register/logout events.

## Internal Areas That May Change
- Internal merge execution details if middleware and event-side observable behavior remains consistent.

## Usage Rules
- Use this middleware when APIs must support anonymous session continuity.
- Ensure host app has compatible user model fields expected by middleware (`is_guest`, email/name/password creation path).

## Extension Rules
- Any change to guest UUID header/cookie behavior is breaking for consumers; coordinate and document.
- Keep merge behavior idempotent and failure-tolerant.

## Testing Requirements
- Validate guest flow for anonymous request, repeat request, login merge, and logout.
- Validate middleware compatibility with downstream packages (notably commerce).

## Docs To Update When This Package Changes
- Root [AGENTS.md](/Users/chegekigathi/Projects/packages/lyre-packages/AGENTS.md)
- [docs/architecture.md](/Users/chegekigathi/Projects/packages/lyre-packages/docs/architecture.md)
- [docs/package-responsibilities.md](/Users/chegekigathi/Projects/packages/lyre-packages/docs/package-responsibilities.md)
- Add/update `packages/guest/README.md` if contract changes
