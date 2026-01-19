DROP TABLE IF EXISTS fichaje;

CREATE TABLE fichaje (
    id_fichaje INT AUTO_INCREMENT PRIMARY KEY,
    alumno_id INT NOT NULL,
    pin_id INT NOT NULL,
    fecha DATE NOT NULL,
    hora_entrada TIME NOT NULL,
    hora_salida TIME NULL,
    total_horas TIME NULL,

    CONSTRAINT fichaje_alumno_fk
        FOREIGN KEY (alumno_id)
        REFERENCES alumno(id_alumno)
        ON DELETE CASCADE,

    CONSTRAINT fichaje_pin_fk
        FOREIGN KEY (pin_id)
        REFERENCES pin(id_pin)
        ON DELETE CASCADE
);
