"use strict";

import Error from "./Error.js";
// import Register from "./Register.js"

class Verify {
    constructor(){
        
        this._nom = "";
        this._prenom = "";
        this._anniversaire = "";
        this._adresse = "";
        this._codePostal = "";
        this._pays = "";
        this._tel = "";
        this._mail = "";
        this._mdp = "";
        
        this.newClient = [];
        
    }
    
/************************************************************************************/
/* *********************************** GETTERS **************************************/
/************************************************************************************/

    get nom(){
        return this._nom;
    }
    get prenom(){
        return this._prenom;
    }
    get anniversaire(){
        return this._anniversaire;
    }
    
    get adresse(){
        return this._adresse;
    }
    
    get codePostal(){
        return this._codePostal;
    }
    
    get pays(){
        return this._pays;
    }
    
    get tel(){
        return this._tel;
    }
    
    get mail(){
        return this._mail;
    }
    
    get mdp(){
        return this._mdp;
    }
    
/************************************************************************************/
/* *********************************** SETTERS **************************************/
/************************************************************************************/   
    
    
    //SETTER NOM
    set nom(nomInput){ // ne doit être pas vide condition = pas moins de 2 caractères, pas de nombres
    
        let nomRegex = new RegExp(/^[A-Za-zéèê-]+$/);
        
        if(nomInput.length > 2 && nomRegex.test(nomInput)){
            // let register = new Register();
            // register.saveInStorage("name",nameInput)
            this.newClient.push(nomInput);
        }
        else{
            console.log("Erreur nom");
            let erreur = new Error("nom","Veuillez entrer plus de 2 caractères");
            erreur.showErrors();
        }
    }
    
    // SETTER PRENOM
    set prenom(prenomInput){ // ne doit être pas vide condition = pas moins de 2 caractères, pas de nombres
    
        let prenomRegex = new RegExp(/^[A-Za-zéèê-]+$/);
        
        if(prenomInput.length > 2 && prenomRegex.test(prenomInput)){
            this.newClient.push(prenomInput);
        }
        else{
            console.log("Erreur prenom");
            let erreur = new Error("prenom","Veuillez entrer plus de 2 caractères");
            erreur.showErrors();
        }
    }
    
    // SETTER ADRESSE
    set adresse(adresseInput){ 
    
        let adresseRegex = new RegExp(/^([0-9]*) ?([a-zA-Z,\. ]*)$/); // commence par des chiffres et doit contenir soit rue, avenue, etc
        
        if(adresseInput.length > 2 && adresseRegex.test(adresseInput)){
            this.newClient.push(adresseInput);
        }
        else{
            console.log("Erreur adresse");
            let erreur = new Error("adresse","L'adresse est invalide");
            erreur.showErrors();
        }
    }
    
    // SETTER CODE POSTAL
    set codePostal(codePostalInput){ 
    
        let cpRegex = new RegExp(/^[0-9]{5} ?([a-zA-Z,\. ]*)$/); // 5 chiffres s+ ville
        
        if(codePostalInput.length > 2 && cpRegex.test(codePostalInput)){
            
            this.newClient.push(codePostalInput);
        }
        else{
            console.log("Erreur code postal");
            let erreur = new Error("codePostal","Veuillez saisir les 5 chiffres du code postal puis la ville");
            erreur.showErrors();
        }
    }
    
    //SETTER PAYS
    set pays(paysInput){ // ne doit être pas vide condition = pas moins de 2 caractères, pas de nombres
    
        let paysRegex = new RegExp(/^[A-Za-zéèê-]+$/);
        
        if(paysInput.length > 2 && paysRegex.test(paysInput)){
            this.newClient.push(paysInput);
        }
        else{
            console.log("Erreur pays");
            let erreur = new Error("pays","Veuillez entrer plus de 2 caractères");
            erreur.showErrors();
        }
    }
    
