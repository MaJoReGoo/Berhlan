<link rel="stylesheet" type="text/css" href="{{ asset('css/archivo-digital/modales/modal-archivoHistorias.blade.css') }}">

<form id="insertarDocumentosForm" method="POST" action="{{ route('insert.historias') }}" enctype="multipart/form-data">
    @csrf
    <div class="modal fade " id="adjuntarArchivos" tabindex="-1" data-backdrop="static" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Activos asignados</h5>
                </div>
                <div class="modal-body" style="padding-right: 0px">
                    <div class="row ">

                        <div class="col-md-4" style="margin: 2px;  width: 240px;  position: relative; padding: inherit">
                            <div class="wrapper" style="position: relative">
                                <label for="file" class="insert-file-upload" style="height: 70px">
                                    <div class="file-upload-design">
                                        <svg viewBox="0 0 640 512" height="50px" style="padding-top: 10px">
                                            <path
                                                d="M144 480C64.5 480 0 415.5 0 336c0-62.8 40.2-116.2 96.2-135.9c-.1-2.7-.2-5.4-.2-8.1c0-88.4 71.6-160 160-160c59.3 0 111 32.2 138.7 80.2C409.9 102 428.3 96 448 96c53 0 96 43 96 96c0 12.2-2.3 23.8-6.4 34.6C596 238.4 640 290.1 640 352c0 70.7-57.3 128-128 128H144zm79-217c-9.4 9.4-9.4 24.6 0 33.9s24.6 9.4 33.9 0l39-39V392c0 13.3 10.7 24 24 24s24-10.7 24-24V257.9l39 39c9.4 9.4 24.6 9.4 33.9 0s9.4-24.6 0-33.9l-80-80c-9.4-9.4-24.6-9.4-33.9 0l-80 80z">
                                            </path>
                                        </svg>
                                        <span class="browse-button" style="display: none">Browse file</span>
                                    </div>
                                    <input class="file-input" id="file" type="file" name="file[]" multiple accept=".jpg, .png, .pdf"
                                        style="display: none" />
                                </label>

                            </div>
                            <ul id="file-list"
                                style="word-break: break-word; overflow-y: auto; max-height: 300px; padding-left: initial;">
                            </ul>

                        </div>

                        <div class="col-md-8" style="margin: 2px;overflow-y: auto; max-height: 400px">
                            <div class="row" id="card_docs" style="height: 400px;border-left: 1px solid black;">
                            </div>

                        </div>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="row " style="padding-left: 70px">
                        <span>
                            <font>MODULO</font>
                        </span>
                        <input type="text" name="modulo" id="modulo" required>
                        <span>
                            <font>ESTREPAÑO</font>
                        </span>
                        <input type="text" name="estrepano" id="estrepano" required>
                        <span>
                            <font>N° CAJA</font>
                        </span>
                        <input type="text" name="ncaja" id="ncaja" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" id="btnEnviar">Confirmar</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" id="empleado_hidden" name="empleado_hidden">
</form>

