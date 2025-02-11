package com.proyecto.idb.service;

import java.security.Timestamp;
import java.sql.Date;
import java.util.Optional;

import java.util.List;
import org.springframework.http.HttpStatus;
import org.springframework.http.ResponseEntity;
import org.springframework.stereotype.Service;
import org.springframework.web.bind.annotation.PathVariable;
import org.springframework.web.bind.annotation.PostMapping;
import org.springframework.web.bind.annotation.PutMapping;
import org.springframework.web.bind.annotation.RequestBody;
import org.springframework.web.bind.annotation.RequestParam;

import com.fasterxml.jackson.core.JsonProcessingException;
import com.fasterxml.jackson.databind.ObjectMapper;
import com.proyecto.idb.entity.AlumnsEntity;
import com.proyecto.idb.entity.AlumnsEntity.Grade;
import com.proyecto.idb.entity.SchoolsEntity;
import com.proyecto.idb.model.AlumnsDto;
import com.proyecto.idb.repository.AlumnsRepository;
import com.proyecto.idb.repository.SchoolsRepository;

import lombok.RequiredArgsConstructor;
import lombok.extern.slf4j.Slf4j;

@Service // para que el servicio se pueda utilizar en el proyecto
@Slf4j // para poner logs
@RequiredArgsConstructor // para que se inyecten los beans
public class WebService {

    private final SchoolsRepository schoolsRepository; // injection de dependencias
    private final AlumnsRepository alumnsRepository; // injection de dependencias
    private final ObjectMapper objectMapper; // para generar un json o pasar de json a objeto.



//----------------------------------CREATE--------------------------------------------------------------------------------------------------------------------------------------------------
    public ResponseEntity<String> addSchool(SchoolsEntity school){
        try{
            schoolsRepository.save(school);
            return ResponseEntity.ok("School created");
        }catch(Exception e){
            log.error("error al guardar escuela", e.getMessage(), e);
            return ResponseEntity.badRequest().body("Error creating school");
            }
        }

    public ResponseEntity<String> addAlumn(AlumnsDto alumnsDto){
        try{
            Optional<SchoolsEntity> school = schoolsRepository.findById(alumnsDto.getIdSchool());
            if(!school.isPresent()){
                return ResponseEntity.badRequest().body("School not found");

                }
                AlumnsEntity alumnsEntity = new AlumnsEntity(alumnsDto.getSurname(), alumnsDto.getName(), alumnsDto.getAge(), alumnsDto.getEmail(), alumnsDto.getCity(), alumnsDto.getGrade(), alumnsDto.getGradeDate(), alumnsDto.getTimestamp(), school.get());

                alumnsRepository.save(alumnsEntity);
                
                return ResponseEntity.ok("Alumn created");
        
            }catch(Exception e){
                log.error("error al guardar alumno", e.getMessage(), e);
                return ResponseEntity.badRequest().body("Error creating student");
            }
    }

//----------------------------------DELETE--------------------------------------------------------------------------------------------------------------------------------------------------
    public ResponseEntity<String> delSchool (Long idSchool){
        try{
            schoolsRepository.deleteById(idSchool); //borramos la escuela de la bbdd
            return ResponseEntity.ok("Escuela eliminada con exito");
            }catch(Exception e){
                log.error("error al eliminar escuela", e.getMessage(), e);
                return ResponseEntity.badRequest().body("Error al eliminar escuela");
                }
    }


