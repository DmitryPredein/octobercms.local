$( document ).ready(function(){
    let statisticManager = {
        init: function(){
            $("#statisticMobileJsManager").click(function(){
                if($(this).data("mw") == "hide"){
                    statisticManager.showStatistic();
                }
                else{
                    statisticManager.hideStatistic();
                }
            });
        },
        showStatistic: function(){
            $("#statisticMwMobileJsManager").show();
            $("#statisticMobileJsManager").data("mw", "show");
        },
        hideStatistic: function(){
            $("#statisticMwMobileJsManager").hide();
            $("#statisticMobileJsManager").data("mw", "hide");
        },
    };
    statisticManager.init();
});
