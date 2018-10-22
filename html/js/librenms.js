function override_config(event, state, tmp_this) {
    event.preventDefault();
    var $this = tmp_this;
    var attrib = $this.data('attrib');
    var device_id = $this.data('device_id');
    $.ajax({
        type: 'POST',
        url: 'ajax_form.php',
        data: { type: 'override-config', device_id: device_id, attrib: attrib, state: state },
        dataType: 'json',
        success: function(data) {
            if (data.status == 'ok') {
                toastr.success(data.message);
            }
            else {
                toastr.error(data.message);
            }
        },
        error: function() {
            toastr.error('Could not set this override');
        }
    });
}

var oldH;
var oldW;
$(document).ready(function() {
    // Device override ajax calls
    $("[name='override_config']").bootstrapSwitch('offColor','danger');
    $('input[name="override_config"]').on('switchChange.bootstrapSwitch',  function(event, state) {
        override_config(event,state,$(this));
    });

    // Device override for text inputs
    $(document).on('blur', 'input[name="override_config_text"]', function(event) {
        event.preventDefault();
        var $this = $(this);
        var attrib = $this.data('attrib');
        var device_id = $this.data('device_id');
        var value = $this.val();
        $.ajax({
            type: 'POST',
            url: 'ajax_form.php',
            data: { type: 'override-config', device_id: device_id, attrib: attrib, state: value },
            dataType: 'json',
            success: function(data) {
                if (data.status == 'ok') {
                    toastr.success(data.message);
                }
                else {
                    toastr.error(data.message);
                }
            },
            error: function() {
                toastr.error('Could not set this override');
            }
        });
    });

    // Checkbox config ajax calls
    $("[name='global-config-check']").bootstrapSwitch('offColor','danger');
    $('input[name="global-config-check"]').on('switchChange.bootstrapSwitch',  function(event, state) {
        event.preventDefault();
        var $this = $(this);
        var config_id = $this.data("config_id");
        $.ajax({
            type: 'POST',
            url: 'ajax_form.php',
            data: {type: "update-config-item", config_id: config_id, config_value: state},
            dataType: "json",
            success: function (data) {
                if (data.status == 'ok') {
                    toastr.success('Config updated');
                } else {
                    toastr.error(data.message);
                }
            },
            error: function () {
                toastr.error(data.message);
            }
        });
    });

    // Input field config ajax calls
    $(document).on('blur', 'input[name="global-config-input"]', function(event) {
        event.preventDefault();
        var $this = $(this);
        var config_id = $this.data("config_id");
        var config_value = $this.val();
        $.ajax({
            type: 'POST',
            url: 'ajax_form.php',
            data: {type: "update-config-item", config_id: config_id, config_value: config_value},
            dataType: "json",
            success: function (data) {
                if (data.status == 'ok') {
                    toastr.success('Config updated');
                } else {
                    toastr.error(data.message);
                }
            },
            error: function () {
                toastr.error(data.message);
            }
        });
    });

    // Select config ajax calls
    $( 'select[name="global-config-select"]').change(function(event) {
        event.preventDefault();
        var $this = $(this);
        var config_id = $this.data("config_id");
        var config_value = $this.val();
        $.ajax({
            type: 'POST',
            url: 'ajax_form.php',
            data: {type: "update-config-item", config_id: config_id, config_value: config_value},
            dataType: "json",
            success: function (data) {
                if (data.status == 'ok') {
                    toastr.success('Config updated');
                } else {
                    toastr.error(data.message);
                }
            },
            error: function () {
                toastr.error(data.message);
            }
        });
    });

    oldW=$(window).width();
    oldH=$(window).height();
});

function submitCustomRange(frmdata) {
    var reto = /to=([0-9a-zA-Z\-])+/g;
    var refrom = /from=([0-9a-zA-Z\-])+/g;
    var tsto = moment(frmdata.dtpickerto.value).unix();
    var tsfrom = moment(frmdata.dtpickerfrom.value).unix();
    frmdata.selfaction.value = frmdata.selfaction.value.replace(reto, 'to=' + tsto);
    frmdata.selfaction.value = frmdata.selfaction.value.replace(refrom, 'from=' + tsfrom);
    frmdata.action = frmdata.selfaction.value;
    return true;
}

function updateResolution(refresh)
{
    $.post('ajax_setresolution.php', 
        {
            width: $(window).width(),
            height:$(window).height()
        },
        function(data) {
            if(refresh == true) {
                location.reload();
            }
        },'json'
    );
}

var rtime;
var timeout = false;
var delta = 500;
var newH;
var newW;

$(window).on('resize', function(){
    rtime = new Date();
    if (timeout === false && !(typeof no_refresh === 'boolean' && no_refresh === true)) {
        timeout = true;
        setTimeout(resizeend, delta);
    }
});

function resizeend() {
    if (new Date() - rtime < delta) {
        setTimeout(resizeend, delta);
    } 
    else {
        newH=$(window).height();
        newW=$(window).width();
        timeout = false;
        if(Math.abs(oldW - newW) >= 200)
        {
            refresh = true;
        }
        else {
            refresh = false;
            resizeGraphs();
        }
        updateResolution(refresh);
    }  
};

function resizeGraphs() {
    ratioW=newW/oldW;
    ratioH=newH/oldH;

    $('.graphs').each(function (){
        var img = jQuery(this);
        img.attr('width',img.width() * ratioW);
    });
    oldH=newH;
    oldW=newW;
}


$(document).on("click", '.collapse-neighbors', function(event)
{
    var caller = $(this);
    var button = caller.find('.neighbors-button');
    var list = caller.find('.neighbors-interface-list');
    var continued = caller.find('.neighbors-list-continued');

    if(button.hasClass("fa-plus")) {
        button.addClass('fa-minus').removeClass('fa-plus');
    }
    else {
        button.addClass('fa-plus').removeClass('fa-minus');
    }
   
    list.toggle();
    continued.toggle();
});

//availability-map mode change
$(document).on("change", '#mode', function() {
    $.post('ajax_mapview.php',
        {
            map_view: $(this).val()
        },
        function(data) {
                location.reload();
        },'json'
    );
});

//availability-map device group
$(document).on("change", '#group', function() {
    $.post('ajax_mapview.php',
        {
            group_view: $(this).val()
        },
        function(data){
            location.reload();
        },'json'
    );
});

$(document).ready(function() {
    var lines = 'on';
    $("#linenumbers").button().click(function() {
        if (lines == 'on') {
            $($('.config').find('ol').get().reverse()).each(function(){
                $(this).replaceWith($('<ul>'+$(this).html()+'</ul>'))
                lines = 'off';
                $('#linenumbers').val('Show line numbers');
            });
        }
        else {
            $($('.config').find('ul').get().reverse()).each(function(){
                $(this).replaceWith($('<ol>'+$(this).html()+'</ol>'));
                lines = 'on';
                $('#linenumbers').val('Hide line numbers');
            });
        }
    });
});
