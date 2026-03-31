const selectgenres = document.querySelector("#filtergenre");
const games = document.querySelectorAll(".game_item");

selectgenres.addEventListener("change", () =>
{
    let genres = selectgenres.value;
    games.forEach(game =>
    {
        if (game.dataset.genre === genres || genres == 'all')
        {
            game.style.display = "flex";
        } else
        {
            game.style.display = "none";
        }
    })
});