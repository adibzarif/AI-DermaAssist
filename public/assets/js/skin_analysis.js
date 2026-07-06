// ==========================================
// GLOBALS
// ==========================================
const modal          = document.getElementById("analysisModal");
const uploadBtn      = document.getElementById("uploadBtn");
const cameraBtn      = document.getElementById("cameraBtn");
const fileInput      = document.getElementById("fileInput");
const preview        = document.getElementById("previewImage");
const video          = document.getElementById("cameraVideo");
const hint           = document.getElementById("faceHint");
const circle         = document.getElementById("faceCircle");
const canvas         = document.getElementById("canvas");
const skinForm       = document.getElementById("skinForm");
const checkBtn       = document.getElementById("checkBtn");
const popupResultBox = document.getElementById("popupResultBox");

let stream       = null;
let captured     = false;
let stableFrames = 0;
let lastBox      = null;
let faceInterval = null;
let selected     = [];
let aiResult     = null;


// ==========================================
// OPEN / CLOSE MODAL
// ==========================================
document.getElementById("openAnalysisBtn").onclick  = () => modal.classList.add("show");
document.getElementById("startAnalysisBtn").onclick = () => modal.classList.add("show");
window.onclick = (e) => { if (e.target === modal) closeModal(); };
document.getElementById("closeModalBtn").onclick = closeModal;

function closeModal() {
    modal.classList.remove("show");
    if (stream) stream.getTracks().forEach(t => t.stop());
    showStep("stepUpload");
    video.srcObject = null;
    captured     = false;
    stableFrames = 0;
}


// ==========================================
// STEP SWITCHER
// ==========================================
function showStep(stepId) {
    document.querySelectorAll(".modal-step").forEach(s => s.classList.remove("active"));
    document.getElementById(stepId).classList.add("active");

    document.querySelectorAll(".progress-step").forEach(s => s.classList.remove("active"));

    const stepMap = {
        "stepUpload":        0,
        "stepProcessing":    0,
        "stepProfile":       1,
        "stepProductReview": 2,
        "stepProductResult": 3
    };

    const idx = stepMap[stepId];
    if (idx !== undefined) {
        document.querySelectorAll(".progress-step")[idx].classList.add("active");
    }
}


// ==========================================
// AFTER AI SCAN — populate profile with results
// ==========================================
function populateProfileFromAI(result) {
    aiResult = result;

    document.getElementById("viewFullResultWrap").style.display = "block";

    const skintype = result.skintype_scores
        ? Object.keys(result.skintype_scores).reduce((a, b) => result.skintype_scores[a] > result.skintype_scores[b] ? a : b)
        : "—";

    const skintone = result.skintone_scores
        ? Object.keys(result.skintone_scores).reduce((a, b) => result.skintone_scores[a] > result.skintone_scores[b] ? a : b)
        : "—";

    const scores     = result.problem_scores || {};
    const topConcern = Object.keys(scores).length
        ? Object.keys(scores).reduce((a, b) => scores[a] > scores[b] ? a : b)
        : "—";

    document.getElementById("aiSkinType").textContent   = skintype.charAt(0).toUpperCase()   + skintype.slice(1);
    document.getElementById("aiSkinTone").textContent   = skintone.charAt(0).toUpperCase()   + skintone.slice(1);
    document.getElementById("aiTopConcern").textContent = topConcern.charAt(0).toUpperCase() + topConcern.slice(1);

    // Score bars
    const colors = {
        acne:      "#ec4899",
        darkspots: "#f59e0b",
        redness:   "#ef4444",
        wrinkles:  "#3b82f6"
    };

    const barsEl = document.getElementById("aiScoreBars");
    barsEl.innerHTML = "";

    Object.entries(scores).forEach(([key, val]) => {
        const pct   = Math.round(val * 100);
        const color = colors[key.toLowerCase()] || "#6366f1";
        const label = key.charAt(0).toUpperCase() + key.slice(1);

        barsEl.innerHTML += `
            <div class="ai-bar-row">
                <span class="ai-bar-label">${label}</span>
                <div class="ai-bar-track">
                    <div class="ai-bar-fill" style="width:${pct}%; background:${color};"></div>
                </div>
                <span class="ai-bar-pct">${pct}%</span>
            </div>`;
    });

    // Pre-select skin type radio
    const typeRadio = document.querySelector(`input[name="skin_type"][value="${skintype.toLowerCase()}"]`);
    if (typeRadio) typeRadio.checked = true;

    // Pre-check top concern checkbox
    const concernMap = { darkspots: "dark_spots" };
    const concernVal = concernMap[topConcern.toLowerCase()] || topConcern.toLowerCase();
    const concernCheck = document.querySelector(`input[name="skin_problem[]"][value="${concernVal}"]`);
    if (concernCheck) concernCheck.checked = true;
}


