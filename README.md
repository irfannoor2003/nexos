# Nexos — Digital Agency Website

Official website for Nexos Digital Agency (nexosdigitalagency.com).

## Stack

- PHP (plain, no framework) + MySQL (PDO)
- Server-rendered pages with GSAP scroll/reveal animations
- Custom admin panel under `/admin`

## Setup (local)

1. Run under Laragon (or any PHP/MySQL stack).
2. Import / run `install.php` to create the database (tables, seed posts, categories, image slots).
3. Point your host to the project root. Default admin login is set during install.

## Deploy (Hostinger)

- Upload the project to `public_html/`.
- Create a MySQL database and set the credentials in `includes/db.php` (and in the DB block at the top of `install.php` before the first run).
- Run `install.php` once, then delete it.
- Create the writable folders if needed: `uploads/site/`, `uploads/blog/`, `logs/`.

## Known Issues / Bugs Log

We are aware of the following issues. They are to be fixed **after we get confirmation from the client** — do not close these until the client confirms.

### 1. Lagging / interaction issue with reveal animations

- When a section or div loads, if the user interacts with it (mouse hover, click, or touch) while it is still revealing, the element looks messed up / broken mid-animation.
- As soon as the cursor or finger is taken off the element, the animation resumes and completes its render correctly.
- The animations also appear slightly delayed in general.
- Likely related to the GSAP ScrollTrigger / reveal setup in `includes/footer.php` interacting with hover states (CSS transforms on hover) while the reveal tween is still running.

> Status: Pending client confirmation. Fix after approval.

### 2. Other bugs

If any other bug is found, log it here and we will continue working from this list.

- (none yet)