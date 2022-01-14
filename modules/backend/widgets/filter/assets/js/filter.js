$( document ).ready(function(){
    let filters = {
        init: function(){
            $("#filterJs").click(function(){
                if($(this).data("mw") == "hide"){
                    filters.showFilter();
                }
                else{
                    filters.hideFilter();
                }
            });
        },
        showFilter: function(){
            $("#filterMwJs").css({"display": "flex"});
            $("#filterJs").data("mw", "show");
        },
        hideFilter: function(){
            $("#filterMwJs").hide();
            $("#filterJs").data("mw", "hide");
        },
    };
    filters.init(); 
});