// ==========================================
// PROFILE VALIDATION
// ==========================================
function validateForm() {
    let isValid = true;
    document.querySelectorAll(".error-msg").forEach(e => e.innerText = "");

    if (!document.querySelector('input[name="skin_type"]:checked')) {
        document.getElementById("skinTypeError").innerText = "Please select your skin type";
        isValid = false;
    }
    if (document.querySelectorAll('input[name="skin_problem[]"]:checked').length === 0) {
        document.getElementById("concernError").innerText = "Please select at least one concern";
        isValid = false;
    }
    if (!document.querySelector('input[name="face_wash"]:checked')) {
        document.getElementById("washError").innerText = "Please select face wash frequency";
        isValid = false;
    }
    if (!document.querySelector('input[name="breakouts"]:checked')) {
        document.getElementById("breakoutError").innerText = "Please select breakout condition";
        isValid = false;
    }
    return isValid;
}

function goToProductReview() {
    if (!validateForm()) return;
    showStep("stepProductReview");
}


// ==========================================
// PRODUCTS
// ==========================================
function searchProducts() {
    const input      = document.getElementById("productSearch").value.toLowerCase();
    const resultsDiv = document.getElementById("searchResults");
    resultsDiv.innerHTML = "";
    if (input.length < 1) return;
    products.filter(p => p.name.toLowerCase().includes(input)).forEach(p => {
        const div = document.createElement("div");
        div.classList.add("search-item");
        div.innerText = p.name;
        div.onclick   = () => addProduct(p);
        resultsDiv.appendChild(div);
    });
}

function addProduct(product) {
    if (selected.find(p => p.id === product.id)) return;
    selected.push(product);
    renderSelected();
    document.getElementById("productError").innerText         = "";
    document.getElementById("productSearch").value            = "";
    document.getElementById("searchResults").innerHTML        = "";
}

function renderSelected() {
    const container = document.getElementById("selectedProducts");
    container.innerHTML = "";
    selected.forEach((p, index) => {
        const div = document.createElement("div");
        div.className = "product-tag";
        div.innerHTML = `${p.name} <span onclick="removeProduct(${index})">&times;</span>`;
        container.appendChild(div);
    });
}

function removeProduct(index) {
    selected.splice(index, 1);
    renderSelected();
}


