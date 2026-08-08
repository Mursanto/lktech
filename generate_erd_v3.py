import matplotlib
matplotlib.use('Agg')
import matplotlib.pyplot as plt
import matplotlib.patches as mpatches
from matplotlib.patches import FancyBboxPatch, FancyArrowPatch
import numpy as np

# ============================================================
# ERD - Entity Relationship Diagram (KONSEPTUAL)
# Gaya: Entitas = kotak rounded, Atribut = oval/elips
#        Relasi = diamond, Garis = crow's foot
# TANPA tipe data, TANPA grid tabel
# ============================================================

fig, ax = plt.subplots(1, 1, figsize=(28, 22))
fig.patch.set_facecolor('#FAFCFF')
ax.set_xlim(-1, 29)
ax.set_ylim(-2, 23)
ax.set_aspect('equal')
ax.axis('off')

# ---- COLOR SCHEME (Blues/Teals - konseptual) ----
ENTITY_COLOR = '#D6EAF8'
ENTITY_BORDER = '#2980B9'
ENTITY_TITLE_BG = '#2980B9'
ENTITY_TITLE_FG = 'white'
ATTR_COLOR = '#333333'
PK_COLOR = '#E74C3C'
FK_COLOR = '#8E44AD'
RELATION_COLOR = '#E67E22'
RELATION_BG = '#FDF2E9'
LINE_COLOR = '#555555'


def draw_entity(ax, x, y, name, attributes, pk_list, fk_list, width=4.5, row_h=0.42):
    """Draw entity as a simple rounded box with attribute list (NO types, NO grid)"""
    total_h = 0.6 + len(attributes) * row_h + 0.3

    # Entity box (rounded)
    box = FancyBboxPatch((x, y - total_h), width, total_h,
                         boxstyle="round,pad=0.08",
                         facecolor=ENTITY_COLOR, edgecolor=ENTITY_BORDER,
                         linewidth=2.5, zorder=3)
    ax.add_patch(box)

    # Title bar
    title_box = FancyBboxPatch((x, y - 0.6), width, 0.6,
                                boxstyle="round,pad=0.05",
                                facecolor=ENTITY_TITLE_BG, edgecolor=ENTITY_BORDER,
                                linewidth=2.5, zorder=4)
    ax.add_patch(title_box)

    # Clip bottom corners of title
    clip_rect = plt.Rectangle((x, y - 0.6), width, 0.6, transform=ax.transData)
    title_box.set_clip_path(clip_rect)

    # Entity name
    ax.text(x + width / 2, y - 0.3, name.upper(),
            ha='center', va='center', fontsize=12, fontweight='bold',
            color=ENTITY_TITLE_FG, fontfamily='sans-serif', zorder=5)

    # Divider line
    ax.plot([x + 0.1, x + width - 0.1], [y - 0.6, y - 0.6],
            color=ENTITY_BORDER, linewidth=1.5, zorder=5)

    # Attributes (simple list - NO type, NO grid)
    for i, attr in enumerate(attributes):
        ay = y - 0.6 - 0.2 - i * row_h
        is_pk = attr in pk_list
        is_fk = attr in fk_list

        # Bullet/marker
        if is_pk:
            ax.text(x + 0.2, ay, '\u25C6', ha='left', va='center',
                    fontsize=8, color=PK_COLOR, zorder=5)  # ◆
            label_color = PK_COLOR
            weight = 'bold'
            suffix = '  (PK)'
        elif is_fk:
            ax.text(x + 0.2, ay, '\u25CB', ha='left', va='center',
                    fontsize=8, color=FK_COLOR, zorder=5)  # ○
            label_color = FK_COLOR
            weight = 'normal'
            suffix = '  (FK)'
        else:
            ax.text(x + 0.2, ay, '\u2022', ha='left', va='center',
                    fontsize=8, color='#888', zorder=5)  # •
            label_color = ATTR_COLOR
            weight = 'normal'
            suffix = ''

        ax.text(x + 0.5, ay, f'{attr}{suffix}',
                ha='left', va='center', fontsize=9, fontweight=weight,
                color=label_color, fontfamily='sans-serif', zorder=5)

    # Return connection points
    cx = x + width / 2
    return {
        'top': (cx, y),
        'bottom': (cx, y - total_h),
        'left': (x, y - total_h / 2),
        'right': (x + width, y - total_h / 2),
        'left_top': (x, y - 0.8),
        'right_top': (x + width, y - 0.8),
        'left_mid': (x, y - total_h * 0.5),
        'right_mid': (x + width, y - total_h * 0.5),
        'bottom_left': (x + width * 0.3, y - total_h),
        'bottom_right': (x + width * 0.7, y - total_h),
        'top_left': (x + width * 0.3, y),
        'top_right': (x + width * 0.7, y),
    }


