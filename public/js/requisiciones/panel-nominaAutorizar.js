import { configureSelect2 } from "/Berhlan/public/js/select2.js";
import { datatablesLanguage } from "/Berhlan/public/js/lang/datatables-lang.js";
import fetchRequest from "../fetchUtil.js";

$(document).ready(function () {
  let csrfToken = $('meta[name="csrf-token"]').attr("content");
  configureSelect2();

  let template_examenes = $("#template-examenes").html();
  let template_solicitud_dotaciones = $(
    "#template-solicitud-dotaciones"
  ).html();

  let tiempos_estados_solicitud = window.tiempos_estados_solicitud;
  let niveles_cargos = window.niveles_cargos;
  let estado_soli = window.estado_soli;
  let fecha_aprobacion = window.fecha_aprobacion;
  let dias_aplazados_db = window.dias_aplazados_db;
  let fecha_aplazado = window.fecha_aplazado;
  let num_solicitud = window.num_solicitud;
  let consecutivo = window.consecutivo;
  

  if ($("#cambio_estado").val() == estado_soli) {
    $(".btn_cambio_estado").hide();
  } else {
    $(".btn_cambio_estado").show();
  }
  if ($("#cambio_estado").val() == 10) {
    $("#section-examenes").show();
  } else {
    $("#section-examenes").hide();
  }

  autosize($("textarea"));
  $("#novedades-solicitudes").DataTable({
    ordering: true,
    language: datatablesLanguage,
    order: [[1, "desc"]],
  });

  $("#ingresos").DataTable({
    ordering: true,
    language: datatablesLanguage,
    order: [[0, "desc"]],
  });

  $("#dotaciones").DataTable({
    ordering: true,
    language: datatablesLanguage,
    order: [[1, "desc"]],
  });

  if (dias_aplazados_db == null) {
    dias_aplazados_db = 0;
  }

  if (fecha_aprobacion != null) {
    fecha_aprobacion = fecha_aprobacion.replace(/^"|"$/g, "");
    fecha_aprobacion = new Date(fecha_aprobacion);
  }

  const year = new Date().getFullYear();
  let holidays = [];

  // Función para obtener los días festivos
  async function fetchHolidays(year) {
    const response = await fetch(
      `https://date.nager.at/Api/v2/PublicHolidays/${year}/CO`
    );
    const data = await response.json();
    return data;
  }

  (async () => {
    holidays = await fetchHolidays(year);
  })();

  async function calculaFechaIngreso(dias_espera) {
    let fechaActual = new Date();
    while (0 < dias_espera) {
      fechaActual.setDate(fechaActual.getDate() + 1);
      // Check if the current day is Saturday (6) or Sunday (0)
      if (fechaActual.getDay() == 6 || fechaActual.getDay() == 0) {
        continue;
      }

      if (
        holidays.some(
          (holiday) => holiday.date === fechaActual.toISOString().slice(0, 10)
        )
      ) {
        continue;
      }

      dias_espera--;
    }

    return fechaActual;
  }

  /* Funciones calculos de fechas */

  function calcularDiasAplazado() {
    let fechaActual = new Date();
    fechaActual = new Date(
      fechaActual.getFullYear(),
      fechaActual.getMonth(),
      fechaActual.getDate(),
      0,
      0,
      0
    );

    let fecha_aplazado_copia = new Date(fecha_aplazado + "T00:00:00");

    let diferenciaMilisegundos = fechaActual - fecha_aplazado_copia;
    let dias = Math.floor(diferenciaMilisegundos / (1000 * 60 * 60 * 24));
    let diasAplazados = 0;

    while (dias > 0) {
      fecha_aplazado_copia.setDate(fecha_aplazado_copia.getDate() + 1);
      dias--;

      if (
        fecha_aplazado_copia.getDay() == 6 ||
        fecha_aplazado_copia.getDay() == 0
      ) {
        continue;
      }
      if (
        holidays.some(
          (holiday) =>
            holiday.date === fecha_aplazado_copia.toISOString().slice(0, 10)
        )
      ) {
        continue;
      }

      diasAplazados++;
    }
    return diasAplazados;
  }

  function calcularDiasHabilesProceso() {
    let fechaActual = new Date();
    fechaActual = new Date(
      fechaActual.getFullYear(),
      fechaActual.getMonth(),
      fechaActual.getDate(),
      0,
      0,
      0
    );

    let fecha_aprobacion_copia = new Date(fecha_aprobacion);
    let diferenciaMilisegundos = fechaActual - fecha_aprobacion_copia;
    let dias = Math.floor(diferenciaMilisegundos / (1000 * 60 * 60 * 24));

    let diasCalculados = 0;

    while (dias > 0) {
      dias--;
      fecha_aprobacion_copia.setDate(fecha_aprobacion_copia.getDate() + 1);
      if (
        fecha_aprobacion_copia.getDay() == 6 ||
        fecha_aprobacion_copia.getDay() == 0
      ) {
        continue;
      }
      if (
        holidays.some(
          (holiday) =>
            holiday.date === fecha_aprobacion_copia.toISOString().slice(0, 10)
        )
      ) {
        continue;
      }

      diasCalculados++;
    }

    return diasCalculados;
  }

  /* --------------------------------- */

  $("#nivel_cargo").on("change", async function () {
    let diasIngreso;

    niveles_cargos.forEach((nivel_cargo) => {
      if ($(this).val() == nivel_cargo.id_nivel_cargo) {
        diasIngreso = nivel_cargo.dias_nivel_cargo;
      }
    });

    let fecha_ingreso = await calculaFechaIngreso(diasIngreso);
    console.log(fecha_ingreso);
    fecha_ingreso = fecha_ingreso.toISOString().split("T")[0];
    $("#fecha_estimada").val(fecha_ingreso);
  });

  $("#cambio_estado").on("change", async function () {
    if ($(this).val() == estado_soli) {
      $(".btn_cambio_estado").hide();
    } else {
      $(".btn_cambio_estado").show();
    }

    if (estado_soli == 10 && $(this).val() == 10) {
      $("#section-examenes").show();
    } else {
      $("#section-examenes").hide();
    }

    //Cuando el estado es aplazado

    if ($(this).val() == 9) {
      let dias_proceso = calcularDiasHabilesProceso();
      let dias_proceso_real = calcularDiasHabilesProceso() - dias_aplazados_db;
      $("input[name=dias_proceso]").val(dias_proceso);
      $("input[name=dias_proceso_real]").val(dias_proceso_real);
      $(".notificar").show();
    } else {
      $(".notificar").hide();
    }

    //Cuando el estado es aplazado y se vuelve activar

    if (estado_soli == 9) {
      if ($(this).val() == 5 || $(this).val() == 3) {
        let diasIngreso;
        niveles_cargos.forEach((nivel_cargo) => {
          if ($("#nivel_cargo").val() == nivel_cargo.id_nivel_cargo) {
            diasIngreso = nivel_cargo.dias_nivel_cargo;
          }
        });
        $(".fecha_aprox_ingreso").hide();
        $(".nueva_fecha").show();
        let fecha_ingreso = await calculaFechaIngreso(diasIngreso);
        fecha_ingreso = fecha_ingreso.toISOString().split("T")[0];
        $("#nueva_fecha_aprox").val(fecha_ingreso);
      }

      let dias_aplazado = calcularDiasAplazado() + parseInt(dias_aplazados_db);
      let dias_proceso = calcularDiasHabilesProceso();
      let dias_proceso_real = calcularDiasHabilesProceso() - dias_aplazado;

      $("input[name=dias_proceso]").val(dias_proceso);
      $("input[name=dias_proceso_real]").val(dias_proceso_real);
      $("input[name=dias_aplazado]").val(dias_aplazado);
    } else {
      $(".fecha_aprox_ingreso").show();
      $(".nueva_fecha").hide();
      $("input[name=dias_aplazado]").val("");
    }
    if (estado_soli != 5 || estado_soli != 3) {
      if ($(this).val() == 5 || $(this).val() == 3) {
        let dias_aplazado =
          calcularDiasAplazado() + parseInt(dias_aplazados_db);
        let dias_proceso = calcularDiasHabilesProceso();
        let dias_proceso_real = calcularDiasHabilesProceso() - dias_aplazado;
        $("input[name=dias_proceso]").val(dias_proceso);
        $("input[name=dias_proceso_real]").val(dias_proceso_real);
        $("input[name=dias_aplazado]").val(dias_aplazado);
      }
    }

    // Cuando el estado es finalizado
    if ($(this).val() == 6) {
      let dias_aplazado = calcularDiasAplazado() + parseInt(dias_aplazados_db);
      let dias_proceso = calcularDiasHabilesProceso();
      let dias_proceso_real = calcularDiasHabilesProceso() - dias_aplazado;
      $("input[name=dias_proceso]").val(dias_proceso);
      $("input[name=dias_proceso_real]").val(dias_proceso_real);
      $("input[name=dias_aplazado]").val(dias_aplazado);
    }
    //Cuando el cambio estado es cancelado
    if ($(this).val() == 7) {
      let dias_aplazado = calcularDiasAplazado() + parseInt(dias_aplazados_db);
      let dias_proceso = calcularDiasHabilesProceso();
      let dias_proceso_real = calcularDiasHabilesProceso() - dias_aplazado;
      $("input[name=dias_proceso]").val(dias_proceso);
      $("input[name=dias_proceso_real]").val(dias_proceso_real);
      $("input[name=dias_aplazado]").val(dias_aplazado);
    }
    //Cuando el estado
    if ($(this).val() == 10) {
      let dias_aplazado = calcularDiasAplazado() + parseInt(dias_aplazados_db);
      let dias_proceso = calcularDiasHabilesProceso();
      let dias_proceso_real = calcularDiasHabilesProceso() - dias_aplazado;
      $("input[name=dias_proceso]").val(dias_proceso);
      $("input[name=dias_proceso_real]").val(dias_proceso_real);
      $("input[name=dias_aplazado]").val(dias_aplazado);
    }
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
  let incrementable = 1;

  $(".agregar-examen").click(function () {
    let clone_template_examenes = $(template_examenes);

    consecutivo++;
    console.log(consecutivo);

    clone_template_examenes
      .find(".input-examen")
      .attr("name", `examen_medico${incrementable}`);
    clone_template_examenes
      .find(".input-genero")
      .attr("name", `genero${incrementable}`);
    clone_template_examenes
      .find(".consecutivo")
      .text(num_solicitud + "-" + consecutivo);
    clone_template_examenes
      .find('input[name="consecutivo[]"]')
      .val(num_solicitud + "-" + consecutivo);
    incrementable++;
    $(".contenedor-examenes").append(clone_template_examenes);

    
  });

  $(".contenedor-examenes").on("click", "#eliminar_examen", function () {
    $(this).closest(".examen").remove();
    let copia_consecutivo = window.consecutivo;
    console.log(copia_consecutivo);
    
    $(".consecutivo").each(function (index, element) {
        $(element).text(num_solicitud + "-" +copia_consecutivo++);
    });
    consecutivo--;
  });

  $(".pedir_dotacion").click(function () {
    let id = $(this).data("id");
    fetchRequest(
      "/Berhlan/public/panel/requisiciones/gestion/ingresos/detalle",
      {
        method: "POST",
        headers: {
          "X-CSRF-TOKEN": csrfToken,
          "Content-Type": "application/json",
        },
        body: JSON.stringify({ id_soli_ingreso: id }),
      }
    ).then((data) => {
      $(".loading").hide();
      $("body").css("overflow", "auto");
      console.log(data);

      $("#modalPedirDotacion").modal("show");

      $("#titulo-ingreso").text("Ingreso No. " + data[0].consecutivo);
      $("#id_soli_ingreso").val(data[0].id_soli_ingreso);
      $("#num_solicitud").val(data[0].fk_num_solicitud);
      $("#nombre_completo").text(data[0].nombre_soli_ingreso);
      $("#genero_soli_ingreso").text(data[0].genero_soli_ingreso);
      $("#cedula_soli_ingreso").text(data[0].cedula_soli_ingreso);
      $("#correo_soli_ingreso").text(data[0].correo_soli_ingreso);
      $("#telefono_soli_ingreso").text(data[0].telefono_soli_ingreso);
      $("#estado_soli_ingreso").text(data[0].nombre_estado_ingreso);
      actualizarTallas();
    });
  });

  function actualizarTallas() {
    $('select[name = "dotacion[]"]').change(function () {
      let selectTallas = $(this).closest(".row").find('select[name="talla[]"]');
      selectTallas.prop("disabled", true);
      fetchRequest("/Berhlan/public/panel/requisiciones/tallas/dotacion", {
        method: "POST",
        headers: {
          "X-CSRF-TOKEN": csrfToken,
          "Content-Type": "application/json",
        },
        body: JSON.stringify({ id_dotacion: $(this).val() }),
      })
        .then((data) => {
          selectTallas.empty();
          selectTallas.append('<option value="">Seleccione una talla</option>');
          data.forEach((talla) => {
            selectTallas.append(
              `<option value="${talla.id_talla_dotacion}">${talla.nombre_talla_dotacion}</option>`
            );
          });
          selectTallas.prop("disabled", false);
        })
        .catch((error) => {
          console.log(error);
        });
    });
  }



  $(".agregar-soli-dotacion").click(function () {
    let clone_template_solicitud_dotaciones = $(template_solicitud_dotaciones);

    $(".contenedor-solicitud-dotaciones").append(
      clone_template_solicitud_dotaciones
    );
    configureSelect2();
    actualizarTallas();

    $(".contenedor-solicitud-dotaciones").on(
      "click",
      "#eliminar_dotacion",
      function () {
        $(this).closest(".row").remove();
      }
    );
  });

  $("#modalPedirDotacion").on("hidden.bs.modal", function () {
    $(".contenedor-solicitud-dotaciones").empty();
    $('#modalPedirDotacion select').val(null).trigger('change'); 
    $("#modalPedirDotacion").find("input").val("");
  });

});
