import { configureSelect2 } from "/Berhlan/public/js/select2.js";

$(document).ready(function () {
  let empleadosPermisos = window.empleadosPermisos;

  Object.entries(empleadosPermisos).forEach(([clave, valor]) => {
    $(`#permiso-${clave}`).val(valor).trigger("change");
  });

  configureSelect2();

  $(".permisos-autorización").on("click", function () {
    $(".autorizacion select").prop("disabled", false);
    $(".enviar-permiso").show();
  });

  function actualizarOpciones() {
    let empleadosSeleccionados = [];
    $(".autorizacion select").each(function () {
      $(this)
        .find("option:selected")
        .each(function () {
          empleadosSeleccionados.push($(this).val());
        });
    });

    $(".autorizacion select").each(function () {
      $(this)
        .find("option")
        .each(function () {
          if (empleadosSeleccionados.includes($(this).val())) {
            $(this).prop("disabled", true);
          } else {
            $(this).prop("disabled", false);
          }
        });
    });
  }

  $(".autorizacion select").on("change", function () {
    actualizarOpciones();
  });

  $("form").on("submit", function (event) {
    $(".autorizacion select").each(function () {
      $(this)
        .find("option")
        .each(function () {
          $(this).prop("disabled", false);
        });
    });
  });
});
