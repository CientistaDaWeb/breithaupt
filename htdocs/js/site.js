$(function () {
    $("#slideshow_content").jqFancyTransitions({
        width: 940,
        height: 238,
        effect: 'zipper',
        navigation: true,
        links: true
    });
    $('#Form_Newsletter').ajaxForm({
        target: '#retornoNews',
        url: '/fale-conosco/cadastranews',
        sucess: function () {
            $('#Form_Newsletter').resetForm();
        }
    });
});