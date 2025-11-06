//Autor Miguel Angel Lara H.
//Autor
//descripcion de funcionamiento
//funcion para exportar tabla
/*
La función exportTableToExcel() convierte los datos de una tabla HTML a Excel, en concreto a un fichero XLS (.xlsx).
tableID $ Obligatorio. Define el ID de la tabla HTML a exportar.
filename $ Opcional. Define el nombre del fichero en el que verteremos la información.
*/
function exportTableToXLSX(tableID, filename = "") {
    var table = document.getElementById(tableID);

    filename = filename
        ? filename.endsWith(".xlsx")
            ? filename
            : filename + ".xlsx"
        : "excel_data.xlsx";

    //  Tabla → Hoja
    const sheet = XLSX.utils.table_to_sheet(table);

    //  Hoja → JSON (arreglo de filas)
    let datos = XLSX.utils.sheet_to_json(sheet, { header: 1 });

    //  Quitar última columna de cada fila
    datos = datos.map(fila => fila.slice(0, -1));

    // Crear hoja nueva sin la columna
    const nuevaHoja = XLSX.utils.aoa_to_sheet(datos);

    //  Crear el workbook
    const workbook = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(workbook, nuevaHoja, "Hoja1");

    //  Descargar XLSX
    XLSX.writeFile(workbook, filename);
}

//en caso de querer exportar en una ubicacion usar las dos funciones siguientes
//crearArchivoSinOpciones()
//guardarArchivoRuta()
/*
**Para usar estas funciones se manda a llamar la funcion guardarArchivoRuta(nombreTabla) y se ejecutara de manera automatica
**la otra funcion crearArchivoSinOpciones(tableID)
*/
/*
function crearArchivoSinOpciones(tableID) {
  const table = document.getElementById(tableID);

  //Convertir tabla HTML → Hoja
  const sheet = XLSX.utils.table_to_sheet(table);

  //Convertir hoja → JSON (arreglo de filas)
  let datos = XLSX.utils.sheet_to_json(sheet, { header: 1 });

  // Quitar última columna (Opciones)
  datos = datos.map((fila) => fila.slice(0, -1));

  // Crear hoja nueva sin la columna
  const hoja = XLSX.utils.aoa_to_sheet(datos);

  // Crear libro
  const workbook = XLSX.utils.book_new();
  XLSX.utils.book_append_sheet(workbook, hoja, "Hoja1");

  return workbook;
}

async function guardarArchivoRuta(tableID) {
  try {
    const workbook = crearArchivoSinOpciones(tableID);

    // Crear archivo binario
    const buffer = XLSX.write(workbook, { bookType: "xlsx", type: "array" });

    // Abrir diálogo "Guardar como"
    const handle = await window.showSaveFilePicker({
      suggestedName: "reporte.xlsx",
      types: [
        {
          description: "Excel",
          accept: {
            "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet":
              [".xlsx"],
          },
        },
      ],
    });

    const writable = await handle.createWritable();
    await writable.write(buffer);
    await writable.close();
     alert("Archivo guardado con éxito");
  } catch (error) {
    if (error.name === "AbortError") return; // Usuario canceló
    console.error(error);
  }
}   */