def draw_crow_foot(ax, x, y, direction, side='many'):
    """Draw crow's foot notation"""
    size = 0.2
    if side == 'many':
        # Three-pronged fork (many)
        if direction == 'left':
            ax.plot([x, x - size], [y, y + size * 0.7], color=LINE_COLOR, linewidth=1.8, zorder=4)
            ax.plot([x, x - size], [y, y - size * 0.7], color=LINE_COLOR, linewidth=1.8, zorder=4)
            ax.plot([x, x - size], [y, y], color=LINE_COLOR, linewidth=1.8, zorder=4)
        elif direction == 'right':
            ax.plot([x, x + size], [y, y + size * 0.7], color=LINE_COLOR, linewidth=1.8, zorder=4)
            ax.plot([x, x + size], [y, y - size * 0.7], color=LINE_COLOR, linewidth=1.8, zorder=4)
            ax.plot([x, x + size], [y, y], color=LINE_COLOR, linewidth=1.8, zorder=4)
        elif direction == 'up':
            ax.plot([x, x + size * 0.7], [y, y + size], color=LINE_COLOR, linewidth=1.8, zorder=4)
            ax.plot([x, x - size * 0.7], [y, y + size], color=LINE_COLOR, linewidth=1.8, zorder=4)
            ax.plot([x, x], [y, y + size], color=LINE_COLOR, linewidth=1.8, zorder=4)
        elif direction == 'down':
            ax.plot([x, x + size * 0.7], [y, y - size], color=LINE_COLOR, linewidth=1.8, zorder=4)
            ax.plot([x, x - size * 0.7], [y, y - size], color=LINE_COLOR, linewidth=1.8, zorder=4)
            ax.plot([x, x], [y, y - size], color=LINE_COLOR, linewidth=1.8, zorder=4)
    elif side == 'one':
        # Single line with perpendicular bar (one)
        if direction == 'left':
            ax.plot([x - size, x - size], [y - size * 0.6, y + size * 0.6], color=LINE_COLOR, linewidth=1.8, zorder=4)
        elif direction == 'right':
            ax.plot([x + size, x + size], [y - size * 0.6, y + size * 0.6], color=LINE_COLOR, linewidth=1.8, zorder=4)
        elif direction == 'up':
            ax.plot([x - size * 0.6, x + size * 0.6], [y + size, y + size], color=LINE_COLOR, linewidth=1.8, zorder=4)
        elif direction == 'down':
            ax.plot([x - size * 0.6, x + size * 0.6], [y - size, y - size], color=LINE_COLOR, linewidth=1.8, zorder=4)


