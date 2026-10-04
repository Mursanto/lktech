"""
Compress all JPEG/PNG blogs images to WebP in storage/app/public/blogs
Target: max 400px wide for main product thumbnails, quality 82
"""
from PIL import Image
import os, pathlib

BASE = r"d:\Project\lktech\storage\app\public\blogs"
MAX_W = 800   # max width untuk product display
QUALITY = 82

total_before = 0
total_after = 0
count = 0

for root, dirs, files in os.walk(BASE):
    for fname in files:
        ext = pathlib.Path(fname).suffix.lower()
        if ext not in ('.jpg', '.jpeg', '.png'):
            continue
        src = os.path.join(root, fname)
        dest = os.path.join(root, pathlib.Path(fname).stem + '.webp')
        if os.path.exists(dest):
            # Sudah ada webp, skip
            continue
        try:
            img = Image.open(src).convert('RGB')
            if img.width > MAX_W:
                ratio = MAX_W / img.width
                img = img.resize((MAX_W, int(img.height * ratio)), Image.LANCZOS)
            before_size = os.path.getsize(src)
            img.save(dest, 'WEBP', quality=QUALITY, method=6)
            after_size = os.path.getsize(dest)
            total_before += before_size
            total_after += after_size
            count += 1
            print(f"OK {fname}: {before_size//1024}KB -> {after_size//1024}KB")
        except Exception as e:
            print(f"SKIP {fname}: {e}")

print(f"\nConverted {count} files")
print(f"Total: {total_before//1024//1024}MB -> {total_after//1024//1024}MB (saved {(total_before-total_after)//1024}KB)")
