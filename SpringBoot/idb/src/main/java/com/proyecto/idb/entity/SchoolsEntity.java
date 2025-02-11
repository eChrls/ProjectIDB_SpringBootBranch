package com.proyecto.idb.entity;

import jakarta.persistence.Column;
import jakarta.persistence.Entity;
import jakarta.persistence.GeneratedValue;
import jakarta.persistence.GenerationType;
import jakarta.persistence.Id;
import jakarta.persistence.Table;
import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;

@Entity // para que SpringBoot sepa que es una entiedad de la bbdd
@Data // para que se generen los setters, getters, toString,...
@AllArgsConstructor //genera un constructor con todos los parámetros
@NoArgsConstructor // genera un constructor sin parámetros
@Table(name="schools") // para que sepa que tabla de la bbdd 
public class SchoolsEntity {
    
    @Id // para saber que es la clave primaria de la tabla
    @GeneratedValue(strategy = GenerationType.IDENTITY) // para que se genere id incrementando automaticamente
    private Long idSchool;

    @Column(unique = true)//para que la columna sea única
    private Long user;

    private String password;
    private String schoolName; 


    //generamos un constructor sin id para que se pueda crear un objeto de la clase sin tener que pasar el id
    public SchoolsEntity(Long user, String password, String schoolName) {
       
        this.user = user;
        this.password = password;
        this.schoolName = schoolName;
        }
        
    
}
