import fetchRequest from "../fetchUtil.js";
import { datatablesLanguage } from "/Berhlan/public/js/lang/datatables-lang.js";

$(document).ready(function () {
  $(".loading").show();
  let csrfToken = $('meta[name="csrf-token"]').attr("content");

  $("body").css("overflow", "hidden");
  let table_ingresos = $("#table-gestion_ingresos").DataTable({
    ordering: true,
    language: datatablesLanguage,
    order: [[0, "desc"]],
    columns: [
      { data: "consecutivo" },
      { data: "nombre_soli_ingreso" },
      { data: "genero_soli_ingreso" },
      { data: "cedula_soli_ingreso" },
      { data: "correo_soli_ingreso" },
      { data: "telefono_soli_ingreso" },
      { data: "estado_diligencia_ingreso" },
      {
        data: "id_soli_ingreso",
        render: function (data) {
          return `<button type="button" class="btn btn-default detalle" data-id="${data}"><img style="height: 30px" width="30px" src="/Berhlan/public/images/detalle_new.png"></img></button>`;
        },
      },
    ],
  });

  let table_examenes = $("#table-examenes_ingresos").DataTable({
    ordering: true,
    language: datatablesLanguage,
    order: [[0, "desc"]],
    columns: [
      { data: "consecutivo" },
      { data: "cedula_soli_ingreso" },
      { data: "nombre_soli_ingreso" },
      { data: "lugar" },
      { data: "hora" },
      { data: "estado_examen" },
      { data: "resultado" },
      {
        data: "concepto",
        render: function (data) {
          if (data === null) {
            return "No hay concepto";
          } else {
            return `<a href="/Berhlan/public/panel/ssl/descargar/concepto/${data}">${data}</a>`;
          }
        },
      },
    ],
  });

  fetchRequest("/Berhlan/public/panel/requisiciones/gestion/ingresos/datos")
    .then((data) => {
      console.log(data);
      if (data) {
        $(".loading").hide();
        $("body").css("overflow", "auto");
      }
      table_ingresos.clear().rows.add(data).draw();
    })
    .catch((error) => {
      console.log(error);
    });

  $(document).on("click", ".detalle", function () {
    $(".loading").show();
    $("body").css("overflow", "hidden");
    const id = $(this).data("id");

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
    )
      .then((data) => {
        $(".loading").hide();
        $("body").css("overflow", "auto");
        $("#infoIngreso").text(`Informacion de ingreso ${data[0].consecutivo}`);
        $("#consecutivo").text(data[0].consecutivo);
        $("#nombre_soli_ingreso").text(data[0].nombre_soli_ingreso);
        $("#genero_soli_ingreso").text(data[0].genero_soli_ingreso);
        $("#cedula_soli_ingreso").text(data[0].cedula_soli_ingreso);
        $("#correo_soli_ingreso").text(data[0].correo_soli_ingreso);
        $("#telefono_soli_ingreso").text(data[0].telefono_soli_ingreso);
        $("#estado_diligencia_ingreso").text(data[0].estado_diligencia_ingreso);
        $("#id_soli_ingreso").val(data[0].id_soli_ingreso);
        $("#fecha_induccion").prop("disabled", false);
        $("#fecha_inicio_laboral").prop("disabled", false);
        $("#gestionar").show();

        if (data[0].fecha_induccion != null) {
          $("#fecha_induccion").val(data[0].fecha_induccion);
          $("#fecha_induccion").prop("disabled", true);
        }

        if (data[0].fecha_inicio_laboral != null) {
          $("#fecha_inicio_laboral").val(data[0].fecha_inicio_laboral);
          $("#fecha_inicio_laboral").prop("disabled", true);
          $("#gestionar").hide();
        }
        $("#modalGestionarIngresos").modal("show");
      })
      .catch((error) => {
        console.log(error);
      });
  });

  fetchRequest("/Berhlan/public/panel/requisiciones/gestion/ingresos/examenes")
    .then((data) => {
      console.log(data);
      table_examenes.clear().rows.add(data).draw();
    })
    .catch((error) => {
      console.log(error);
    });

  $("#modalGestionarIngresos").on("hidden.bs.modal", function (e) {
    $("#gestionarIngreso")[0].reset();
  });

  $("#ingresos").on("click", function () {
    $(".info-ingresos").show();
    $(".info-examenes-ingresos").hide();
    $(".cambio-listado")
      .find("button.btn-success")
      .removeClass("btn-success")
      .addClass("btn-danger");
    $(this).removeClass("btn-danger").addClass("btn-success");
  });

  $("#examenes_ingresos").on("click", function () {
    $(".info-examenes-ingresos").show();
    $(".info-ingresos").hide();
    $(".cambio-listado")
      .find("button.btn-success")
      .removeClass("btn-success")
      .addClass("btn-danger");
    $(this).removeClass("btn-danger").addClass("btn-success");
  });
});
