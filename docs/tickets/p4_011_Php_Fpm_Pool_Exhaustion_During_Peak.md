# Php Fpm Pool Exhaustion During Peak

Panel: console

## Problem

The production php-fpm log shows repeated pool exhaustion warnings during evening peaks, for example a sustained burst on 2026-08-21 17:47 to 17:48 and again on 2026-08-22 19:07 and 21:24:

```
WARNING: [pool www] seems busy (you may need to increase pm.start_servers,
or pm.min/max_spare_servers), spawning 32 children, there are 0 idle, and 17 total children
```

Zero idle workers means incoming requests queue while fpm scales up from a cold pool, which users experience as slow page loads at exactly the busiest time. This corroborates the earlier performance investigation which found the latency floor is application startup cost (OPcache not enabled on the server, package install pending with Ops).

## Scope

This is server configuration on the Forge box, not application code.

- Raise `pm.start_servers` and `pm.min_spare_servers`/`pm.max_spare_servers` (or move the pool to `pm = static` sized for peak) so the pool is already warm at peak. Size against memory headroom on the box.
- Land the pending OPcache enablement alongside, since each fpm child is currently paying full compile cost, which both slows requests and makes pool scale-up worse.
- Afterwards, watch `php8.4-fpm.log` across a few evening peaks and confirm the "seems busy" warnings are gone.

Needs server access, so this is for the operator or a session with Forge credentials. Log evidence lives in `storage/logs/production-logs/php-fpm/`.