<script>
    let nextId = 1;
    const fileList = new Set(); // Set para almacenar los archivos seleccionados
    function addRemoveButtonEventListener(li, fileName) {
        let removeBtn = li.querySelector('.remove-btn');
        removeBtn.addEventListener('click', function() {
            let id = li.dataset.id; // Obtener el ID único del elemento de la lista
            fileList.delete(fileName); // Eliminar el archivo del Set
            li.remove(); // Eliminar el elemento de la lista
            // Encontrar y eliminar el div correspondiente
            let cardDiv = document.querySelector(`.col-md-4[data-id="${id}"]`);
            if (cardDiv) {
                cardDiv.remove();
            }

            // Actualizar el input file para reflejar los archivos restantes
            const fileInput = document.querySelector('.file-input');
            const fileData = new DataTransfer();
            for (const file of fileList) {
                fileData.items.add(new File([file], file));
            }
            fileInput.files = fileData.files;
        });
    }

    document.querySelector('.file-input').addEventListener('change', function() {


        var tablaDocumentos = document.getElementById('card_docs');
        for (const file of this.files) {
            //console.log(file);
            if (!fileList.has(file.name)) {
                fileList.add(file.name);

                const reader = new FileReader();
                reader.onload = function(e) {

                    let content;
                    if (file.type.startsWith('image/')) {
                        content =
                            `<img src="${e.target.result}" class="card-img-top" style="width: 180px; height: 160px; margin-bottom: 7px; " alt="...">`;
                    } else if (file.type === 'application/pdf') {
                        content = `
                        <object data="${e.target.result}" type="application/pdf" width="180" height="160">
                            <p>Alternative text - include a link <a href="${e.target.result}">to the PDF!</a></p>
                        </object>`;
                    } else {
                        Swal.fire({

                            icon: "error",
                            title: "Formato de archivo no soportado!",
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }

                    const li = document.createElement('li');
                    let id = `file-${nextId++}`;
                    li.className += "list-group-item d-flex justify-content-between align-items-center";
                    li.dataset.id = id; // Asignar ID único al elemento de la lista
                    li.textContent = file.name;
                    let selectId = `prueba-${nextId++}`;
                    li.innerHTML +=
                        `<button class="remove-btn badge badge-pill"><font style="color:red;">X</font></button>`; // Botón para eliminar
                    tablaDocumentos.innerHTML += `
                    <div class="col-md-4"  style=" margin-bottom: 14px;  padding-left: 2px;" data-id="${id}">
                        <div class="card" >
                            ${content}
                            <div class="card-body">
                                <select class="form-select" id="${selectId}" name="categorias[]" style="width: 180px; border: 1px solid #ced4da;padding:0.375rem 0.75rem;font-size: 1.5rem;line-height: 1.5;border-radius: 0.25rem;height: 30px; border: 1px solid black;" >

                                </select>
                            </div>
                        </div>
                    </div>`;
                    document.getElementById('file-list').appendChild(li);
                    addRemoveButtonEventListener(li, file.name); // Agrega evento de clic al botón "X"
                    var empleadoId = document.getElementById('empleado_historia').value;
                    fetch(
                            `{{ env('API_BASE_URL') }}/Berhlan/public/panel/archivo/historias/tipodocs/${empleadoId}`
                        )
                        .then(response => response.json())
                        .then(data => {
                            // 'data' contiene los datos devueltos por el controlador
                            // Construir las opciones del select
                            const select = document.getElementById(selectId);
                            select.innerHTML =
                                '<option>Seleccionar</option>'; // Limpiar opciones anteriores
                            data.forEach(item => {
                                const option = document.createElement('option');
                                option.value = item.ID;
                                option.textContent = item.D;
                                select.appendChild(option);
                            });
                        })
                        .catch(error => {
                            console.error('Error al obtener los datos:', error);
                        });
                };
                if (file.type.startsWith('image/') || file.type === 'application/pdf') {
                    reader.readAsDataURL(file);
                } else {
                    Swal.fire({

                        icon: "error",
                        title: "Formato de archivo no soportado!",
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            }
        }

    });


    document.getElementById('insertarDocumentosForm').addEventListener('submit', function(event) {
        // Evitar que el formulario se envíe de forma predeterminada
        event.preventDefault();
        var empleadoId = document.getElementById('empleado_historia').value;
        // Realizar la petición AJAX para enviar el formulario
        fetch(this.action, {
                method: this.method,
                body: new FormData(this),
            })
            .then(response => {
                // Si la respuesta es exitosa, recargar la página
                if (response.ok) {
                    Swal.fire({

                        icon: "success",
                        title: "Documentos adjuntos correctamente",
                        showConfirmButton: false,
                        timer: 1500
                    });
                    localStorage.setItem('empleadoSeleccionado', empleadoId);
                    window.location.reload();
                }
            })
            .catch(error => {
                console.error('Error al enviar el formulario:', error);
            });
    });
</script>
