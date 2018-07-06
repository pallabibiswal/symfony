var profile = function() {
    var likes = function() {
        $.ajax(
            {
                type: 'POST',
                url:  Routing.generate('save_likes'),
                dataType: 'json',
                success: function (response) {
                    console.log(response);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                }
            }
        );
    };
    return {
        likeProfile : likes
    };
}();

$(document).ready(function() {
    $("#like-btn").on("click", function() {
        profile.likeProfile();
    });
});