$( document ).ready(function() {
    $('#form_friends').change(function(){
        var id = $("#form_friends").val();
        window.location.href = url.replace('%s', id);
    });
});