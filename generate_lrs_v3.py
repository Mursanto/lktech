import matplotlib
matplotlib.use('Agg')
import matplotlib.pyplot as plt
import matplotlib.patches as mpatches
from matplotlib.patches import FancyBboxPatch
import numpy as np

# ============================================================
# LRS - Logical Record Structure (TEKNIKAL/FISIK)
# Gaya: Tabel GRID dengan kolom (Field | Tipe Data | Key)
#        Garis relasi = panah sederhana (TANPA crow's foot)
# DENGAN tipe data lengkap, DENGAN grid tabel
# ============================================================

fig, ax = plt.subplots(1, 1, figsize=(30, 24))
fig.patch.set_facecolor('#FFFDF8')
ax.set_xlim(-1, 31)
ax.set_ylim(-2, 25)
ax.set_aspect('equal')
ax.axis('off')

# ---- COLOR SCHEME (Warm/Orange - teknikal) ----
TABLE_BG = '#FFF8F0'
TABLE_BORDER = '#D35400'
TABLE_HEADER_BG = '#D35400'
TABLE_HEADER_FG = 'white'
GRID_COLOR = '#E8D5C4'
FIELD_COLOR = '#333333'
TYPE_COLOR = '#666666'
PK_BG = '#FDEBD0'
FK_BG = '#F5EEF8'
PK_BADGE = '#E74C3C'
FK_BADGE = '#8E44AD'
ARROW_COLOR = '#2C3E50'


def draw_record_table(ax, x, y, name, fields, width=6.2, row_h=0.38):
    """
    Draw LRS record table with GRID structure
    fields: list of (field_name, data_type, key_type)
       key_type: 'PK', 'FK', or ''
    """
    col_w1 = width * 0.38  # field name column
    col_w2 = width * 0.42  # data type column
    col_w3 = width * 0.20  # key column
    header_h = 0.55
    total_h = header_h + len(fields) * row_h

    # Main table background
    ax.add_patch(plt.Rectangle((x, y - total_h), width, total_h,
                 facecolor=TABLE_BG, edgecolor=TABLE_BORDER,
                 linewidth=2.5, zorder=3))

    # Header
    ax.add_patch(plt.Rectangle((x, y - header_h), width, header_h,
                 facecolor=TABLE_HEADER_BG, edgecolor=TABLE_BORDER,
                 linewidth=2.5, zorder=4))

    ax.text(x + width / 2, y - header_h / 2, name,
            ha='center', va='center', fontsize=11, fontweight='bold',
            color=TABLE_HEADER_FG, fontfamily='monospace', zorder=5)

    # Column headers row
    ch_y = y - header_h
    ax.add_patch(plt.Rectangle((x, ch_y - row_h), width, row_h,
                 facecolor='#F5E6D3', edgecolor=TABLE_BORDER,
                 linewidth=1, zorder=4))
    ax.text(x + col_w1 / 2, ch_y - row_h / 2, 'Field',
            ha='center', va='center', fontsize=8, fontweight='bold',
            color='#555', fontfamily='monospace', zorder=5)
    ax.text(x + col_w1 + col_w2 / 2, ch_y - row_h / 2, 'Tipe Data',
            ha='center', va='center', fontsize=8, fontweight='bold',
            color='#555', fontfamily='monospace', zorder=5)
    ax.text(x + col_w1 + col_w2 + col_w3 / 2, ch_y - row_h / 2, 'Key',
            ha='center', va='center', fontsize=8, fontweight='bold',
            color='#555', fontfamily='monospace', zorder=5)

    # Vertical grid lines (column separators)
    grid_top = ch_y
    grid_bottom = y - total_h
    ax.plot([x + col_w1, x + col_w1], [grid_top, grid_bottom],
            color=GRID_COLOR, linewidth=1, zorder=4)
    ax.plot([x + col_w1 + col_w2, x + col_w1 + col_w2], [grid_top, grid_bottom],
            color=GRID_COLOR, linewidth=1, zorder=4)

    # Data rows
    for i, (field_name, data_type, key_type) in enumerate(fields):
        ry = ch_y - row_h - i * row_h

        # Row background
        if key_type == 'PK':
            row_bg = PK_BG
        elif key_type == 'FK':
            row_bg = FK_BG
        else:
            row_bg = TABLE_BG if i % 2 == 0 else '#FFF4EA'

        ax.add_patch(plt.Rectangle((x, ry - row_h), width, row_h,
                     facecolor=row_bg, edgecolor='none', zorder=3))

        # Horizontal grid line
        ax.plot([x, x + width], [ry, ry],
                color=GRID_COLOR, linewidth=0.5, zorder=4)

        # Field name
        fw = 'bold' if key_type == 'PK' else 'normal'
        fc = PK_BADGE if key_type == 'PK' else (FK_BADGE if key_type == 'FK' else FIELD_COLOR)
        ax.text(x + 0.12, ry - row_h / 2, field_name,
                ha='left', va='center', fontsize=8, fontweight=fw,
                color=fc, fontfamily='monospace', zorder=5)

        # Data type
        ax.text(x + col_w1 + 0.12, ry - row_h / 2, data_type,
                ha='left', va='center', fontsize=7.5,
                color=TYPE_COLOR, fontfamily='monospace', zorder=5)

        # Key badge
        if key_type:
            badge_x = x + col_w1 + col_w2 + col_w3 / 2
            badge_y = ry - row_h / 2
            badge_color = PK_BADGE if key_type == 'PK' else FK_BADGE
            ax.add_patch(FancyBboxPatch((badge_x - 0.3, badge_y - 0.1), 0.6, 0.22,
                         boxstyle="round,pad=0.04", facecolor=badge_color,
                         edgecolor='none', zorder=5))
            ax.text(badge_x, badge_y, key_type,
                    ha='center', va='center', fontsize=6.5, fontweight='bold',
                    color='white', fontfamily='monospace', zorder=6)

    # Return connection points
    cx = x + width / 2
    return {
        'top': (cx, y),
        'bottom': (cx, y - total_h),
        'left': (x, y - total_h / 2),
        'right': (x + width, y - total_h / 2),
        'left_top': (x, y - 1.5),
        'right_top': (x + width, y - 1.5),
        'bottom_left': (x + width * 0.3, y - total_h),
        'bottom_right': (x + width * 0.7, y - total_h),
        'top_left': (x + width * 0.3, y),
        'top_right': (x + width * 0.7, y),
    }


