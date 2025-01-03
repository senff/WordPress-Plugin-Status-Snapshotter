jQuery(function($) {

    $('body').append('<div id="pluginstatussnapshotter-confirmation-overlay"></div>');

    // --- HANDLING THE TABS ----------------------------------- 

    var hash = window.location.hash;

    $('#pluginstatussnapshotter-settings .tabs-content').children().addClass('hide');

    if (hash != '') {
        $('#pluginstatussnapshotter-settings .nav-tab-wrapper a[href="' + hash + '"]').addClass('nav-tab-active');
        $('#pluginstatussnapshotter-settings .tabs-content div' + hash.replace('#', '#pluginstatussnapshotter-')).removeClass('hide');
    } else {
        $('#pluginstatussnapshotter-settings .nav-tab-wrapper a:first-child').addClass('nav-tab-active');
        $('#pluginstatussnapshotter-settings .tabs-content div#pluginstatussnapshotter-main').removeClass('hide');
    }

    $('#pluginstatussnapshotter-settings .nav-tab-wrapper a').on('click',function() {
        var tab_id = $(this).attr('href').replace('#', '#pluginstatussnapshotter-');

        // Set the current tab active
        $(this).parent().children().removeClass('nav-tab-active');
        $(this).addClass('nav-tab-active');

        // Show the active content
        $('#pluginstatussnapshotter-settings .tabs-content').children().addClass('hide');
        $('#pluginstatussnapshotter-settings .tabs-content div' + tab_id).removeClass('hide');
    });

    $('#pluginstatussnapshotter-settings a.create-first-snapshot').on('click',function() {
        var tab_id = $(this).attr('href').replace('#', '#pluginstatussnapshotter-');

        // Set the second tab active
        $('.nav-tab-wrapper').children().removeClass('nav-tab-active');
        $('.nav-tab-wrapper a:nth-of-type(2)').addClass('nav-tab-active');

        // Show the active content
        $('#pluginstatussnapshotter-settings .tabs-content').children().addClass('hide');
        $('#pluginstatussnapshotter-settings .tabs-content div#pluginstatussnapshotter-new').removeClass('hide');
    });    

    $('#pluginstatussnapshotter-settings a.help').on('click',function(h) {
        h.preventDefault();    
    });

    // --- CONFIRMING A RESTORE / DELETE -----------------------------------

    $('form#pss-snapshot-restore-delete input').on('click',function(){
        $('#pluginstatussnapshotter-confirmation-overlay, .pluginstatussnapshotter-confirmation-container, .pluginstatussnapshotter-confirmation-dialog').show();
        $('.pluginstatussnapshotter-confirmation-container').css('display','flex');
        var snapshot_id = $(this).parent().attr('data-snapshot-id');
        var snapshot_action = $(this).attr('data-snapshot-action');
        $('.pluginstatussnapshotter-confirmation-dialog .snapshotid').val(snapshot_id);
        if (snapshot_action == 'delete') {
            $('.pluginstatussnapshotter-confirmation-dialog .section-restore').hide();
            $('.pluginstatussnapshotter-confirmation-dialog .section-delete').show();
        } else {
            $('.pluginstatussnapshotter-confirmation-dialog .section-restore').show();
            $('.pluginstatussnapshotter-confirmation-dialog .section-delete').hide();
        }
    });

    $('#pluginstatussnapshotter-confirmation-overlay,.pluginstatussnapshotter-confirmation-container, .pluginstatussnapshotter-confirmation-dialog input.close-confirmation').on('click',function(c){
        $('.pluginstatussnapshotter-confirmation-dialog .snapshotid').val('');
        $('#pluginstatussnapshotter-confirmation-overlay, .pluginstatussnapshotter-confirmation-container, .pluginstatussnapshotter-confirmation-dialog').hide();
        c.preventDefault();
    });

    $('.pluginstatussnapshotter-confirmation-dialog').on('click',function(d){
        d.stopPropagation();
    });

    // --- SHOWING/HIDING THE PLUGINS IN A SNAPSHOT -----------------------------------

    $('button.show-details').on('click',function(){
        $(this).parent().find('.plugins-in-snapshot').stop(true, false).slideDown();
        $(this).hide();
        $(this).parent().find('button.hide-details').show();
    });

    $('button.hide-details').on('click',function(){
        $(this).parent().find('.plugins-in-snapshot').stop(true, false).slideUp();
        $(this).hide();
        $(this).parent().find('button.show-details').show();
    });     

    // --- SHOWING/HIDING THE PLUGINS IN A SNAPSHOT -----------------------------------

    $('.button-action').on('click',function(){
        $(this).parent().find('.spinner').addClass('is-active');
    });



});