def draw_relationship_line(ax, p1, p2, label, card_start='one', card_end='many'):
    """Draw relationship line with label and crow's foot"""
    x1, y1 = p1
    x2, y2 = p2

    # Main line
    ax.plot([x1, x2], [y1, y2], color=LINE_COLOR, linewidth=1.5, zorder=2)

    # Label at midpoint
    mx, my = (x1 + x2) / 2, (y1 + y2) / 2
    angle = np.degrees(np.arctan2(y2 - y1, x2 - x1))
    if abs(angle) > 90:
        angle += 180

    ax.text(mx, my + 0.2, label,
            ha='center', va='bottom', fontsize=8.5, fontstyle='italic',
            color=RELATION_COLOR, fontweight='bold', fontfamily='sans-serif',
            bbox=dict(boxstyle='round,pad=0.15', facecolor=RELATION_BG,
                      edgecolor=RELATION_COLOR, alpha=0.9, linewidth=1),
            rotation=angle, rotation_mode='anchor', zorder=6)

    # Crow's foot at end
    dx = x2 - x1
    dy = y2 - y1
    if abs(dx) > abs(dy):
        if dx > 0:
            draw_crow_foot(ax, x2, y2, 'left', card_end)
            draw_crow_foot(ax, x1, y1, 'right', card_start)
        else:
            draw_crow_foot(ax, x2, y2, 'right', card_end)
            draw_crow_foot(ax, x1, y1, 'left', card_start)
    else:
        if dy > 0:
            draw_crow_foot(ax, x2, y2, 'down', card_end)
            draw_crow_foot(ax, x1, y1, 'up', card_start)
        else:
            draw_crow_foot(ax, x2, y2, 'up', card_end)
            draw_crow_foot(ax, x1, y1, 'down', card_start)


# ============ ENTITY DEFINITIONS (TANPA TIPE DATA) ============

entities_data = {
    'customers': {
        'attrs': ['id', 'name', 'phone', 'email', 'address', 'created_at'],
        'pk': ['id'], 'fk': [],
        'pos': (0.5, 21)
    },
    'users': {
        'attrs': ['id', 'name', 'email', 'password', 'role', 'created_at'],
        'pk': ['id'], 'fk': [],
        'pos': (11, 21)
    },
    'categories': {
        'attrs': ['id', 'parent_id', 'name', 'type_category', 'description'],
        'pk': ['id'], 'fk': ['parent_id'],
        'pos': (21.5, 21)
    },
    'services': {
        'attrs': ['id', 'customer_id', 'technician_id', 'device_name', 'serial_number',
                  'service_type', 'complaint', 'status', 'service_fee',
                  'estimated_parts_cost', 'total_amount', 'created_at'],
        'pk': ['id'], 'fk': ['customer_id', 'technician_id'],
        'pos': (0.5, 14)
    },
    'rentals': {
        'attrs': ['id', 'customer_id', 'customer_name', 'customer_phone',
                  'laptop_name', 'serial_number', 'rental_date', 'return_date',
                  'daily_price', 'total_price', 'status', 'created_at'],
        'pk': ['id'], 'fk': ['customer_id'],
        'pos': (6.5, 14)
    },
    'sales': {
        'attrs': ['id', 'user_id', 'customer_id', 'payment_method',
                  'total_amount', 'profit_amount', 'operational_cost',
                  'transaction_date', 'payment_status', 'created_at'],
        'pk': ['id'], 'fk': ['user_id', 'customer_id'],
        'pos': (12.5, 14)
    },
    'products': {
        'attrs': ['id', 'category_id', 'brand', 'model_series', 'serial_number',
                  'processor', 'ram', 'storage', 'screen_size', 'condition',
                  'purchase_price', 'selling_price', 'status', 'stock',
                  'image_path', 'created_at'],
        'pk': ['id'], 'fk': ['category_id'],
        'pos': (21.5, 14.5)
    },
    'activity_logs': {
        'attrs': ['id', 'user_id', 'action', 'model_type', 'model_id',
                  'old_values', 'new_values', 'ip_address', 'created_at'],
        'pk': ['id'], 'fk': ['user_id'],
        'pos': (0.5, 5.5)
    },
    'service_parts': {
        'attrs': ['id', 'service_id', 'product_id', 'quantity', 'price', 'created_at'],
        'pk': ['id'], 'fk': ['service_id', 'product_id'],
        'pos': (8, 5.5)
    },
    'sale_details': {
        'attrs': ['id', 'sale_id', 'product_id', 'manual_sn', 'quantity',
                  'price_at_transaction', 'purchase_price', 'profit', 'created_at'],
        'pk': ['id'], 'fk': ['sale_id', 'product_id'],
        'pos': (15, 5.5)
    },
}

# Draw all entities
conn_points = {}
for name, data in entities_data.items():
    x, y = data['pos']
    conn_points[name] = draw_entity(ax, x, y, name, data['attrs'],
                                     data['pk'], data['fk'])

