/**
 * Funciones para Abrir el modal de Importacion de archivo
 * ademas otras funciones para controlar la subida de forma simulada de un archivo
 * autor: Miguel Angel Lara Hermosillo
 */

let archivosSeleccionados = [];

/* ===============================================
   ABRIR MODAL Y PREPARAR TODO
================================================ */
function buscarArchivoImportado() {
  // Detectar si NO hay internet
  if (!navigator.onLine) {
    mostrarErrorInternet();
    return; //Detener ejecución
  }

  if (/Android|iPhone|iPad/i.test(navigator.userAgent)) {
    zonaCarga.style.display = "none";
  }

  const modalElement = document.getElementById("modalImportar");
  const modal = new bootstrap.Modal(modalElement);
  modal.show();

  inicializarImportador();
}
function mostrarErrorInternet() {
  const mensaje = document.getElementById("mensajeError");
  mensaje.textContent =
    "No hay conexión a Internet. Verifique su conexión e inténtelo nuevamente.";

  const modalError = new bootstrap.Modal(document.getElementById("modalError"));
  modalError.show();
}

/* ===============================================
   INICIALIZAR TODO — LISTENERS DENTRO DEL MODAL
================================================ */
function inicializarImportador() {
  const dropZone = document.getElementById("dropZone");
  const fileInput = document.getElementById("fileInput");
  const fileList = document.getElementById("fileList");
  const btnUploadAll = document.getElementById("btnUploadAll");

  const modal = document.getElementById("modalImportar");

  modal.addEventListener("hidden.bs.modal", () => {
    archivosSeleccionados = [];
    fileList.innerHTML = "";
    fileInput.value = "";
  });

  archivosSeleccionados = [];
  fileList.innerHTML = "";
  btnUploadAll.disabled = true; // Bloquea al inicio

  dropZone.addEventListener("dragover", (e) => {
    e.preventDefault();
    dropZone.classList.add("active");
  });

  dropZone.addEventListener("dragleave", () =>
    dropZone.classList.remove("active")
  );

  dropZone.addEventListener("drop", (e) => {
    e.preventDefault();
    dropZone.classList.remove("active");
    manejarArchivos(e.dataTransfer.files);
    btnUploadAll.disabled = false; // Activar botón
  });

  fileInput.addEventListener("change", (e) => {
    manejarArchivos(e.target.files);
    btnUploadAll.disabled = false; // Activar botón
  });

  btnUploadAll.addEventListener("click", subirArchivoManual);
}

/* ===============================================
   MANEJAR ARCHIVOS 
================================================ */
function manejarArchivos(files) {
  // VALIDAR QUE EXISTA UN ARCHIVO
  if (!files || files.length === 0) {
    if (fileInput.value !== "") {
      console.warn("No se seleccionó archivo");
    }
    return;
  }

  const file = files[0]; // Solo tomar 1 archivo aunque arrastre varios

  // Validar tipo Excel
  if (!file.name.toLowerCase().match(/\.(xls|xlsx)$/)) {
    fileInput.value = "";
    mostrarErrorArchivo();
    return;
  }

  //Si ya existe un archivo, reemplazarlo
  if (archivosSeleccionados.length >= 1) {
    const anterior = archivosSeleccionados[0];
    eliminarArchivo(anterior.id); // eliminar del DOM y del arreglo
  }

  const id =
    self.crypto.randomUUID?.() ??
    "id-" + Math.random().toString(36).substring(2, 12);

  // Guardar nuevo archivo
  archivosSeleccionados = [{ file, id }];

  // Mostrar en lista
  mostrarArchivoEnLista(file, id);

  fileInput.value = ""; //Permite Seleccinar archivos nuevos
}
/* ===============================================
   sUBIR EL ARCHIVO AL PRECIONAR SOBRE EL BOTON
================================================ */
function subirArchivoManual() {
  // SI NO HAY ARCHIVO → ERROR
  if (archivosSeleccionados.length === 0) {
    mostrarErrorArchivo();

    return; // Detener todo
  }

  // AQUÍ SÍ EXISTE ARCHIVO SE SUBE
  const { file, id } = archivosSeleccionados[0];

  subirArchivoConFetch(file, id);
}

