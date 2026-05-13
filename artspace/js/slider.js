const slides = document.querySelectorAll('.slide');

let current = 0;

function showSlide(index){

    slides.forEach(slide => {
        slide.classList.remove('active');
    });

    slides[index].classList.add('active');
}

function nextSlide(){

    current++;

    if(current >= slides.length){
        current = 0;
    }

    showSlide(current);
}

function prevSlide(){

    current--;

    if(current < 0){
        current = slides.length - 1;
    }

    showSlide(current);
}

setInterval(nextSlide,3000);

document.querySelector('.next').addEventListener('click',nextSlide);
document.querySelector('.prev').addEventListener('click',prevSlide);