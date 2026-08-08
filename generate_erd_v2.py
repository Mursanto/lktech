"""
Generate ERD (Entity Relationship Diagram) untuk Sistem LKTech
ERD menampilkan entitas, atribut, dan relasi antar entitas 
menggunakan notasi crow's foot (tanpa tipe data).

Berbeda dari LRS:
- ERD: Fokus pada RELASI dan KARDINALITAS antar entitas
- ERD: TIDAK menampilkan tipe data
- ERD: Menggunakan notasi crow's foot untuk menunjukkan 1:N, 1:1
"""

import matplotlib
matplotlib.use('Agg')
import matplotlib.pyplot as plt
import matplotlib.patches as patches
from matplotlib.patches import FancyBboxPatch
import numpy as np

fig, ax = plt.subplots(1, 1, figsize=(24, 18))
ax.set_xlim(0, 24)
ax.set_ylim(0, 18)
ax.set_aspect('equal')
ax.axis('off')

# Color palette
COLORS = {
    'customers': '#FFF3E0',    # warm orange light
    'users': '#E3F2FD',        # light blue
    'categories': '#F3E5F5',   # light purple
    'products': '#E8F5E9',     # light green
    'sales': '#FCE4EC',        # light pink
    'sale_details': '#FFF9C4', # light yellow
    'services': '#E0F7FA',     # light cyan
    'service_parts': '#F1F8E9',# light lime
    'rentals': '#FBE9E7',      # light deep orange
    'activity_logs': '#ECEFF1', # light blue grey
}

HEADER_COLORS = {
    'customers': '#E65100',
    'users': '#1565C0',
    'categories': '#6A1B9A',
    'products': '#2E7D32',
    'sales': '#C62828',
    'sale_details': '#F9A825',
    'services': '#00838F',
    'service_parts': '#558B2F',
    'rentals': '#BF360C',
    'activity_logs': '#546E7A',
}

ROW_HEIGHT = 0.32
HEADER_HEIGHT = 0.42
COL_WIDTH = 3.2

def draw_entity(ax, x, y, name, attributes, pk_list, fk_list):
    """Draw an ERD entity box (no data types - just attribute names with PK/FK markers)"""
    n_rows = len(attributes)
    total_height = HEADER_HEIGHT + n_rows * ROW_HEIGHT + 0.1
    
    bg_color = COLORS.get(name, '#F5F5F5')
    hd_color = HEADER_COLORS.get(name, '#424242')
    
    # Shadow
    shadow = FancyBboxPatch((x + 0.06, y - total_height + 0.06), COL_WIDTH, total_height,
                            boxstyle="round,pad=0.05", facecolor='#00000020',
                            edgecolor='none', linewidth=0)
    ax.add_patch(shadow)
    
    # Main box
    main_box = FancyBboxPatch((x, y - total_height), COL_WIDTH, total_height,
                              boxstyle="round,pad=0.05", facecolor=bg_color,
                              edgecolor='#555555', linewidth=1.5)
    ax.add_patch(main_box)
    
    # Header
    header = FancyBboxPatch((x, y - HEADER_HEIGHT), COL_WIDTH, HEADER_HEIGHT,
                            boxstyle="round,pad=0.05", facecolor=hd_color,
                            edgecolor='#555555', linewidth=1.5)
    ax.add_patch(header)
    
    # Header text
    ax.text(x + COL_WIDTH / 2, y - HEADER_HEIGHT / 2, name,
            ha='center', va='center', fontsize=11, fontweight='bold', color='white',
            fontfamily='serif')
    
    # Attributes
    for i, attr in enumerate(attributes):
        row_y = y - HEADER_HEIGHT - (i + 0.5) * ROW_HEIGHT
        
        # PK/FK marker
        marker = ""
        
        # Determine style
        is_pk = attr in pk_list
        is_fk = attr in fk_list
        
        # Attribute name - use special marker for PK
        display_name = attr
        if is_pk:
            display_name = f"\u00BB {attr}  (PK)"  # » symbol
        elif is_fk:
            display_name = f"  {attr}  (FK)"
        else:
            display_name = f"  {attr}"
        
        style = 'italic' if is_fk else 'normal'
        weight = 'bold' if is_pk else 'normal'
        
        # Row separator line
        if i > 0:
            line_y = y - HEADER_HEIGHT - i * ROW_HEIGHT
            ax.plot([x + 0.1, x + COL_WIDTH - 0.1], [line_y, line_y],
                    color='#CCCCCC', linewidth=0.5, linestyle='-')
        
        ax.text(x + 0.2, row_y, display_name,
                ha='left', va='center', fontsize=8.5, fontstyle=style,
                fontweight=weight, color='#333333', fontfamily='serif')
    
    # Return connection points
    center_x = x + COL_WIDTH / 2
    center_y = y - total_height / 2
    return {
        'top': (center_x, y),
        'bottom': (center_x, y - total_height),
        'left': (x, center_y),
        'right': (x + COL_WIDTH, center_y),
        'top_left': (x, y),
        'top_right': (x + COL_WIDTH, y),
        'bottom_left': (x, y - total_height),
        'bottom_right': (x + COL_WIDTH, y - total_height),
        'x': x, 'y': y, 'w': COL_WIDTH, 'h': total_height,
        'cx': center_x, 'cy': center_y,
    }


