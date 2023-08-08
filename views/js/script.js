"use strict";

import Verify from ".//modules/Verify.js";
// import Register from ".//modules/Register.js"

let btnCreateAccount;

function addClient(event){
    // event.preventDefault();
    $("span").remove();
    
    let nom = document.getElementById("nom").value;
    //console.log(nom);
    let prenom = document.getElementById("prenom").value;
    //console.log(prenom);
    let anniversaire = document.getElementById("anniversaire").value;
    console.log(anniversaire);
    let adresse = document.getElementById("adresse").value;
    //console.log(adresse);
    let codePostal = document.getElementById("codePostal").value;
    //console.log(codePostal);
    let pays = document.getElementById("pays").value;
    //console.log(pays);
    let tel = document.getElementById("tel").value;
    //console.log(tel);
    let mail = document.getElementById("mail").value;
    //console.log(mail);
    let mdp = document.getElementById("mdp").value;
    
    
    //instanciation nouvelle requête qui envoie les inputs
    let verify = new Verify();
    
    
    //new Request(nom, prenom, anniv, adresse, cp, pays, tel, mail);
    verify.nom = nom;
    verify.prenom = prenom;
    verify.anniversaire = anniversaire;
    verify.adresse = adresse;
    verify.codePostal = codePostal;
    verify.pays = pays;
    verify.tel = tel;
    verify.mail = mail;
    verify.mdp = mdp;
    
    //console.log(name,mail,age);
    //console.log(request);
    //appel à la méthode qui consolelog les valeurs récupérés
    // verify.showValues();
    console.log(verify.newClient);
    
    if(verify.newClient.length != 9) // si le tableau newClient ne fait pas 9 alors on arrête l'envoi du formulaire
    {
        // console.log("form");
        event.preventDefault(); // arrête l'envoi du formulaire
    }
    
}

document.addEventListener('DOMContentLoaded',function(){
    
    btnCreateAccount = document.getElementById("bouton");
    //soumettre le formulaire
    btnCreateAccount.addEventListener("click",addClient);
    
    
    
});