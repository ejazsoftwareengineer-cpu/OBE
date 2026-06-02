// ////////////////////////////////////////////////////
///////////// PEO ////////////////////////////////
////////////////////////////////////////////////////


///////////////////////// Modal OPEN /////////

function openPeoKpisModal(){
    $('#open_peo_kpis').modal("show");
}

function openAssignProgramModal(){
    $('#assign_program').modal("show");
}

/////////////////////////////////////

$('#aligned_vision').change(function(){
    if($(this).prop("checked") == true){
        $('#aligned_vision').val(1)
    }else if($(this).prop("checked") == false){
        $('#aligned_vision').val(0)
    }
});

$('#aligned_mission').change(function(){
    if($(this).prop("checked") == true){
        $('#aligned_mission').val(1)
    }else if($(this).prop("checked") == false){
        $('#aligned_mission').val(0)
    }
});

// ///////////////  SAVE PEO PROGRAM ////////
function savePeoProgram(siteurl, main_url){
    jQuery.ajaxSetup({
        headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
        }
    });     
    const   peo_id = $('#peo_id').val(),
            program_id = $('#program_id').val(),
            aligned_vision    = $('#aligned_vision').val(),
            aligned_mission    = $('#aligned_mission').val();
    $('#save_peo_program').prop('disabled',true);
    $.ajax({
        type: "POST",
        url: siteurl,
        data: {
            peo_id: peo_id,
            program_id: program_id,
            program_vision: aligned_vision,
            program_mission: aligned_mission,
        },
        success: function(response){
            $('#assign_program').modal("hide");
            showPeoProgramData(peo_id, main_url);
        }
    });
} 


function showPeoProgramData(id, siteurl){
    $('#div_datatable_peokpis table').remove();
    $('#div_datatable_peoprogram table').remove();
    jQuery.ajaxSetup({
        headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
        }
    });     
    $.ajax({
        type: "POST",
        url: siteurl,
        data: {
            id: id,
        },
        success: function(response){
            $('#div_datatable_peoprogram').html(response);
        }
    });
}

// //////////////////// Save Peo KPIs /////////////

function savePeoKpis(siteurl, main_url){
    jQuery.ajaxSetup({
        headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
        }
    });     
    const   peo_id = $('#peo_id').val(),
            code = $('#code').val(),
            name = $('#name').val(),
            description = $('#description').val(),
            kpi_percentage = $('#kpi_percentage').val(),
            measured_when    = $('#measured_when').val();
            if (kpi_percentage < 0 || kpi_percentage > 100) {
                alert("Value must be between 0 and 100");
            }else{
                $('#save_peo_kpis').prop('disabled',true);
                $.ajax({
                    type: "POST",
                    url: siteurl,
                    data: {
                        peo_id: peo_id,
                        code: code,
                        name: name,
                        description: description,
                        kpi_percentage: kpi_percentage,
                        measured_when: measured_when,
                    },
                    success: function(response){
                        $('#open_peo_kpis').modal("hide");
                        showPeoKpisData(peo_id, main_url);
                    }
                });
            }

} 


function showPeoKpisData(id, siteurl){
    
    $('#div_datatable_peoprogram table').remove();
    $('#div_datatable_peokpis table').remove();
    jQuery.ajaxSetup({
        headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
        }
    });     
    $.ajax({
        type: "POST",
        url: siteurl,
        data: {
            id: id,
        },
        success: function(response){
            $('#div_datatable_peokpis').html(response);
        }
    });
}

// ////////////////////////////////////////////////////
///////////// PLO ////////////////////////////////
////////////////////////////////////////////////////



function openAssignPloModal(){
    $('#assign_peo_to_plo').modal("show");
}
function openMapPLOAtCLoModal(){
    $('#assign_clo_to_plo').modal("show");
}


function openPloKpisModal(){
    $('#open_plo_kpis').modal("show");
}
function openPloProgramModal(){
    $('#open_plo_program').modal("show");
}

// ///////////////  SAVE PLO Program ////////
function savePloProgram(siteurl, main_url){
    jQuery.ajaxSetup({
        headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
        }
    });     
    const   peo_id = $('#peo_id').val(),
            plo_id = $('#plo_id').val(),
            weight    = $('#weight').val();
    $('#save_peo_program').prop('disabled',true);
    $.ajax({
        type: "POST",
        url: siteurl,
        data: {
            peo_id: peo_id,
            plo_id: plo_id,
            weight: weight,
        },
        success: function(response){
            $('#assign_peo_to_plo').modal("hide");
            showPloProgramData(plo_id, main_url);
        }
    });
} 

function showPloProgramData(id, siteurl){
    $('#div_datatable_plokpis table').remove();
    $('#div_datatable_plopeo table').remove();
    $('#div_datatable_ploprogram table').remove();
    jQuery.ajaxSetup({
        headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
        }
    });     
    $.ajax({
        type: "POST",
        url: siteurl,
        data: {
            id: id,
        },
        success: function(response){
            $('#div_datatable_ploprogram').html(response);
        }
    });
}

// ///////////////  SAVE PLO PEO ////////
function savePloPeo(siteurl, main_url){
    jQuery.ajaxSetup({
        headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
        }
    });     
    const   peo_id = $('#peo_id').val(),
            plo_id = $('#plo_id').val(),
            weight    = $('#weight').val();
    $('#save_peo_program').prop('disabled',true);
    $.ajax({
        type: "POST",
        url: siteurl,
        data: {
            peo_id: peo_id,
            plo_id: plo_id,
            weight: weight,
        },
        success: function(response){
            $('#assign_peo_to_plo').modal("hide");
            showPloPeoData(plo_id, main_url);
        }
    });
} 


function showPloPeoData(id, siteurl){
    $('#div_datatable_plokpis table').remove();
    $('#div_datatable_plopeo table').remove();
    jQuery.ajaxSetup({
        headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
        }
    });     
    $.ajax({
        type: "POST",
        url: siteurl,
        data: {
            id: id,
        },
        success: function(response){
            $('#div_datatable_plopeo').html(response);
        }
    });
}

// //////////////////// Save Plo KPIs /////////////

function savePloKpis(siteurl, main_url){
    jQuery.ajaxSetup({
        headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
        }
    });     
    const   plo_id = $('#plo_id').val(),
            code = $('#code').val(),
            name = $('#name').val(),
            description = $('#description').val(),
            kpi_percentage = $('#kpi_percentage').val(),
            measured_when    = $('#measured_when').val();
    $('#save_plo_kpis').prop('disabled',true);
    $.ajax({
        type: "POST",
        url: siteurl,
        data: {
            plo_id: plo_id,
            code: code,
            name: name,
            description: description,
            kpi_percentage: kpi_percentage,
            measured_when: measured_when,
        },
        success: function(response){
            $('#open_plo_kpis').modal("hide");
            showPloKpisData(plo_id, main_url);
        }
    });
} 


function showPloKpisData(id, siteurl){
    $('#div_datatable_plopeo table').remove();
    $('#div_datatable_plokpis table').remove();
    jQuery.ajaxSetup({
        headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
        }
    });     
    $.ajax({
        type: "POST",
        url: siteurl,
        data: {
            id: id,
        },
        success: function(response){
            $('#div_datatable_plokpis').html(response);
        }
    });
}

