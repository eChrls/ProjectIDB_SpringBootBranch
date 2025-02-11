package com.proyecto.idb.controller;

import java.security.Timestamp;
import java.sql.Date;
import java.util.List;

import org.springframework.data.jpa.repository.Query;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.CrossOrigin;
import org.springframework.web.bind.annotation.DeleteMapping;
import org.springframework.web.bind.annotation.GetMapping;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RequestParam;
import org.springframework.web.bind.annotation.RestController;

import com.proyecto.idb.entity.AlumnsEntity;
import com.proyecto.idb.entity.SchoolsEntity;
import com.proyecto.idb.entity.AlumnsEntity.Grade;
import com.proyecto.idb.model.AlumnsDto;
import com.proyecto.idb.service.WebService;

import lombok.RequiredArgsConstructor;
import lombok.extern.slf4j.Slf4j;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.RequestBody;
import org.springframework.web.bind.annotation.PutMapping;
import org.springframework.web.bind.annotation.PathVariable;



@RestController //para hacer las llamadas a la api y generar una respuesta por el body
@Slf4j //para poner logs
@CrossOrigin("*") //para que se pueda llamar desde cualquier sitio
@RequiredArgsConstructor //para que se inyecten los beans
@RequestMapping("/idbProject") //mapeo de la url que aparecerá cuando se haga la llamada
public class WebController {

    private final WebService webService; //injection del bean de la clase webService

    // @param idSchool
    // @param idAlumn

//----------------------------------CREATE--------------------------------------------------------------------------------------------------------------------------------------------------
    @PostMapping("/+sch")
    public ResponseEntity<String> addSchool (@RequestBody SchoolsEntity school) {

            return webService.addSchool(school);
    }

    @PostMapping("/+alu")
    public ResponseEntity<String> addAlumn (@RequestBody AlumnsDto alumnsDto){
        return webService.addAlumn(alumnsDto);
    }      
    

//----------------------------------DELETE--------------------------------------------------------------------------------------------------------------------------------------------------    
    @DeleteMapping("/-sch/{idSchool}")
    public ResponseEntity<String>delSchool(@PathVariable Long idSchool){
        return webService.delSchool(idSchool);
    }

    @DeleteMapping("/-alu/{idAlumn}")
    public ResponseEntity<String>delAlumn(@PathVariable Long idAlumn){
        return webService.deleteByIdAlumn(idAlumn);
    }    
//----------------------------------GET--------------------------------------------------------------------------------------------------------------------------------------------------
@GetMapping("/show=sch")
    public ResponseEntity<String>showSchools(){
        return webService.showSchools();
    }


// @PostMapping("/show=byIdSch/{idSchool}")
//     public ResponseEntity<String>showSchoolById(@RequestParam Long idSchool){
//         return webService.showSchoolById(idSchool);
    // }

// @GetMapping("/show=alu/{idSchool}")
//     public ResponseEntity<String>showAlumns(@PathVariable Long idSchool){   
//         return webService.findAllAlumnsByIdSchool(idSchool);
//     }

@GetMapping("/show=alu/{idAlumn}")
    public ResponseEntity<String>showAlumnById(@PathVariable Long idAlumn){
        return webService.showAlumnById(idAlumn);
    }



//----------------------------------UPDATE--------------------------------------------------------------------------------------------------------------------------------------------------   
  
@PutMapping("/upt=sch/{idSchool}")
    public ResponseEntity<String>uptSchool(@PathVariable Long idSchool, @RequestBody SchoolsEntity school){
        return webService.uptSchool(idSchool, school);
    }
    
@PutMapping("/upt=alu/{idAlumn}")
public ResponseEntity<String> uptAlumn(@PathVariable Long idAlumn, @RequestBody AlumnsDto alumnsDto){
    return webService.uptAlumn(idAlumn, alumnsDto);
    }
    

//----------------------------------LOGIN--------------------------------------------------------------------------------------------------------------------------------------------------       
// //BUSCAMOS POR LOGIN Y PASSWORD Y DEVOLVEMOS IDSCHOOL
// REPOSITORY: 
//     @Query (value = "SELECT id_school FROM schools WHERE user = :user AND password = :password", nativeQuery = true)
//     List<Long> findByLoginAndPassword(Long user, String password);


@PostMapping("/login")
    public ResponseEntity<String>login(@RequestParam Long user, @RequestParam String password){
        return webService.login(user, password);
        }

//ACTUALIZAR CONTRASEÑA
@PutMapping("/upt=pass")
    public ResponseEntity<String>uptPass(@RequestBody SchoolsEntity school){
            return webService.uptPass(school);
        }

//MOSTRAR TODOS LOS ALUMNOS
@GetMapping("/show=all")
public ResponseEntity<String>  getAllAlumns (@RequestParam Long user,@RequestParam String password) {
    return webService.getAllAlumns(user, password);
}

//MOSTRAR NOMBRE ESCUELA
@GetMapping("/show/school")
public ResponseEntity<String> getSchoolName(@RequestParam Long user,@RequestParam String password) {
    return webService.getSchoolName(user, password);
}



}
