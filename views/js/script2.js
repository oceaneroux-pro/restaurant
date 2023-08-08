"use strict";

import Verify from ".//modules/Verify.js";

let btnConnexion;

function addClient(event){
    // event.preventDefault();
    $("span").remove();
    
    let mail = document.getElementById("mail").value;
    let mdp = document.getElementById("mdp").value;
    
    
    //instanciation nouvelle requête qui envoie les inputs
    let verify = new Verify();
    
    
    //new Request(nom, prenom, anniv, adresse, cp, pays, tel, mail);
    verify.mail = mail;
    verify.mdp = mdp;
    
    //console.log(name,mail,age);
    //console.log(request);
    //appel à la méthode qui consolelog les valeurs récupérés
    // verify.showValues();
    console.log(verify.newClient);
    
    if(verify.newClient.length != 2) // si le tableau newClient ne fait pas 9 alors on arrête l'envoi du formulaire
    {
        // console.log("form");
        event.preventDefault(); // arrête l'envoi du formulaire
    }
    
}

document.addEventListener('DOMContentLoaded',function(){
    
    btnConnexion = document.getElementById("bouton");
    //soumettre le formulaire
    btnConnexion.addEventListener("click",addClient);
});