import fetchRequest from "../fetchUtil.js";
import { datatablesLanguage } from "/Berhlan/public/js/lang/datatables-lang.js";

$(document).ready(function () {
  $(".loading").show();
  $("body").css("overflow", "hidden");
  let table = $("#table-solicitudes").DataTable({
    ordering: true,
    language: datatablesLanguage,
    order: [[0, "desc"]],
    columns: [
      { data: "num_solicitud" },
      { data: "nombre_usr_solicita" },
      { data: "centro_operacion" },
      { data: "cargo" },
      { data: "nombre_motivo" },
      { data: "fecha_solicita" },
      { data: "nombre_estado" },
      {
        data: "num_solicitud",
        render: function (data) {
          return `<button type="button" class="btn btn-default light" 
                    onclick="window.location.href='/Berhlan/public/panel/requisiciones/consultaadm/masinfo/${data}'">
                    <img style="height: 30px" width="30px" src="/Berhlan/public/images/detalle_new.png"></img>
                    </button>`;
        },
      },
    ],
  });

  fetchRequest("/Berhlan/public/panel/requisiciones/consultaadm/listado")
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
    });

  //   fetch("http://localhost:3000/soap/add", {
  //     method: "GET",
  //     headers: {
  //       "Content-Type": "application/json",
  //     },
  //   })
  //   .then((response) => response.json())
  //   .then((data) => {
  //     console.log(data);
  //     $(".loading").hide();
  //     // Procesa los datos recibidos
  //   })
  //   .catch((error) => {
  //     console.error("Error en la solicitud fetch:", error);
  //   });
});
