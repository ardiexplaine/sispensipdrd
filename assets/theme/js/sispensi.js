$('#zbtnModalNotification').click(function() {
    loadModal('NOTIF');
});
$('#menuChangePassword').click(function() {
    loadModal('CHANGEPASS');
});


function datepic(attr,formatdate){
    $('#'+attr+'_date').datepicker({format: formatdate}).on('changeDate', function(ev){
        var dateText = $(this).data('date');
        $('#'+attr).val(dateText);
        $('#'+attr+'_date').datepicker('hide');
    });
}



function loadModal(mode){
    $.ajax({
        url: baseurl+"api/getmodal",
        type: "POST",
        dataType: "json",
        data: { mode:mode },
        success : function(data){
            if(data.status==0){
                $('#dataModal').html(data.htmlmodal);
		        $("#dataModal").find("#dataModalTable").addClass("table table-hover");
            } else{

            }
        },
        error: function(xhr, ajaxOptions, thrownError){
            alert(xhr.responseText);
            $('body').css('cursor','default');			
        }
    });
}

function loadStatus(stscd){
    $.ajax({
        url: baseurl+"ranperda/loadstatus",
        type: "POST",
        dataType: "json",
        data: {stscd:stscd},
        success : function(data){
            $('#txtStatusCd').val(data.stscd);
            $('#txtStatusNm').val(data.stsnm); 
            $('#lblStatus').text(data.stsnm);
        },
        error: function(xhr, ajaxOptions, thrownError){
            alert(xhr.responseText);
            $('body').css('cursor','default');			
        }
    });
}

