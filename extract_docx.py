import zipfile
import xml.etree.ElementTree as ET

def extract_text_from_docx(docx_path):
    try:
        with zipfile.ZipFile(docx_path) as docx:
            xml_content = docx.read('word/document.xml')
            tree = ET.fromstring(xml_content)
            
            # The namespace for WordprocessingML
            ns = {'w': 'http://schemas.openxmlformats.org/wordprocessingml/2006/main'}
            
            # Find all text elements
            texts = [node.text for node in tree.findall('.//w:t', ns) if node.text]
            return '\n'.join(texts)
    except Exception as e:
        return str(e)

file_path = r'D:\Project\Kebutuhan Skripsi\Arsitektur Enterprise\Makalah PEMODELAN ARSITEKTUR ENTERPRISE SISTEM INFORMASI MANAJEMEN LKTECH MENGGUNAKAN KERANGKA KERJA TOGAF ADM.docx'
text = extract_text_from_docx(file_path)
with open('extracted_makalah.txt', 'w', encoding='utf-8') as f:
    f.write(text)
print('Extraction complete. Saved to extracted_makalah.txt')
