import { configureSelect2 } from "../../js/select2.js";
import { datatablesLanguage } from "../../js/lang/datatables-lang.js";

$(document).ready(function () {
  configureSelect2();
  autosize($("textarea"));

  $("#table-mis-solicitudes").DataTable({
    ordering: true,
    language: datatablesLanguage,
    order: [1, "desc"],
  });
  
});