# ============ RELATIONSHIPS (with crow's foot & labels) ============

# customers -> services (1:N, "has")
draw_relationship_line(ax,
    conn_points['customers']['bottom'],
    conn_points['services']['top'],
    'has')

# customers -> rentals (1:N, "has")
draw_relationship_line(ax,
    conn_points['customers']['bottom_right'],
    conn_points['rentals']['top'],
    'has')

# customers -> sales (1:N, "has")
p1 = (conn_points['customers']['right'][0], conn_points['customers']['bottom'][1] + 0.3)
p2 = conn_points['sales']['top_left']
ax.plot([p1[0], p1[0] + 1, p2[0], p2[0]], [p1[1], p1[1] - 1, p2[1] + 1, p2[1]],
        color=LINE_COLOR, linewidth=1.5, zorder=2)
ax.text((p1[0] + p2[0]) / 2, p1[1] - 0.7, 'has',
        ha='center', va='center', fontsize=8.5, fontstyle='italic',
        color=RELATION_COLOR, fontweight='bold',
        bbox=dict(boxstyle='round,pad=0.15', facecolor=RELATION_BG,
                  edgecolor=RELATION_COLOR, alpha=0.9, linewidth=1), zorder=6)
draw_crow_foot(ax, p1[0], p1[1], 'down', 'one')
draw_crow_foot(ax, p2[0], p2[1], 'up', 'many')

# users -> sales (1:N, "creates")
draw_relationship_line(ax,
    conn_points['users']['bottom'],
    conn_points['sales']['top'],
    'creates')

# users -> services (1:N, "assigned")
p1 = conn_points['users']['bottom_left']
p2 = conn_points['services']['top_right']
ax.plot([p1[0], p1[0], p2[0], p2[0]], [p1[1], p1[1] - 1.5, p2[1] + 1, p2[1]],
        color=LINE_COLOR, linewidth=1.5, zorder=2, linestyle='--')
ax.text((p1[0] + p2[0]) / 2 + 1, p1[1] - 1.5, 'assigned',
        ha='center', va='center', fontsize=8.5, fontstyle='italic',
        color=RELATION_COLOR, fontweight='bold',
        bbox=dict(boxstyle='round,pad=0.15', facecolor=RELATION_BG,
                  edgecolor=RELATION_COLOR, alpha=0.9, linewidth=1), zorder=6)
draw_crow_foot(ax, p1[0], p1[1], 'down', 'one')
draw_crow_foot(ax, p2[0], p2[1], 'up', 'many')

# users -> activity_logs (1:N, "generates")
draw_relationship_line(ax,
    (conn_points['users']['left'][0], conn_points['users']['bottom'][1] + 0.3),
    conn_points['activity_logs']['top'],
    'generates')

# categories -> products (1:N, "contains")
draw_relationship_line(ax,
    conn_points['categories']['bottom'],
    conn_points['products']['top'],
    'contains')

# categories -> categories (self-reference)
sx = conn_points['categories']['right'][0]
sy = conn_points['categories']['right'][1]
ax.annotate('', xy=(sx, sy + 0.8), xytext=(sx + 1.5, sy + 0.8),
            arrowprops=dict(arrowstyle='->', color='#E74C3C', lw=2))
ax.plot([sx, sx + 1.5, sx + 1.5, sx], [sy, sy, sy + 0.8, sy + 0.8],
        color='#E74C3C', linewidth=2, zorder=2)
ax.text(sx + 1.7, sy + 0.4, 'parent', ha='left', va='center',
        fontsize=8, fontstyle='italic', color='#E74C3C', fontweight='bold', zorder=6)

# sales -> sale_details (1:N, "contains")
draw_relationship_line(ax,
    conn_points['sales']['bottom'],
    conn_points['sale_details']['top'],
    'contains')

# products -> sale_details (1:N, "sold in")
draw_relationship_line(ax,
    conn_points['products']['bottom'],
    conn_points['sale_details']['top_right'],
    'sold in')

# services -> service_parts (1:N, "uses")
draw_relationship_line(ax,
    conn_points['services']['bottom'],
    conn_points['service_parts']['top'],
    'uses')