function authButton(butmo,curst,nexst,iscls,isrea){
    if(isrea == "X"){
        $('#zmdlReason').modal('show');
        $("#txtReasonCurrst").val(curst);
        $("#txtReasonNextst").val(nexst);
    }
    switch(butmo){
        case 'BTN_BACK_SELECT':
            location.href = baseurl+'ranperda';
        break;

        case 'BTN_SAVE_DATA':
            saveData(butmo,curst,nexst,iscls,isrea);
        break;

        case 'BTN_REQ_APPV':  
            saveData(butmo,curst,nexst,iscls,isrea);
        break;

        case 'BTN_APPROVED':
            var ask = confirm("Anda Yakin Menerima Ranperda Ini?");  
            if (ask == true){
                saveData(butmo,curst,nexst,iscls,isrea);
            }
        break;

        case 'BTN_DELETE_DATA':
            var ask = confirm("Anda Yakin Menghapus Ranperda Ini?");
            if (ask == true){
                saveData(butmo,curst,nexst,iscls,isrea);
            }
        break;
        

        default:	
        break;
    }
}

 async function loaddata() {
    var wfnum = $('#txtWfnum').val();

    var formData = {
        'wfnum': wfnum,
    };
    $.ajax({
        url: baseurl+"ranperda/loaddata",
        type: "POST",
        dataType: "json",
        data: formData,
        success : function(data){

            var head = data.header;

            $('#redLabel').text('> '+ data.redlabel);

            $("#kategori").val(head.kategori);
            $("#jns_pad").val(head.jns_pad);
            funcSelectAttr('PAD',head.jns_pajak,'jns_pajak',head.jns_pad);

            loadItem('KP01',wfnum);

            // Kab Kota
            $("#no_surat_ke_gubernur").val(head.no_surat_ke_gubernur);
            $("#tgl_surat_ke_gubernur").val(head.tgl_surat_ke_gubernur);
            $("#no_surat_ke_mendagri").val(head.no_surat_ke_mendagri);
            $("#tgl_surat_ke_mendagri").val(head.tgl_surat_ke_mendagri);
            $("#no_surat_ke_menkeu").val(head.no_surat_ke_menkeu);
            $("#tgl_surat_ke_menkeu").val(head.tgl_surat_ke_menkeu);

            $("#no_surat_menkeu_ke_mendagri").val(head.no_surat_menkeu_ke_mendagri);
            $("#tgl_surat_menkeu_ke_mendagri").val(head.tgl_surat_menkeu_ke_mendagri);
            $("#no_kepmenkeu").val(head.no_kepmenkeu);
            $("#tgl_kepmenkeu").val(head.tgl_kepmenkeu);
            $("#no_surat_gub_ke_kabkota").val(head.no_surat_gub_ke_kabkota);
            $("#tgl_surat_gub_ke_kabkota").val(head.tgl_surat_gub_ke_kabkota);
            $("#hasil_evaluasi").val(head.hasil_evaluasi);
            $("#no_kepgub").val(head.no_kepgub);
            $("#tgl_kepgub").val(head.tgl_kepgub);
            $("#no_surat_mendagri_kegub").val(head.no_surat_mendagri_kegub);
            $("#tgl_surat_mendagri_kegub").val(head.tgl_surat_mendagri_kegub);
            $("#no_kepmendagri").val(head.no_kepmendagri);
            $("#tgl_kepmendagri").val(head.tgl_kepmendagri);
            

            // // kepGUb
            // $("#txtSPGubernur-prov").val(head.sp_gubernur);
            // $("#txtSPSekda").val(head.sp_sekda);
            // $("#datetglSP4").val(head.sp_sekda_tgl);
            // $("#txtProDescSekda").val(head.pro_descsekda);
            // $("#txtProIsiSuratSekda").val(head.pro_isisuratsekda);

            // loadItem('PR01',wfnum);
            // loadItem('PR02',wfnum);

            // $("#txtSpMdn").val(head.sp_mdn);
            // $("#datetglSP3").val(head.sp_mdn_tgl);
            // $("#txtKemDesc").val(head.kem_desc);
            // $("#txtKemIsiSurat").val(head.kem_isisurat);

            // loadItem('KM01',wfnum);

            loadItem('KP02',wfnum);
            
            loadStatus(head.curst);
            loadHistory();
            roleScreen(head.curst,data.user_type),
            hasilEvaluasi(head.wfcat,head.hasil_evaluasi);
            workflow();
            

            if(head.kategori == "PP"){
                $('#divfileRancanganPerda').show();
            }else{
                $('#divfileRancanganPerda').hide();
            }

            $.each( data.btnFiles, function( key, value ) { 
                if(value.oriname != null){
                    $('#btn_'+value.fcode).html('<button onclick="singlelink('+"'"+value.path+"'"+','+"'"+value.oriname+"'"+');" class="btn btn-sm btn-default"><i class="splashy-document_a4_download"></i> '+value.oriname+'</button>');
                }
            });
        },
        error: function(xhr, ajaxOptions, thrownError){
            alert(xhr.responseText);
            $('body').css('cursor','default');			
        }
    });
}

function singlelink(encrypt,original){
    //alert(encrypt)
    location.href = baseurl+'ranperda/singlelink/?path='+encrypt+'&fname='+original;
}

function fdownload(encrypt,original){
    //alert(encrypt)
    location.href = baseurl+'ranperda/push_file/'+encrypt+'/'+original;
}

