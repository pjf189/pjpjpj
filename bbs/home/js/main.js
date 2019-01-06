$(".setting").click(function(){
    $(".leftPage").toggle();
    });

$(document).ready(function(){
    $("#btn").on("click",function(){
        $.post("../dianzan.php",{name:$("#btn").val()},function(data){
            $("#s").text(data);
        });
    });
});
