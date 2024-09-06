export function configureSelect2() {
  $("select").select2({
    closeOnSelect: true,
    width: "100%",
    matcher: function (params, data) {
      // Si no se ha ingresado texto de búsqueda, mostrar todas las opciones
      if ($.trim(params.term) === "") {
        return data;
      }

      // Dividir el término de búsqueda en palabras
      var terms = params.term.split(" ");

      // Recorrer todas las palabras del término de búsqueda
      for (var i = 0; i < terms.length; i++) {
        var term = terms[i].toLowerCase();
        var found = false;

        // Comprobar si alguna parte del texto coincide con la palabra de búsqueda
        if (data.text.toLowerCase().indexOf(term) > -1) {
          found = true;
        }

        // Si no se encuentra la palabra de búsqueda en el texto actual, no es una coincidencia
        if (!found) {
          return null;
        }
      }
      // Si todas las palabras coinciden, mostrar la opción
      return data;
    },
  });
}