function saveData(butmo,curst,nexst,iscls,isrea){

    var data = new FormData();

    data.append('butmo', butmo);
    data.append('curst', curst);
    data.append('nexst', nexst);
    data.append('iscls', iscls);
    data.append('isrea', isrea);
    

    //if(nexst.substring(0, 2) == 'RN'){
        data.append('wfnum', $('#txtWfnum').val());
        data.append('kategori', $('#kategori').val());
        data.append('jns_pad', $("#jns_pad").val()); 
        data.append('jns_pajak', $("#jns_pajak").val()); 

        data.append('no_surat_ke_gubernur', $('#no_surat_ke_gubernur').val());
        data.append('tgl_surat_ke_gubernur', $('#tgl_surat_ke_gubernur').val());
        data.append('no_surat_ke_mendagri', $("#no_surat_ke_mendagri").val()); 
        data.append('tgl_surat_ke_mendagri', $("#tgl_surat_ke_mendagri").val());
        data.append('no_surat_ke_menkeu', $("#no_surat_ke_menkeu").val()); 
        data.append('tgl_surat_ke_menkeu', $("#tgl_surat_ke_menkeu").val()); 
        data.append('no_surat_menkeu_ke_mendagri', $("#no_surat_menkeu_ke_mendagri").val()); 
        data.append('tgl_surat_menkeu_ke_mendagri', $("#tgl_surat_menkeu_ke_mendagri").val()); 
        data.append('no_kepmenkeu', $("#no_kepmenkeu").val()); 
        data.append('tgl_kepmenkeu', $("#tgl_kepmenkeu").val()); 
        data.append('no_surat_gub_ke_kabkota', $("#no_surat_gub_ke_kabkota").val()); 
        data.append('tgl_surat_gub_ke_kabkota', $("#tgl_surat_gub_ke_kabkota").val()); 
        data.append('hasil_evaluasi', $("#hasil_evaluasi").val()); 
        data.append('no_kepgub', $("#no_kepgub").val()); 
        data.append('tgl_kepgub', $("#tgl_kepgub").val()); 
        data.append('no_surat_mendagri_kegub', $("#no_surat_mendagri_kegub").val()); 
        data.append('tgl_surat_mendagri_kegub', $("#tgl_surat_mendagri_kegub").val()); 
        data.append('no_kepmendagri', $("#no_kepmendagri").val()); 
        data.append('tgl_kepmendagri', $("#tgl_kepmendagri").val()); 

    //}

    $("#txtTentang").prop('required',true);
    
    $.ajax({
        url: baseurl+"ranperda/saveData",
        type: 'POST', 
        data: data, 
        processData: false,
        contentType: false,
        dataType: "json",
        beforeSend: function(e) {
            $('.page-loader').show();
            if(e && e.overrideMimeType) {
                e.overrideMimeType("application/json;charset=UTF-8");
            }
        },
        success: function(data){
           $('.page-loader').hide();

            if(data.status==0){
                $("#txtWfnum").val(data.wfnum);
                $('#fileSuratPengantar').val(null); 
                $('#fileKesepakatanDPRD').val(null); 
                $('#fileRancanganPerda').val(null);     
                $('#fileSuratKetGub').val(null); 
                $('#fileMatrikEvaluasi').val(null); 
                $('#fileSuratHasilKonsul').val(null); 
                $('#fileKepGubEvaluasi').val(null); 
                $('#filePerda').val(null); 
                loaddata();
                document.getElementById('ztxtAppsMsg').innerHTML = '';
            }else{
                document.getElementById('ztxtAppsMsg').innerHTML = data.notif;
            }			
        },
        error: function(xhr, ajaxOptions, thrownError){
            alert(xhr.responseText);
            $('body').css('cursor','default');			
        }
    });
}

function doUploads(attrs,fileext){
    var data = new FormData();

    data.append('wfnum', $('#txtWfnum').val());
    data.append('attr_name', attrs);
    data.append('fileext', fileext);
    data.append(attrs, $("#"+attrs)[0].files[0]);
    
    $.ajax({
        url: baseurl+"ranperda/douploads",
        type: 'POST', 
        data: data, 
        processData: false,
        contentType: false,
        dataType: "json",
        beforeSend: function() {
			$('#btn_'+attrs).html("<img src='"+baseurl+"/assets/theme/img/upload-wait.gif' />");
		},
        success: function(data){
            if(data.status == 0){
                $('#'+attrs).val('');
                $('#btn_'+attrs).html('<button onclick="singlelink('+"'"+data.full_path+"'"+','+"'"+data.orig_name+"'"+');" class="btn btn-sm btn-default"><i class="splashy-document_a4_download"></i> '+data.orig_name+'</button>');
            }else{
                $('#btn_'+attrs).html("<span class='help-block' style='color:#FF0000;'>"+data.message+"</span>");
                $('#'+attrs).val('');
                $('#'+attrs).focus();
            }
            
        }
    });
}

//function validation

