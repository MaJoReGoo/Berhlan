import { configureSelect2 } from "/Berhlan/public/js/select2.js";

$(document).ready(function () {
  configureSelect2();

  let html = `<tr>
<td>
    <input class="with_input" type="text" name="nombre_nivel_cargo[]" required>
</td>
<td>
    <input class="with_input" type="number" name="dias_nivel_cargo[]" required >
</td>
<td>
    <select class="gui-input" name="estado_nivel_cargo[]" required>
        <option value="1">Activo</option>
        <option value="2">Inactivo</option>
    </select>
    <a class="eliminar_nivel_cargo" style = "color:red; cursor:pointer;" ><i class="fa-regular fa-trash-can fa-xl"></i></a>
</td>
</tr>`;

  $(".agregar").click(function () {
    $(".listado-cargos").append(html);
    configureSelect2();
    $(".listado-cargos").on("click", ".eliminar_nivel_cargo", function () {
      $(this).closest("tr").remove();
    });
  });

  $("#editar_nivel_cargo").click(function () {
    $(".listado-cargos input").prop("disabled", false);
    $(".listado-cargos select").prop("disabled", false);
    $(".listado-cargos textarea").prop("disabled", false);
    $("#actualizar_nivel_cargo").show();
    $("#agregar_nivel_cargo").show();
  });

  /* PETICIONES AJAX */

  $("#nivelCargoForm").on("submit", function (event) {
    event.preventDefault(); // Evita el envío normal del formulario
    let formData = $("#nivelCargoForm").serialize();
    $.ajax({
      url: "{{ route('gestionarNivelesCargos') }}",
      type: "POST",
      data: formData,
      success: function (response) {
        Swal.fire({
          position: "center",
          width: 500,
          padding: "3em",
          icon: "success",
          title: "Guardado con exito",
          showConfirmButton: false,
          timer: 1500,
        });
      },
      error: function (xhr, status, error) {
        console.error("Error al guardar cambios:", error);
        alert("Ocurrió un error al guardar los cambios");
      },
    });
  });
});
