# Fantasy Football World Cup — Reconstructed Source

Your Word doc had all the code pasted in one long, shuffled stream (not in file
order), so I split it back into individual files by matching each snippet
against clues in the code itself: AJAX `xmlhttp.open("POST", "X.php", ...)`
calls, `<form action="X.php">`, and `header("location: X.php")` redirects.
Filenames below are reconstructed from those clues, not guessed at random —
but a few are still my best judgement, flagged below.

## Structure
```
php/       - all PHP pages/endpoints + index.html
css/       - ff.css (site-wide) and table.css (team/player tables)
python/    - two standalone offline scripts (not run by the website itself)
sql/       - one-off SQL used to update stats/prices
notes/     - a leftover fragment I couldn't confidently place
```

## Site flow (as far as I could reconstruct it)
- `index.html` → `signup.php` / `login.php` → `welcome.php`
- `welcome.php` → `team.php` (pick 15 players, uses `get_players.php`,
  `submit_players.php`, `remove_players.php`, `get_selected_players.php`)
- `team.php` → `team_confirmation.php` (review squad, budget/position checks
  via `submit_players_check.php`) → `submit_players_final.php` → `team_view.php`
- `team_view.php` (view squad/points) → `subs.php` (pick starting 11) →
  `substitutions.php`
- `reset_form.php` → `reset_password.php` → `reset_process.php` (forgot
  password flow)
- `logout.php` destroys the session

## Things worth knowing / cleaning up
1. **`welcome.php`** — the login-check (`if (!isset($_SESSION['loggedin']))...`)
   was pasted *after* the page content, and there's a stray extra `<html>`
   tag. I kept your original code exactly as written rather than silently
   fixing it — you'll want to move that check to the very top of the file.
2. **`subs.php`** — combined two chunks that were far apart in the doc: a
   `starter = 'False'` reset query, and the "choose your starting 11" page
   markup. This is my best reconstruction of one file, but worth double
   checking.
3. **`reset_password.php` / `reset_process.php`** — the original was one
   continuous block mixing "send reset email" with "verify token & update
   password". I split it at the natural `<?php endif; ?>` boundary since the
   form (`reset_process.php` is its `action`) implied two separate steps, but
   they may have originally been one file.
4. **`notes/unidentified_fragment.html`** — a bare, contentless page skeleton
   (just `<head>` + `ff.css` link) that didn't match any other file's title
   or stylesheet combo. Might be leftover paste noise — check if you actually
   need it.
5. **Duplicate footer skeletons** — two near-identical stray
   `<!DOCTYPE html><html><head>...ff.css` fragments appeared mid-document
   (after `team_confirmation.php` and `team_view.php` content). I treated
   these as accidental duplicate pastes and only kept the closing
   `</body></html>` + footer div from them, folded into the preceding file.
6. **Images** referenced (`images/worldcup.PNG`, `images/pitch.PNG`) weren't
   in the doc, so you'll need to re-add those yourself.
7. I did **not** fix any bugs in the logic (e.g. a missing semicolon in
   `submit_players.php`, or `subs.php`'s starter-reset query not being scoped
   to a user) — everything is preserved exactly as it was originally written.