function rejectData(){

    var data = new FormData();

    data.append('wfnum', $('#txtWfnum').val());
    data.append('curre', $('#txtReasonCurrst').val());
    data.append('nexst', $('#txtReasonNextst').val());
    data.append('reasn', $('#txtReason').val());
    
    $.ajax({
        url: baseurl+"ranperda/rejectData",
        type: 'POST', 
        data: data, 
        processData: false,
        contentType: false,
        dataType: "json",
        beforeSend: function(e) {
            // $('#zdivOverlay').show();
            if(e && e.overrideMimeType) {
                e.overrideMimeType("application/json;charset=UTF-8");
            }
        },
        success: function(data){
            // $('#zdivOverlay').hide();
            $("#txtWfnum").val(data.wfnum);
            $('#fileSuratPengantar').val(null); 
            $('#fileKesepakatanDPRD').val(null); 
            $('#fileRancanganPerda').val(null); 
            loaddata();
            //document.getElementById('ztxtAppsMsg').innerHTML = data.message;			
        },
        error: function(xhr, ajaxOptions, thrownError){
            alert(xhr.responseText);
            $('body').css('cursor','default');			
        }
    });
}


function workflow(){
    var formData = {
        'wfnum': $('#txtWfnum').val(),
    };
    $.ajax({
        url: baseurl+"ranperda/workflow",
        type: "POST",
        dataType: "json",
        data: formData,
        success : function(data){
            $("#zbtnAction").html('');
            $("#zbtnAction").html(data.button); 
        },
        error: function(xhr, ajaxOptions, thrownError){
            alert(xhr.responseText);
            $('body').css('cursor','default');			
        }
    });
}


function loadHistory() {

    // hapus datatable
    var table = $('#tblHistory').DataTable();
    table.destroy();

    var formData = {
        'wfnum': $('#txtWfnum').val(),
    };

    $('#tblHistory').DataTable({
        "ajax": {
            "url": baseurl+"ranperda/loadHistory",
            "type": "POST",
            "deferLoading": 57,
            "data": formData,
            "dataSrc": ""
        },
        "columns": [
            { "data": "zdate" },
            { "data": "ztime" },
            { "data": "zuser" },
            { "data": "from_status" },
            { "data": "to_status" },
            { "data": "reason" }
        ]
    });
}

function jenisStatus(){
    var formData = {
        'mode': "JENISSTATUS",
    };
    $.ajax({
        url: baseurl+"ranperda/loadDropdown",
        type: "POST",
        dataType: "json",
        data: formData,
        beforeSend: function(e) {
        },
        success : function(data){
            $('#slcJenisStatus option').remove();
            $('#slcJenisStatus').append(data.option);
        },
        error: function(xhr, ajaxOptions, thrownError){
            alert(xhr.responseText);
            $('body').css('cursor','default');			
        }
    });
}

