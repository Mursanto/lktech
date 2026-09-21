import re

with open(r'd:\Project\lktech\resources\views\pages\sewa-laptop.blade.php', 'r', encoding='utf-8') as f:
    content = f.read()

def repl(m):
    color = m.group(1)
    icon = m.group(2)
    title = m.group(3)
    desc = m.group(4)
    
    return f'''<div class="float-anim group bg-white rounded-2xl p-3 sm:p-4 border border-gray-100 shadow-sm hover:shadow-lg hover:border-emerald-200 transition-all flex items-center sm:flex-col sm:text-center text-left gap-3 sm:gap-0 cursor-default">
                        <div class="w-10 h-10 sm:w-12 sm:h-12 shrink-0 bg-{color}-50 text-{color}-600 rounded-2xl flex items-center justify-center text-xl sm:text-2xl sm:mx-auto sm:mb-3 group-hover:bg-{color}-500 group-hover:text-white transition-colors">
                            <i class='bx {icon}'></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-800 text-[11px] sm:text-xs leading-tight">{title}</h4>
                            <p class="text-[9px] sm:text-[10px] text-gray-400 mt-0.5 sm:mt-1 leading-snug">{desc}</p>
                        </div>
                    </div>'''

pattern = re.compile(r'<div class="float-anim group bg-white rounded-2xl p-4 border border-gray-100 shadow-sm hover:shadow-lg hover:border-emerald-200 transition-all text-center cursor-default">\s*<div class="w-12 h-12 bg-([a-z]+)-50 text-\1-600 rounded-2xl flex items-center justify-center text-2xl mx-auto mb-3 group-hover:bg-\1-500 group-hover:text-white transition-colors">\s*<i class=\'bx ([^\']+)\'></i>\s*</div>\s*<h4 class="font-bold text-gray-800 text-xs leading-tight">([^<]+)</h4>\s*<p class="text-\[10px\] text-gray-400 mt-1 leading-snug">([^<]+)</p>\s*</div>')

new_content = pattern.sub(repl, content)

with open(r'd:\Project\lktech\resources\views\pages\sewa-laptop.blade.php', 'w', encoding='utf-8') as f:
    f.write(new_content)
