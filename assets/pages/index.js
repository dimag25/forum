$("#register").click(function () {
    $("#login-panel").fadeOut(1000);
    $("#register-panel").delay(1000).fadeIn(1000);
});
$("#login").click(function () {
    $("#register-panel").fadeOut(1000);
    $("#login-panel").delay(1000).fadeIn(1000);
});


AjaxMethod({"action":"get_all_topics"},function (data) {
    $("#accordion").html(data.data);
});

$("#newTopic").click(function () {
    AjaxMethod({"action":"new_topic","topicName":topic_name.value,"topicDesc":topic_description.value},function (data) {
        console.log(data);
    });
});

$(document).ready(function(){
    $("#myBtn").click(function(){
        $("#myModal").modal('show');
    });
});
$(document).ready(function(){
    $("#newTopic").click(function(){
        $("#topicModal").modal('show');
    });
});

$("[data-toggle=tooltip]").tooltip();