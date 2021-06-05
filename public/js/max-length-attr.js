$('input.number').each(function(i) {
    if ($(this).attr('max-length') != null)
        $(this).keypress(limitMe);
});

function limitMe(e) {
    if (e.keyCode == 8) { return true; }
    return this.value.length < $(this).attr("max-length");
}