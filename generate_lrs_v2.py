"""
Generate LRS (Logical Record Structure) untuk Sistem LKTech
LRS menampilkan struktur record secara logis DENGAN TIPE DATA,
menunjukkan bagaimana record-record saling terhubung melalui foreign key.

Perbedaan utama dengan ERD:
- LRS: Menampilkan TIPE DATA setiap atribut (VARCHAR, BIGINT, DECIMAL, dll)
- LRS: Fokus pada STRUKTUR RECORD dan koneksi FK (bukan kardinalitas)
- LRS: Layout horizontal/tabular yang menunjukkan field-field record
- LRS: Garis penghubung hanya menunjukkan FK connections (tanpa crow's foot)
"""

import matplotlib
matplotlib.use('Agg')
import matplotlib.pyplot as plt
import matplotlib.patches as patches
from matplotlib.patches import FancyBboxPatch
import numpy as np

fig, ax = plt.subplots(1, 1, figsize=(26, 20))
ax.set_xlim(0, 26)
ax.set_ylim(0, 20)
ax.set_aspect('equal')
ax.axis('off')

# Color palette (deliberately different from ERD)
COLORS = {
    'customers': '#FFF8E1',
    'users': '#E8EAF6',
    'categories': '#F3E5F5',
    'products': '#E8F5E9',
    'sales': '#FCE4EC',
    'sale_details': '#FFFDE7',
    'services': '#E0F2F1',
    'service_parts': '#F1F8E9',
    'rentals': '#FBE9E7',
    'activity_logs': '#ECEFF1',
}

HEADER_COLORS = {
    'customers': '#FF8F00',
    'users': '#283593',
    'categories': '#7B1FA2',
    'products': '#388E3C',
    'sales': '#D32F2F',
    'sale_details': '#FBC02D',
    'services': '#00796B',
    'service_parts': '#689F38',
    'rentals': '#D84315',
    'activity_logs': '#455A64',
}

ROW_HEIGHT = 0.30
HEADER_HEIGHT = 0.40
ATTR_COL = 2.2
TYPE_COL = 1.6
KEY_COL = 0.5
TOTAL_W = ATTR_COL + TYPE_COL + KEY_COL

def draw_lrs_entity(ax, x, y, name, columns):
    """
    Draw an LRS entity box WITH data types.
    columns: list of tuples (attr_name, data_type, key_type)
    key_type: 'PK', 'FK', or ''
    """
    n_rows = len(columns)
    total_height = HEADER_HEIGHT + n_rows * ROW_HEIGHT + 0.08
    
    bg_color = COLORS.get(name, '#F5F5F5')
    hd_color = HEADER_COLORS.get(name, '#424242')
    
    # Shadow
    shadow = FancyBboxPatch((x + 0.05, y - total_height + 0.05), TOTAL_W, total_height,
                            boxstyle="round,pad=0.04", facecolor='#00000018',
                            edgecolor='none', linewidth=0)
    ax.add_patch(shadow)
    
    # Main box
    main_box = FancyBboxPatch((x, y - total_height), TOTAL_W, total_height,
                              boxstyle="round,pad=0.04", facecolor=bg_color,
                              edgecolor='#666666', linewidth=1.5)
    ax.add_patch(main_box)
    
    # Header
    header = FancyBboxPatch((x, y - HEADER_HEIGHT), TOTAL_W, HEADER_HEIGHT,
                            boxstyle="round,pad=0.04", facecolor=hd_color,
                            edgecolor='#666666', linewidth=1.5)
    ax.add_patch(header)
    
    # Header text
    ax.text(x + TOTAL_W / 2, y - HEADER_HEIGHT / 2, name,
            ha='center', va='center', fontsize=10.5, fontweight='bold', color='white',
            fontfamily='monospace')
    
    # Column headers (sub-header)
    sub_y = y - HEADER_HEIGHT
    ax.plot([x + 0.05, x + TOTAL_W - 0.05], [sub_y, sub_y],
            color='#888', linewidth=0.8)
    
    # Draw column separators (vertical lines)
    col1_x = x + ATTR_COL
    col2_x = x + ATTR_COL + TYPE_COL
    
    for i, (attr, dtype, key) in enumerate(columns):
        row_y = sub_y - (i + 0.5) * ROW_HEIGHT
        
        # Row separator
        if i > 0:
            line_y = sub_y - i * ROW_HEIGHT
            ax.plot([x + 0.05, x + TOTAL_W - 0.05], [line_y, line_y],
                    color='#DDDDDD', linewidth=0.5)
        
        # Vertical separator lines
        ax.plot([col1_x, col1_x], [sub_y - i * ROW_HEIGHT, sub_y - (i + 1) * ROW_HEIGHT],
                color='#CCCCCC', linewidth=0.5)
        ax.plot([col2_x, col2_x], [sub_y - i * ROW_HEIGHT, sub_y - (i + 1) * ROW_HEIGHT],
                color='#CCCCCC', linewidth=0.5)
        
        # Attribute name
        is_fk = key == 'FK'
        is_pk = key == 'PK'
        style = 'italic' if is_fk else 'normal'
        weight = 'bold' if is_pk else 'normal'
        
        # Key icon
        if is_pk:
            attr_display = f">> {attr}"
        else:
            attr_display = f"   {attr}"
        
        ax.text(x + 0.12, row_y, attr_display,
                ha='left', va='center', fontsize=7.5, fontstyle=style,
                fontweight=weight, color='#333', fontfamily='monospace')
        
        # Data type
        ax.text(col1_x + 0.1, row_y, dtype,
                ha='left', va='center', fontsize=7.5, color='#0D47A1',
                fontfamily='monospace')
        
        # Key marker
        if key:
            key_color = '#C62828' if key == 'PK' else '#1565C0'
            ax.text(col2_x + KEY_COL / 2, row_y, key,
                    ha='center', va='center', fontsize=7, fontweight='bold',
                    color=key_color, fontfamily='monospace')
    
    # Return connection points
    center_x = x + TOTAL_W / 2
    center_y = y - total_height / 2
    return {
        'top': (center_x, y),
        'bottom': (center_x, y - total_height),
        'left': (x, center_y),
        'right': (x + TOTAL_W, center_y),
        'x': x, 'y': y, 'w': TOTAL_W, 'h': total_height,
        'cx': center_x, 'cy': center_y,
    }


