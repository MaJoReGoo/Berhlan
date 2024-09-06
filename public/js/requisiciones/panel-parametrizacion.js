import { datatablesLanguage } from "/Berhlan/public/js/lang/datatables-lang.js";
import { configureSelect2 } from "/Berhlan/public/js/select2.js";

$(document).ready(function () {
  let template_motivos = $("#template-motivos").html();
  let template_tipos_contrato = $("#template-tipos-contrato").html();
  let template_activo = $("#template-activo").html();
  let template_dotaciones = $("#template-dotaciones").html();
  let template_talla = $("#template-talla").html();

  let numeroMotivos = window.MotivosCant;
  let numeroContratos = window.TipoContratoCant;
  let numeroActivos = window.ActivosCant;
  let numeroDotaciones = window.DotacionesCant;
  let numeroTallas = window.tallasCant;


  configureSelect2();

  $("#table-motivos").DataTable({
    ordering: true,
    language: datatablesLanguage,
    order: [[0, "asc"]],

    columnDefs: [
      {
        targets: 3,
        visible: false,
      },
      {
        targets: 2,
        searchable: false,
        orderData: [3],
      },
    ],
  });
  $("#table-tipo-contrato").DataTable({
    ordering: true,
    language: datatablesLanguage,
    order: [[0, "asc"]],
    columnDefs: [
      {
        targets: 3,
        visible: false,
      },
      {
        targets: 2,
        searchable: false,
        orderData: [3],
      },
    ],
  });

  $("#table-activos").DataTable({
    ordering: true,
    language: datatablesLanguage,
    order: [[0, "asc"]],
    columnDefs: [
      {
        targets: 4,
        visible: false,
      },
      {
        targets:2,
        searchable: false,
        orderData: [4],
      },
      {
        targets: 5,
        visible: false,
      },
      {
        targets: 3,
        searchable: false,
        orderData: [5],
      }
    ],
  });

  $("#table-dotaciones").DataTable({
    ordering: true,
    language: datatablesLanguage,
    order: [[0, "asc"]],
    columnDefs: [
      {
        targets: 4,
        visible: false,
      },
      {
        targets:2,
        searchable: false,
        orderData: [4],
      },
      {
        targets: 5,
        visible: false,
      },
      {
        targets: 3,
        searchable: false,
        orderData: [5],
      }
    ],
  });

  $("#table-tallas").DataTable({
    ordering: true,
    language: datatablesLanguage,
    order: [[0, "asc"]],
    columnDefs: [
      {
        targets: 4,
        visible: false,
      },
      {
        targets:2,
        searchable: false,
        orderData: [4],
      },
      {
        targets: 5,
        visible: false,
      },
      {
        targets: 3,
        searchable: false,
        orderData: [5],
      }
    ],
  });


  $("#tipos_contratos").hide();
  $("#activos").hide();
  $("#dotaciones").hide();
  $("#tallas").hide();

  $(".agregar-motivo").click(function () {
    let clone_template_motivos = $(template_motivos);
    numeroMotivos++;
    clone_template_motivos.find(".numero_motivo").text(numeroMotivos);
    $(".contenedor-motivos").append(clone_template_motivos);
    configureSelect2();

    $(".contenedor-motivos").on("click", "#eliminar_motivo", function () {
      $(this).closest(".row").remove();
    });
  });

  $(".agregar-contrato").click(function () {
    let clone_template_tipos_contrato = $(template_tipos_contrato);
    numeroContratos++;

    clone_template_tipos_contrato
      .find(".numero_tipo_contrato")
      .text(numeroContratos);
    $(".contenedor-tipos-contrato").append(clone_template_tipos_contrato);
    configureSelect2();

    $(".contenedor-tipos-contrato").on(
      "click",
      "#eliminar-tipos-contrato",
      function () {
        $(this).closest(".row").remove();
      }
    );
  });

  $(".agregar_activo").click(function () {
    let clone_template_activo = $(template_activo);
    numeroActivos++;

    clone_template_activo.find(".numero_activo").text(numeroActivos);
    $(".contenedor-activos").append(clone_template_activo);
    configureSelect2();

    $(".contenedor-activos").on("click", "#eliminar-activo", function () {
      $(this).closest(".row").remove();
    });
  });

  $(".agregar_dotacion").click(function () {
    let clone_template_dotaciones = $(template_dotaciones);
    numeroDotaciones++;

    clone_template_dotaciones.find(".numero_dotacion").text(numeroDotaciones);
    $(".contenedor-dotaciones").append(clone_template_dotaciones);
    configureSelect2();

    $(".contenedor-dotaciones").on("click", "#eliminar_dotacion", function () {
      $(this).closest(".row").remove();
    });
  });

  $(".agregar_talla").click(function () {
    let clone_template_talla = $(template_talla);
    numeroTallas++;

    clone_template_talla.find(".numero_talla").text(numeroTallas);
    $(".contenedor-tallas").append(clone_template_talla);
    configureSelect2();

    $(".contenedor-tallas").on("click", "#eliminar_talla", function () {
      $(this).closest(".row").remove();
    });
  });

  $("#editar_motivo").click(function () {
    $(".listado-motivos select").prop("disabled", false);
    $("#actualizar_motivo").show();
  });

  $("#editar_tipo_contrato").click(function () {
    $(".listado-tipo-contrato select").prop("disabled", false);
    $("#actualizar_tipo_contrato").show();
  });

  $("#editar_activo").click(function () {
    $(".listado-activo select").prop("disabled", false);
    $("#actualizar_activo").show();
  });

  $("#editar_dotacion").click(function () {
    $(".listado-dotacion select").prop("disabled", false);
    $("#actualizar_dotacion").show();
  });

  $("#editar_talla").click(function () {
    $(".listado-tallas select").prop("disabled", false);
    $("#actualizar_talla").show();
  });

  $("#btn_motivos_rechazo").click(function () {
    $("#tipos_contratos").hide();
    $("#activos").hide();
    $("#dotaciones").hide();
    $('#tallas').hide();
    $("#motivos_rechazo").show();
    $(".mostrarTabla")
      .find("button.btn-success")
      .removeClass("btn-success")
      .addClass("btn-danger");
    $(this).removeClass("btn-danger").addClass("btn-success");
  });

  $("#btn_tipos_de_contrato").click(function () {
    $("#motivos_rechazo").hide();
    $("#activos").hide();
    $("#dotaciones").hide();
    $('#tallas').hide();
    $("#tipos_contratos").show();
    $(".mostrarTabla")
      .find("button.btn-success")
      .removeClass("btn-success")
      .addClass("btn-danger");
    $(this).removeClass("btn-danger").addClass("btn-success");
  });

  $("#btn_activos").click(function () {
    $("#tipos_contratos").hide();
    $("#motivos_rechazo").hide();
    $("#dotaciones").hide();
    $('#tallas').hide();
    $("#activos").show();
    $(".mostrarTabla")
      .find("button.btn-success")
      .removeClass("btn-success")
      .addClass("btn-danger");
    $(".mostrarTabla")
      .find("button.btn-success")
      .removeClass("btn-success")
      .addClass("btn-danger");
    $(this).removeClass("btn-danger").addClass("btn-success");
  });

  $("#btn_dotaciones").click(function () {
    $("#tipos_contratos").hide();
    $("#motivos_rechazo").hide();
    $("#activos").hide();
    $('#tallas').hide();
    $("#dotaciones").show();
    $(".mostrarTabla")
      .find("button.btn-success")
      .removeClass("btn-success")
      .addClass("btn-danger");
    $(".mostrarTabla")
      .find("button.btn-success")
      .removeClass("btn-success")
      .addClass("btn-danger");
    $(this).removeClass("btn-danger").addClass("btn-success");
  });

  $("#btn_tallas").click(function () {
    $("#tipos_contratos").hide();
    $("#motivos_rechazo").hide();
    $("#activos").hide();
    $("#dotaciones").hide();
    $('#tallas').show();
    $(".mostrarTabla")
      .find("button.btn-success")
      .removeClass("btn-success")
      .addClass("btn-danger");
    $(".mostrarTabla")
      .find("button.btn-success")
      .removeClass("btn-success")
      .addClass("btn-danger");
      $(this).removeClass("btn-danger").addClass("btn-success");
  });

});