def draw_fk_arrow(ax, p1, p2, waypoints=None):
    """Draw simple FK arrow (NO crow's foot - just arrow)"""
    if waypoints:
        all_points = [p1] + waypoints + [p2]
        for i in range(len(all_points) - 1):
            x1, y1 = all_points[i]
            x2, y2 = all_points[i + 1]
            if i == len(all_points) - 2:
                ax.annotate('', xy=(x2, y2), xytext=(x1, y1),
                           arrowprops=dict(arrowstyle='->', color=ARROW_COLOR,
                                          lw=1.8, connectionstyle='arc3,rad=0'))
            else:
                ax.plot([x1, x2], [y1, y2], color=ARROW_COLOR, linewidth=1.8, zorder=2)
        # Dot at start
        ax.plot(p1[0], p1[1], 'o', color=ARROW_COLOR, markersize=5, zorder=4)
    else:
        ax.annotate('', xy=(p2[0], p2[1]), xytext=(p1[0], p1[1]),
                   arrowprops=dict(arrowstyle='->', color=ARROW_COLOR,
                                  lw=1.8, connectionstyle='arc3,rad=0'))
        ax.plot(p1[0], p1[1], 'o', color=ARROW_COLOR, markersize=5, zorder=4)


# ============ TABLE DEFINITIONS (DENGAN TIPE DATA) ============

