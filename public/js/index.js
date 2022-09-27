window.addEventListener("DOMContentLoaded", function () {
    let form_recipe = document.getElementById("form_recipe");

    form_recipe.addEventListener(
        "submit",
        function () {
            window.confirm("削除しますか？");
        },
        false
    );
});