// ==========================================
// CHECK PRODUCTS
// ==========================================
function checkProducts() {
    if (selected.length === 0) {
        document.getElementById("productError").innerText = "Please select at least one product";
        return;
    }

    checkBtn.disabled   = true;
    checkBtn.innerText  = "Analyzing...";

    showStep("stepProductResult");
    popupResultBox.innerHTML = `<div class="result-card"><p>Analyzing your skincare products...</p></div>`;

    const formData = new FormData(skinForm);
    selected.forEach(p => formData.append("products[]", p.id));

    fetch("check_products_entry.php", { method: "POST", body: formData })
        .then(res => res.json())
        .then(data => {
            popupResultBox.innerHTML = "";

            if (data.error) {
                popupResultBox.innerHTML = `<div class="result-card"><p>${data.error}</p></div>`;
                return;
            }

            if (data.length === 0) {
                popupResultBox.innerHTML = `
                    <div class="result-card">
                        <h3>Great News 🎉</h3>
                        <p>Your products appear suitable for your skin.</p>
                    </div>`;
            } else {
                const grouped = {};
                data.forEach(r => {
                    if (!grouped[r.product]) grouped[r.product] = { brand: r.brand || "Unknown", image: r.image || "assets/images/default.png", items: [] };
                    grouped[r.product].items.push(r);
                });

                const sortedProducts = Object.keys(grouped).sort((a, b) =>
                    grouped[b].items.some(i => i.type === "danger") - grouped[a].items.some(i => i.type === "danger")
                );

                sortedProducts.forEach(product => {
                    const p         = grouped[product];
                    const goodCount = p.items.filter(i => i.type === "good").length;
                    const badCount  = p.items.filter(i => i.type === "danger").length;
                    const total     = goodCount + badCount;
                    const score     = total > 0 ? Math.round((goodCount / total) * 100) : 50;

                    const div = document.createElement("div");
                    div.innerHTML = `
<div class="review-product-card">
    <div class="review-product-image-box">
        <img src="${p.image}" class="review-product-image">
    </div>
    <div class="review-product-body">
        <div class="review-product-info">
            <h3>${product}</h3>
            <div class="review-brand">${p.brand}</div>
        </div>
        <div class="review-ingredient-list">
            ${p.items.map(i => `
                <div class="review-ingredient-card ${i.type}">
                    <div class="review-icon">${i.type === 'good' ? '✔' : i.type === 'danger' ? '⚠' : '•'}</div>
                    <div>
                        <div class="review-ingredient-name">${i.ingredient}</div>
                        <div class="review-ingredient-result">${i.result}</div>
                    </div>
                </div>
            `).join('')}
        </div>
        <div class="review-score ${score >= 70 ? 'good' : 'bad'}">${score}%</div>
    </div>
</div>`;
                    popupResultBox.appendChild(div);
                });
            }

            checkBtn.disabled  = false;
            checkBtn.innerText = "Analyze My Products";
        })
        .catch(err => {
            console.error(err);
            popupResultBox.innerHTML = `<div class="result-card"><p>Something went wrong.</p></div>`;
            checkBtn.disabled  = false;
            checkBtn.innerText = "Analyze My Products";
        });

    sessionStorage.setItem('modal_complete', '1');
}


// ==========================================
// FACE API
// ==========================================
async function loadFaceModel() {
    await faceapi.nets.tinyFaceDetector.loadFromUri('./models');
}

function updateHint(msg) { hint.innerText = msg; }

function smoothBox(newBox) {
    if (!lastBox) return newBox;
    const a = 0.7;
    return {
        x:      a * newBox.x      + (1 - a) * lastBox.x,
        y:      a * newBox.y      + (1 - a) * lastBox.y,
        width:  a * newBox.width  + (1 - a) * lastBox.width,
        height: a * newBox.height + (1 - a) * lastBox.height
    };
}

async function startCamera() {
    try {
        updateHint("Starting camera...");
        if (stream) stream.getTracks().forEach(t => t.stop());
        stream = await navigator.mediaDevices.getUserMedia({ video: { facingMode: "user" }, audio: false });
        video.srcObject = stream;
        await video.play();
        updateHint("Camera Ready ✔");
        await loadFaceModel();
        startFaceDetection();
    } catch (err) {
        console.error(err);
        alert("Camera access denied");
    }
}

function startFaceDetection() {
    faceInterval = setInterval(async () => {
        if (video.readyState !== 4 || captured) return;
        const detection = await faceapi.detectSingleFace(video, new faceapi.TinyFaceDetectorOptions({ inputSize: 416, scoreThreshold: 0.5 }));

        if (!detection) { updateHint("No face detected ❌"); stableFrames = 0; circle.style.borderColor = "#ef4444"; return; }

        const box      = detection.box;
        const dx       = (box.x + box.width  / 2) - video.videoWidth  / 2;
        const dy       = (box.y + box.height / 2) - video.videoHeight / 2;
        const inside   = (dx * dx + dy * dy) < (140 * 140);
        const faceRatio = box.width / video.videoWidth;

        if (faceRatio < 0.38) { updateHint("Move closer 🔍");          stableFrames = 0; circle.style.borderColor = "#f59e0b"; return; }
        if (faceRatio > 0.75) { updateHint("Move slightly back 📏");   stableFrames = 0; circle.style.borderColor = "#f59e0b"; return; }
        if (!inside)          { updateHint("Center your face 🎯");      stableFrames = 0; circle.style.borderColor = "#f59e0b"; return; }

        stableFrames++;
        circle.style.borderColor = "#10b981";
        updateHint(`Hold still (${stableFrames}/5)`);

        if (stableFrames >= 5 && !captured) {
            captured = true;
            clearInterval(faceInterval);
            updateHint("Perfect ✔ Capturing...");
            setTimeout(() => captureImage(detection.box), 700);
        }
    }, 250);
}

