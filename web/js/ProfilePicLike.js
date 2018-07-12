
var profile = function() {
    var likes = function(id) {
        $.ajax(
            {
                type: 'POST',
                url:  Routing.generate('save_likes'),
                dataType: 'json',
                data: {id : id},
                success: function (response) {
                    $("#total-likes"+id).html(response);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    $("#error").html(textStatus + errorThrown);
                }
            }
        );
    };
    return {
        likeProfile : function(id) {
            likes(id);
        }
    };
}();

