$( document ).ready(function() {
    
    $("#komment, #sum").change(function() {
        if($("#sum").val() != null && $("#sum").val() != undefined && $("#sum").val() != "" && $("#sum").val() != 0 && $("#komment").val() != null && $("#komment").val() != undefined && $("#komment").val() != "" && $("#komment").val() != 0 && $.isNumeric($("#sum").val())){
            $(".conteiner_manage_cashbox_admin button").removeAttr("disabled");
        }
        else{
            $(".conteiner_manage_cashbox_admin button").attr("disabled", "disabled");
        }
    });
    
    $("#plus-request, #minus-request").click(function() {
        $.request('onCahsManage', {
            data: {sum: $("#sum").val(), koment: $("#komment").val(), pay: $("#selectPayType").val(), type: $(this).attr("id")=="plus-request"?'nal':'expenses', stock: $("#selectStock").val()},
            update: {managecashbox_tabl: '.conteiner_manage_cashbox_tabl'}
        });
        
        $("#komment, #sum").val("");
        $(".conteiner_manage_cashbox_admin button").attr( "disabled", "disabled" );
    });
    
    $("#selectStock").change(function() {
        if($(this).val() != "-"){
            $("#komment, #sum").removeAttr( "disabled" );
        }
        else{
            $("#komment, #sum").attr( "disabled", "disabled" );
        }
        
        $.request('onRefresh', {
            data: {stock: $(this).val()},
            update: {managecashbox_tabl: '.conteiner_manage_cashbox_tabl'}
        });
    });
});