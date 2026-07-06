<?php
session_start();
$loggedIn = isset($_SESSION['user_id']);
?>

<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>AI-DermaAssist</title>

<link rel="stylesheet" href="assets/css/style.css">

<link rel='stylesheet' href='assets/css/style.css'>
<meta name="viewport" content="width=device-width, initial-scale=1">

</head>

<body>

<?php include "header.php"; ?>



<!-- ================= HERO SECTION ================= -->
<section class="hero">

    <img src="assets/images/hero-skin-ai.png" class="hero-bg">

    <div class="hero-overlay"></div>

    <div class="hero-content">
        <h1>Reveal Your Skin’s True Potential</h1>

        <p>
        AI-powered analysis designed to understand your skin,
        detect concerns, and guide your skincare journey.
        </p>

        <div class="hero-buttons">
            <a href="#features" class="btn primary">Learn More</a>
        </div>
    </div>

</section>




<!-- ================= ABOUT ================= -->
<section class="about">
<div class="container about-wrapper">

    <div class="about-text">

        <span>ABOUT AI-DERMAASSIST</span>

        <h2>
        Personalized AI Skincare
        Designed For Everyone
        </h2>

        <p>
        AI-DermaAssist is an intelligent skincare platform
        that helps users better understand their skin
        using advanced artificial intelligence technology.
        </p>

        <p>
        By analyzing facial images, our system can detect
        common skin concerns such as acne, pigmentation,
        wrinkles, dryness, and uneven skin tone in seconds.
        </p>

        <p>
        We combine machine learning with dermatology-based
        knowledge to provide smarter skincare insights,
        personalized recommendations, and a more confident
        skincare journey for every user.
        </p>

        <a href="#features" class="btn">
        Explore Features
        </a>

    </div>

    <div class="about-image">
        <img src="assets/images/about.jpg">
    </div>

</div>
</section>


<!-- ================= FEATURES ================= -->
<section id="features" class="features">
<div class="container">
<h2>Smart Skincare Features</h2>

<div class="feature-grid">

<div class="feature-card" data-aos="fade-up">
<h3>AI Skin Analysis</h3>
<p>
Upload a facial image and our AI detects
possible skin conditions instantly.
</p>
</div>

<div class="feature-card" data-aos="fade-up">
<h3>Ingredient Safety Detection</h3>
<p>
Check cosmetic ingredients and detect
potentially harmful substances.
</p>
</div>

<div class="feature-card" data-aos="fade-up">
<h3>Price Comparison</h3>
<p>
Compare skincare product prices across
multiple online stores.
</p>
</div>

<div class="feature-card" data-aos="fade-up">
<h3>Product Recommendations</h3>
<p>
Receive skincare products recommended
for your skin condition.
</p>
</div>

</div>
</div>
</section>


<!-- ================= RESULTS PREVIEW ================= -->
<!--<section class="results-preview">
<div class="container">
<h2>Real Skin Insights</h2>

<p>See how AI detects skin conditions and provides detailed analysis.</p>

<div class="results-grid">

<div class="result-card" data-aos="fade-up">
<img src="assets/images/acne.jpg">
<p>Before Analysis</p>
</div>

<div class="result-card" data-aos="fade-up">
<img src="assets/images/acne_result.png" >
<p>AI Skin Detection Result</p>
</div>

</div>
</div>
</section>
-->

<!-- ================= HOW IT WORKS ================= -->
<section class="how-it-works">
<div class="container">

<h2>How AI-DermaAssist Works</h2>

<p class="section-text">
Our intelligent system makes skincare analysis simple,
fast, and accessible for everyone in just a few steps.
</p>

<div class="timeline">

<div class="timeline-item" data-aos="fade-up">
    <div class="circle">1</div>

    <h3>Upload Your Image</h3>

    <p>
    Upload a clear facial image using your device camera
    or gallery for analysis.
    </p>
</div>

<div class="line"></div>

<div class="timeline-item" data-aos="fade-up">
    <div class="circle">2</div>

    <h3>AI Skin Detection</h3>

    <p>
    Our AI analyzes your skin condition using deep
    learning models trained on dermatology datasets.
    </p>
</div>

<div class="line"></div>

<div class="timeline-item" data-aos="fade-up">
    <div class="circle">3</div>

    <h3>Receive Insights</h3>

    <p>
    View detailed skin analysis results including
    detected concerns and condition explanations.
    </p>
</div>

<div class="line"></div>

<div class="timeline-item" data-aos="fade-up">
    <div class="circle">4</div>

    <h3>Get Recommendations</h3>

    <p>
    Discover skincare product recommendations and
    ingredient guidance suitable for your skin.
    </p>
</div>

</div>
</div>
</section>


<!-- ================= TESTIMONIALS ================= 
<section class="testimonials">
<div class="container">
<h2>What Our Users Say</h2>

<div class="testimonial-grid">

<div class="testimonial-card" data-aos="fade-up">
<p>
"This AI analysis helped me understand my acne problem better. Highly recommended!"
</p>
<h4>- Sarah L.</h4>
</div>

<div class="testimonial-card" data-aos="fade-up">
<p>
"I love how fast and accurate the results are. It feels like having a dermatologist online."
</p>
<h4>- Jason K.</h4>
</div>

<div class="testimonial-card" data-aos="fade-up">
<p>
"The product recommendations actually worked for my skin. Amazing!"
</p>
<h4>- Nur Aisyah</h4>
</div>

</div>
</div>
</section>
-->

<!-- ================= SKIN CONDITIONS ================= -->
<section class="conditions">