def draw_crow_foot_many(ax, x, y, direction, color='#333'):
    """Draw crow's foot (many) notation"""
    size = 0.15
    if direction == 'left':
        ax.plot([x, x - size], [y, y + size], color=color, linewidth=1.5)
        ax.plot([x, x - size], [y, y - size], color=color, linewidth=1.5)
        ax.plot([x, x - size], [y, y], color=color, linewidth=1.5)
    elif direction == 'right':
        ax.plot([x, x + size], [y, y + size], color=color, linewidth=1.5)
        ax.plot([x, x + size], [y, y - size], color=color, linewidth=1.5)
        ax.plot([x, x + size], [y, y], color=color, linewidth=1.5)
    elif direction == 'up':
        ax.plot([x, x - size], [y, y + size], color=color, linewidth=1.5)
        ax.plot([x, x + size], [y, y + size], color=color, linewidth=1.5)
        ax.plot([x, x], [y, y + size], color=color, linewidth=1.5)
    elif direction == 'down':
        ax.plot([x, x - size], [y, y - size], color=color, linewidth=1.5)
        ax.plot([x, x + size], [y, y - size], color=color, linewidth=1.5)
        ax.plot([x, x], [y, y - size], color=color, linewidth=1.5)


def draw_one_mark(ax, x, y, direction, color='#333'):
    """Draw one (|) notation"""
    size = 0.12
    if direction == 'left':
        ax.plot([x - 0.08, x - 0.08], [y - size, y + size], color=color, linewidth=1.5)
    elif direction == 'right':
        ax.plot([x + 0.08, x + 0.08], [y - size, y + size], color=color, linewidth=1.5)
    elif direction == 'up':
        ax.plot([x - size, x + size], [y + 0.08, y + 0.08], color=color, linewidth=1.5)
    elif direction == 'down':
        ax.plot([x - size, x + size], [y - 0.08, y - 0.08], color=color, linewidth=1.5)


def draw_relationship_line(ax, start, end, start_card, end_card, color='#555', label='', 
                           route_points=None, start_dir='right', end_dir='left'):
    """Draw relationship line with cardinality markers"""
    if route_points:
        all_points = [start] + route_points + [end]
    else:
        all_points = [start, end]
    
    xs = [p[0] for p in all_points]
    ys = [p[1] for p in all_points]
    
    ax.plot(xs, ys, color=color, linewidth=1.8, solid_capstyle='round', zorder=1)
    
    # Draw cardinality at start
    if start_card == '1':
        draw_one_mark(ax, start[0], start[1], start_dir, color)
    elif start_card == 'N':
        draw_crow_foot_many(ax, start[0], start[1], start_dir, color)
    
    # Draw cardinality at end
    if end_card == '1':
        draw_one_mark(ax, end[0], end[1], end_dir, color)
    elif end_card == 'N':
        draw_crow_foot_many(ax, end[0], end[1], end_dir, color)
    
    # Label on the line
    if label:
        mid_idx = len(all_points) // 2
        if len(all_points) % 2 == 0:
            mx = (all_points[mid_idx-1][0] + all_points[mid_idx][0]) / 2
            my = (all_points[mid_idx-1][1] + all_points[mid_idx][1]) / 2
        else:
            mx, my = all_points[mid_idx]
        
        ax.text(mx, my + 0.18, label, ha='center', va='bottom', fontsize=7,
                color=color, fontweight='bold', fontfamily='serif',
                bbox=dict(boxstyle='round,pad=0.15', facecolor='white', edgecolor='none', alpha=0.85))


