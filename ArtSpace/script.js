document.addEventListener('DOMContentLoaded', function() {
    const sliderImages = document.getElementById('sliderImages');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    const dotsContainer = document.getElementById('dots');
    const captionElement = document.getElementById('sliderCaption');
    
    const captions = window.sliderCaptions || [
        "🎨 Рисование: раскрой свой талант на холсте",
        "🏺 Лепка: создавай формы своими руками",
        "💻 Дизайн: от идеи до макета",
        "💧 Акварель: лёгкость и прозрачность цвета"
    ];
    
    if (sliderImages && prevBtn && nextBtn) {
        let images = document.querySelectorAll('.slider-img');
        let total = images.length;
        let currentIndex = 0;
        let autoInterval;
        
        function updateSlider() {
            sliderImages.style.transform = `translateX(-${currentIndex * 100}%)`;
            document.querySelectorAll('.dot').forEach((dot, i) => {
                dot.classList.toggle('active', i === currentIndex);
            });
            if (captionElement && captions[currentIndex]) {
                captionElement.style.opacity = '0';
                setTimeout(() => {
                    captionElement.textContent = captions[currentIndex];
                    captionElement.style.opacity = '1';
                }, 150);
            }
        }
        
        function nextSlide() {
            currentIndex = (currentIndex + 1) % total;
            updateSlider();
            resetAuto();
        }
        
        function prevSlide() {
            currentIndex = (currentIndex - 1 + total) % total;
            updateSlider();
            resetAuto();
        }
        
        function resetAuto() {
            if (autoInterval) clearInterval(autoInterval);
            autoInterval = setInterval(() => nextSlide(), 3000);
        }
        
        for (let i = 0; i < total; i++) {
            let dot = document.createElement('div');
            dot.classList.add('dot');
            if (i === currentIndex) dot.classList.add('active');
            dot.addEventListener('click', () => {
                currentIndex = i;
                updateSlider();
                resetAuto();
            });
            dotsContainer.appendChild(dot);
        }
        
        prevBtn.addEventListener('click', prevSlide);
        nextBtn.addEventListener('click', nextSlide);
        resetAuto();
        updateSlider();
        
        const sliderContainer = document.querySelector('.slider-container');
        if (sliderContainer) {
            sliderContainer.addEventListener('mouseenter', () => clearInterval(autoInterval));
            sliderContainer.addEventListener('mouseleave', resetAuto);
        }
    }
    
    document.querySelectorAll('.btn-primary, .btn-outline, .nav-item').forEach(btn => {
        btn.addEventListener('mousedown', () => btn.style.transform = 'scale(0.96)');
        btn.addEventListener('mouseup', () => btn.style.transform = '');
        btn.addEventListener('mouseleave', () => btn.style.transform = '');
    });
});