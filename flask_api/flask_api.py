from flask import Flask, request, jsonify
import tensorflow as tf
import numpy as np
from PIL import Image
import io, json, os

app = Flask(__name__)
BASE = os.path.dirname(__file__)

# ================= LOAD MODEL =================
def load_model_and_labels(name):
    mpath = os.path.join(BASE, f'model_{name}.h5')
    lmpath = os.path.join(BASE, f'label_map_{name}.json')

    if not os.path.exists(mpath) or not os.path.exists(lmpath):
        raise FileNotFoundError(f'Model or label map not found for {name}')

    model = tf.keras.models.load_model(mpath)

    with open(lmpath,'r') as f:
        lm = json.load(f)

    # handle list / dict
    if isinstance(lm, list):
        inv = {i: lm[i] for i in range(len(lm))}
    else:
        inv = {int(v): k for k, v in lm.items()}

    return model, inv

# ================= PREPROCESS =================
def preprocess_image(file_bytes, target_size=(224,224)):
    img = Image.open(io.BytesIO(file_bytes)).convert('RGB')
    img = img.resize(target_size)
    arr = np.array(img)/255.0
    arr = np.expand_dims(arr, axis=0)
    return arr

# ================= PREDICT =================
@app.route('/predict', methods=['POST'])
def predict():
    if 'image' not in request.files:
        return jsonify({'error':'no image provided'}), 400

    file = request.files['image'].read()
    x = preprocess_image(file)

    try:
        # ===== PROBLEM MODEL =====
        m_p, lm_p = load_model_and_labels('problem')
        preds_p = m_p.predict(x)[0]

        # 🔥 FIX: reduce redness bias
        if preds_p[2] > 0.8 and preds_p[0] < 0.2:
            preds_p[2] *= 0.6

        preds_p = preds_p.tolist()

        # 🔥 FIX: REMOVE "Normal" FROM OUTPUT
        probs_p = {}
        for i in range(len(preds_p)):
            label = lm_p[i]

            if label == "Normal":
                continue  # ❌ skip normal

            probs_p[label] = float(preds_p[i])

        # ===== SKIN TYPE =====
        m_t, lm_t = load_model_and_labels('skintype')
        preds_t = m_t.predict(x)[0].tolist()
        probs_t = {lm_t[i]: float(preds_t[i]) for i in range(len(preds_t))}

        # ===== SKIN TONE =====
        m_s, lm_s = load_model_and_labels('skintone')
        preds_s = m_s.predict(x)[0].tolist()
        probs_s = {lm_s[i]: float(preds_s[i]) for i in range(len(preds_s))}

    except Exception as e:
        return jsonify({'error':'model_error','detail':str(e)}), 500

    return jsonify({
        'problem_scores': probs_p,
        'skintype_scores': probs_t,
        'skintone_scores': probs_s
    })

# ================= RUN =================
if __name__ == '__main__':
    app.run(host='127.0.0.1', port=5000, debug=True)