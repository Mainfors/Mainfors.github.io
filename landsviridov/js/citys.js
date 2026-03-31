const form = document.querySelector("#cityform");
const cityinput = document.querySelector("#Cityinput");
const status = document.querySelector("#status");
const history = document.querySelector("#history");

const usedCity = new Set ();
let lastletter = null;

form.addEventListener ("submit", (event) =>{
    event.preventDefault();
    const city = cityinput.value;
    const citynorm = city.trim().toLowerCase();
   
    if(citynorm === ""){
        status.textContent = "Введите Город";
        status.style.color = "red";
        return;
    } 
    if(usedCity.has(citynorm)){
        status.textContent = ("Город был введен");
        status.style.color = "red";
        return;
    }
    


    if( lastletter !== null && lastletter !== citynorm[0]){
         status.textContent = ("Неправильно, Вам нужна буква: " + lastletter.toUpperCase());
         status.style.color = "red";
         return;
    } 
    
    
    
    
    
    usedCity.add(citynorm);
    
    
    const li = document.createElement("li");
    li.textContent = city;
    history.appendChild(li);
    
    const badlet = new Set(["ь", "ы", "ъ", "й"]);
    let lastindex = citynorm.length-1
        for( let i = lastindex; i >= 0; i--){
            if(!badlet.has(citynorm[i])){
                lastletter = citynorm[i];
                break;
            };
        };


   
    status.textContent = ("Следующий город на букву - " +  lastletter.toUpperCase());
    
    cityinput.value = "";
});
