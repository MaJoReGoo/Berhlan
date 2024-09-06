import { datatablesLanguage } from "/Berhlan/public/js/lang/datatables-lang.js";

$(document).ready(function () {
  let tiempos_estados_solicitud = window.tiempos_estados_solicitud;
  

  $("#novedades-solicitudes").DataTable({
    ordering: true,
    language: datatablesLanguage,
    order: [[1, "desc"]],
  });

  $("#ingresos").DataTable({
    ordering: true,
    language: {
      url: "//cdn.datatables.net/plug-ins/1.10.15/i18n/Spanish.json",
    },
    order: [[1, "desc"]],
  });

  $("#dotaciones").DataTable({
    ordering: true,
    language: datatablesLanguage,
    order: [[1, "desc"]],
  });
  
  tiempos_estados_solicitud = tiempos_estados_solicitud.map((item) => {
    if (item.content == "Activo") {
      item.style = "background-color: lightgreen;";
    } else if (item.content == "Aplazado") {
      item.style = "background-color: lightsalmon;";
    } else if (item.content == "Retomado") {
      item.style = "background-color: lightseagreen;";
    } else if (item.content == "Finalizado") {
      item.style = "background-color: lightskyblue;";
    }

    if (item.end === null || item.end == item.start) {
      let { end, ...rest } = item;
      return rest;
    }
    return item;
  });

  let data_estados_tiempos = new vis.DataSet(tiempos_estados_solicitud);

  let options = {
    timeAxis: {
      scale: "weekday",
      step: 1,
    },
  };

  new vis.Timeline(
    document.getElementById("linea_temporal"),
    data_estados_tiempos,
    options
  );
});
