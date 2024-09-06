import fetchRequest from "../fetchUtil.js";
import { datatablesLanguage } from "/Berhlan/public/js/lang/datatables-lang.js";

$(document).ready(function () {
  $(".loading").show();
  $("body").css("overflow", "hidden");
  let table = $("#elementos-table").DataTable({
    ordering: true,
    language: datatablesLanguage,
    order: [[0, "desc"]],
    columns: [
      { data: "consecutivo_elementos" },
      { data: "centro_operacion" },
      { data: "cargo" },
      { data: "fecha_aprox_ingreso" },
      { 
        data: "area",
        render: function (data, type, row) {
          if(data == 10){
            return row.estado_tic_soli_elementos;
          } else if (data == 17) {
            return row.estado_sop_soli_elementos;
          }
        }
      },
      {
        data: "id_soli_elementos",
        render: function (data, type, row) {
          return `<button class="btn btn-secondary" onclick="window.location.href='/Berhlan/public/panel/requerimientos/elementos/solicitud/${data}'"
          ><img style="height: 30px" width="30px" src="/Berhlan/public/images/detalle_new.png"></img></button>`;
        },
      },
    ],
  });

  fetchRequest("/Berhlan/public/panel/requerimientos/elementos/area")
    .then((data) => {
      console.log(data);

      if (data) {
        $(".loading").hide();
        $("body").css("overflow", "auto");
      }
      table.clear().rows.add(data).draw();
    })
    .catch((error) => {
      console.log(error);
      //window.location.reload();
      $(".loading").hide();
      $("body").css("overflow", "auto");
    });

  $(document).on("click", ".detalle", function () {
    $(".loading").show();
    $("body").css("overflow", "hidden");
    const id = $(this).data("id");

    fetchRequest("", {
      method: "post",
      headers: {
        "X-CSRF-TOKEN": csrfToken,
        "Content-Type": "application/json",
      },
      body: JSON.stringify({ id_solicitud: id }),
    })
      .then((data) => {
        $(".loading").hide();
        $("body").css("overflow", "auto");
        console.log(data);
        $("#modalGestionarIngreso").modal("show");
      })
      .catch((error) => {
        console.log(error);
        window.location.reload();
        $(".loading").hide();
        $("body").css("overflow", "auto");
      });
  });

  $("#modalGestionarIngreso").on("hidden.bs.modal", function (e) {});
});