# ==================== DEFINE ENTITIES ====================
# Positions: (x, y) where y is the TOP of the entity box

# Row 1 (top)
customers_pos = (1.5, 17)
users_pos = (6.5, 17)
categories_pos = (14, 17)

# Row 2 (middle)
services_pos = (0.5, 12.5)
rentals_pos = (5, 12.5)
sales_pos = (9.5, 12.5)
products_pos = (14, 12.5)

# Row 3 (bottom) 
activity_logs_pos = (0.5, 7)
service_parts_pos = (5.5, 7)
sale_details_pos = (10.5, 7)

# ==================== DRAW ENTITIES ====================

# customers
cust = draw_entity(ax, *customers_pos, 'customers', 
    ['id', 'name', 'phone', 'email', 'address', 'created_at'],
    ['id'], [])

# users
usr = draw_entity(ax, *users_pos, 'users',
    ['id', 'name', 'email', 'password', 'role', 'created_at'],
    ['id'], [])

# categories
cat = draw_entity(ax, *categories_pos, 'categories',
    ['id', 'parent_id', 'name', 'type_category', 'description'],
    ['id'], ['parent_id'])

# services
svc = draw_entity(ax, *services_pos, 'services',
    ['id', 'customer_id', 'technician_id', 'device_name', 'serial_number',
     'service_type', 'complaint', 'status', 'service_fee',
     'estimated_parts_cost', 'total_amount', 'created_at'],
    ['id'], ['customer_id', 'technician_id'])

# rentals
rnt = draw_entity(ax, *rentals_pos, 'rentals',
    ['id', 'customer_id', 'customer_name', 'customer_phone',
     'laptop_name', 'serial_number', 'rental_date', 'return_date',
     'daily_price', 'total_price', 'status', 'created_at'],
    ['id'], ['customer_id'])

# sales
sal = draw_entity(ax, *sales_pos, 'sales',
    ['id', 'user_id', 'customer_id', 'payment_method', 'total_amount',
     'profit_amount', 'operational_cost', 'transaction_date',
     'payment_status', 'created_at'],
    ['id'], ['user_id', 'customer_id'])

# products
prd = draw_entity(ax, *products_pos, 'products',
    ['id', 'category_id', 'brand', 'model_series', 'serial_number',
     'processor', 'ram', 'storage', 'screen_size', 'condition',
     'purchase_price', 'selling_price', 'status', 'stock',
     'image_path', 'created_at'],
    ['id'], ['category_id'])

# activity_logs
alog = draw_entity(ax, *activity_logs_pos, 'activity_logs',
    ['id', 'user_id', 'action', 'model_type', 'model_id',
     'old_values', 'new_values', 'ip_address', 'created_at'],
    ['id'], ['user_id'])

# service_parts
sp = draw_entity(ax, *service_parts_pos, 'service_parts',
    ['id', 'service_id', 'product_id', 'quantity', 'price', 'created_at'],
    ['id'], ['service_id', 'product_id'])

# sale_details
sd = draw_entity(ax, *sale_details_pos, 'sale_details',
    ['id', 'sale_id', 'product_id', 'manual_sn', 'quantity',
     'price_at_transaction', 'purchase_price', 'profit', 'created_at'],
    ['id'], ['sale_id', 'product_id'])


# ==================== DRAW RELATIONSHIPS ====================

# 1. customers (1) --< services (N)
draw_relationship_line(ax,
    (cust['x'], cust['cy'] - 0.5),
    (svc['x'] + svc['w'], svc['cy'] + 1.2),
    '1', 'N', color='#E65100', label='has',
    start_dir='right', end_dir='left')