function roleScreen(curst,user_type){

    if(curst.substring(0, 2) == 'RN'){

        if (curst == 'RNA1') {
            $('#tabBody').hide();
            $('#tabHeader *').prop('disabled', false);
        }else{
            $('#tabHeader *').prop('disabled', true);
            $('#divRevisi, #divPenetapanPerda').hide();
        } 
        
        if(curst=='RNB1' || curst=='RNBX'){
            authField(curst,user_type);
            $('#tabBody').show();
            $('#tabkab').show();
            $('#tabpro, #tabkem, #tabkeu').hide();

            $('#tabkab,#tab1').addClass('active');
        }

        if(curst=='RNC1'){

            $('#tabpro, #tabkem, #tabkeu').hide();
            $('#tabkab,#tab1').addClass('active');
            authField(curst,user_type);
            $('#tab1 *').prop('disabled', true);
        }

        if(curst=='RNC2'){
            
            $('#tabpro, #tabkem, #tabkeu').show();
            authField(curst,user_type);
            authTab(curst,user_type);
            $('#tab1 *').prop('disabled', true);
            $('#tab2 *').prop('disabled', true);
        }

        if(curst=='RND1'){
            $('#tabpro, #tabkem, #tabkeu').show();
            authField(curst,user_type);
            authTab(curst,user_type);
            $('#tab3 *').prop('disabled', true);
            $('#tab4 *').prop('disabled', true);
            $('#divRevisi, #divPenetapanPerda').hide();
            $('#tab1 *').prop('disabled', true);

        }

        if(curst=='RNF1'){
            /// ini kondisi belum kelar
            $('#tab1 *').prop('disabled', true);
            $('#tab2 *').prop('readonly', true);
            $('#tab3 *').prop('disabled', true);
            $('#tab4 *').prop('disabled', true);
            $('#divPenetapanPerda').show();
            if(user_type == "KAB"){
                $('#divRevisi *').prop('disabled', false);
                $('#divPenetapanPerda *').prop('disabled', false);
            }

        }

        if(curst=='RNG1'){
            $('#tab1 *').prop('disabled', true);
            $('#tab2 *').prop('disabled', true);
            $('#tab3 *').prop('disabled', true);
            $('#tab4 *').prop('disabled', true);
            $('#divPenetapanPerda').show();
        }

    }


    if(curst.substring(0, 2) == 'PV'){
        if (curst == 'PVA1') {
            $('#tabBody').hide();
            $('#tabHeader *').prop('disabled', false);
        }else{
            $('#tabHeader *').prop('disabled', true);
            $('#divRevisi, #divPenetapanPerda').hide();
        } 
        
        if(curst=='PVB1' || curst=='PVBX'){
        
            authField(curst,user_type);
        
            $('#tabBody').show();
            $('#tabkab').show();
            $('#tabpro, #tabkem, #tabkeu').hide();
        
            $('#tabkab,#tab1').addClass('active');
        }
        
        if(curst=='PVC1'){
        
            $('#tabpro, #tabkem, #tabkeu').hide();
            $('#tabkab,#tab1').addClass('active');
            authField(curst,user_type);
            $('#tab1 *').prop('disabled', true);
        }
        
        if(curst=='PVC2'){
            
            $('#tabpro, #tabkem, #tabkeu').show();
            authField(curst,user_type);
            authTab(curst,user_type);
            $('#tab1 *').prop('disabled', true);
            $('#tab2 *').prop('disabled', true);
        }
        
        if(curst=='PVD1'){
            $('#tabpro, #tabkem, #tabkeu').show();
            authField(curst,user_type);
            authTab(curst,user_type);
            $('#divRevisi, #divPenetapanPerda').hide();
            $('#tab1 *').prop('disabled', true);
        
        }
        
        if(curst=='PVE1'){
            authTab(curst,user_type);
            $('#tab1 *').prop('disabled', true);
            $('#tab2 *').prop('readonly', true);
            $('#tab3 *').prop('disabled', true);
            $('#divPenetapanPerda').show();
            if(user_type == "PRO"){
                $('#divRevisi *').prop('disabled', false);
                $('#divPenetapanPerda *').prop('disabled', false);
            }
        
        }
        
        if(curst=='PVF1'){
            authTab(curst,user_type);
            $('#tab1 *').prop('disabled', true);
            $('#tab2 *').prop('disabled', true);
            $('#tab3 *').prop('disabled', true);
            $('#divPenetapanPerda').show();
        }
    }

}

