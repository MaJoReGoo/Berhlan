import { datatablesLanguage } from "/Berhlan/public/js/lang/datatables-lang.js";

$(document).ready(function () {
  $("#message-table").DataTable({
    ordering: true,
    language: datatablesLanguage,
    order: [[0, "desc"]],
  });

  $("#fecha_solicitud_inicial").change(function () {
    var fechaIni = $("#fecha_solicitud_inicial").val();
    $("#fecha_solicitud_final")
      .attr("min", fechaIni)
      .removeAttr("disabled")
      .val("");
  });
});
