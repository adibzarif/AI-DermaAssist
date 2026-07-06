<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AI Skin Analysis - AI DermaAssist</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body class="analysis-page">

<?php include "header.php"; ?>

<div class="hero">

    <img src="assets/images/skin_analysis.jpg" class="hero-bg">
    <div class="hero-overlay"></div>

    <div class="hero-content">
        <span class="hero-badge">AI Powered Skin Consultation</span>
        <h1>Analyze Your Skin Using Advanced AI Technology</h1>
        <p>Discover your skin condition, analyze your current products,
           and receive personalized skincare recommendations instantly.</p>
        <button id="openAnalysisBtn" class="hero-btn">Start Analysis</button>
    </div>

    <div class="hero-preview">
        <div class="dashboard-preview">
            <div class="preview-card"><h3>Skin Health</h3><span>82%</span></div>
            <div class="preview-card"><h3>AI Confidence</h3><span>94%</span></div>
            <div class="preview-card"><h3>Detected</h3><span>Mild Acne</span></div>
        </div>
    </div>

</div>

<!-- TRUST SECTION -->
<section class="trust-section">
    <div class="section-header">
        <h2>Trusted AI Skin Analysis</h2>
        <p>Our intelligent dermatology assistant helps users understand their skin condition using advanced AI technology, ingredient matching, and personalized skincare recommendations.</p>
    </div>
    <div class="trust-container">
        <div class="trust-card"><h2>95%</h2><p>AI Detection Accuracy</p></div>
        <div class="trust-card"><h2>10K+</h2><p>Products Analyzed</p></div>
        <div class="trust-card"><h2>24/7</h2><p>Instant Skin Analysis</p></div>
        <div class="trust-card"><h2>500+</h2><p>Ingredients Database</p></div>
    </div>
</section>

<!-- HOW IT WORKS -->
<section class="how-section">
    <div class="section-header">
        <h2>How It Works</h2>
        <p>Simple AI-powered skincare consultation flow</p>
    </div>
    <div class="steps-grid">
        <div class="step-card">
            <div class="step-number">01</div>
            <h3>Face Analysis</h3>
            <p>Upload or capture your face for AI skin detection first.</p>
        </div>
        <div class="step-card">
            <div class="step-number">02</div>
            <h3>Complete Skin Profile</h3>
            <p>Review your AI results and tell us more about your skin.</p>
        </div>
        <div class="step-card">
            <div class="step-number">03</div>
            <h3>Get Recommendations</h3>
            <p>Analyze your current products and get personalized picks.</p>
        </div>
    </div>
</section>

<!-- CTA SECTION -->
<section class="analysis-cta">
    <div class="analysis-cta-card">
        <h2>Ready To Start Your AI Skin Consultation?</h2>
        <p>Experience personalized AI-powered skincare analysis.</p>
        <button id="startAnalysisBtn" class="primary-btn">Start Free Analysis</button>
    </div>
</section>


<!-- =========================================
     MAIN ANALYSIS MODAL