    public ResponseEntity<String> deleteByIdAlumn (long idAlumn){
        try{
            alumnsRepository.deleteById(idAlumn); //borramos el alumno de la bbdd
            
            return ResponseEntity.ok("Alumno eliminado con exito");
            }catch(Exception e){
                log.error("error al eliminar alumno", e.getMessage(), e);
                return ResponseEntity.badRequest().body("Error al eliminar alumno");
                }
    }
//----------------------------------GET--------------------------------------------------------------------------------------------------------------------------------------------------
public ResponseEntity<String>showSchools(){
    try{
        return ResponseEntity.ok(objectMapper.writeValueAsString(schoolsRepository.findAll()));
    }catch(Exception e){
        log.error("error al mostrar escuelas", e.getMessage(), e);
        return ResponseEntity.badRequest().body("Error al mostrar escuelas");
    }
}

// public ResponseEntity<String>findAllAlumnsByIdSchool(Long idSchool){
//     try{
//         return ResponseEntity.ok(objectMapper.writeValueAsString(alumnsRepository.findByIdSchool(idSchool)));
//         }catch(Exception e){
//             log.error("error al mostrar alumnos", e.getMessage(), e);
//             return ResponseEntity.badRequest().body("Error al mostrar alumnos");
//             }
// }

// public ResponseEntity<String>showSchoolById(Long idSchool){
//     try{
//         return ResponseEntity.ok(objectMapper.writeValueAsString(schoolsRepository.findByIdSchool(idSchool)));
//     }catch(JsonProcessingException e){
//         log.error("error al mostrar escuela", e.getMessage(), e);
//         return ResponseEntity.status(HttpStatus.INTERNAL_SERVER_ERROR).body("Error al obtener la escuela");
//     }
// }

public ResponseEntity<String>showAlumnById(Long idAlumn){
    try{
        return ResponseEntity.ok(objectMapper.writeValueAsString(alumnsRepository.findById(idAlumn)));
        }catch(JsonProcessingException e){
            log.error("error al mostrar alumno", e.getMessage(), e);
            return ResponseEntity.status(HttpStatus.INTERNAL_SERVER_ERROR).body("Error al obtener el alumno");
            }

        }
    

//----------------------------------UPDATE--------------------------------------------------------------------------------------------------------------------------------------------------
   
public ResponseEntity<String>uptSchool(Long idSchool, SchoolsEntity school){
    try{
        SchoolsEntity schoolsEntity = schoolsRepository.findById(idSchool).get();
        schoolsEntity.setUser(school.getUser());
        schoolsEntity.setPassword(school.getPassword());
        schoolsEntity.setSchoolName(school.getSchoolName());
        schoolsRepository.save(schoolsEntity);
        return ResponseEntity.ok("Escuela actualizada");
        }catch(Exception e){
            log.error("error al actualizar escuela", e.getMessage(), e);
            return ResponseEntity.badRequest().body("Error al actualizar escuela");
            }
            }


public ResponseEntity<String>uptAlumn(Long idAlumn, AlumnsDto alumnsDto){
    try{
        AlumnsEntity alumnsEntity = alumnsRepository.findById(idAlumn).get();
        alumnsEntity.setSurname(alumnsDto.getSurname());
        alumnsEntity.setName(alumnsDto.getName());
        alumnsEntity.setAge(alumnsDto.getAge());
        alumnsEntity.setEmail(alumnsDto.getEmail());
        alumnsEntity.setCity(alumnsDto.getCity());
        alumnsEntity.setGrade(alumnsDto.getGrade());
        alumnsEntity.setGradeDate(alumnsDto.getGradeDate());
        alumnsEntity.setTimestamp(alumnsDto.getTimestamp());
        
        alumnsRepository.save(alumnsEntity);
        return ResponseEntity.ok("Alumno actualizado");
        }catch(Exception e){
            log.error("error al actualizar alumno", e.getMessage(), e);
            return ResponseEntity.badRequest().body("Error al actualizar alumno");
            }
            }





//----------------------------------LOGIN--------------------------------------------------------------------------------------------------------------------------------------------------       

public ResponseEntity<String> login (Long user, String password){
    try{
        Optional<Long> idSchool = schoolsRepository.findByLoginAndPassword(user, password);
        if(idSchool.isEmpty()){
            return ResponseEntity.badRequest().body("Error de credenciales");
        }
        return ResponseEntity.ok(objectMapper.writeValueAsString(idSchool.get()));
    } catch (Exception e) {
        log.error("error al iniciar sesión", e.getMessage(), e);
        return ResponseEntity.badRequest().body("Error al iniciar sesión");
    }
}

//CAMBIAR CONTRASEÑA        

public ResponseEntity<String> uptPass (SchoolsEntity school){
    try{
        Optional<SchoolsEntity> user = schoolsRepository.findByUser(school.getUser());
        if(user.isPresent()){
            SchoolsEntity schoolsEntity = user.get();

            schoolsEntity.setPassword(school.getPassword());

            schoolsRepository.save(schoolsEntity);
            return ResponseEntity.ok("Contraseña actualizada");

        }else{
            return ResponseEntity.badRequest().body("Error al actualizar contraseña");
            }
            } catch (Exception e) {
                log.error("error al actualizar contraseña", e.getMessage(), e);
                return ResponseEntity.badRequest().body("Error al actualizar contraseña");
                }
                
        }

    //MOSTRAR TODOS LOS ALUMNOS PARA LA TABLA

    public ResponseEntity<String> getAllAlumns(Long user, String password){

            try{
                Optional<Long> idSchool = schoolsRepository.findByLoginAndPassword(user, password);
                List<AlumnsEntity> listaAlumnos = alumnsRepository.findAll(idSchool);
                if(idSchool.isEmpty()){
                    return ResponseEntity.badRequest().body("Error de credenciales");
                }
                return ResponseEntity.ok(objectMapper.writeValueAsString(listaAlumnos));
            } catch (Exception e) {
                log.error("error al iniciar sesión", e.getMessage(), e);
                return ResponseEntity.badRequest().body("Error al iniciar sesión");
            }
        }
        

    //COGER NOMBRE DEL CENTRO
    public ResponseEntity<String> getSchoolName(Long user, String password){
        try{
            Optional<String> nombre = schoolsRepository.findSchoolName(user, password);
            if(nombre.isPresent()){
                return ResponseEntity.ok(nombre.get());
                }else{
                    return ResponseEntity.badRequest().body("Error de credenciales");
                    }
                    } catch (Exception e) {
                        log.error("error al iniciar sesión", e.getMessage(), e);
                        return ResponseEntity.badRequest().body("Error al iniciar sesión");
                        }
                        }
                        



















    }

























