let search = document.querySelector("#search");
let gameItem = document.querySelectorAll(".game_item");

search.addEventListener("input", () =>
{
    const searchText = search.value.toLowerCase();
    gameItem.forEach(game =>
    {
        const title = game.querySelector("h3").textContent.toLowerCase();
        if (title.includes(searchText))
        {
            game.style.display = "flex";
        } else
        {
            game.style.display = "none";
        }
    })
});