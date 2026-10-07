/**
 * SiKlinik - Hero Image Slider / Carousel JS
 * Controls the automatic transition, next/prev arrows, and dots.
 */

document.addEventListener('DOMContentLoaded', () => {
    const slides = document.querySelectorAll('.hero-slide');
    const dots = document.querySelectorAll('.hero-indicator-dot');
    const prevBtn = document.querySelector('.hero-prev');
    const nextBtn = document.querySelector('.hero-next');
    
    // Only run if there are multiple slides (more than 1)
    if (slides.length <= 1) return;

    let currentIndex = 0;
    let slideInterval;
    const intervalTime = 4000; // 4 seconds auto-play

    // Function to show a specific slide
    const showSlide = (index) => {
        // Remove active class from all slides and dots
        slides.forEach(slide => slide.classList.remove('active'));
        dots.forEach(dot => dot.classList.remove('active'));

        // Handle index bounds
        if (index >= slides.length) {
            currentIndex = 0;
        } else if (index < 0) {
            currentIndex = slides.length - 1;
        } else {
            currentIndex = index;
        }

        // Add active class to current slide and dot
        slides[currentIndex].classList.add('active');
        if (dots[currentIndex]) {
            dots[currentIndex].classList.add('active');
        }
    };

    // Next slide action
    const nextSlide = () => {
        showSlide(currentIndex + 1);
    };

    // Previous slide action
    const prevSlide = () => {
        showSlide(currentIndex - 1);
    };

    // Auto-play control
    const startAutoPlay = () => {
        stopAutoPlay(); // Prevents multiple intervals running
        slideInterval = setInterval(nextSlide, intervalTime);
    };

    const stopAutoPlay = () => {
        if (slideInterval) {
            clearInterval(slideInterval);
        }
    };

    // Event listeners for controls
    if (nextBtn) {
        nextBtn.addEventListener('click', () => {
            nextSlide();
            startAutoPlay(); // Reset timer on click
        });
    }

    if (prevBtn) {
        prevBtn.addEventListener('click', () => {
            prevSlide();
            startAutoPlay(); // Reset timer on click
        });
    }

    // Dots navigation
    dots.forEach((dot, idx) => {
        dot.addEventListener('click', () => {
            showSlide(idx);
            startAutoPlay(); // Reset timer on click
        });
    });

    // Pause autoplay on mouse hover over the slider
    const heroSection = document.querySelector('.hero-section');
    if (heroSection) {
        heroSection.addEventListener('mouseenter', stopAutoPlay);
        heroSection.addEventListener('mouseleave', startAutoPlay);
    }

    // Initialize auto play
    startAutoPlay();
});
