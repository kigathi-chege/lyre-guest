# Lyre Guest

`lyre/guest` tracks anonymous users and bridges guest activity into authenticated users.

## Install
```bash
composer require lyre/guest
```

Publish migrations and migrate:
```bash
php artisan vendor:publish --provider="Lyre\Guest\Providers\LyreGuestServiceProvider"
php artisan migrate
```

## Core behavior
- `EnsureGuestUser` middleware ensures every anonymous flow has a guest UUID.
- Guest UUID is propagated with `X-Guest-UUID` header and guest cookie/session.
- On login/register, guest user data can be merged into the authenticated user via event subscriber flow.

## Notes
- Host app user model is expected to support guest user creation flow (`is_guest`, name/email/password).
- Commerce package APIs depend on this middleware by default.