async function subirArchivoConFetch(file, idUnico) {
  const item = document.querySelector(`.file-item[data-id="${idUnico}"]`);
  const status = item.querySelector(".file-status");
  const bar = item.querySelector(".progress-bar-custom");
  const url = "/Prueba/Controlador/Intermediarios/captura/Captura.php";

  status.textContent = "Subiendo...";
  status.classList.add("text-warning");

  const formData = new FormData();
  formData.append("archivo", file);

  try {
    const response = await fetch(url, {
      method: "POST",
      body: formData,
    });

    const resultado = await response.json();

    // Validar error del backend
    if (!response.ok || !resultado.ok) {
      throw new Error(resultado.mensaje || "Error al subir archivo");
    }

    console.log(resultado);
    for (let p = 0; p <= 95; p += 8) {
      bar.style.width = p + "%";
      await new Promise((res) => setTimeout(res, 50));
    }

    // Empuje final exacto al 100%
    bar.style.width = "100%";

    status.textContent = "Completado ✓";
    status.classList.remove("text-warning");
    status.classList.add("text-success");
    btnUploadAll.disabled = true;
  } catch (error) {
    console.error("Error al subir archivo:", error);

    status.textContent = "Error al subir";
    status.classList.remove("text-warning");
    status.classList.add("text-danger");

    bar.style.width = "0%";
  }
}

/* ===============================================
   MOSTRAR ARCHIVO EN LA LISTA + BOTÓN X
================================================ */
function mostrarArchivoEnLista(file, id) {
  const fileList = document.getElementById("fileList");
  fileList.style.color = "black";
  fileList.style.fontWeight = "bold";

  const item = document.createElement("div");
  item.classList.add("file-item");
  item.dataset.id = id;

  item.innerHTML = `
        <div class="file-info archivo-click">
            <i class="fas fa-file-excel text-primary fs-4"></i>
            <div>
                <div class="file-name fw-bold">${file.name}</div>
                <div class="file-size text-muted">${(file.size / 1024).toFixed(
                  2
                )} KB</div>
            </div>
        </div>

        <button class="btn btn-sm btn-outline-danger file-remove" data-id="${id}" id="removerArchivo">
            <i class="">Remover</i>
        </button>

        <div class="file-status text-muted mt-2">Pendiente</div>

        <div class="progress-container">
            <div class="progress-bar-custom"></div>
        </div>
    `;

  fileList.innerHTML = "";
  fileList.appendChild(item);

  // Botón X para eliminar archivo
  item.querySelector("#removerArchivo").addEventListener("click", () => {
    eliminarArchivo(id);
    archivosSeleccionados = [];
    fileList.innerHTML = "";
  });

  // Al hacer clic en el archivo → abrir vista previa
  item.querySelector(".file-info").addEventListener("click", () => {
    mostrarVistaPrevia(file);
  });
}

/* ===============================================
   vista previa del documento 
================================================ */
function mostrarVistaPrevia(file) {
    const previewModal = new bootstrap.Modal(document.getElementById("modalPreview"));
    const previewContent = document.getElementById("previewContent");

    previewContent.innerHTML = `<p class="text-muted">Leyendo archivo...</p>`;

    const lector = new FileReader();

    lector.onload = function (e) {
        const datos = new Uint8Array(e.target.result);
        const workbook = XLSX.read(datos, { type: "array" });

        // Tomar la primera hoja
        const nombreHoja = workbook.SheetNames[0];
        const hoja = workbook.Sheets[nombreHoja];

        // Convertir a HTML
        const html = XLSX.utils.sheet_to_html(hoja);

        previewContent.innerHTML = `
            <h5 class="mb-3 text-center">Hoja: <strong>${nombreHoja}</strong></h5>
            ${html}
        `;
    };

    lector.readAsArrayBuffer(file);
    previewModal.show();
}



/* ===============================================
   ELIMINAR ARCHIVO
================================================ */
function eliminarArchivo(id) {
  const item = document.querySelector(`.file-item[data-id="${id}"]`);

  if (item) item.remove();

  archivosSeleccionados = archivosSeleccionados.filter((a) => a.id !== id);
}

/* ===============================================
   MOSTRAR ERROR DE ARCHIVOS NO PERMITIDOS---
================================================ */
function mostrarErrorArchivo() {
  const mensaje = document.getElementById("fileList");
  mensaje.textContent = "Solo se permiten archivos Excel (.xls o .xlsx).";
  mensaje.style.color = "red";
  mensaje.style.fontWeight = "bold";
}