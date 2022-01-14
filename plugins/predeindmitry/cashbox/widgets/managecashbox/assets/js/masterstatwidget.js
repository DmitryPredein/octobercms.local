$( document ).ready(function() {
    
    $("#penalty").change(function() {
        if($(this).val() != "0" && $.isNumeric($(this).val())){
            $("#donePenalty").removeAttr( "disabled" );
        }
        else{
            $("#donePenalty").attr( "disabled", "disabled" );
        }
    });
    
    $("#precent").change(function() {
        if($(this).val() != "0" && $.isNumeric($(this).val())){
            $("#donePrecent").removeAttr( "disabled" );
        }
        else{
            $("#donePrecent").attr( "disabled", "disabled" );
        }
    });
    
    $("#selectMaster").change(function() {
        if($(this).val() != "-"){
            $("#precent").removeAttr( "disabled" );
            $("#penalty").removeAttr( "disabled" );
            $("#closeStat").removeAttr( "disabled" );
        }
        else{
            $("#precent").attr( "disabled", "disabled" );
            $("#penalty").attr( "disabled", "disabled" );
            $("#closeStat").attr( "disabled", "disabled" );
        }
        
        $.request('onRefresh', {
            data: {name: $(this).val()},
            update: {masterstatwidgetmaster: '#masterstatwidgetmaster'}
        });
    });
    
    $("#closeStat").click(function() {
        $.request('onCloseStat', {
            data: {name: $("#selectMaster").val()},
            update: {masterstatwidgetmaster: '#masterstatwidgetmaster'}
        });
    });
    
    $("#donePenalty").click(function() {
        $.request('onDonePenalty', {
            data: {name: $("#selectMaster").val(), penalty: $("#penalty").val()},
            update: {masterstatwidgetmaster: '#masterstatwidgetmaster'}
        });
        
        $("#penalty").val("");
        $("#donePenalty").attr( "disabled", "disabled" );
    });
    
    $("#donePrecent").click(function() {
        $.request('onDonePrecent', {
            data: {name: $("#selectMaster").val(), percent: $("#precent").val()},
            update: {masterstatwidgetmaster: '#masterstatwidgetmaster'}
        });
        
        $("#precent").val("");
        $("#donePrecent").attr( "disabled", "disabled" );
    });
});