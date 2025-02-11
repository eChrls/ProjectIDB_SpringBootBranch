package com.proyecto.idb.repository;

import org.springframework.data.jpa.repository.Query;
import org.springframework.data.repository.CrudRepository;

import com.proyecto.idb.entity.SchoolsEntity;
import java.util.List;
import java.util.Optional;


public interface SchoolsRepository extends CrudRepository <SchoolsEntity, Long> {
// cambiamos public class a public interface para usara las interfaces de CrudRepository, señalando que vamos a necesitar una entidad y una id
//Esto ejecuta la conexión con la bbdd (crud repository), esto permite las acciones CRUD
    
    @Query (value = "SELECT * FROM schools WHERE id_school = :idSchool", nativeQuery = true)  
    Optional<SchoolsEntity> findById(Long idSchool);
     
    List<SchoolsEntity>findAll();
    
    //BUSCAMOS POR LOGIN Y PASSWORD Y DEVOLVEMOS ID-SCHOOL
    @Query (value = "SELECT id_school FROM schools WHERE user = :user AND password = :password", nativeQuery = true)
    Optional<Long> findByLoginAndPassword(Long user, String password);

    @Query (value = "SELECT * FROM schools WHERE user = :user", nativeQuery = true)
    Optional<SchoolsEntity>findByUser(Long user);

    @Query (value = "SELECT school_name FROM schools WHERE user = :user AND password = :password", nativeQuery = true)
    Optional<String> findSchoolName(Long user, String password);


}
