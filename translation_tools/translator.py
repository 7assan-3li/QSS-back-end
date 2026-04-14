import json
import urllib.request
import urllib.parse
import time
import sys
import concurrent.futures

# Set stdout to fallback on error so console doesn't crash on emojis
sys.stdout.reconfigure(errors='replace')

missing_file = 'missing_translations.json'
lang_file = 'resources/lang/en.json'

with open(missing_file, 'r', encoding='utf-8') as f:
    missing = json.load(f)

with open(lang_file, 'r', encoding='utf-8') as f:
    existing = json.load(f)

def translate(text):
    if text in existing: return None
    if not text.strip(): return None
    url = "https://translate.googleapis.com/translate_a/single?client=gtx&sl=ar&tl=en&dt=t&q=" + urllib.parse.quote(text)
    req = urllib.request.Request(url, headers={'User-Agent': 'Mozilla/5.0'})
    try:
        with urllib.request.urlopen(req, timeout=5) as response:
            res = json.loads(response.read().decode('utf-8'))
            t_text = "".join([s[0] for s in res[0]])
            return text, t_text
    except Exception as e:
        return text, text

to_translate = [k for k in missing if k not in existing and k.strip()]
print(f"Remaining to translate: {len(to_translate)}")

count = 0
with concurrent.futures.ThreadPoolExecutor(max_workers=5) as executor:
    futures = {executor.submit(translate, text): text for text in to_translate}
    for future in concurrent.futures.as_completed(futures):
        res = future.result()
        if res:
            ar, en = res
            existing[ar] = en
            count += 1
            print(f"[{count}/{len(to_translate)}] translated.")
        
        if count % 20 == 0:
            with open(lang_file, 'w', encoding='utf-8') as f:
                json.dump(existing, f, ensure_ascii=False, indent=4)

with open(lang_file, 'w', encoding='utf-8') as f:
    json.dump(existing, f, ensure_ascii=False, indent=4)

print("Translation fully complete! Saved to en.json")
