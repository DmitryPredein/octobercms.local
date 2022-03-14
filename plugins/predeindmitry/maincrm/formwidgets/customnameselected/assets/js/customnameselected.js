$(document).ready(function() {
	let nameSelected = {
		init: function (){
			let _this = nameSelected;

			$(document).on("focus", ".LayautsFlexColumn .form-controlOtchest", function(){
				if ($(this).val().length >= 3) {
					_this.show(this);
					_this.selectedFilter(this);
				}
			});

			$(document).on("input", ".LayautsFlexColumn .form-controlOtchest", function(){
				if ($(this).val().length >= 3) {
					_this.show(this);
					_this.selectedFilter(this);
				}
			});

			$(document).on("input", ".LayautsFlexColumn .form-controlOtchest", function(){
				if ($(this).val().length < 3) {
					_this.hide(this);
				}
			});

			$(document).on("blur", ".LayautsFlexColumn .form-controlOtchest", function(){
				_this.hide(this);
			});

			$(document).on("click",  ".LayautsFlexColumn .formNameSelectedUl li", function(){
				let valName = $(this).data("name");
				let valTel = $(this).data("tel");
				let valId = $(this).data("id");
				_this.selected(valName, valTel, valId);
				$("#controlOtchestIdTel").attr("disabled", true);
			});

			$(document).on("input",  ".LayautsFlexColumn .form-controlOtchest, #controlOtchestIdTel", function(){
				if($("#controlOtchestFinal").data("check") == "select"){
					_this.selectedDel(this);
					$("#controlOtchestIdTel").removeAttr("disabled");
				}
				_this.selectedFilter(this);
				_this.addInputFinal(id = null);
			});

			$(document).on("input",  "#controlOtchestIdTelUpdate, #controlOtchestIdNameUpdate", function(){
				if($(this).val() != ""){
					_this.updateName();
				}
				else{
					_this.selectedDel(elem = "update");
				}

			});
		},
		show: function(elem){
			$(elem).siblings(".formNameSelectedUl").slideDown();
		},
		hide: function(elem){
			$(elem).siblings(".formNameSelectedUl").slideUp();
		},
		selected: function(valName, valTel, valId){
			let _this = nameSelected;
			valName = valName.split(' ');

			let firstName = valName[0];
			let name = valName[1];
			let lastName = valName[2];

			$("#controlOtchestIdTel").val(valTel);
			$("#controlOtchestIdFirstName").val(firstName);
			$("#controlOtchestIdName").val(name);
			$("#controlOtchestIdLastName").val(lastName);

			$("#controlOtchestFinal").data("check", "select");
			_this.addInputFinal(valId);
		},
		selectedDel: function(elem){
			if($(elem).is("#controlOtchestIdTel")){
				$("#controlOtchestIdFirstName").val(null);
				$("#controlOtchestIdName").val(null);
				$("#controlOtchestIdLastName").val(null);
				$("#controlOtchestFinal").val(null);
			}
			else if($(elem).is("#controlOtchestIdFirstName")){
				$("#controlOtchestIdTel").val(null);
				$("#controlOtchestIdName").val(null);
				$("#controlOtchestIdLastName").val(null);
				$("#controlOtchestFinal").val(null);
			}
			else if($(elem).is("#controlOtchestIdName")){
				$("#controlOtchestIdTel").val(null);
				$("#controlOtchestIdFirstName").val(null);
				$("#controlOtchestIdLastName").val(null);
				$("#controlOtchestFinal").val(null);
			}
			else if($(elem).is("#controlOtchestIdLastName")){
				$("#controlOtchestIdTel").val(null);
				$("#controlOtchestIdFirstName").val(null);
				$("#controlOtchestIdName").val(null);
				$("#controlOtchestFinal").val(null);
			}
			else if(elem == "update"){
				$("#controlOtchestFinalUpdate").val(null);
			}
			$("#controlOtchestFinal").data("check", "custom");
		},
		selectedFilter: function(elem){
			let textFilter = $(elem).val().toLowerCase();
			$(".LayautsFlexColumn .formNameSelectedUl li").filter(function() {
				$(this).toggle($(this).text().toLowerCase().indexOf(textFilter) > -1);
			});
		},
		addInputFinal: function(id){
			if($("#controlOtchestFinal").data("check") == "custom"){
				if($("#controlOtchestIdTel").val() != "" && $("#controlOtchestIdFirstName").val() != "" && $("#controlOtchestIdName").val() != "" && $("#controlOtchestIdLastName").val() != ""){
					$("#controlOtchestFinal").val($("#controlOtchestFinal").data("check")+":::"+$("#controlOtchestIdTel").val()+":::"+$("#controlOtchestIdFirstName").val()+":::"+$("#controlOtchestIdName").val()+":::"+$("#controlOtchestIdLastName").val());
				}
			}
			else{
				$("#controlOtchestFinal").val($("#controlOtchestFinal").data("check")+":::"+id);
			}
		},
		updateName: function(){
			$("#controlOtchestFinalUpdate").val("update"+":::"+$("#controlOtchestFinalUpdate").data("id")+":::"+$("#controlOtchestIdNameUpdate").val()+":::"+$("#controlOtchestIdTelUpdate").val());
		},
	};
	let maskTel = {
		init: function(){
			$("#controlOtchestIdTel").mask("+7 (999) 99-99-999", {
				completed: function(){
				  nameSelected.addInputFinal();
				}
			});
		},
	};

	nameSelected.init();
	maskTel.init();
});