def draw_fk_line(ax, start, end, color='#666', route_points=None):
    """Draw FK connection line (simple arrow, no crow's foot - that's for ERD)"""
    if route_points:
        all_points = [start] + route_points + [end]
    else:
        all_points = [start, end]
    
    xs = [p[0] for p in all_points]
    ys = [p[1] for p in all_points]
    
    # Draw line segments
    for i in range(len(all_points) - 1):
        if i == len(all_points) - 2:
            # Last segment - draw arrow
            ax.annotate('', xy=all_points[i+1], xytext=all_points[i],
                       arrowprops=dict(arrowstyle='->', color=color, lw=1.5))
        else:
            ax.plot([all_points[i][0], all_points[i+1][0]], 
                   [all_points[i][1], all_points[i+1][1]], 
                   color=color, linewidth=1.5)
    
    # Small circle at start
    ax.plot(start[0], start[1], 'o', color=color, markersize=4, zorder=5)


# ==================== DEFINE LRS ENTITIES ====================
# Positions: (x, y_top)

# Row 1 (top)
customers_pos = (1.5, 19)
users_pos = (7, 19)
categories_pos = (15, 19)

# Row 2 (middle)
services_pos = (0.2, 13.5)
rentals_pos = (5.2, 13.5)
sales_pos = (10.2, 13.5)
products_pos = (15, 13.5)

# Row 3 (bottom)
activity_logs_pos = (0.2, 7)
service_parts_pos = (6, 7)
sale_details_pos = (11, 7)


# ==================== DRAW LRS ENTITIES ====================

cust = draw_lrs_entity(ax, *customers_pos, 'customers', [
    ('id', 'BIGINT UNSIGNED', 'PK'),
    ('name', 'VARCHAR(255)', ''),
    ('phone', 'VARCHAR(255)', ''),
    ('email', 'VARCHAR(255)', ''),
    ('address', 'TEXT', ''),
    ('created_at', 'TIMESTAMP', ''),
    ('updated_at', 'TIMESTAMP', ''),
])

usr = draw_lrs_entity(ax, *users_pos, 'users', [
    ('id', 'BIGINT UNSIGNED', 'PK'),
    ('name', 'VARCHAR(255)', ''),
    ('email', 'VARCHAR(255)', ''),
    ('password', 'VARCHAR(255)', ''),
    ('role', 'VARCHAR(255)', ''),
    ('google2fa_secret', 'VARCHAR(255)', ''),
    ('otp_code', 'VARCHAR(255)', ''),
    ('otp_enabled', 'BOOLEAN', ''),
    ('created_at', 'TIMESTAMP', ''),
])

