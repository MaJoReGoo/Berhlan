import { configureSelect2 } from "/Berhlan/public/js/select2.js";
import { datatablesLanguage } from "/Berhlan/public/js/lang/datatables-lang.js";

$(document).ready(function () { 
  configureSelect2();
  autosize($("textarea"));
  $("#soli-candidatos-table").DataTable({
    ordering: true,
    language: datatablesLanguage,
    order: [[0, "desc"]],
  });

  $("#soli-dotaciones-table").DataTable({
    ordering: true,
    language: datatablesLanguage,
    order: [[0, "desc"]],
  })

});
