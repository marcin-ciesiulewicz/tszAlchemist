/**
 * hide tag selection
 */
$(document).mouseup(function (e) {
    let container = $(".tags-hide");

    // if the target of the click isn't the container nor a descendant of the container
    if (!container.is(e.target) && container.has(e.target).length === 0) {
        container.addClass('d-none');
    }
});

/**
 * show tag selection
 */
$(document).on('click', '.add-tag', function (e) {
    e.preventDefault();
    let campaignId = $(this).data('campaign-id');
    $('.tags-container-' + campaignId).removeClass('d-none');
});

/**
 * add tag
 */
$(document).on('change','.select-tag' ,function () {
    let tagId = $(this).find(':selected').val(),
        campaignId = $(this).find(':selected').data('campaign-id'),
        tagContainer = $('.tag-container-'+campaignId),
        url = route('tags.storeTag'),
        urlIndex = route('tags.index', campaignId);

    $.ajax({
        method: "POST",
        url: url,
        data: {campaignId: campaignId, tagId: tagId},
        dataType: 'json',
        async: true

    })
        .fail(function (jqXHR, textStatus) {
            ajaxResponseFail(jqXHR.responseJSON, tagContainer)
        })
        .done(function (resp) {

            if (resp.status === 'success'){
                ajaxLoadView(urlIndex, {id: campaignId} , tagContainer);
            }else if(resp.status === 'error'){
                tagContainer.html('').append(alertNotification('danger', resp.msg)).hide().fadeIn('slow');
            }

        });
});

/**
 * remove tag
 */
$(document).on('click', '.remove-tag', function (e) {
    e.preventDefault();

    var campaignId = $(this).data('campaign-id'),
        tagId = $(this).data('tag-id'),
        tagContainer = $('.tag-container-'+campaignId),
        url = route('tags.removeTag'),
        urlIndex = route('tags.index', campaignId);

    $.ajax({
        method: "POST",
        url: url,
        data: {campaignId: campaignId, tagId: tagId},
        dataType: 'json',
        async: true
    })
        .fail(function (jqXHR, textStatus) {
            console.log(jqXHR);
            alert("Request failed: " + textStatus);
        })
        .done(function (resp) {

            if (resp.status === 'success'){
                ajaxLoadView(urlIndex, {id: campaignId} , tagContainer);
            }else if(resp.status === 'error'){
                tagContainer.html('').append(alertNotification('danger', resp.msg)).hide().fadeIn('slow');
            }
        });

});
