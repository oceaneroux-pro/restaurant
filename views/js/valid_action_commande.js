"use strict"

let selectMeal;
let btnAdd;
let quantity;
let panier = [];
let recupDetails;
let total;
let btnValider;
let totalPanier = 0;

function loadDetails(){
    let selectedOption = selectMeal.value;
    console.log(selectedOption);
    console.log($.get("index.php?action=cmdAjax","id="+selectedOption,displayMeal));
}


function displayMeal(details)
{
    // json --> js 
    details = JSON.parse(details);
    recupDetails = details;
    console.log(details);
    
    let div = document.querySelector('#affichage');
    div.innerHTML = "<h4>"+details.titre+"</h4>"+
                    "<img src='views/images/meals/"+details.image+"' class='imgCmd'>"+
                    "<p><small>"+details.details+"</small></p>"+
                    "<p>Prix: "+details.prix_unité+"€</p>";
    
}

function addCart(event){
    event.preventDefault();
    //ajoute une case avec les infos du repas et quantité commandée dans un tableau global.
    // let selectedOption = selectMeal.value;
    
    let chosenQuantity = parseInt(quantity.value);
    
    let oneItem =
    {
        produit: recupDetails,
        quantite: chosenQuantity
    };
    
    panier.push(oneItem);
    console.log(panier);
    
    saveLocalStorage();
    loadLocalStorage();
    affichage();
    
}

function saveLocalStorage()
{
    //une fnct qui permet d'enregistrer dans le localStorage  
    // js --> json 
    panier = JSON.stringify(panier);
    window.localStorage.setItem("panier",panier);
}


function loadLocalStorage()
{
    panier = window.localStorage.getItem("panier");
    
    if(panier == null)
    {
        panier = [];
    }
    else
    {
        panier = JSON.parse(panier); //json --> js
    }

}


function affichage(){
    
    $('#target').empty();
    
    totalPanier = 0;
    
    let table = '<table>' +'<thead>' +'<tr>' +
                            '<th>Product Name</th>' +
                            '<th>Description</th>' +
                            '<th>Price</th>' +
                            '<th>Quantity</th>' +
                            '<th>Total</th>' +
                        '</tr>' +'</thead>' +'<tbody>';
    
    for(let i=0;i<panier.length;i++)
    {
        
        let total=panier[i].quantite*panier[i].produit.prix_unité;
        totalPanier += panier[i].quantite*panier[i].produit.prix_unité; 
        
        
         let row = '<tr>' +
                        '<td>' + panier[i].produit.titre + '</td>' +
                        '<td>' + panier[i].produit.details + '</td>' +
                        '<td>' + panier[i].produit.prix_unité + '€</td>' +
                        '<td>' + panier[i].quantite + '</td>' +
                        '<td>' + total + '</td>' +
                   '</tr>';
                      
        table += row;
         
    }
    
    let totalRow = '<tr>' +
                      '<td colspan="4"><strong>Panier</strong>:</td>' +
                      '<td>' + totalPanier + '€</td>' +
                    '</tr>';
    table += totalRow;
    table += '</tbody></table>';

    $("#target").append(table);
}

function passerCommande(event)
{
  event.preventDefault();
  loadLocalStorage();
  panier = JSON.stringify(panier);  // Convertir le tableau de commande en chaîne JSON
  console.log(panier);
  console.log($.ajax(                           
    {
        url: "index.php?action=cmdAjax",    // Envoyer la requête AJAX
        type: 'GET',
        data: {
          commande: panier,
          total: totalPanier
        },
    
    dataType: 'json',
    
    // Réinitialiser le tableau global et vider le localStorage
   
    success: function(response)
    {
        console.log("coucou");
      validOrder(response);    
    },
    error: function(jqXHR, textStatus, errorThrown) 
    {
        console.log("erreur");
    //   console.error('Erreur lors de la validation de la commande : ' + textStatus + ', ' + errorThrown);
    }
    }));
    
    // console.log($.ajax);
}


function validOrder() {
    
//   event.preventDefault();
  panier = []; // Réinitialiser le tableau global
  saveLocalStorage();
  loadLocalStorage();
  window.localStorage.removeItem('panier');  // Vider le localStorage
  affichage();   // Actualiser la vue
}




document.addEventListener("DOMContentLoaded",function(){
    
    
    //gestionnaire d’événement avec écouteur d’événement au changement de valeur de la liste déroulante
    selectMeal = document.getElementById("selecteur");
    btnAdd = document.getElementById("bouton");
    quantity = document.getElementById("quantity");
    btnValider = document.getElementById("commander");
    
    selectMeal.addEventListener("change",loadDetails);
    btnAdd.addEventListener("click",addCart);
    btnValider.addEventListener("click",passerCommande);
})