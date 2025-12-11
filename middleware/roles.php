<?php
// Autor: Miguel Angel Lara Hermosillo
// Fecha: 12-10-2025
// Descripción: Mapeo de roles permitidos por módulo.

return [

    // ============================
    // MÓDULO ALUMNO
    // ============================
    "alumno.main"       => ["Administrador", "JefeDeCarrera"],
    "alumno.add"        => ["Administrador", "JefeDeCarrera"],
    "alumno.edit"       => ["Administrador", "JefeDeCarrera"],

    // ============================
    // MÓDULO BAJA
    // ============================
    "baja.main"         => ["Administrador"],
    "baja.manual"       => ["Administrador"],
    "baja.edit"         => ["Administrador"],

    // ============================
    // MÓDULO CAPTURA
    // ============================
    "captura.main"      => ["Administrador"],
    "captura.add"       => ["Docente"],
    "captura.grup"      => ["Docente"],
    "captura.indi"      => ["Docente"],


    // ============================
    // JEFE DE CARRERA 
    // ============================
    "career.main"       => ["Administrador"],
    "career.add"        => ["Administrador"],
    "career.edit"       => ["Administrador"],

    // ============================
    // CARRERA
    // ============================
    "carrera.main"      => ["Administrador", "JefeDeCarrera"],
    "carrera.add"       => ["Administrador", "JefeDeCarrera"],
    "carrera.edit"      => ["Administrador", "JefeDeCarrera"],

    // ============================
    // DOCENTE
    // ============================
    "docente.main"      => ["Administrador"],
    "docente.add"       => ["Administrador"],
    "docente.edit"      => ["Administrador"],

    // ============================
    // HORARIO
    // ============================
    "horario.main"      => ["Administrador", "JefeDeCarrera"],
    "horario.add"       => ["Administrador", "JefeDeCarrera"],
    "horario.grup"      => ["Administrador", "JefeDeCarrera"],
    "horario.indi"      => ["Administrador", "JefeDeCarrera"],

    // ============================
    // INFORMACIÓN CUENTA
    // ============================
    "cuenta.main"       => ["Administrador", "Docente", "JefeDeCarrera"],

    // ============================
    // MATERIA
    // ============================
    "materia.main"      => ["Administrador", "JefeDeCarrera"],
    "materia.add"       => ["Administrador", "JefeDeCarrera"],
    "materia.edit"      => ["Administrador", "JefeDeCarrera"],

    // ============================
    // Vista Principal de captura para Jefe de carrera
    //mostrarCalJefe
    // ============================

    "capturaJefe.import"  => ["JefeDeCarrera"],


    // ============================
    // OFERTA
    // ============================
    "oferta.main"       => ["Administrador", "JefeDeCarrera"],
    "oferta.add"        => ["Administrador", "JefeDeCarrera"],
    "oferta.edit"       => ["Administrador", "JefeDeCarrera"],

    // ============================
    // PARCIAL
    // ============================
    "parcial.main"      => ["Administrador"],
    "parcial.add"       => ["Administrador"],
    "parcial.edit"      => ["Administrador"],

    // ============================
    // PERIODO
    // ============================
    "period.main"       => ["Administrador"],
    "period.add"        => ["Administrador"],
    "period.edit"       => ["Administrador"],

    // ============================
    // USUARIO
    // ============================
    "usuario.main"      => ["Administrador"],
    "usuario.add"       => ["Administrador"],
    "usuario.edit"      => ["Administrador"]
];