cat = draw_lrs_entity(ax, *categories_pos, 'categories', [
    ('id', 'BIGINT UNSIGNED', 'PK'),
    ('parent_id', 'BIGINT UNSIGNED', 'FK'),
    ('name', 'VARCHAR(255)', ''),
    ('type_category', 'ENUM', ''),
    ('description', 'TEXT', ''),
    ('created_at', 'TIMESTAMP', ''),
])

svc = draw_lrs_entity(ax, *services_pos, 'services', [
    ('id', 'BIGINT UNSIGNED', 'PK'),
    ('customer_id', 'BIGINT UNSIGNED', 'FK'),
    ('technician_id', 'BIGINT UNSIGNED', 'FK'),
    ('device_name', 'VARCHAR(255)', ''),
    ('serial_number', 'VARCHAR(255)', ''),
    ('service_type', 'VARCHAR(255)', ''),
    ('complaint', 'TEXT', ''),
    ('status', 'ENUM', ''),
    ('service_fee', 'DECIMAL(15,2)', ''),
    ('estimated_parts_cost', 'DECIMAL(15,2)', ''),
    ('total_amount', 'DECIMAL(15,2)', ''),
    ('payment_status', 'VARCHAR(255)', ''),
    ('payment_method', 'VARCHAR(255)', ''),
    ('created_at', 'TIMESTAMP', ''),
])

rnt = draw_lrs_entity(ax, *rentals_pos, 'rentals', [
    ('id', 'BIGINT UNSIGNED', 'PK'),
    ('customer_id', 'BIGINT UNSIGNED', 'FK'),
    ('customer_name', 'VARCHAR(255)', ''),
    ('customer_phone', 'VARCHAR(255)', ''),
    ('laptop_name', 'VARCHAR(255)', ''),
    ('serial_number', 'VARCHAR(255)', ''),
    ('rental_date', 'DATE', ''),
    ('return_date', 'DATE', ''),
    ('daily_price', 'DECIMAL(15,2)', ''),
    ('total_price', 'DECIMAL(15,2)', ''),
    ('status', 'VARCHAR(255)', ''),
    ('payment_status', 'VARCHAR(255)', ''),
    ('created_at', 'TIMESTAMP', ''),
])

sal = draw_lrs_entity(ax, *sales_pos, 'sales', [
    ('id', 'BIGINT UNSIGNED', 'PK'),
    ('user_id', 'BIGINT UNSIGNED', 'FK'),
    ('customer_id', 'BIGINT UNSIGNED', 'FK'),
    ('payment_method', 'VARCHAR(255)', ''),
    ('total_amount', 'DECIMAL(10,2)', ''),
    ('profit_amount', 'DECIMAL(10,2)', ''),
    ('operational_cost', 'DECIMAL(15,2)', ''),
    ('transaction_date', 'DATE', ''),
    ('payment_status', 'VARCHAR(255)', ''),
    ('notes', 'TEXT', ''),
    ('created_at', 'TIMESTAMP', ''),
])

prd = draw_lrs_entity(ax, *products_pos, 'products', [
    ('id', 'BIGINT UNSIGNED', 'PK'),
    ('category_id', 'BIGINT UNSIGNED', 'FK'),
    ('brand', 'VARCHAR(255)', ''),
    ('model_series', 'VARCHAR(255)', ''),
    ('serial_number', 'VARCHAR(255)', ''),
    ('processor', 'VARCHAR(255)', ''),
    ('ram', 'VARCHAR(255)', ''),
    ('storage', 'VARCHAR(255)', ''),
    ('screen_size', 'DECIMAL(8,2)', ''),
    ('purchase_price', 'DECIMAL(10,2)', ''),
    ('selling_price', 'DECIMAL(10,2)', ''),
    ('status', 'ENUM', ''),
    ('stock', 'INTEGER', ''),
    ('tipe_stok', 'VARCHAR(20)', ''),
    ('image_path', 'VARCHAR(255)', ''),
    ('created_at', 'TIMESTAMP', ''),
])

alog = draw_lrs_entity(ax, *activity_logs_pos, 'activity_logs', [
    ('id', 'BIGINT UNSIGNED', 'PK'),
    ('user_id', 'BIGINT UNSIGNED', 'FK'),
    ('action', 'VARCHAR(255)', ''),
    ('model_type', 'VARCHAR(255)', ''),
    ('model_id', 'BIGINT UNSIGNED', ''),
    ('old_values', 'JSON', ''),
    ('new_values', 'JSON', ''),
    ('ip_address', 'VARCHAR(255)', ''),
    ('user_agent', 'VARCHAR(255)', ''),
    ('created_at', 'TIMESTAMP', ''),
])