function authField(curst,user_type){
    if(curst.substring(0, 2) == 'RN'){
        switch (user_type) {
                case "KAB":
                    $('#tab1 *').prop('disabled', false);
                    $('#tab2 *').prop('disabled', true);
                    $('#tab3 *').prop('disabled', true);
                    $('#tab4 *').prop('disabled', true);
                    break;
                case "PRO":                 
                    $('#tab1 *').prop('disabled', true);
                    $('#tab2 *').prop('disabled', false);
                    $('#tab3 *').prop('disabled', true);
                    $('#tab4 *').prop('disabled', true);
        
                    break;
                case "KEU":
                    $('#tab1 *').prop('disabled', true);
                    $('#tab2 *').prop('disabled', true);
                    $('#tab3 *').prop('disabled', false);
                    $('#tab4 *').prop('disabled', true);
        
                    break;
                case "KEM":
                    $('#tab1 *').prop('disabled', true);
                    $('#tab2 *').prop('disabled', true);
                    $('#tab3 *').prop('disabled', true);
                    $('#tab4 *').prop('disabled', false);
                    break;

                case "PUU":
                    $('#tab1 *').prop('disabled', true);
                    $('#tab2 *').prop('disabled', true);
                    $('#tab3 *').prop('disabled', true);
                    $('#tab4 *').prop('disabled', true);
                    break;
            
                default:
                    break;
        }
    }

    if(curst.substring(0, 2) == 'PV'){
        switch (user_type) {
            case "PRO":
                $('#tab1 *').prop('disabled', false);
                $('#tab2 *').prop('disabled', true);
                $('#tab3 *').prop('disabled', true);
                break;
            case "KEM":
                $('#tab1 *').prop('disabled', true);
                $('#tab2 *').prop('disabled', false);
                $('#tab3 *').prop('disabled', true);
    
                break;
            case "KEU":
                $('#tab1 *').prop('disabled', true);
                $('#tab2 *').prop('disabled', true);
                $('#tab3 *').prop('disabled', false);
                break;
        
            default:
                break;
        }

    }
    
}

    

function authTab(curst,user_type){

    if(curst.substring(0, 2) == 'RN'){
        switch (user_type) {
            case "KAB":
                $('#tabpro,#tab2, #tabkeu,#tab3, #tabkem,#tab4').removeClass('active');
                $('#tabkab,#tab1').addClass('active');
                break;
            case "PRO":
                $('#tabkab,#tab1, #tabkeu,#tab3, #tabkem,#tab4').removeClass('active');
                $('#tabpro,#tab2').addClass('active');
                break;
            case "KEU":
                $('#tabkab,#tab1, #tabpro,#tab2, #tabkem,#tab4').removeClass('active');
                $('#tabkeu,#tab3').addClass('active');
                break;
            case "KEM": 
                $('#tabkab,#tab1, #tabpro,#tab2, #tabkeu,#tab3').removeClass('active');
                $('#tabkem,#tab4').addClass('active');
                break;
        
            default:
                break;
        }
    }

    if(curst.substring(0, 2) == 'PV'){
        switch (user_type) {
            case "PRO":
                $('#tabpro,#tab2, #tabkeu,#tab3').removeClass('active');
                $('#tabkab,#tab1').addClass('active');
                break;
            case "KEM":
                $('#tabkab,#tab1, #tabkeu,#tab3').removeClass('active');
                $('#tabpro,#tab2').addClass('active');
                break;
            case "KEU":
                $('#tabkab,#tab1, #tabpro,#tab2').removeClass('active');
                $('#tabkeu,#tab3').addClass('active');
                break;
            default:
                break;
        }
    }
}

function userprofile(mode) {

    // hapus datatable
    var table = $('#tblListUsers').DataTable();
    table.destroy();

    var formData = {
        'mode': mode,
    };

    if(mode == 'KAB'){
        var cols = [
            { "data": "usrcd" },
            { "data": "daerah" },
            { "data": "nama_lengkap" },
            { "data": "username" },
            { "data": "jabatan" },
            { "data": "email" },
            { "data": "telepon" },
            { "data": "status" }
        ];
    }

    if(mode == 'PUSAT'){
        var cols = [
            { "data": "usrcd" },
            { "data": "nama_lengkap" },
            { "data": "username" },
            { "data": "jabatan" },
            { "data": "email" },
            { "data": "telepon" },
            { "data": "status" }
        ];
    }    

    $('#tblListUsers').DataTable({
        "ajax": {
            "url": baseurl+"profile/loadAllUsers",
            "type": "POST",
            "deferLoading": 57,
            "data": formData,
            "scrollY": "200px",
            "scrollCollapse": true,
            "paging": false,
            "dataSrc": ""
        },
        "columns": cols
    });

    $('#tblListUsers tbody').on('click', 'tr', function () {
        var table = $('#tblListUsers').DataTable();
        var data = table.row( this ).data();
        //alert( 'You clicked on '+data["wfcat"]+'\'s row' );
        if(data["group_user"] == 0){
            location.href = baseurl+'profile/detail/pusat/'+data["usrcd"];
        }else{
            location.href = baseurl+'profile/detail/kabkot/'+data["usrcd"];
        }
        
    });
}