<div class="container">

<span>SKIN CONDITIONS</span>

<h2>
Common Skin Concerns
We Can Detect
</h2>

<p class="section-text">
Our AI model is trained to identify multiple types
of common skin conditions through facial image analysis.
</p>

<div class="conditions-list">

<div>
    <h3>Acne</h3>
    <p>
    Detect pimples, inflammation,
    blackheads, and acne-prone areas.
    </p>
</div>

<div>
    <h3>Pigmentation</h3>
    <p>
    Identify uneven skin tone,
    dark spots, and discoloration.
    </p>
</div>

<div>
    <h3>Wrinkles</h3>
    <p>
    Analyze fine lines and visible
    signs of skin aging.
    </p>
</div>

<div>
    <h3>Dry Skin</h3>
    <p>
    Detect rough texture,
    dehydration, and skin dryness.
    </p>
</div>

</div>

</div>
</section>


<!-- ================= TRUST ================= -->
<section class="trust-banner">

<div class="container">

<span>WHY USERS TRUST US</span>

<h2>
AI Technology Built With
Privacy, Accuracy, and Care
</h2>

<p>
AI-DermaAssist is designed to provide a safe and
intelligent skincare experience for every user.
</p>

<p>
Our platform focuses on secure image processing,
fast AI analysis, and dermatology-based insights
to help users make better skincare decisions.
</p>

<p>
We believe technology should make skincare easier,
more accessible, and more personalized without
making the experience complicated.
</p>

</div>
</section>


<!-- ================= CTA ================= -->
<section class="cta" >
<div class="container">
<h2>Start Your AI Skin Analysis</h2>

<p>
Upload your image and receive instant skincare insights.
</p>

<a href="<?= $loggedIn ? 'skin_analysis.php' : 'login_signup.php' ?>" class="btn">
Analyze My Skin
</a>
</div>
</section>


<!-- ================= CUSTOMER SERVICE ================= -->
<section id="customer-service" class="support">
<div class="container">
<h2>Customer Service</h2>

<div class="support-grid">

<div class="support-card">
<h3>Contact Us</h3>
<p>Email: support@aidermassist.com</p>
<p>Phone: +60 123 456 789</p>
</div>

<!-- ================= CUSTOMER SERVICE ================= 
<div class="support-card" data-aos="fade-up">
<h3>Working Hours</h3>
<p>Mon - Fri: 9AM - 6PM</p>
<p>Sat - Sun: Closed</p>
</div>
-->
<div class="support-card" >
<h3>Help Center</h3>
<p>Get help with skin analysis, product recommendations, and more.</p>
</div>

</div>
</div>
</section>


<!-- ================= FAQ ================= -->
<section id="faqs" class="faq">
<div class="container">
<h2>FAQs</h2>

<div class="faq-container">

<div class="faq-item">
<button class="faq-question">
How accurate is the AI analysis?
</button>

<div class="faq-answer">
<p>
Our AI model is trained using dermatology-related datasets
to identify common skin concerns with high accuracy.
However, results should be used as guidance and not as a
medical diagnosis.
</p>
</div>
</div>


<div class="faq-item">
<button class="faq-question">
Do I need to create an account?
</button>

<div class="faq-answer">
<p>
Users can explore the platform freely, but creating an
account allows you to save analysis history and receive
personalized skincare recommendations.
</p>
</div>
</div>


<div class="faq-item">
<button class="faq-question">
What skin conditions can the AI detect?
</button>

<div class="faq-answer">
<p>
Our system can detect common skin concerns such as acne,
pigmentation, wrinkles, dryness, dark spots, and uneven
skin tone.
</p>
</div>
</div>


<div class="faq-item">
<button class="faq-question">
Can I use AI-DermaAssist on mobile devices?
</button>

<div class="faq-answer">
<p>
Yes. AI-DermaAssist is fully responsive and works on
smartphones, tablets, and desktop devices for a seamless
experience.
</p>
</div>
</div>


<div class="faq-item">
<button class="faq-question">
How long does the analysis take?
</button>

<div class="faq-answer">
<p>
Most analyses are completed within a few seconds after
uploading your facial image.
</p>
</div>
</div>


<div class="faq-item">
<button class="faq-question">
Are the skincare recommendations personalized?
</button>

<div class="faq-answer">
<p>
Yes. Recommendations are generated based on your detected
skin concerns and ingredient compatibility.
</p>
</div>
</div>


<div class="faq-item">
<button class="faq-question">
Is my uploaded image stored permanently?
</button>

<div class="faq-answer">
<p>
No. User privacy is important to us. Uploaded images are
securely processed and are not permanently stored without
your permission.
</p>
</div>
</div>


<div class="faq-item">
<button class="faq-question">
Can AI-DermaAssist replace a dermatologist?
</button>

<div class="faq-answer">
<p>
AI-DermaAssist is designed to provide skincare guidance
and educational insights. For medical concerns, users
should consult a licensed dermatologist.
</p>
</div>
</div>

</div>

<script>
document.querySelectorAll(".faq-question").forEach(btn => {
    btn.addEventListener("click", () => {
        const answer = btn.nextElementSibling;
        answer.style.display =
            answer.style.display === "block" ? "none" : "block";
    });
});
</script>

</section>

</div>



<?php include "footer.php"; ?>

<link rel="stylesheet"
href="https://unpkg.com/aos@2.3.1/dist/aos.css"/>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

<script>
AOS.init({
    duration:1000,
    once:true
});
</script>
</body>
</html>