tables_data = {
    'customers': {
        'fields': [
            ('id', 'BIGINT UNSIGNED', 'PK'),
            ('name', 'VARCHAR(255)', ''),
            ('phone', 'VARCHAR(255)', ''),
            ('email', 'VARCHAR(255)', ''),
            ('address', 'TEXT', ''),
            ('created_at', 'TIMESTAMP', ''),
            ('updated_at', 'TIMESTAMP', ''),
        ],
        'pos': (0.5, 23)
    },
    'users': {
        'fields': [
            ('id', 'BIGINT UNSIGNED', 'PK'),
            ('name', 'VARCHAR(255)', ''),
            ('email', 'VARCHAR(255)', ''),
            ('password', 'VARCHAR(255)', ''),
            ('role', 'VARCHAR(255)', ''),
            ('google2fa_secret', 'VARCHAR(255)', ''),
            ('otp_code', 'VARCHAR(255)', ''),
            ('otp_enabled', 'BOOLEAN', ''),
            ('created_at', 'TIMESTAMP', ''),
        ],
        'pos': (11.5, 23)
    },
    'categories': {
        'fields': [
            ('id', 'BIGINT UNSIGNED', 'PK'),
            ('parent_id', 'BIGINT UNSIGNED', 'FK'),
            ('name', 'VARCHAR(255)', ''),
            ('type_category', 'ENUM', ''),
            ('description', 'TEXT', ''),
            ('created_at', 'TIMESTAMP', ''),
        ],
        'pos': (22.5, 23)
    },
    'services': {
        'fields': [
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
        ],
        'pos': (0.5, 15)
    },
    'rentals': {
        'fields': [
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
        ],
        'pos': (8, 15)
    },
    'sales': {
        'fields': [
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
        ],
        'pos': (15.5, 15)
    },
    'products': {
        'fields': [
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
            ('image_path', 'VARCHAR(255)', ''),
            ('created_at', 'TIMESTAMP', ''),
        ],
        'pos': (23, 15.5)
    },
    'activity_logs': {
        'fields': [
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
        ],
        'pos': (0.5, 6)
    },
    'service_parts': {
        'fields': [
            ('id', 'BIGINT UNSIGNED', 'PK'),
            ('service_id', 'BIGINT UNSIGNED', 'FK'),
            ('product_id', 'BIGINT UNSIGNED', 'FK'),
            ('quantity', 'INTEGER', ''),
            ('price', 'DECIMAL(15,2)', ''),
            ('created_at', 'TIMESTAMP', ''),
        ],
        'pos': (9, 6)
    },
    'sale_details': {
        'fields': [
            ('id', 'BIGINT UNSIGNED', 'PK'),
            ('sale_id', 'BIGINT UNSIGNED', 'FK'),
            ('product_id', 'BIGINT UNSIGNED', 'FK'),
            ('manual_sn', 'VARCHAR(255)', ''),
            ('quantity', 'INTEGER', ''),
            ('price_at_transaction', 'DECIMAL(10,2)', ''),
            ('purchase_price', 'DECIMAL(15,2)', ''),
            ('profit', 'DECIMAL(15,2)', ''),
            ('created_at', 'TIMESTAMP', ''),
        ],
        'pos': (17, 6)
    },
}

# Draw all tables
conn = {}
for name, data in tables_data.items():
    x, y = data['pos']
    conn[name] = draw_record_table(ax, x, y, name, data['fields'])

# ============ FK ARROWS (simple arrows - NO crow's foot) ============

# customers -> services
draw_fk_arrow(ax, conn['customers']['bottom'], conn['services']['top'])

# customers -> rentals
draw_fk_arrow(ax, conn['customers']['bottom_right'], conn['rentals']['top'])

# customers -> sales
p1 = (conn['customers']['right'][0], conn['customers']['bottom'][1] + 0.5)
p2 = conn['sales']['top_left']
draw_fk_arrow(ax, p1, p2, [(p1[0] + 1, p1[1] - 1.5), (p2[0], p2[1] + 1)])

# users -> sales
draw_fk_arrow(ax, conn['users']['bottom'], conn['sales']['top'])

# users -> services
p1 = conn['users']['bottom_left']
p2 = conn['services']['top_right']
draw_fk_arrow(ax, p1, p2, [(p1[0], p1[1] - 1.5), (p2[0], p2[1] + 1)])

# users -> activity_logs
draw_fk_arrow(ax,
    (conn['users']['left'][0], conn['users']['bottom'][1] + 0.5),
    conn['activity_logs']['top'])

# categories -> products
draw_fk_arrow(ax, conn['categories']['bottom'], conn['products']['top'])

# categories self-reference
sx = conn['categories']['right'][0]
sy = conn['categories']['right'][1]
ax.plot([sx, sx + 1.2, sx + 1.2, sx], [sy, sy, sy + 1, sy + 1],
        color='#E74C3C', linewidth=2, zorder=2)
ax.annotate('', xy=(sx, sy + 1), xytext=(sx + 1.2, sy + 1),
           arrowprops=dict(arrowstyle='->', color='#E74C3C', lw=2))
ax.plot(sx, sy, 'o', color='#E74C3C', markersize=5, zorder=4)

# sales -> sale_details
draw_fk_arrow(ax, conn['sales']['bottom'], conn['sale_details']['top'])

