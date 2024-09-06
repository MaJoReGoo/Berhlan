// Variables para setear
onload=function() 
{
	cAyuda=document.getElementById("mensajesAyuda");
	cNombre=document.getElementById("ayudaTitulo");
	cTex=document.getElementById("ayudaTexto");
	divTransparente=document.getElementById("transparencia");
	divMensaje=document.getElementById("transparenciaMensaje");
	form=document.getElementById("formulario");
	urlDestino="login.php";
	
	claseNormal="input";
	claseError="inputError";
	
	ayuda=new Array();
	ayuda["Nombre"]="Ingresa tu nombre. De 4 a 50 caracteres. OBLIGATORIO";
	ayuda["Clave"]="Ingresa la Clave. OBLIGATORIO";
	
	
	preCarga("ok.gif", "img/loading.gif", "img/delete_24.png");
}

function preCarga()
{
	imagenes=new Array();
	for(i=0; i<arguments.length; i++)
	{
		imagenes[i]=document.createElement("img");
		imagenes[i].src=arguments[i];
	}
}

function nuevoAjax()
{ 
	var xmlhttp=false; 
	try 
	{ 
		// No IE
		xmlhttp=new ActiveXObject("Msxml2.XMLHTTP"); 
	}
	catch(e)
	{ 
		try
		{ 
			// IE 
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP"); 
		} 
		catch(E) { xmlhttp=false; }
	}
	if (!xmlhttp && typeof XMLHttpRequest!="undefined") { xmlhttp=new XMLHttpRequest(); } 
	return xmlhttp; 
}

function limpiaForm()
{
	for(i=0; i<=1; i++)
	{
		form.elements[i].className=claseNormal;
	}
	//document.getElementById("inputComentario").className=claseNormal;
}

function campoError(campo)
{
	campo.className=claseError;
	error=1;
}

function ocultaMensaje()
{
	divTransparente.style.display="none";
}

function muestraMensaje(mensaje)
{
	divMensaje.innerHTML=mensaje;
	divTransparente.style.display="block";
}

function eliminaEspacios(cadena)
{
	// Funcion para eliminar espacios delante y detras de cada cadena
	while(cadena.charAt(cadena.length-1)==" ") cadena=cadena.substr(0, cadena.length-1);
	while(cadena.charAt(0)==" ") cadena=cadena.substr(1, cadena.length-1);
	return cadena;
}

function validaLongitud(valor, permiteVacio, minimo, maximo)
{
	var cantCar=valor.length;
	if(valor=="")
	{
		if(permiteVacio) return true;
		else return false;
	}
	else
	{
		if(cantCar>=minimo && cantCar<=maximo) return true;
		else return false;
	}
}

function validaCorreo(valor)
{
	var reg=/(^[a-zA-Z0-9._-]{1,30})@([a-zA-Z0-9.-]{1,30}$)/;
	if(reg.test(valor)) return true;
	else return false;
}

function POST_AJAX(url, variables) {
	    
        objeto = false;
		//creamos el onjeto XMLHttpRequest para poder enviar datos mediante ajax
        if (window.XMLHttpRequest) { // Mozilla, Safari,...
           objeto = new XMLHttpRequest();
           if (objeto.overrideMimeType) {
           	objeto.overrideMimeType('text/xml');
           }
        } else if (window.ActiveXObject) { // IE
           try {
              objeto = new ActiveXObject("Msxml2.XMLHTTP");
           } catch (e) {
              try {
                 objeto = new ActiveXObject("Microsoft.XMLHTTP");
              } catch (e) {}
           }
        }
        if (!objeto) {
           alert("No se puede crear la instancia XMLHTTP");
           return false;
        } 
		
        //objeto.onreadystatechange = avisos;    /*Cuando el archivo que se mando llamar mediante ajax (checar.php) regrese un resultado, entonces lo primero que se hace es mandar llamar la funcion avios(), que es donde se imprimirá mensaje de bienvenida*/
        objeto.open("POST", url, true);  /* enviaremos los datos por el metodo POST hacia checar.php */
        objeto.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); /*asignamos header. Esto no tiene relacion con el sistema de logeo. Solo es necesario para poder enviar los datos mediante ajax*/
        objeto.setRequestHeader("Content-length", variables.length);
        objeto.setRequestHeader("Connection", "close");
        objeto.send(variables); /* enviamos las variables con un formato como este: "user=minombre&pass=123456&n=0" */
	  }


