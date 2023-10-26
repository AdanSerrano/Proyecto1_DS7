USE db_aa090b_ds7utp;

-- CREATE TABLE USER
DROP TABLE IF EXISTS USERS;
CREATE TABLE USERS(  
    ID_USER int NOT NULL PRIMARY KEY AUTO_INCREMENT,
    USER_NAME VARCHAR(255),
    USER_FIRST_NAME VARCHAR(255),
    USER_LAST_NAME VARCHAR(255)
);

-- CREATE SP INSERT NEW USSER
DROP PROCEDURE IF EXISTS SP_USER_NEW;
CREATE PROCEDURE `SP_USER_NEW`(
    IN VAR_USER_NAME VARCHAR(255),
    IN VAR_USER_FIRST_NAME VARCHAR(255),
    IN VAR_USER_LAST_NAME VARCHAR(255)
)
BEGIN
    DECLARE USER_EXIST INT;
    SET @USER_EXIST = (SELECT COUNT(*) FROM USERS WHERE USER_NAME = UPPER(VAR_USER_NAME));
    IF(@USER_EXIST > 0) THEN
        SELECT 'USUARIO YA EXISTE EN LA BD' AS 'MESSAGE_STATE', '400' AS 'CODE_STATE';
    ELSE
        INSERT INTO USERS(USER_NAME, USER_FIRST_NAME, USER_LAST_NAME) VALUES (UPPER(VAR_USER_NAME), UPPER(VAR_USER_FIRST_NAME), UPPER(VAR_USER_LAST_NAME));
        SELECT 'USUARIO REGISTRADO' AS 'MESSAGE_STATE', '200' AS 'CODE_STATE';
    END IF;
END;

CALL SP_USER_NEW('ASERRANO', 'ADAN', 'SERRANO');

-- CREATE SP GET USERS

CREATE PROCEDURE `SP_USER`()
BEGIN
    SELECT ID_USER, USER_NAME, USER_FIRST_NAME, USER_LAST_NAME FROM USERS;
END;

CALL SP_USER();

-- CREAR TABLE Categorie

DROP TABLE IF EXISTS CATEGORIES;
CREATE TABLE CATEGORIES(
    ID_CATEGORIE INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    CAT_NAME VARCHAR(255),
    CAT_COLOR VARCHAR(15)
);

-- CREATE SP INSERT NEW CATEGORIE
DROP PROCEDURE IF EXISTS SP_CATEGORIE_NEW;
CREATE PROCEDURE `SP_CATEGORIE_NEW`(
    IN VAR_CAT_NAME VARCHAR(255),
    IN VAR_CAT_COLOR VARCHAR(15)
)
BEGIN
    DECLARE CAT_EXIST INT;
    SET @CAT_EXIST = (SELECT COUNT(*) FROM CATEGORIES WHERE CAT_NAME = UPPER(VAR_CAT_NAME));
    IF(@CAT_EXIST > 0) THEN
        SELECT 'CATEGORIA YA EXISTE EN LA BD' AS 'MESSAGE_STATE', '400' AS 'CODE_STATE';
    ELSE
        INSERT INTO CATEGORIES(CAT_NAME, CAT_COLOR) VALUES (UPPER(VAR_CAT_NAME), UPPER(VAR_CAT_COLOR));
        SELECT 'CATEGORIA REGISTRADA' AS 'MESSAGE_STATE', '200' AS 'CODE_STATE';
    END IF;
END;

CALL SP_CATEGORIE_NEW('CATEGORIA 2', 'Ff0000');

-- CREATE SP GET CATEGORIES
CREATE PROCEDURE `SP_CATEGORIE`()
BEGIN
    SELECT ID_CATEGORIE, CAT_NAME, CAT_COLOR FROM CATEGORIES;
END;

CALL SP_CATEGORIE();


-- CREATE TABLE PARAMETER

DROP TABLE IF EXISTS PARAMETERS;
CREATE TABLE PARAMETERS(
    ID_PARAMETER INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    PARA_NAME VARCHAR(255),
    PARA_CATEGORY VARCHAR(255)
);

INSERT INTO PARAMETERS(PARA_NAME, PARA_CATEGORY) VALUES ('POR HACER', 'ESTADOS DE TAREAS');
INSERT INTO PARAMETERS(PARA_NAME, PARA_CATEGORY) VALUES ('EN PROGRESO', 'ESTADOS DE TAREAS');
INSERT INTO PARAMETERS(PARA_NAME, PARA_CATEGORY) VALUES ('TERMINADA', 'ESTADOS DE TAREAS');

