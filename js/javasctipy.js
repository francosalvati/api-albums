"use strict";



const URL = "api/albums";

async function getAll(){
    
    try{
        let response = await fetch(URL);
        let albums = await response.json();
    
        console.log(albums);
    }

    catch(exc){
        console.log("error");
    }
    
}

getAll();

alert('hola');