sp = draw_lrs_entity(ax, *service_parts_pos, 'service_parts', [
    ('id', 'BIGINT UNSIGNED', 'PK'),
    ('service_id', 'BIGINT UNSIGNED', 'FK'),
    ('product_id', 'BIGINT UNSIGNED', 'FK'),
    ('quantity', 'INTEGER', ''),
    ('price', 'DECIMAL(15,2)', ''),
    ('created_at', 'TIMESTAMP', ''),
])

sd = draw_lrs_entity(ax, *sale_details_pos, 'sale_details', [
    ('id', 'BIGINT UNSIGNED', 'PK'),
    ('sale_id', 'BIGINT UNSIGNED', 'FK'),
    ('product_id', 'BIGINT UNSIGNED', 'FK'),
    ('manual_sn', 'VARCHAR(255)', ''),
    ('quantity', 'INTEGER', ''),
    ('price_at_transaction', 'DECIMAL(10,2)', ''),
    ('purchase_price', 'DECIMAL(15,2)', ''),
    ('profit', 'DECIMAL(15,2)', ''),
    ('created_at', 'TIMESTAMP', ''),
])


# ==================== DRAW FK CONNECTIONS (arrows only, no crow's foot) ====================

# 1. customers.id -> services.customer_id
draw_fk_line(ax,
    (cust['x'], cust['cy'] - 0.5),
    (svc['x'] + svc['w'], svc['cy'] + 1.5),
    color='#FF8F00')

# 2. customers.id -> rentals.customer_id
draw_fk_line(ax,
    (cust['cx'] - 0.3, cust['y'] - cust['h']),
    (rnt['cx'] - 0.3, rnt['y']),
    color='#FF8F00')

# 3. customers.id -> sales.customer_id
draw_fk_line(ax,
    (cust['x'] + cust['w'], cust['cy'] - 0.3),
    (sal['cx'] + 0.3, sal['y']),
    color='#FF8F00',
    route_points=[(cust['x'] + cust['w'] + 0.3, cust['cy'] - 0.3),
                  (cust['x'] + cust['w'] + 0.3, sal['y'] + 0.5),
                  (sal['cx'] + 0.3, sal['y'] + 0.5)])

# 4. users.id -> sales.user_id
draw_fk_line(ax,
    (usr['cx'] - 0.3, usr['y'] - usr['h']),
    (sal['cx'] - 0.3, sal['y']),
    color='#283593')

# 5. users.id -> services.technician_id
draw_fk_line(ax,
    (usr['x'], usr['cy']),
    (svc['cx'] + 0.3, svc['y']),
    color='#283593',
    route_points=[(usr['x'] - 0.5, usr['cy']),
                  (usr['x'] - 0.5, svc['y'] + 0.5),
                  (svc['cx'] + 0.3, svc['y'] + 0.5)])

# 6. users.id -> activity_logs.user_id
draw_fk_line(ax,
    (usr['x'], usr['cy'] - 0.8),
    (alog['x'] + alog['w'], alog['cy'] + 0.5),
    color='#283593',
    route_points=[(usr['x'] - 1.0, usr['cy'] - 0.8),
                  (usr['x'] - 1.0, alog['cy'] + 0.5)])

# 7. categories.id -> products.category_id
draw_fk_line(ax,
    (cat['cx'], cat['y'] - cat['h']),
    (prd['cx'], prd['y']),
    color='#7B1FA2')

# 8. categories self-reference (parent_id)
cat_self_x = cat['x'] + cat['w'] + 0.15
cat_self_top = cat['y'] - 0.2
cat_self_bot = cat['y'] - 0.8
ax.annotate('', xy=(cat['x'] + cat['w'], cat_self_top), 
            xytext=(cat['x'] + cat['w'], cat_self_bot),
            arrowprops=dict(arrowstyle='->', color='#7B1FA2', lw=1.5,
                          connectionstyle='arc3,rad=-0.5'))
ax.text(cat['x'] + cat['w'] + 0.5, (cat_self_top + cat_self_bot) / 2, 'parent_id',
        ha='left', va='center', fontsize=7, color='#7B1FA2', fontweight='bold', fontfamily='monospace')

