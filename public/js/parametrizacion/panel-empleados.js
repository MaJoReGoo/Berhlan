import { configureSelect2 } from "/Berhlan/public/js/select2.js";
import { datatablesLanguage } from "/Berhlan/public/js/lang/datatables-lang.js";

$(document).ready(function () {
  configureSelect2();


  $("#tabla-empleados").DataTable({
    language: datatablesLanguage,
  });
});
