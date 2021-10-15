$(document).ready(function () {

    moment.updateLocale('en', {
        week: {dow: 1} // Monday is the first day of the week
    })

    $('.select-all').click(function () {
        let $select2 = $(this).parent().siblings('.select2')
        $select2.find('option').prop('selected', 'selected')
        $select2.trigger('change')
    })
    $('.deselect-all').click(function () {
        let $select2 = $(this).parent().siblings('.select2')
        $select2.find('option').prop('selected', '')
        $select2.trigger('change')
    })


    $('.treeview').each(function () {
        var shouldExpand = false
        $(this).find('li').each(function () {
            if ($(this).hasClass('active')) {
                shouldExpand = true
            }
        })
        if (shouldExpand) {
            $(this).addClass('active')
        }
    })

    $('[data-toggle="tooltip"]').tooltip();

    document.addEventListener("wheel", function (event) {
        if (document.activeElement.type === "number" &&
            document.activeElement.classList.contains("noscroll")) {
            document.activeElement.blur();
        }
    });

    //setup ajax
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

});