function userprofilePIC(mode) {

    // hapus datatable
    var table = $('#tblListUsers').DataTable();
    table.destroy();

    var formData = {
        'mode': mode,
    };

    if(mode == 'KAB'){
        var cols = [
            { "data": "usrcd" },
            { "data": "daerah" },
            { "data": "nama_lengkap" },
            { "data": "username" },
            { "data": "jabatan" },
            { "data": "email" },
            { "data": "telepon" },
            { "data": "status" }
        ];
    }

    if(mode == 'PUSAT'){
        var cols = [
            { "data": "usrcd" },
            { "data": "nama_lengkap" },
            { "data": "username" },
            { "data": "jabatan" },
            { "data": "email" },
            { "data": "telepon" },
            { "data": "status" }
        ];
    }    

    $('#tblListUsersPIC').DataTable({
        "ajax": {
            "url": baseurl+"profile/loadAllUsers",
            "type": "POST",
            "deferLoading": 57,
            "data": formData,
            "scrollY": "200px",
            "scrollCollapse": true,
            "paging": false,
            "dataSrc": ""
        },
        "columns": cols
    });

}

function loadDetailUsers(){
    var formData = {
        'txtusrcd': $('#txtusrcd').val(),
    };
    $.ajax({
        url: baseurl+"profile/getDataUsers",
        type: "POST",
        dataType: "json",
        data: formData,
        success : function(data){

            $('#txtDaerah').val(data.daerah);
            $("#txtNamaLengkap").val(data.nama_lengkap);
            $("#txtUsername").val(data.username);
            $("#txtJabatan").val(data.jabatan);
            $("#txtEmail").val(data.email);
            $("#txtTlpNo").val(data.telepon);
            $("#txtFaxNo").val(data.fax);
            $("#slcIsActive").val(data.status);
            $("#slcIsSuperAdmin").val(data.superadmin);

        },
        error: function(xhr, ajaxOptions, thrownError){
            alert(xhr.responseText);
            $('body').css('cursor','default');			
        }
    });
}

function slckabkot(){
    var formData = {
        'kodeprov': $("#slcDaerahProv").val(),
    };
    $.ajax({
        url: baseurl+"ranperda/slckabkot",
        type: "POST",
        dataType: "json",
        data: formData,
        beforeSend: function(e) {
        },
        success : function(data){
            $('#slcDaerahKab option').remove();
            $('#slcDaerahKab').append(data.option);
        },
        error: function(xhr, ajaxOptions, thrownError){
            alert(xhr.responseText);
            $('body').css('cursor','default');			
        }
    });
}

function getCodeNOS(type,size) {
    var text = "";
    var possible = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
  
    for (var i = 0; i < size; i++)
        text += possible.charAt(Math.floor(Math.random() * possible.length));
  
    return type+text;
}

function getCodeNDI(){
    $.ajax({
        url: baseurl+"ranperda/getndi",
        type: 'POST', 
        processData: false,
        contentType: false,
        dataType: "json",
        success: function(data){
            if(data.status == 0){
                $('#txtWfnum').val(data.ndi);
            }else{
                $('#txtWfnum').val('');
            }
        }
    });
}