# 9. sales.id -> sale_details.sale_id
draw_fk_line(ax,
    (sal['cx'], sal['y'] - sal['h']),
    (sd['cx'] - 0.3, sd['y']),
    color='#D32F2F')

# 10. products.id -> sale_details.product_id
draw_fk_line(ax,
    (prd['x'], prd['cy'] + 0.5),
    (sd['x'] + sd['w'], sd['cy'] + 0.5),
    color='#388E3C',
    route_points=[(prd['x'] - 0.4, prd['cy'] + 0.5),
                  (prd['x'] - 0.4, sd['cy'] + 0.5)])

# 11. services.id -> service_parts.service_id
draw_fk_line(ax,
    (svc['cx'] + 0.3, svc['y'] - svc['h']),
    (sp['cx'] - 0.3, sp['y']),
    color='#00796B')

# 12. products.id -> service_parts.product_id
draw_fk_line(ax,
    (prd['x'], prd['cy'] - 1.0),
    (sp['x'] + sp['w'], sp['cy']),
    color='#388E3C',
    route_points=[(prd['x'] - 0.8, prd['cy'] - 1.0),
                  (prd['x'] - 0.8, sp['cy'])])


# ==================== LEGEND ====================
legend_x = 19.5
legend_y = 7.5

legend_box = FancyBboxPatch((legend_x, legend_y - 3.2), 5.5, 3.2,
                            boxstyle="round,pad=0.1", facecolor='#FAFAFA',
                            edgecolor='#AAAAAA', linewidth=1)
ax.add_patch(legend_box)

ax.text(legend_x + 2.75, legend_y - 0.25, 'Keterangan', ha='center', va='center',
        fontsize=10, fontweight='bold', fontfamily='monospace', color='#333')

# PK
ax.text(legend_x + 0.3, legend_y - 0.75, '>> id    BIGINT   PK', ha='left', va='center',
        fontsize=8, fontweight='bold', fontfamily='monospace', color='#333')
ax.text(legend_x + 3.5, legend_y - 0.75, '= Primary Key', ha='left', va='center',
        fontsize=8, fontfamily='monospace', color='#555')

# FK
ax.text(legend_x + 0.3, legend_y - 1.2, '   user_id BIGINT   FK', ha='left', va='center',
        fontsize=8, fontstyle='italic', fontfamily='monospace', color='#333')
ax.text(legend_x + 3.5, legend_y - 1.2, '= Foreign Key', ha='left', va='center',
        fontsize=8, fontfamily='monospace', color='#555')

# Arrow
ax.annotate('', xy=(legend_x + 1.5, legend_y - 1.65), xytext=(legend_x + 0.3, legend_y - 1.65),
           arrowprops=dict(arrowstyle='->', color='#666', lw=1.5))
ax.plot(legend_x + 0.3, legend_y - 1.65, 'o', color='#666', markersize=4)
ax.text(legend_x + 2.0, legend_y - 1.65, '= FK Reference', ha='left', va='center',
        fontsize=8, fontfamily='monospace', color='#555')

# Data type
ax.text(legend_x + 0.3, legend_y - 2.1, 'VARCHAR, BIGINT,', ha='left', va='center',
        fontsize=8, fontfamily='monospace', color='#0D47A1')
ax.text(legend_x + 0.3, legend_y - 2.5, 'DECIMAL, ENUM...', ha='left', va='center',
        fontsize=8, fontfamily='monospace', color='#0D47A1')
ax.text(legend_x + 2.8, legend_y - 2.3, '= Data Types', ha='left', va='center',
        fontsize=8, fontfamily='monospace', color='#555')


# ==================== TITLE ====================
ax.text(13, 0.8, 'Gambar III.9.', ha='center', va='center',
        fontsize=13, fontfamily='serif', fontstyle='italic', color='#333')
ax.text(13, 0.35, 'Logical Record Structure (LRS) Sistem LKTech', ha='center', va='center',
        fontsize=13, fontfamily='serif', fontstyle='italic', color='#333')

ax.text(1.5, 0.35, '(Sumber: Olahan Peneliti, 2026)', ha='left', va='center',
        fontsize=10, fontfamily='serif', color='#555')

plt.tight_layout(pad=0.5)
plt.savefig('d:/Project/lktech/LRS_LKTech_v2.png', dpi=200, bbox_inches='tight',
            facecolor='white', edgecolor='none')
print("LRS saved to d:/Project/lktech/LRS_LKTech_v2.png")
plt.close()