# products -> sale_details
draw_fk_arrow(ax, conn['products']['bottom'], conn['sale_details']['top_right'])

# services -> service_parts
draw_fk_arrow(ax, conn['services']['bottom'], conn['service_parts']['top'])

# products -> service_parts
p1 = conn['products']['left']
p2 = conn['service_parts']['right']
draw_fk_arrow(ax, p1, p2, [(p2[0] + 2, p1[1]), (p2[0] + 2, p2[1])])


# ============ LEGEND ============
lx, ly = 24, 6
ax.add_patch(plt.Rectangle((lx, ly - 3.5), 5.5, 4,
             facecolor='white', edgecolor='#AAA', linewidth=1.5, zorder=3))
ax.text(lx + 2.75, ly + 0.2, 'Keterangan', ha='center', va='center',
        fontsize=11, fontweight='bold', color='#333', fontfamily='monospace', zorder=5)

# PK badge
ax.add_patch(FancyBboxPatch((lx + 0.3, ly - 0.45), 0.6, 0.25,
             boxstyle="round,pad=0.04", facecolor=PK_BADGE,
             edgecolor='none', zorder=5))
ax.text(lx + 0.6, ly - 0.33, 'PK', ha='center', va='center',
        fontsize=7, fontweight='bold', color='white', fontfamily='monospace', zorder=6)
ax.text(lx + 1.1, ly - 0.33, '= Primary Key', ha='left', va='center',
        fontsize=9, color='#333', fontfamily='monospace', zorder=5)

# FK badge
ax.add_patch(FancyBboxPatch((lx + 0.3, ly - 0.95), 0.6, 0.25,
             boxstyle="round,pad=0.04", facecolor=FK_BADGE,
             edgecolor='none', zorder=5))
ax.text(lx + 0.6, ly - 0.83, 'FK', ha='center', va='center',
        fontsize=7, fontweight='bold', color='white', fontfamily='monospace', zorder=6)
ax.text(lx + 1.1, ly - 0.83, '= Foreign Key', ha='left', va='center',
        fontsize=9, color='#333', fontfamily='monospace', zorder=5)

# Arrow
ax.annotate('', xy=(lx + 1.0, ly - 1.3), xytext=(lx + 0.3, ly - 1.3),
           arrowprops=dict(arrowstyle='->', color=ARROW_COLOR, lw=1.8))
ax.plot(lx + 0.3, ly - 1.3, 'o', color=ARROW_COLOR, markersize=5, zorder=5)
ax.text(lx + 1.2, ly - 1.3, '= FK Reference', ha='left', va='center',
        fontsize=9, color='#333', fontfamily='monospace', zorder=5)

# Data types
ax.text(lx + 0.3, ly - 1.8, 'Tipe Data:', ha='left', va='center',
        fontsize=9, fontweight='bold', color='#333', fontfamily='monospace', zorder=5)
ax.text(lx + 0.3, ly - 2.2, 'VARCHAR, BIGINT,', ha='left', va='center',
        fontsize=8, color=TYPE_COLOR, fontfamily='monospace', zorder=5)
ax.text(lx + 0.3, ly - 2.55, 'DECIMAL, ENUM,', ha='left', va='center',
        fontsize=8, color=TYPE_COLOR, fontfamily='monospace', zorder=5)
ax.text(lx + 0.3, ly - 2.9, 'JSON, TEXT, DATE...', ha='left', va='center',
        fontsize=8, color=TYPE_COLOR, fontfamily='monospace', zorder=5)


# ============ TITLE & CAPTION ============
ax.text(15, -0.8, 'Gambar III.9.', ha='center', va='center',
        fontsize=13, fontweight='bold', color='#222', fontfamily='serif')
ax.text(15, -1.4, 'Logical Record Structure (LRS) Sistem LKTech',
        ha='center', va='center', fontsize=12, fontstyle='italic',
        color='#222', fontfamily='serif')
ax.text(0.5, -1.4, '(Sumber: Olahan Peneliti, 2026)',
        ha='left', va='center', fontsize=9, color='#666', fontfamily='serif')

plt.tight_layout()
plt.savefig('d:/Project/lktech/LRS_LKTech_v3.png', dpi=200, bbox_inches='tight',
            facecolor=fig.get_facecolor())
plt.close()
print("LRS v3 saved to d:/Project/lktech/LRS_LKTech_v3.png")
