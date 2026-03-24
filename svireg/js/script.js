let passwords = document.querySelectorAll(".password");
let message = document.querySelector("#message");
let submit = document.querySelector("#submit");
passwords.forEach((elem)=>{
    elem.addEventListener("input", ()=>{
        if(passwords[0].value !== passwords[1].value) {
            message.style.color = "red";
            message.textContent = "Введенные пароли не совпадают"; 
            submit.setAttribute("disabled", "");
        } else {
            message.textContent = "Введенные пароли совпадают";
            message.style.color = "green";
            submit.removeAttribute("disabled");
        }
});
});






















