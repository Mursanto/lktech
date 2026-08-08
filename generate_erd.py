import urllib.request
import urllib.parse
import json

dot_code = """
graph ER {
    layout=neato;
    overlap=false;
    splines=true;
    node [fontname="Helvetica,Arial,sans-serif"]
    edge [fontname="Helvetica,Arial,sans-serif"]

    node [shape=box, style=filled, fillcolor="#99c2e6"];
    USERS; PRODUCTS; CATEGORIES; CUSTOMERS; SALES;

    node [shape=ellipse, style=solid, fillcolor=white];
    u_id [label=<<u>id</u>>];
    u_name [label="name"];
    u_email [label="email"];
    u_role [label="role"];
    u_password [label="password"];

    p_id [label=<<u>id</u>>];
    p_brand [label="brand"];
    p_model_series [label="model_series"];
    p_serial_number [label="serial_number", style=filled, fillcolor="#fff2cc"];
    p_stock [label="stock"];
    p_selling_price [label="selling_price"];
    p_status [label="status"];

    c_id [label=<<u>id</u>>];
    c_name [label="name"];
    c_type_category [label="type_category"];

    cu_id [label=<<u>id</u>>];
    cu_name [label="name"];
    cu_phone [label="phone"];
    cu_email [label="email"];
    cu_address [label="address"];

    s_id [label=<<u>id</u>>];
    s_customer_id [label="customer_id"];
    s_total_amount [label="total_amount"];
    s_payment_method [label="payment_method"];
    s_transaction_date [label="transaction_date"];

    node [shape=diamond, style=filled, fillcolor="#ffe699"];
    melakukan; melibatkan; termasuk; membuat;

    USERS -- melakukan [label="1", len=1.5];
    melakukan -- SALES [label="N", len=1.5];

    SALES -- melibatkan [label="M", len=2.0];
    melibatkan -- PRODUCTS [label="N", len=2.0];

    PRODUCTS -- termasuk [label="N", len=1.5];
    termasuk -- CATEGORIES [label="1", len=1.5];

    CUSTOMERS -- membuat [label="1", len=1.5];
    membuat -- SALES [label="N", len=1.5];

    USERS -- u_id;
    USERS -- u_name;
    USERS -- u_email;
    USERS -- u_role;
    USERS -- u_password;

    PRODUCTS -- p_id;
    PRODUCTS -- p_brand;
    PRODUCTS -- p_model_series;
    PRODUCTS -- p_serial_number;
    PRODUCTS -- p_stock;
    PRODUCTS -- p_selling_price;
    PRODUCTS -- p_status;

    CATEGORIES -- c_id;
    CATEGORIES -- c_name;
    CATEGORIES -- c_type_category;

    CUSTOMERS -- cu_id;
    CUSTOMERS -- cu_name;
    CUSTOMERS -- cu_phone;
    CUSTOMERS -- cu_email;
    CUSTOMERS -- cu_address;

    SALES -- s_id;
    SALES -- s_customer_id;
    SALES -- s_total_amount;
    SALES -- s_payment_method;
    SALES -- s_transaction_date;
}
"""

url = "https://quickchart.io/graphviz"
data = json.dumps({"graph": dot_code, "format": "png"}).encode("utf-8")
headers = {"Content-Type": "application/json"}
req = urllib.request.Request(url, data=data, headers=headers)
with urllib.request.urlopen(req) as response:
    with open("ERD_Lktech_Updated.png", "wb") as f:
        f.write(response.read())
print("ERD Chen style saved as ERD_Lktech_Updated.png.")
