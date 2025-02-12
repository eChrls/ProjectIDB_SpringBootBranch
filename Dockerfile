FROM maven:3-amazoncorretto-21-alpine AS build
COPY ./ .
RUN mvn clean package -DskipTests

FROM amazoncorretto:21-alpine-jdk 
COPY --from=build /target/idb-0.0.1-SNAPSHOT.jar idb.jar
EXPOSE 8080

ENTRYPOINT ["java","-jar","-Dspring.profiles.active=pro","/idb.jar", "org.springframework.boot.loader.launch.JarLauncher"]