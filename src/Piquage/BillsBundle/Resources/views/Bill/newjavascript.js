require(["dgrid/Grid", "dojo/store/JsonRest", "dojo/request", "dojo/json", "dojo/domReady!"], 
    function(Grid,JsonRest,request, json){
        var grid = new Grid({
            columns: {
                id: "ID",
                name: "Name",
                due: "Due"
            }
        }, "grid");
                            
                            
        request.get("/app_dev.php/bills/grid/current",{
            handleAs: 'json'
        }).then(
            function(data){
                grid.renderArray(data);
                console.log("data = "+data);
            }
            )
    });