========================================= -->
<div id="analysisModal" class="analysis-modal">
    <div class="modal-wrapper">

        <button id="closeModalBtn" class="close-modal-btn">&times;</button>

        <!-- SIDEBAR -->
        <div class="modal-sidebar">
            <h2>AI Skin Consultation</h2>
            <div class="progress-steps">
                <div class="progress-step active"><span>1</span> Face Analysis</div>
                <div class="progress-step"><span>2</span> Skin Profile</div>
                <div class="progress-step"><span>3</span> Product Review</div>
                <div class="progress-step"><span>4</span> Recommendations</div>
            </div>
        </div>

        <!-- MAIN CONTENT -->
        <div class="modal-main">

            <!-- STEP 1: FACE UPLOAD / CAMERA -->
            <div id="stepUpload" class="modal-step active">
                <div class="step-header">
                    <h2>AI Face Analysis</h2>
                    <p>Upload or capture your face so our AI can detect your skin condition.</p>
                </div>
                <div class="upload-layout">
                    <div class="upload-actions">
                        <button id="uploadBtn" class="upload-btn">Upload Image</button>
                        <button id="cameraBtn" class="upload-btn">Use Camera</button>
                    </div>
                    <div class="preview-area">
                        <div class="camera-frame">
                            <video id="cameraVideo" autoplay muted playsinline></video>
                            <div id="faceCircle"></div>
                        </div>
                        <p id="faceHint"></p>
                        <img id="previewImage" class="preview-image">
                    </div>
                </div>
                <input type="file" id="fileInput" accept="image/*" hidden>
                <canvas id="canvas" style="display:none;"></canvas>
            </div>

            <!-- STEP 2: PROCESSING -->
            <div id="stepProcessing" class="modal-step">
                <div class="processing-box">
                    <div class="loader"></div>
                    <h2>AI Analyzing Your Skin...</h2>
                    <p id="processingText">Detecting skin texture...</p>
                </div>
            </div>

            <!-- STEP 3: SKIN PROFILE -->
            <div id="stepProfile" class="modal-step">
                <div class="step-header">
                    <h2>Your Skin Profile</h2>
                    <p>AI has analyzed your skin. Review the results and complete your profile.</p>
                </div>

                <!-- AI RESULT BANNER -->
                <div id="aiResultBanner" class="ai-result-banner">
                    <div class="ai-result-scores">
                        <div class="ai-score-item">
                            <span class="ai-score-label">Skin Type</span>
                            <span id="aiSkinType" class="ai-score-value">—</span>
                        </div>
                        <div class="ai-score-item">
                            <span class="ai-score-label">Skin Tone</span>
                            <span id="aiSkinTone" class="ai-score-value">—</span>
                        </div>
                        <div class="ai-score-item">
                            <span class="ai-score-label">Top Concern</span>
                            <span id="aiTopConcern" class="ai-score-value">—</span>
                        </div>
                    </div>
                    <div style="border-top: 1px solid #e2e8f0; margin-bottom: 16px;"></div>
                    <div class="ai-score-bars" id="aiScoreBars"></div>
                </div>

                <div id="viewFullResultWrap" style="text-align:center; margin: 4px 0 20px; display:none;">
                    <a href="analyze_entry.php" target="_blank" class="view-full-btn">
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M9 17v-2m3 2v-4m3 4v-6M5 20h14a2 2 0 002-2V7l-5-5H5a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                        </svg>
                        View Full Result Report
                    </a>
                </div>

                <form id="skinForm">

                    <div class="form-group">
                        <label>Confirm Skin Type <small style="color:#888">(AI detected above)</small></label>
                        <small class="error-msg" id="skinTypeError"></small>
                        <div class="modern-options">
                            <label class="option-card"><input type="radio" name="skin_type" value="normal"><span>Normal</span></label>
                            <label class="option-card"><input type="radio" name="skin_type" value="oily"><span>Oily</span></label>
                            <label class="option-card"><input type="radio" name="skin_type" value="dry"><span>Dry</span></label>
                            <label class="option-card"><input type="radio" name="skin_type" value="combination"><span>Combination</span></label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Confirm Skin Concerns <small style="color:#888">(AI detected above)</small></label>
                        <small class="error-msg" id="concernError"></small>
                        <div class="modern-options">
                            <label class="option-card"><input type="checkbox" name="skin_problem[]" value="acne"><span>Acne</span></label>
                            <label class="option-card"><input type="checkbox" name="skin_problem[]" value="wrinkles"><span>Wrinkles</span></label>
                            <label class="option-card"><input type="checkbox" name="skin_problem[]" value="dark_spots"><span>Dark Spots</span></label>
                            <label class="option-card"><input type="checkbox" name="skin_problem[]" value="redness"><span>Redness</span></label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>How often do you wash your face?</label>
                        <small class="error-msg" id="washError"></small>
                        <div class="modern-options">
                            <label class="option-card"><input type="radio" name="face_wash" value="1"><span>Once</span></label>
                            <label class="option-card"><input type="radio" name="face_wash" value="2"><span>Twice</span></label>
                            <label class="option-card"><input type="radio" name="face_wash" value="3+"><span>More Than Twice</span></label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Do you experience breakouts?</label>
                        <small class="error-msg" id="breakoutError"></small>
                        <div class="modern-options">
                            <label class="option-card"><input type="radio" name="breakouts" value="yes"><span>Yes</span></label>
                            <label class="option-card"><input type="radio" name="breakouts" value="sometimes"><span>Sometimes</span></label>
                            <label class="option-card"><input type="radio" name="breakouts" value="no"><span>No</span></label>
                        </div>
                    </div>

                    <div class="form-submit">
                        <button type="button" class="primary-btn" onclick="goToProductReview()">
                            Continue to Product Review →
                        </button>
                    </div>

                </form>
            </div>

            <!-- STEP 4: PRODUCT REVIEW -->
            <div id="stepProductReview" class="modal-step">
                <div class="step-header">
                    <h2>Your Current Products</h2>
                    <p>Add the skincare products you currently use so we can check compatibility.</p>
                </div>
                <div class="form-group">
                    <label>Search Your Products</label>
                    <input type="text" id="productSearch" placeholder="Search product..." onkeyup="searchProducts()">
                    <div id="searchResults" class="search-results"></div>
                </div>
                <div class="form-group">
                    <label>Your Selected Products</label>
                    <div id="selectedProducts" class="selected-products"></div>
                    <small class="error-msg" id="productError"></small>
                </div>
                <div class="step-actions">
                    <button onclick="showStep('stepProfile')" class="secondary-btn">← Back</button>
                    <button id="checkBtn" class="primary-btn" onclick="checkProducts()">
                        Analyze My Products
                    </button>
                </div>
            </div>

            <!-- STEP 5: PRODUCT RESULT + RECOMMEND -->
            <div id="stepProductResult" class="modal-step">
                <div class="step-header">
                    <h2>Product Compatibility Result</h2>
                    <p>AI analysis based on your current skincare products.</p>
                </div>
                <div id="popupResultBox" class="result-dashboard"></div>
                <div class="step-actions" style="margin-top: 24px;">
                    <button onclick="showStep('stepProductReview')" class="secondary-btn">← Back</button>
                    <a id="recommendBtn" href="recommend_entry.php" class="primary-btn">
                        View Recommended Products →
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>