function validaForm()
{
	limpiaForm();
	error=0;
	
	var nombre=eliminaEspacios(form.inputNombre.value);
	var clave=eliminaEspacios(form.inputClave.value);
	

	if(!validaLongitud(nombre, 0, 4, 50)) campoError(form.inputNombre); //Debe Estar 0 para que valide
	if(!validaLongitud(clave, 0, 4, 50)) campoError(form.inputClave);

	
	if(error==1)
	{
		var texto="<img src='../img/delete_24.png' alt='Error'><br><br>Error: revise los campos en rojo.<br><br><button style='width:45px; height:18px; font-size:10px;' onClick='ocultaMensaje()' type='button'>Ok</button>";
		muestraMensaje(texto);
	}
	else
	{
		/*var texto="<img src='../img/loading.gif' alt='Enviando'><br>Enviando. Por favor espere.<br><br><button style='width:60px; height:18px; font-size:10px;' onClick='ocultaMensaje()' type='button'>Ocultar</button>";
		muestraMensaje(texto);*/
		
		/*var ajax=nuevoAjax();
		ajax.open("POST", urlDestino, true);
		ajax.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		ajax.send("nombre="+nombre+"&clave="+clave);*/
		
		/*ajax.onreadystatechange=function()
		{
			if (ajax.readyState==4)
			{
				var respuesta=ajax.responseText;
				if(respuesta=="OK")
				{
					var texto="<img src='ok.gif' alt='Ok'><br>Gracias por su mensaje.<br>Le responderemos a la brevedad.<br><br><button style='width:45px; height:18px; font-size:10px;' onClick='ocultaMensaje()' type='button'>Ok</button>";
				}
				else var texto="<img src='error.gif'><br><br>Error: intente más tarde.<br><br><button style='width:45px; height:18px; font-size:10px;' onClick='ocultaMensaje()' type='button'>Ok</button>";
				
				muestraMensaje(texto);
			}
		}*/
		
		    //n=0;
			var Formulario = document.getElementById('formulario');
		    var longitudFormulario = Formulario.elements.length;
			var variables = "";
		    var sepCampos = "";
		    for (var i=0; i<=Formulario.elements.length-2; i++)
		      {
		       variables += sepCampos+Formulario.elements[i].id + '=' + encodeURI(Formulario.elements[i].value);
               sepCampos="&";   
			  }
		    //indice para saber si envio formulario
		    //variables += '&n=' + n; 
		    POST_AJAX('login.php', variables);
	}
}

// Mensajes de ayuda

if(navigator.userAgent.indexOf("MSIE")>=0) navegador=0;
else navegador=1;

function colocaAyuda(event)
{
	if(navegador==0)
	{
		var corX=window.event.clientX+document.documentElement.scrollLeft;
		var corY=window.event.clientY+document.documentElement.scrollTop;
	}
	else
	{
		var corX=event.clientX+window.scrollX;
		var corY=event.clientY+window.scrollY;
	}
	cAyuda.style.top=corY+20+"px";
	cAyuda.style.left=corX+15+"px";
}

function ocultaAyuda()
{
	cAyuda.style.display="none";
	if(navegador==0) 
	{
		document.detachEvent("onmousemove", colocaAyuda);
		document.detachEvent("onmouseout", ocultaAyuda);
	}
	else 
	{
		document.removeEventListener("mousemove", colocaAyuda, true);
		document.removeEventListener("mouseout", ocultaAyuda, true);
	}
}

function muestraAyuda(event, campo)
{
	colocaAyuda(event);
	
	if(navegador==0) 
	{ 
		document.attachEvent("onmousemove", colocaAyuda); 
		document.attachEvent("onmouseout", ocultaAyuda); 
	}
	else 
	{
		document.addEventListener("mousemove", colocaAyuda, true);
		document.addEventListener("mouseout", ocultaAyuda, true);
	}
	
	cNombre.innerHTML=campo;
	cTex.innerHTML=ayuda[campo];
	cAyuda.style.display="block";
}