# 2. customers (1) --< rentals (N)
draw_relationship_line(ax,
    (cust['x'] + cust['w'] / 2 - 0.3, cust['y'] - cust['h']),
    (rnt['x'] + rnt['w'] / 2 - 0.3, rnt['y']),
    '1', 'N', color='#E65100', label='has',
    start_dir='down', end_dir='up')

# 3. customers (1) --< sales (N)
draw_relationship_line(ax,
    (cust['x'] + cust['w'], cust['cy'] - 0.3),
    (sal['x'] + sal['w'] / 2 + 0.3, sal['y']),
    '1', 'N', color='#E65100', label='has',
    route_points=[(cust['x'] + cust['w'] + 0.3, cust['cy'] - 0.3),
                  (cust['x'] + cust['w'] + 0.3, sal['y'] + 0.5),
                  (sal['x'] + sal['w'] / 2 + 0.3, sal['y'] + 0.5)],
    start_dir='right', end_dir='up')

# 4. users (1) --< sales (N) [user_id]
draw_relationship_line(ax,
    (usr['x'] + usr['w'] / 2 - 0.3, usr['y'] - usr['h']),
    (sal['x'] + sal['w'] / 2 - 0.3, sal['y']),
    '1', 'N', color='#1565C0', label='creates',
    start_dir='down', end_dir='up')

# 5. users (1) --< services (N) [technician_id]
draw_relationship_line(ax,
    (usr['x'], usr['cy']),
    (svc['x'] + svc['w'] / 2 + 0.3, svc['y']),
    '1', 'N', color='#1565C0', label='assigned',
    route_points=[(usr['x'] - 0.5, usr['cy']),
                  (usr['x'] - 0.5, svc['y'] + 0.5),
                  (svc['x'] + svc['w'] / 2 + 0.3, svc['y'] + 0.5)],
    start_dir='left', end_dir='up')

# 6. users (1) --< activity_logs (N)
draw_relationship_line(ax,
    (usr['x'], usr['cy'] - 0.8),
    (alog['x'] + alog['w'], alog['cy'] + 0.5),
    '1', 'N', color='#1565C0', label='generates',
    route_points=[(usr['x'] - 1.0, usr['cy'] - 0.8),
                  (usr['x'] - 1.0, alog['cy'] + 0.5)],
    start_dir='left', end_dir='left')

# 7. categories (1) --< products (N)
draw_relationship_line(ax,
    (cat['x'] + cat['w'] / 2, cat['y'] - cat['h']),
    (prd['x'] + prd['w'] / 2, prd['y']),
    '1', 'N', color='#6A1B9A', label='contains',
    start_dir='down', end_dir='up')

# 8. categories self-reference (parent_id)
cat_self_x = cat['x'] + cat['w'] + 0.15
cat_self_top = cat['y'] - 0.2
cat_self_bot = cat['y'] - 0.8
ax.annotate('', xy=(cat['x'] + cat['w'], cat_self_top), 
            xytext=(cat['x'] + cat['w'], cat_self_bot),
            arrowprops=dict(arrowstyle='->', color='#6A1B9A', lw=1.5,
                          connectionstyle='arc3,rad=-0.5'))
ax.text(cat['x'] + cat['w'] + 0.55, (cat_self_top + cat_self_bot) / 2, 'parent',
        ha='left', va='center', fontsize=7, color='#6A1B9A', fontweight='bold', fontfamily='serif')

# 9. sales (1) --< sale_details (N)
draw_relationship_line(ax,
    (sal['x'] + sal['w'] / 2, sal['y'] - sal['h']),
    (sd['x'] + sd['w'] / 2 - 0.3, sd['y']),
    '1', 'N', color='#C62828', label='contains',
    start_dir='down', end_dir='up')

# 10. products (1) --< sale_details (N) 
draw_relationship_line(ax,
    (prd['x'], prd['cy'] + 0.5),
    (sd['x'] + sd['w'], sd['cy'] + 0.5),
    '1', 'N', color='#2E7D32', label='sold in',
    route_points=[(prd['x'] - 0.4, prd['cy'] + 0.5),
                  (prd['x'] - 0.4, sd['cy'] + 0.5)],
    start_dir='left', end_dir='right')

