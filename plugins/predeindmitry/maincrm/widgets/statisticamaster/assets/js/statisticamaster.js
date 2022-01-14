$( document ).ready(function(){
    let statisticMaster = {
        init: function(){
            $("#statisticMobileJsMaster").click(function(){
                if($(this).data("mw") == "hide"){
                    statisticMaster.showStatistic();
                }
                else{
                    statisticMaster.hideStatistic();
                }
            });
        },
        showStatistic: function(){
            $("#statisticMwMobileJsMaster").show();
            $("#statisticMobileJsMaster").data("mw", "show");
        },
        hideStatistic: function(){
            $("#statisticMwMobileJsMaster").hide();
            $("#statisticMobileJsMaster").data("mw", "hide");
        },
    };
    statisticMaster.init(); 
});