function captureImage(faceBox) {
    if (video.readyState !== 4) { alert("Camera not ready"); return; }
    const context = canvas.getContext("2d");
    canvas.width  = 224;
    canvas.height = 224;
    const padding = 60;
    const sx = Math.max(faceBox.x - padding, 0);
    const sy = Math.max(faceBox.y - padding, 0);
    const sw = Math.min(faceBox.width  + padding * 2, video.videoWidth  - sx);
    const sh = Math.min(faceBox.height + padding * 2, video.videoHeight - sy);
    context.imageSmoothingEnabled  = true;
    context.imageSmoothingQuality  = "high";
    context.filter = "brightness(1.08) contrast(1.05) saturate(1.02)";
    context.drawImage(video, sx, sy, sw, sh, 0, 0, 224, 224);

    const imageData  = context.getImageData(0, 0, canvas.width, canvas.height);
    const brightness = calculateBrightness(imageData);
    const sharpness  = calculateSharpness(imageData);

    if (brightness < 65) { captured = false; stableFrames = 0; updateHint("Lighting too dark 💡"); return; }
    if (sharpness  < 55) { captured = false; stableFrames = 0; updateHint("Image too blurry ❌");  return; }

    canvas.toBlob(function (blob) {
        const formData = new FormData();
        formData.append("image", blob, "capture.png");
        showStep("stepProcessing");

        fetch("analyze_entry.php", { method: "POST", body: formData })
            .then(res => res.json())
            .then(data => {
                if (data.problem_scores && !data.problem_scores_scaled) {
                    data.problem_scores_scaled = {};
                    Object.entries(data.problem_scores).forEach(([k, v]) => {
                        data.problem_scores_scaled[k.toLowerCase()] = Math.round(v * 100);
                    });
                }
                populateProfileFromAI(data);
                showStep("stepProfile");
            })
            .catch(err => {
                console.error(err);
                alert("Analysis failed. Please try again.");
                showStep("stepUpload");
            });
    }, "image/jpeg", 0.95);
}

function calculateBrightness(imageData) {
    const d = imageData.data; let t = 0;
    for (let i = 0; i < d.length; i += 4) t += (d[i] + d[i + 1] + d[i + 2]) / 3;
    return t / (d.length / 4);
}

function calculateSharpness(imageData) {
    const d = imageData.data; let t = 0;
    for (let i = 0; i < d.length; i += 4) t += d[i];
    return t / (d.length / 4);
}


// ==========================================
// CAMERA / UPLOAD BUTTONS
// ==========================================
cameraBtn.onclick = async function () {
    captured     = false;
    stableFrames = 0;
    lastBox      = null;
    preview.style.display = "none";
    showStep("stepUpload");
    setTimeout(async () => await startCamera(), 300);
};

uploadBtn.onclick = function () { fileInput.click(); };

fileInput.onchange = async function (event) {
    const file = event.target.files[0];
    if (!file) return;

    const reader   = new FileReader();
    reader.onload  = e => { preview.src = e.target.result; preview.style.display = "block"; };
    reader.readAsDataURL(file);

    const formData = new FormData();
    formData.append("image", file);
    showStep("stepProcessing");

    fetch("analyze_entry.php", { method: "POST", body: formData })
        .then(res => res.json())
        .then(data => {
            if (data.problem_scores && !data.problem_scores_scaled) {
                data.problem_scores_scaled = {};
                Object.entries(data.problem_scores).forEach(([k, v]) => {
                    data.problem_scores_scaled[k.toLowerCase()] = Math.round(v * 100);
                });
            }
            populateProfileFromAI(data);
            showStep("stepProfile");
        })
        .catch(err => {
            console.error(err);
            alert("Upload failed. Please try again.");
            showStep("stepUpload");
        });
};
