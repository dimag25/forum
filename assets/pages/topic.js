$(document).ready(function(){
    $("#newDiscuss").click(function(){
        $("#discussModal").modal('show');
    });
});

var url = new URL(document.URL);
AjaxMethod({"action":"get_topic_data","topicId": url.searchParams.get("topic_id")},function (data) {
   // $("#topicAccordion").html(data.data);
    console.log(data.data);
    var jsonObj=JSON.parse(data.data);
    var topicName=jsonObj[0]["topic_name"];
    document.getElementById("topicHeader").innerHTML = topicName;
    //console.log(jsonObj[0]["topic_name"]);

});

AjaxMethod({"action":"get_topic_discuss","topicId": url.searchParams.get("topic_id")},function (data) {
    $("#topicAccordion").html(data.data);
});

$("#addDiscussBtn").click(function () {
    AjaxMethod({"action":"new_discussion","discussionName":discuss_name.value,"disccusionDesc":discuss_desc.value,
            "topicId": url.searchParams.get("topic_id")},
        function (data) {
        console.log(data);
    });
});

