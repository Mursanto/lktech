import urllib.request
import urllib.parse
import json

dot_code = """
digraph LRS {
    rankdir=TB;
    node [shape=none, fontname="Arial", fontsize=12, margin=0];
    edge [fontname="Arial", fontsize=10, dir=both, arrowtail=crow, arrowhead=none, penwidth=2.5];

    // Define tables using HTML-like labels
    users [label=<
        <table border="0" cellborder="1" cellspacing="0" cellpadding="4">
            <tr><td bgcolor="#bde0fe" colspan="3"><b>users</b></td></tr>
            <tr><td port="id" align="left"><b>&#128273; id</b></td><td align="left"><b>BIGINT</b></td><td align="left"><b>PK</b></td></tr>
            <tr><td align="left">name</td><td align="left">VARCHAR</td><td align="left"></td></tr>
            <tr><td align="left">email</td><td align="left">VARCHAR</td><td align="left"></td></tr>
            <tr><td align="left">password</td><td align="left">VARCHAR</td><td align="left"></td></tr>
            <tr><td align="left">role</td><td align="left">VARCHAR</td><td align="left"></td></tr>
            <tr><td align="left">created_at</td><td align="left">TIMESTAMP</td><td align="left"></td></tr>
        </table>
    >];

    products [label=<
        <table border="0" cellborder="1" cellspacing="0" cellpadding="4">
            <tr><td bgcolor="#d8f3dc" colspan="3"><b>products</b></td></tr>
            <tr><td port="id" align="left"><b>&#128273; id</b></td><td align="left"><b>BIGINT</b></td><td align="left"><b>PK</b></td></tr>
            <tr><td port="category_id" align="left"><i>category_id</i></td><td align="left">BIGINT</td><td align="left"><i>FK</i></td></tr>
            <tr><td align="left">brand</td><td align="left">VARCHAR</td><td align="left"></td></tr>
            <tr><td align="left">model_series</td><td align="left">VARCHAR</td><td align="left"></td></tr>
            <tr><td align="left">serial_number</td><td align="left">VARCHAR</td><td align="left"></td></tr>
            <tr><td align="left">stock</td><td align="left">INT</td><td align="left"></td></tr>
            <tr><td align="left">selling_price</td><td align="left">DECIMAL</td><td align="left"></td></tr>
            <tr><td align="left">status</td><td align="left">VARCHAR</td><td align="left"></td></tr>
        </table>
    >];

    categories [label=<
        <table border="0" cellborder="1" cellspacing="0" cellpadding="4">
            <tr><td bgcolor="#ffca3a" colspan="3"><b>categories</b></td></tr>
            <tr><td port="id" align="left"><b>&#128273; id</b></td><td align="left"><b>BIGINT</b></td><td align="left"><b>PK</b></td></tr>
            <tr><td align="left">name</td><td align="left">VARCHAR</td><td align="left"></td></tr>
            <tr><td align="left">type_category</td><td align="left">VARCHAR</td><td align="left"></td></tr>
            <tr><td align="left">description</td><td align="left">TEXT</td><td align="left"></td></tr>
        </table>
    >];

    sales [label=<
        <table border="0" cellborder="1" cellspacing="0" cellpadding="4">
            <tr><td bgcolor="#cdb4db" colspan="3"><b>sales</b></td></tr>
            <tr><td port="id" align="left"><b>&#128273; id</b></td><td align="left"><b>BIGINT</b></td><td align="left"><b>PK</b></td></tr>
            <tr><td port="user_id" align="left"><i>user_id</i></td><td align="left">BIGINT</td><td align="left"><i>FK</i></td></tr>
            <tr><td port="customer_id" align="left"><i>customer_id</i></td><td align="left">BIGINT</td><td align="left"><i>FK</i></td></tr>
            <tr><td align="left">total_amount</td><td align="left">DECIMAL</td><td align="left"></td></tr>
            <tr><td align="left">payment_method</td><td align="left">VARCHAR</td><td align="left"></td></tr>
            <tr><td align="left">transaction_date</td><td align="left">DATETIME</td><td align="left"></td></tr>
        </table>
    >];

    sale_details [label=<
        <table border="0" cellborder="1" cellspacing="0" cellpadding="4">
            <tr><td bgcolor="#fcf6bd" colspan="3"><b>sale_details</b></td></tr>
            <tr><td port="id" align="left"><b>&#128273; id</b></td><td align="left"><b>BIGINT</b></td><td align="left"><b>PK</b></td></tr>
            <tr><td port="sale_id" align="left"><i>sale_id</i></td><td align="left">BIGINT</td><td align="left"><i>FK</i></td></tr>
            <tr><td port="product_id" align="left"><i>product_id</i></td><td align="left">BIGINT</td><td align="left"><i>FK</i></td></tr>
            <tr><td align="left">quantity</td><td align="left">INT</td><td align="left"></td></tr>
            <tr><td align="left">unit_price</td><td align="left">DECIMAL</td><td align="left"></td></tr>
        </table>
    >];

    customers [label=<
        <table border="0" cellborder="1" cellspacing="0" cellpadding="4">
            <tr><td bgcolor="#ffadad" colspan="3"><b>customers</b></td></tr>
            <tr><td port="id" align="left"><b>&#128273; id</b></td><td align="left"><b>BIGINT</b></td><td align="left"><b>PK</b></td></tr>
            <tr><td align="left">name</td><td align="left">VARCHAR</td><td align="left"></td></tr>
            <tr><td align="left">phone</td><td align="left">VARCHAR</td><td align="left"></td></tr>
            <tr><td align="left">email</td><td align="left">VARCHAR</td><td align="left"></td></tr>
            <tr><td align="left">address</td><td align="left">TEXT</td><td align="left"></td></tr>
            <tr><td align="left">created_at</td><td align="left">TIMESTAMP</td><td align="left"></td></tr>
        </table>
    >];

    services [label=<
        <table border="0" cellborder="1" cellspacing="0" cellpadding="4">
            <tr><td bgcolor="#a0c4ff" colspan="3"><b>services</b></td></tr>
            <tr><td port="id" align="left"><b>&#128273; id</b></td><td align="left"><b>BIGINT</b></td><td align="left"><b>PK</b></td></tr>
            <tr><td port="customer_id" align="left"><i>customer_id</i></td><td align="left">BIGINT</td><td align="left"><i>FK</i></td></tr>
            <tr><td port="user_id" align="left"><i>user_id</i></td><td align="left">BIGINT</td><td align="left"><i>FK</i></td></tr>
            <tr><td align="left">service_date</td><td align="left">DATETIME</td><td align="left"></td></tr>
            <tr><td align="left">service_type</td><td align="left">VARCHAR</td><td align="left"></td></tr>
            <tr><td align="left">cost</td><td align="left">DECIMAL</td><td align="left"></td></tr>
        </table>
    >];

    service_parts [label=<
        <table border="0" cellborder="1" cellspacing="0" cellpadding="4">
            <tr><td bgcolor="#caffbf" colspan="3"><b>service_parts</b></td></tr>
            <tr><td port="id" align="left"><b>&#128273; id</b></td><td align="left"><b>BIGINT</b></td><td align="left"><b>PK</b></td></tr>
            <tr><td port="service_id" align="left"><i>service_id</i></td><td align="left">BIGINT</td><td align="left"><i>FK</i></td></tr>
            <tr><td port="product_id" align="left"><i>product_id</i></td><td align="left">BIGINT</td><td align="left"><i>FK</i></td></tr>
            <tr><td align="left">quantity</td><td align="left">INT</td><td align="left"></td></tr>
            <tr><td align="left">price</td><td align="left">DECIMAL</td><td align="left"></td></tr>
        </table>
    >];

    rentals [label=<
        <table border="0" cellborder="1" cellspacing="0" cellpadding="4">
            <tr><td bgcolor="#ffd6a5" colspan="3"><b>rentals</b></td></tr>
            <tr><td port="id" align="left"><b>&#128273; id</b></td><td align="left"><b>BIGINT</b></td><td align="left"><b>PK</b></td></tr>
            <tr><td port="customer_id" align="left"><i>customer_id</i></td><td align="left">BIGINT</td><td align="left"><i>FK</i></td></tr>
            <tr><td port="user_id" align="left"><i>user_id</i></td><td align="left">BIGINT</td><td align="left"><i>FK</i></td></tr>
            <tr><td align="left">rental_date</td><td align="left">DATETIME</td><td align="left"></td></tr>
            <tr><td align="left">return_date</td><td align="left">DATETIME</td><td align="left"></td></tr>
            <tr><td align="left">daily_price</td><td align="left">DECIMAL</td><td align="left"></td></tr>
            <tr><td align="left">status</td><td align="left">VARCHAR</td><td align="left"></td></tr>
        </table>
    >];

    // Invisible edges to enforce vertical layout
    users -> sales [style=invis, penwidth=0];
    categories -> products [style=invis, penwidth=0];
    products -> sale_details [style=invis, penwidth=0];
    sales -> sale_details [style=invis, penwidth=0];

    // Real relationships with colored edges matching the parent table color (slightly darker for visibility)
    users:id -> sales:user_id [color="#023e8a"];
    users:id -> rentals:user_id [color="#023e8a"];
    users:id -> services:user_id [color="#023e8a"];
    
    customers:id -> sales:customer_id [color="#d90429"];
    customers:id -> rentals:customer_id [color="#d90429"];
    customers:id -> services:customer_id [color="#d90429"];

    categories:id -> products:category_id [color="#d4a373"];

    sales:id -> sale_details:sale_id [color="#7209b7"];
    
    products:id -> sale_details:product_id [color="#2d6a4f"];
    products:id -> service_parts:product_id [color="#2d6a4f"];

    services:id -> service_parts:service_id [color="#0077b6"];
}
"""

url = "https://quickchart.io/graphviz"
data = json.dumps({"graph": dot_code, "format": "png", "width": 900, "height": 1500}).encode("utf-8")
headers = {"Content-Type": "application/json"}
req = urllib.request.Request(url, data=data, headers=headers)
with urllib.request.urlopen(req) as response:
    with open("LRS_Vertical_LKtech.png", "wb") as f:
        f.write(response.read())
print("Vertical Colored LRS saved.")