    // SETTER TELEPHONE
    set tel(telInput){ 
    
        let telRegex = new RegExp(/^[0]{1}[0-9]{9}$/); // commence par un 0 et contient 9 autres chiffres
        
        if(telInput.length > 2 && telRegex.test(telInput)){
            this.newClient.push(telInput);
        }
        else{
            console.log("Erreur téléphone");
            let erreur = new Error("tel","Le numéro de téléphone est invalide");
            erreur.showErrors();
        }
    }
    
    // SETTER MAIL
    set mail(mailInput){ // ne doit pas être vide
        
        let emailRegex = new RegExp(/^[A-Za-z0-9_!#$%&'*+\/=?`{|}~^.-]+@[A-Za-z0-9.-]+$/, "gm"); // @ et .qlqc
        
        
        if(emailRegex.test(mailInput)){
            //span.remove();
            // let register = new Register();
            // register.saveInStorage("mail",mailInput)
            this.newClient.push(mailInput);
        }
        else{
            console.log("Erreur mail");
            //this.mail = "Erreur mail non conforme";
            let erreur = new Error("mail","Le format de l'adresse mail est invalide (@, .com, .fr...)");
            erreur.showErrors();
        }
    }
    
    // SETTER ANNIVERSAIRE + CONDITION SUR L'AGE >= 18
    set anniversaire(annivInput){ // comment faire pour ne récupérer QUE l'année ??
        
        // let anneeRegex = new RegExp(/^(19|20)\d{2}$/); // doit commencer par 19 ou 20 et être suivi de 2 chiffres ??
        // let mtn = new Date();
        // console.log(mtn);
        // let year = mtn.getFullYear();
        // let majorite = year - 18; // mais ça vérifie que l'année, pas le mois donc c'est à l'année des 18 ans
        // console.log(majorite);
        
        // if(!isNaN(annivInput) && anneeRegex.test(annivInput) && majorite) //si l'input est bien un nombre et s'il passe le regex et si majorité = true
        // {
        //     this.newClient.push(annivInput);
        // }
        // else{
        //     console.log("Erreur age non requis");
        //     let erreur = new Error("anniversaire","Vous devez avoir plus de 18 ans pour vous inscrire");
        //     erreur.showErrors();
        // }
        
        let maintenant = new Date();
        let anniv = new Date(annivInput);
        let age = maintenant.getFullYear() - anniv.getFullYear();
        let mois = maintenant.getMonth() - anniv.getMonth();
        
        // une condition pour soustraire 1 an si l'anniversaire n'est pas encore passé
        if (mois < 0 || (mois === 0 && maintenant.getDate() < anniv.getDate())){ // si la différence entre le mois actuel et le mois d'anniversaire est inf à 0 alors l'anniversaire n'est pas encore passé et on soustrait 1 an à son âge, dans la 2ème partie le mois est le même mais on vérifie la date
                age--;
        }
        
        if (age >= 18) {
            this.newClient.push(annivInput);
        } 
        else {
            console.log("Erreur age non requis");
            let erreur = new Error("anniversaire","Vous devez avoir plus de 18 ans pour vous inscrire");
            erreur.showErrors();
        }
    }
    
    set mdp(mdpInput){ // ne doit pas être vide
        
        let mdp = new RegExp(/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/);
        
        if(mdp.test(mdpInput)){
            this.newClient.push(mdpInput);
        }
        else{
            console.log("Erreur mdp");
            //this.mail = "Erreur mail non conforme";
            let erreur = new Error("mdp","Le mot de passe doit contenir au moins 8 lettres et 1 chiffre");
            erreur.showErrors();
        }
    }
    

/************************************************************************************/
/* *********************************** MÉTHODES *************************************/
/************************************************************************************/

    // showValues(){
    //     let register = new Register();
    //     if(this.newClient.length == 9)
    //     {
    //         register.addClient(this.newClient);
    //     }
    // }
    
}

export default Verify;