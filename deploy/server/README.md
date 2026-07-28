# Server configuration (reference copies)

Mirror of the hand-maintained config for this site on `47.237.191.213`. The
path under `deploy/server/` is the path on the box.

**Not applied by any deploy.** This is version control for config that
otherwise exists only on the server. Editing here changes nothing until someone
applies it by hand.

pixaproof shares the box with the innov8tif marketing site. Server-wide config —
`/etc/caddy/Caddyfile` (which imports this vhost), logrotate, the Caddy systemd
drop-in and the apt/unattended-upgrades policy — lives in that repo under the
same `deploy/server/` path. Only this site's own vhost is tracked here.

## Checking for drift

```bash
vendor/bin/dep server:diff prod
```

## Two things that will bite you

**A `caddy reload` proves almost nothing about a reboot.** Reload reuses open
file descriptors and keeps the old config running if the new one fails. After
any log-related change, do a real `systemctl restart caddy` — that is the only
test matching what a reboot does. On 2026-07-28 a latent log-ownership fault
took this site down twice, having hidden behind reloads for months.

**A syntax error here takes down all three vhosts, not just this one.** Caddy
loads the whole config atomically. Always
`caddy validate --config /etc/caddy/Caddyfile --adapter caddyfile` first.
