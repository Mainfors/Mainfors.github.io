const banners = document.querySelectorAll(".banner");
const prevBtn = document.querySelector("#prevBtn");
const nextBtn = document.querySelector("#nextBtn");
const circles = document.querySelectorAll(".circle");
const countSlide = document.querySelector("#allslides");
const currentlide = document.querySelector("#curretslide");

let indexBanner = 0;
let timerslider = 0; 

function nextSlide (){
       banners[indexBanner].classList.remove('active');
    circles[indexBanner].classList.remove('activecircle');
    
    indexBanner++;
    if(indexBanner > banners.length-1){
        indexBanner = 0
    }
    banners[indexBanner].classList.add('active');
    circles[indexBanner].classList.add('activecircle');
   
}

banners[indexBanner].classList.add('active');
circles[indexBanner].classList.add('activecircle');
currentlide.textcontent = indexBanner + 1;


nextBtn.addEventListener("click", () => {
   nextSlide();
   startslider();
});


prevBtn.addEventListener("click", () => {
    banners[indexBanner].classList.remove('active');
    circles[indexBanner].classList.remove('activecircle');
    indexBanner--;
    if(indexBanner < 0){
        indexBanner = banners.length-1;
    }
    banners[indexBanner].classList.add('active');
    circles[indexBanner].classList.add('activecircle');
    startslider();
});


circles.forEach( (circle, indexCircle) =>{
circle.addEventListener("click", () =>{
 nextSlide()

});
});


function startslider(){
    clearInterval(timerslider); // очищает функцию
    timerslider = setInterval(() => {
        nextSlide();
    }, 3000);
    
};


banners.forEach(banner => {
    banner.addEventListener("mouseenter", () =>{
        clearInterval(timerslider);
    });

});

banners.forEach(banner =>{
    banner.addEventListener("mouseleave", () =>{
        startslider();
    });
});

startslider();