# products -> service_parts (1:N, "used in")
p1 = conn_points['products']['left']
p2 = conn_points['service_parts']['right']
ax.plot([p1[0], p2[0] + 2, p2[0] + 2, p2[0]], [p1[1], p1[1], p2[1], p2[1]],
        color=LINE_COLOR, linewidth=1.5, zorder=2)
ax.text(p2[0] + 2.2, (p1[1] + p2[1]) / 2, 'used in',
        ha='left', va='center', fontsize=8.5, fontstyle='italic',
        color=RELATION_COLOR, fontweight='bold',
        bbox=dict(boxstyle='round,pad=0.15', facecolor=RELATION_BG,
                  edgecolor=RELATION_COLOR, alpha=0.9, linewidth=1), zorder=6)
draw_crow_foot(ax, p1[0], p1[1], 'right', 'one')
draw_crow_foot(ax, p2[0], p2[1], 'left', 'many')


# ============ LEGEND ============
lx, ly = 22, 4
ax.add_patch(FancyBboxPatch((lx, ly - 3), 6, 3.5,
             boxstyle="round,pad=0.1", facecolor='white',
             edgecolor='#AAA', linewidth=1.5, zorder=3))
ax.text(lx + 3, ly + 0.2, 'Keterangan', ha='center', va='center',
        fontsize=11, fontweight='bold', color='#333', zorder=5)

# PK
ax.text(lx + 0.3, ly - 0.4, '\u25C6', ha='left', va='center',
        fontsize=9, color=PK_COLOR, zorder=5)
ax.text(lx + 0.7, ly - 0.4, 'id  (PK)  = Primary Key', ha='left', va='center',
        fontsize=9, color='#333', zorder=5)

# FK
ax.text(lx + 0.3, ly - 0.9, '\u25CB', ha='left', va='center',
        fontsize=9, color=FK_COLOR, zorder=5)
ax.text(lx + 0.7, ly - 0.9, 'user_id  (FK)  = Foreign Key', ha='left', va='center',
        fontsize=9, color='#333', zorder=5)

# One
ax.plot([lx + 0.3, lx + 1.0], [ly - 1.4, ly - 1.4], color=LINE_COLOR, linewidth=1.5, zorder=5)
draw_crow_foot(ax, lx + 0.3, ly - 1.4, 'right', 'one')
ax.text(lx + 1.2, ly - 1.4, '= One (1)', ha='left', va='center',
        fontsize=9, color='#333', zorder=5)

# Many
ax.plot([lx + 0.3, lx + 1.0], [ly - 1.9, ly - 1.9], color=LINE_COLOR, linewidth=1.5, zorder=5)
draw_crow_foot(ax, lx + 1.0, ly - 1.9, 'left', 'many')
ax.text(lx + 1.2, ly - 1.9, '= Many (N)', ha='left', va='center',
        fontsize=9, color='#333', zorder=5)

# Self-ref
ax.plot([lx + 0.3, lx + 1.0], [ly - 2.4, ly - 2.4], color='#E74C3C', linewidth=2, zorder=5)
ax.text(lx + 1.2, ly - 2.4, '= Self-reference', ha='left', va='center',
        fontsize=9, color='#333', zorder=5)


# ============ TITLE & CAPTION ============
ax.text(14, -0.8, 'Gambar III.8.', ha='center', va='center',
        fontsize=13, fontweight='bold', color='#222', fontfamily='serif')
ax.text(14, -1.4, 'Entity Relationship Diagram (ERD) Sistem LKTech',
        ha='center', va='center', fontsize=12, fontstyle='italic',
        color='#222', fontfamily='serif')
ax.text(0.5, -1.4, '(Sumber: Olahan Peneliti, 2026)',
        ha='left', va='center', fontsize=9, color='#666', fontfamily='serif')

plt.tight_layout()
plt.savefig('d:/Project/lktech/ERD_LKTech_v3.png', dpi=200, bbox_inches='tight',
            facecolor=fig.get_facecolor())
plt.close()
print("ERD v3 saved to d:/Project/lktech/ERD_LKTech_v3.png")
