const banners = document.querySelectorAll(".banner");
const prevBtn = document.querySelector("#prevBtn");
const nextBtn = document.querySelector("#nextBtn");
const circles = document.querySelectorAll(".circle");

let indexBanner = 0;

banners[indexBanner].classList.add('active');
circles[indexBanner].classList.add('activecircle');


nextBtn.addEventListener("click", () => {
    banners[indexBanner].classList.remove('active');
    circles[indexBanner].classList.remove('activecircle');
    
    indexBanner++;
    if(indexBanner > banners.length-1){
        indexBanner = 0
    }
    banners[indexBanner].classList.add('active');
    circles[indexBanner].classList.add('activecircle');
   
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
});


circles.forEach( (circle, indexCircle) =>{
circle.addEventListener("click", () =>{
  banners[indexBanner].classList.remove('active');
  circles[indexBanner].classList.remove('activecircle');
         
  indexBanner = indexCircle;

  banners[indexBanner].classList.add('active');
    circles[indexBanner].classList.add('activecircle');

});
});