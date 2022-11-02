<?php

class AlbumsModel {
    
    private $db;

    function __construct(){
        $this->db = new PDO ('mysql:host=localhost;'.'dbname=db_canciones;charset=utf8', 'root', '');
    }

    function getAll(){

        $query = $this->db->prepare('SELECT * FROM album');
        $query->execute();

        $albums = $query->fetchAll(PDO::FETCH_OBJ);

        return $albums;
    }
    
   

    function getAlbum($id_album_fk){

        $query = $this->db->prepare('SELECT * FROM album where id = ?');
        $query->execute([$id_album_fk]);

        $album = $query->fetch(PDO::FETCH_OBJ);
        
        return $album;
    }

        
    function insert($nombre, $banda, $genero, $año, $cantidadCanciones, $imgURL){

        $query = $this->db->prepare("INSERT INTO album (nombre, anio, banda, genero, cant_canciones, imgURL) VALUES (?, ?, ?, ?, ?, ?)");
        $query->execute([$nombre, $banda, $genero, $año, $cantidadCanciones, $imgURL]);

    }

    function modify($nombre, $banda, $genero, $año, $cantidadCanciones, $imgURL, $id){

        $query = $this->db->prepare("UPDATE album SET nombre = ?, banda=?, genero=?, anio=?, cant_canciones=?, imgURL= ? WHERE id= ?");
        $query->execute([$nombre, $banda, $genero, $año, $cantidadCanciones, $imgURL, $id]);

    }
    

    function delete($id){

        $query = $this->db->prepare('DELETE FROM album where id = ?');
        $query->execute([$id]);

    }

    function search($nombre){

        $query = $this->db->prepare('SELECT * FROM album where nombre like ?');
        $query->execute(['%'.$nombre.'%']);
    
        return $query->fetchAll(PDO::FETCH_OBJ);
    }
}
