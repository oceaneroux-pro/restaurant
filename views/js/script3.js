"use strict"

let selectMeal;


function onSelectMeal(){
    $.get("php/Meal.php","num="+$("#num_order").val(),displayMeals)
}

function displayMeals(meal){
    $("#affichage").html(meal);
}



document.addEventListener("DOMContentLoaded",function(){
    
    selectMeal = document.getElementById("selecteur");
    
    selectMeal.addEventListener("select",displayMeals);
})