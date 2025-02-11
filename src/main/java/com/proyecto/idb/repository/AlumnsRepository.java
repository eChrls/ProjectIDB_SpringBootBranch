package com.proyecto.idb.repository;

import org.springframework.data.jpa.repository.Modifying;
import org.springframework.data.jpa.repository.Query;
import org.springframework.data.repository.CrudRepository;
import org.springframework.data.repository.query.Param;

import com.proyecto.idb.entity.AlumnsEntity;
import com.proyecto.idb.entity.SchoolsEntity;

import java.util.List;
import java.util.Optional;


public interface AlumnsRepository extends CrudRepository<AlumnsEntity, Long>{
// cambiamos public class a public interface para usara las interfaces de CrudRepository, señalando que vamos a necesitar una entidad y una id
//Esto ejecuta la conexión con la bbdd (crud repository), esto permite las acciones CRUD

    @Query (value = "SELECT * FROM alumns WHERE id_alumn = :idAlumn", nativeQuery = true)
    Optional<AlumnsEntity> findById(long idAlumn);


     @Query (value = "SELECT * FROM alumns WHERE schools = :idSchool", nativeQuery = true)  
        List<AlumnsEntity> findAll(Optional<Long> idSchool);

    // List<AlumnsEntity> findAll();

//    @Modifying
//     @Query(value = "DELETE FROM alumns WHERE idAlumn = :idAlumn", nativeQuery = true)
//     int deleteByIdAlumn(@Param("idAlumn") Long idAlumn);
}