<?php include "footer.php"; ?>

<script src="https://cdn.jsdelivr.net/npm/face-api.js@0.22.2/dist/face-api.min.js"></script>

<!-- Products list injected by controller (no raw DB calls in view) -->
<script>
const products = <?= json_encode($products) ?>;
</script>

<script src="assets/js/skin_analysis.js"></script>

<!-- Auto-open modal if redirected from analyze page -->
<script>
const urlParams = new URLSearchParams(window.location.search);
if (urlParams.get('openModal') === '1') {
    modal.classList.add("show");
    <?php if (isset($_SESSION['latest_analysis'])): ?>
    const sessionResult = <?= json_encode($_SESSION['latest_analysis']) ?>;
    populateProfileFromAI(sessionResult);
    showStep("stepProfile");
    <?php else: ?>
    showStep("stepUpload");
    <?php endif; ?>
}

if (urlParams.get('incomplete') === '1') {
    const notice = document.createElement('div');
    notice.style.cssText = `
        position:fixed; bottom:24px; left:50%; transform:translateX(-50%);
        background:#1e293b; color:#fff; padding:12px 24px; border-radius:8px;
        font-size:13px; font-weight:500; z-index:99999; box-shadow:0 4px 20px rgba(0,0,0,.3);
        white-space:nowrap;
    `;
    notice.textContent = '⚠️ Please complete your skin profile & product review first.';
    document.body.appendChild(notice);
    setTimeout(() => notice.remove(), 4000);
}
</script>

</body>
</html>
