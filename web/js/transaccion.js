var body = document.body,
    dropArea,
    idma,
    namema,
    mantenimiento,
    droppableArr = [],
    dropAreaTimeout;

dragable();
inicio();
// initialize draggable(s)
function inicio() {
	[].slice.call(document.querySelectorAll('#grid .grid__item')).forEach(function(el) {
		if ($(el).hasClass('mant'))mantenimiento=true; else mantenimiento=false;
		if(mantenimiento===true) {
			dropArea = 'drop-area';	
			}else {
			dropArea = 'drop-area2';
			}
		drag(dropArea, el);
	});
	if(mantenimiento===true) {
		$('#lineas').removeClass('ocultar');
	}
		
}

// initialize droppables
function dragable() {
	[].slice.call(document.querySelectorAll('.drop-area .drop-area__item')).forEach(function(el) {
		id = "";
		droppableArr.push(new Droppable(el, {
			onDrop : function(instance, draggableEl) {
				// show checkmark inside the droppabe element
				idma = $(el).attr("id");
				namema = $(el).html();
				console.log("ejemplo" + idma);
				classie.add(instance.el, 'drop-feedback');
				clearTimeout(instance.checkmarkTimeout);
				instance.checkmarkTimeout = setTimeout(function() {
					classie.remove(instance.el, 'drop-feedback');
				}, 800);
				// ...
			}
		}));
	});
}

function drag(id, el) {
	dropArea = document.getElementById(id);
	new Draggable(el, droppableArr, {
		draggabilly : {
			containment : document.body
		},
		scroll : true,
		scrollable : '#' + id,
		scrollSpeed : 20,
		scrollSensitivity : 10,
		onStart : function() {
			// add class 'drag-active' to body
			classie.add(body, 'drag-active');
			// clear timeout: dropAreaTimeout (toggle drop area)
			clearTimeout(dropAreaTimeout);
			// show dropArea
			classie.add(dropArea, 'show');
		},
		onEnd : function(wasDropped) {
			var afterDropFn = function() {

			if(mantenimiento===true) {
				$(el).attr("idma", idma);
				$(el).html("maquina seleccionado");
				console.log("ejemplo3" + idma);
			}else {
				$(el).addClass("mant");
				$(el).attr("idmant", idma);
				$(el).html("Mantenimiento seleccionado");
				console.log("ejemplo2" + idma);
			
			}
				// hide dropArea
				classie.remove(dropArea, 'show');
				// remove class 'drag-active' from body
				classie.remove(body, 'drag-active');
				inicio();
			};

			if (!wasDropped) {
				afterDropFn();
			} else {
				// after some time hide drop area and remove class 'drag-active' from body
				clearTimeout(dropAreaTimeout);
				dropAreaTimeout = setTimeout(afterDropFn, 400);
			}
		}
	});
}