-- CREATE SP  GET PARAMETERS
CREATE PROCEDURE `SP_PARAMETER`(
    IN VAR_PARA_CATEGORY VARCHAR(255)
)
BEGIN
    SELECT ID_PARAMETER, PARA_NAME, PARA_CATEGORY FROM PARAMETERS WHERE PARA_CATEGORY = VAR_PARA_CATEGORY;
END;
-- CREATE TABLE TASK

DROP TABLE IF EXISTS TASKS;
CREATE TABLE TASKS(
    ID_TASK INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    TASK_NAME VARCHAR(255),
    TASK_DESCRIPTION TEXT,
    TASK_STATE INT NOT NULL,
    TASK_DATE DATETIME NOT NULL,
    TASK_EDIT VARCHAR(2) NOT NULL,
    TASK_CATEGORIE_ID INT,
    TASK_USER_ID INT,
    FOREIGN KEY (TASK_CATEGORIE_ID) REFERENCES CATEGORIES(ID_CATEGORIE),
    FOREIGN KEY (TASK_USER_ID) REFERENCES USERS(ID_USER),
    FOREIGN KEY (TASK_STATE) REFERENCES PARAMETERS(ID_PARAMETER)
);


-- CREATE SP INSERT NEW TASK
DROP PROCEDURE IF EXISTS SP_TASK_NEW;
CREATE PROCEDURE `SP_TASK_NEW`(
    IN VAR_TASK_NAME VARCHAR(255),
    IN VAR_TASK_DESCRIPTION TEXT,
    IN VAR_TASK_STATE INT,
    IN VAR_TASK_DATE DATETIME,
    IN VAR_TASK_USER_ID INT,
    IN VAR_TASK_CATEGORIE_ID INT
)
BEGIN
    INSERT INTO TASKS(TASK_NAME, TASK_DESCRIPTION, TASK_STATE, TASK_DATE, TASK_EDIT, TASK_CATEGORIE_ID, TASK_USER_ID) 
    VALUES (UPPER(VAR_TASK_NAME), UPPER(VAR_TASK_DESCRIPTION), VAR_TASK_STATE, VAR_TASK_DATE, 'NO', VAR_TASK_CATEGORIE_ID, VAR_TASK_USER_ID);
END;    

-- CREATE SP GET TASKS
DROP PROCEDURE IF EXISTS SP_TASK;
CREATE PROCEDURE `SP_TASK`()
BEGIN
    SELECT ID_TASK, TASK_NAME, TASK_DESCRIPTION,TA.TASK_STATE,  PA.PARA_NAME , TASK_DATE, TASK_EDIT, CA.CAT_NAME , CONCAT(US.USER_LAST_NAME , ' ', US.USER_FIRST_NAME )  USER_NAME
    FROM TASKS TA
    INNER JOIN CATEGORIES CA ON TA.TASK_CATEGORIE_ID = CA.ID_CATEGORIE
    INNER JOIN USERS US ON TA.TASK_USER_ID = US.ID_USER
    INNER JOIN PARAMETERS PA ON TA.TASK_STATE = PA.ID_PARAMETER;
END;

call SP_TASK();

-- CREATE SP UPDATE TASKS

DROP PROCEDURE IF EXISTS SP_TASK_PUT;
CREATE PROCEDURE `SP_TASK_PUT`(
    IN VAR_TASK_ID INT,
    IN VAR_TASK_NAME VARCHAR(255),
    IN VAR_TASK_DESCRIPTION TEXT,
    IN VAR_TASK_STATE INT,
    IN VAR_TASK_DATE DATETIME,
    IN VAR_TASK_USER_ID INT,
    IN VAR_TASK_CATEGORIE_ID INT
)
BEGIN
    UPDATE TASKS 
    SET TASK_NAME = UPPER(VAR_TASK_NAME)
        , TASK_DESCRIPTION = UPPER(VAR_TASK_DESCRIPTION)
        , TASK_STATE = VAR_TASK_STATE
        , TASK_DATE = VAR_TASK_DATE
        , TASK_CATEGORIE_ID = VAR_TASK_CATEGORIE_ID
        , TASK_USER_ID = VAR_TASK_USER_ID 
    WHERE ID_TASK = VAR_TASK_ID;
END;