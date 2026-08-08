"""
Kompres gambar Martabak Jawara ke WebP untuk web.
- Input  : public/images/martabak-jawara/*.jpeg
- Output : public/images/martabak-jawara/*.webp
- Kualitas: 78 | Max: 1080px lebar (cukup untuk gallery web)
"""

import os, sys
from pathlib import Path
from PIL import Image

# Force UTF-8 output
sys.stdout.reconfigure(encoding='utf-8')

SRC_DIR    = Path("public/images/martabak-jawara")
QUALITY    = 78
MAX_WIDTH  = 1080
MAX_HEIGHT = 1440

results = []

for src in sorted(list(SRC_DIR.glob("*.jpeg")) + list(SRC_DIR.glob("*.jpg")) + list(SRC_DIR.glob("*.png"))):
    dst = src.with_suffix(".webp")
    orig_kb = src.stat().st_size / 1024

    with Image.open(src) as img:
        if img.mode in ("RGBA", "P"):
            img = img.convert("RGB")
        w, h = img.size
        if w > MAX_WIDTH or h > MAX_HEIGHT:
            img.thumbnail((MAX_WIDTH, MAX_HEIGHT), Image.LANCZOS)
        img.save(dst, "WEBP", quality=QUALITY, method=6)

    new_kb = dst.stat().st_size / 1024
    saving = (1 - new_kb / orig_kb) * 100
    results.append((src.name, orig_kb, new_kb, saving))
    print(f"  {src.name:<55} {orig_kb:>7.1f} KB -> {new_kb:>6.1f} KB  ({saving:.0f}% lebih kecil)")

total_orig = sum(r[1] for r in results)
total_new  = sum(r[2] for r in results)
print("")
print(f"  Total {len(results)} file | {total_orig/1024:.2f} MB -> {total_new/1024:.2f} MB (hemat {(1-total_new/total_orig)*100:.0f}%)")
print("Selesai! File .webp sudah dibuat di:", SRC_DIR)
