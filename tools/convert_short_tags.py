#!/usr/bin/env python3
"""
Convert legacy PHP short open tags to long form.

Rules:
- Replace `<?` with `<?php` unless it is:
  - already `<?php`
  - short echo `<?=`
  - XML declaration `<?xml`
- Replace `<?=` with `<?php echo `

By default, this script rewrites files in-place (no backups), as requested.
Use `--check` to only report what would change (no writes).
"""

from __future__ import annotations

import argparse
import os
import re
from pathlib import Path


ROOT = Path(__file__).resolve().parents[1]

# `<?=` → `<?php echo `
RE_SHORT_ECHO = re.compile(rb"<\?=")

# `<?` not followed by: php, =, xml  (case-insensitive for php/xml)
# Python supports lookahead, so this is safe here.
RE_SHORT_OPEN = re.compile(rb"<\?(?!(?:php\b|=|xml))", re.IGNORECASE)


def convert_bytes(content: bytes) -> tuple[bytes, int, int]:
    """Return (new_content, short_open_replacements, short_echo_replacements)."""
    new_content, echo_n = RE_SHORT_ECHO.subn(b"<?php echo ", content)
    new_content, open_n = RE_SHORT_OPEN.subn(b"<?php", new_content)
    return new_content, open_n, echo_n


def should_skip(path: Path) -> bool:
    # Skip obvious binary/large non-source dirs if any ever show up.
    parts = {p.lower() for p in path.parts}
    if "backups" in parts:
        return True
    if "tmimages" in parts or "imagens" in parts or "assets" in parts:
        return True
    return False


def main() -> int:
    parser = argparse.ArgumentParser()
    parser.add_argument(
        "--check",
        action="store_true",
        help="Report counts only (do not write changes).",
    )
    args = parser.parse_args()

    php_files = [p for p in ROOT.rglob("*.php") if p.is_file() and not should_skip(p)]

    changed_files = 0
    total_open = 0
    total_echo = 0
    would_change_files = 0

    for path in php_files:
        try:
            original = path.read_bytes()
        except OSError:
            continue

        converted, open_n, echo_n = convert_bytes(original)
        if open_n == 0 and echo_n == 0:
            continue

        would_change_files += 1
        if args.check:
            total_open += open_n
            total_echo += echo_n
            continue

        # Write back only if changed (default)
        try:
            path.write_bytes(converted)
        except OSError:
            continue

        changed_files += 1
        total_open += open_n
        total_echo += echo_n

    print(f"Scanned .php files: {len(php_files)}")
    if args.check:
        print(f"Would change files: {would_change_files}")
        print(f"Would replace short open tags (<?): {total_open}")
        print(f"Would replace short echo tags (<?=): {total_echo}")
    else:
        print(f"Changed files: {changed_files}")
        print(f"Replaced short open tags (<?): {total_open}")
        print(f"Replaced short echo tags (<?=): {total_echo}")
    return 0


if __name__ == "__main__":
    raise SystemExit(main())

