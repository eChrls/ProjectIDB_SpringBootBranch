package com.proyecto.idb.entity;

import java.sql.Date;

import jakarta.annotation.Generated;
import jakarta.persistence.Entity;
import jakarta.persistence.ForeignKey;
import jakarta.persistence.GeneratedValue;
import jakarta.persistence.GenerationType;
import jakarta.persistence.Id;
import jakarta.persistence.JoinColumn;
import jakarta.persistence.ManyToOne;
import jakarta.persistence.Table;
import lombok.AllArgsConstructor;
import lombok.Data;
import lombok.NoArgsConstructor;

import  java.sql.Timestamp;
@Entity //para que Spring Boot sepa que es una entidad de la bbdd
@Data //para que se generen los setters, getters y toString...
@Table(name="alumns")  //para que sepa el nombre de la tabla
@AllArgsConstructor
@NoArgsConstructor
public class AlumnsEntity {

        @Id //para identificar la variable como PK
        @GeneratedValue(strategy = GenerationType.IDENTITY)//para que se genere automaticamente el id de manera incremental
        private long idAlumn;
        
        private String surname; 
        private String name; 
        private int age; 
        private String email;
        private String city; 
        private Grade grade; 
        private Date gradeDate; 
        private Timestamp timestamp;
        
        
        @ManyToOne
        @JoinColumn(name="schools", foreignKey = @jakarta.persistence.ForeignKey(name = "FK_SCHOOL"))
        private SchoolsEntity schoolsEntity;
            // se establece la relacion que una Escuela tiene muchos alumnos y se señala la FK con JOIN COLUMN 
        
        
        
        
        public static enum Grade {
            PRIMERO,
            SEGUNDO,
            TERCERO
        }
        
            // Constructor
    public AlumnsEntity(String surname, String name, int age, String email, String city, Grade grade2, Date gradeDate, java.sql.Timestamp timestamp, SchoolsEntity schoolsEntity) {
        this.surname = surname;
        this.name = name;
        this.age = age;
        this.email = email;
        this.city = city;
        this.grade = grade2;
        this.gradeDate = gradeDate;
        this.timestamp = timestamp;
        this.schoolsEntity = schoolsEntity;
    }



        
        
        
        
        
        
        
        
        
        
        }




