var $formDoctorPost = $("#appointment_doctorPost")
var $token = $("#appointment_token")

$formDoctorPost.change(function ()
{
    var $form = $(this).closest('form')

    var data = {}

    data[$token.attr('name')] = $token.val();
    data[$formDoctorPost.attr('name')] = $formDoctorPost.val();

    $.post($form.attr('action'), data).then(function (response)
    {
        $("#appointment_doctor").replaceWith(
            $(response).find('#appointment_doctor')
        )
    })
})