# 11. services (1) --< service_parts (N)
draw_relationship_line(ax,
    (svc['x'] + svc['w'] / 2 + 0.3, svc['y'] - svc['h']),
    (sp['x'] + sp['w'] / 2 - 0.3, sp['y']),
    '1', 'N', color='#00838F', label='uses',
    start_dir='down', end_dir='up')

# 12. products (1) --< service_parts (N) 
draw_relationship_line(ax,
    (prd['x'], prd['cy'] - 1.0),
    (sp['x'] + sp['w'], sp['cy']),
    '1', 'N', color='#2E7D32', label='used in',
    route_points=[(prd['x'] - 0.8, prd['cy'] - 1.0),
                  (prd['x'] - 0.8, sp['cy'])],
    start_dir='left', end_dir='right')


# ==================== LEGEND ====================
legend_x = 18.5
legend_y = 7.5

legend_box = FancyBboxPatch((legend_x, legend_y - 3.5), 4.5, 3.5,
                            boxstyle="round,pad=0.1", facecolor='#FAFAFA',
                            edgecolor='#AAAAAA', linewidth=1)
ax.add_patch(legend_box)

ax.text(legend_x + 2.25, legend_y - 0.25, 'Keterangan', ha='center', va='center',
        fontsize=10, fontweight='bold', fontfamily='serif', color='#333')

# PK
ax.text(legend_x + 0.3, legend_y - 0.8, 'id  (PK)', ha='left', va='center',
        fontsize=8.5, fontweight='bold', fontfamily='serif', color='#333')
ax.text(legend_x + 2.2, legend_y - 0.8, '= Primary Key', ha='left', va='center',
        fontsize=8.5, fontfamily='serif', color='#555')

# FK
ax.text(legend_x + 0.3, legend_y - 1.3, 'user_id  (FK)', ha='left', va='center',
        fontsize=8.5, fontstyle='italic', fontfamily='serif', color='#333')
ax.text(legend_x + 2.2, legend_y - 1.3, '= Foreign Key', ha='left', va='center',
        fontsize=8.5, fontfamily='serif', color='#555')

# 1 marker
draw_one_mark(ax, legend_x + 0.6, legend_y - 1.8, 'right', '#333')
ax.plot([legend_x + 0.3, legend_x + 1.5], [legend_y - 1.8, legend_y - 1.8], color='#333', linewidth=1.5)
ax.text(legend_x + 2.2, legend_y - 1.8, '= One (1)', ha='left', va='center',
        fontsize=8.5, fontfamily='serif', color='#555')

# N marker (crow's foot)
ax.plot([legend_x + 0.3, legend_x + 1.5], [legend_y - 2.3, legend_y - 2.3], color='#333', linewidth=1.5)
draw_crow_foot_many(ax, legend_x + 1.5, legend_y - 2.3, 'right', '#333')
ax.text(legend_x + 2.2, legend_y - 2.3, '= Many (N)', ha='left', va='center',
        fontsize=8.5, fontfamily='serif', color='#555')

# Self ref
ax.annotate('', xy=(legend_x + 1.3, legend_y - 2.65), 
            xytext=(legend_x + 1.3, legend_y - 3.05),
            arrowprops=dict(arrowstyle='->', color='#333', lw=1.5,
                          connectionstyle='arc3,rad=-0.5'))
ax.text(legend_x + 2.2, legend_y - 2.85, '= Self-reference', ha='left', va='center',
        fontsize=8.5, fontfamily='serif', color='#555')


# ==================== TITLE ====================
ax.text(12, 0.8, 'Gambar III.8.', ha='center', va='center',
        fontsize=13, fontfamily='serif', fontstyle='italic', color='#333')
ax.text(12, 0.35, 'Entity Relationship Diagram (ERD) Sistem LKTech', ha='center', va='center',
        fontsize=13, fontfamily='serif', fontstyle='italic', color='#333')

ax.text(1.5, 0.35, '(Sumber: Olahan Peneliti, 2026)', ha='left', va='center',
        fontsize=10, fontfamily='serif', color='#555')

plt.tight_layout(pad=0.5)
plt.savefig('d:/Project/lktech/ERD_LKTech_v2.png', dpi=200, bbox_inches='tight',
            facecolor='white', edgecolor='none')
print("ERD saved to d:/Project/lktech/ERD_LKTech_v2.png")
plt.close()