function addItem(filety,filecd,title,fileid){

    var data = new FormData();

    data.append('wfnum', $('#txtWfnum').val());
    data.append('filety', filety);
    data.append('filecd', filecd);
    data.append('title', $('#'+title).val());
    data.append('filenm', fileid); 
    data.append('fileid', $('#'+fileid)[0].files[0]); 

    data.append('kepgubno', $('#txtKepGubNo').val());
    data.append('kepgubtgl', $('#datetglSP6').val());

    data.append('perdareg', $('#txtRegNo').val());
    data.append('perdano', $('#txtPerdaNo').val());
    data.append('perdatgl', $('#datetglSP7').val());

    if($('#'+title).val() == ''){
        $('#'+title).focus();
        return;
    }

    
    $.ajax({
        url: baseurl+"ranperda/additem",
        type: 'POST', 
        data: data, 
        processData: false,
        contentType: false,
        dataType: "json",
        beforeSend: function(e) {
            $('.page-loader').show();
        },
        success: function(data){
            $('.page-loader').hide();

            $('#fileRancanganPerda, #txtDescFiles').val('');
            $('#fileRancanganPerdaPR01, #txtDescFilesPR01').val('');
            $('#fileRancanganPerdaKM01, #txtDescFilesKM01').val('');
            $('#fileRancanganPerdaPR02, #txtDescFilesPR02, #datetglSP6, #txtKepGubNo').val('');
            $('#fileRancanganPerdaKP02, #txtDescFilesKP02, #datetglSP7, #txtRegNo, #txtPerdaNo').val('');
            if(data.status == 0){
                loadItem(filety,$('#txtWfnum').val());
                document.getElementById('ztxtAppsMsg').innerHTML = '';
            }else{
                document.getElementById('ztxtAppsMsg').innerHTML = data.notif;
            }		
        },
        error: function(xhr, ajaxOptions, thrownError){
            alert(xhr.responseText);
            $('body').css('cursor','default');			
        }
    });
}

function loadItem(filety,wfnum){

    var data = new FormData();

    data.append('wfnum', wfnum);
    data.append('filety', filety);


    $.ajax({
        url: baseurl+"ranperda/loaditem",
        type: 'POST', 
        data: data, 
        processData: false,
        contentType: false,
        dataType: "json",
        beforeSend: function(e) {
            $('.page-loader').show();
            if(e && e.overrideMimeType) {
                e.overrideMimeType("application/json;charset=UTF-8");
            }
        },
        success: function(data){
           $('.page-loader').hide();
            $('#tbl'+filety).html(data.html);			
        },
        error: function(xhr, ajaxOptions, thrownError){
            alert(xhr.responseText);
            $('body').css('cursor','default');			
        }
    });
}

function delItem(filety,wfnum,filecd){

    var formData = {
        'wfnum': wfnum,
        'filety': filety,
        'filecd': filecd
    };
    $.ajax({
        url: baseurl+"ranperda/delitem",
        type: 'POST', 
        data: formData, 
        dataType: "json",
        beforeSend: function() {
            $('.page-loader').show();
        },
        success: function(data){
            $('.page-loader').hide();
            loadItem(filety,wfnum);	
        }
    });
}


function funcSelectAttr(type,val,attr,pad) {

    var formData = {
        'type': type,
        'param': val,
        'pad': pad
    };
    $.ajax({
        url: baseurl+"attr/dropdown",
        type: 'POST', 
        data: formData, 
        dataType: "json",
        success: function(data){
            $('#'+attr).html(data.html);
            if(val != ""){
                $('#'+attr).val(val);
            }		
        }
    });
}

function hasilEvaluasi(wfcat,hasil_evaluasi){

    if(wfcat == 'WF01'){
        var name = 'Gubernur';
    }

    if(wfcat == 'WF02'){
        var name = 'Mendagri';
    }

    if(hasil_evaluasi == 'S' || hasil_evaluasi == ''){
        $('#provH4').text('Persetujuan '+name+' dalam bentuk Keputusan '+name);
        $('#no_kepgub_label').text('No. Keputusan '+name);
        $('#tgl_kepgub_label').text('Tanggal Keputusan '+name);
        $('#file_kepgub_label').text('File Keputusan '+name); 
        $('#divRevisi').hide();
    }

    if(hasil_evaluasi == 'P'){
        $('#provH4').text('Penolakan '+name+' dalam bentuk Surat Rekomendasi Perbaikan');
        $('#no_kepgub_label').text('No. Surat Rekomendasi');
        $('#tgl_kepgub_label').text('Tanggal Surat Rekomendasi');
        $('#file_kepgub_label').text('File Surat Rekomendasi');
        $('#divRevisi').show();
    }

}


