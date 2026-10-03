"""
LKTech Performance Optimizer — Tahap 1: Image Optimization
- Resize Logo-TokPed-TikTok-Shopee.png -> 300px wide WebP
- Compress LKtech.png -> LKtech.webp (lossless)
- Compress all remaining .png/.jpg to .webp
"""
from PIL import Image
import os

BASE = r"d:\Project\lktech\public\images"

tasks = [
    # (src, dest, max_width, quality, lossless)
    ("Logo-TokPed-TikTok-Shopee.png", "Logo-TokPed-TikTok-Shopee.webp", 300, 80, False),
    ("LKtech.png", "LKtech.webp", 800, 90, True),
    ("LKtech1.png", "LKtech1.webp", 800, 90, True),
]

for src_name, dest_name, max_w, quality, lossless in tasks:
    src_path = os.path.join(BASE, src_name)
    dest_path = os.path.join(BASE, dest_name)
    if not os.path.exists(src_path):
        print(f"  SKIP (not found): {src_name}")
        continue
    img = Image.open(src_path).convert("RGBA")
    # Resize if wider than max_w
    if img.width > max_w:
        ratio = max_w / img.width
        new_h = int(img.height * ratio)
        img = img.resize((max_w, new_h), Image.LANCZOS)
    before = os.path.getsize(src_path)
    if lossless:
        img.save(dest_path, "WEBP", lossless=True)
    else:
        img.save(dest_path, "WEBP", quality=quality, method=6)
    after = os.path.getsize(dest_path)
    saved = before - after
    print(f"  OK {src_name} ({img.width}x{img.height}) -> {dest_name}: {before//1024}KB -> {after//1024}KB (saved {saved//1024}KB)")

print("\nDone: Image optimization complete!")
