package com.proyecto.idb.model;

import java.sql.Timestamp;
import java.sql.Date;

import com.proyecto.idb.entity.SchoolsEntity;
import com.proyecto.idb.entity.AlumnsEntity.Grade;

import lombok.Data;

@Data //siempre data en entidades para que se generen los setters, getters y toString
public class AlumnsDto {
     
    private String surname; 
    private String name; 
    private int age; 
    private String email;
    private String city; 
    private Grade grade;
    private Date gradeDate; 
    private Timestamp timestamp;
    private Long idSchool; 


//         public AlumnsDto(String surname, String name, int age, String email, String city, Grade grade, Date gradeDate, Timestamp timestamp, SchoolsEntity schoolsEntity) {
//                 this.surname = surname;
//                 this.name = name; 
//                 this.age = age;
//                 this.email = email;
//                 this.city = city;
//                 this.grade = grade;
//                 this.gradeDate = gradeDate;
//                 this.timestamp = timestamp;
//                 this.schoolsEntity = schoolsEntity;
//         }
}